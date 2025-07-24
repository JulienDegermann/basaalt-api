<?php

namespace App\Events\EventsSubscribers;

use Throwable;
use App\Entity\User;
use Psr\Log\LoggerInterface;
use InvalidArgumentException;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Doctrine\ORM\Event\PostPersistEventArgs;
use App\Service\Interface\UserRepositoryInterface;
use App\Service\NotifierService\EmailVerificationNotifierServiceInterface;

final class UserCreateOrUpdateEmailSubscriber implements EventSubscriber
{
    public function __construct(
        private readonly EmailVerificationNotifierServiceInterface $notifier,
        private readonly UserRepositoryInterface $repo,
        private readonly LoggerInterface $logger
    ) {}

    public function getSubscribedEvents(): array
    {
        return [
            'postPersist',
            'preUpdate'
        ];
    }


    /**
     * Send an e-mail to verify user's e-mail UPDATED
     * @param PreUpdateEventArgs $event - event to listen
     * @return string
     */
    public function preUpdate(PreUpdateEventArgs $event): void
    {
        try {
            $user = $event->getObject();

            if (!$user instanceof User) {
                throw new InvalidArgumentException('L\'utilisateur n\'est pas conforme.');
            }

            if ($event->hasChangedField('email')) {
                ($this->notifier)($user);
            }
        } catch (Throwable $e) {
            $this->logger->info('ERROR : ' . $e->getMessage());
        }
    }

    /**
     * Send an e-mail to verify user's e-mail after user's created
     * @param PostUpdateEventArgs $event - event to listen
     * @return string
     */
    public function postPersist(PostPersistEventArgs $event): void
    {
        try {
            $user = $event->getObject();
            if (!$user || !$user instanceof User) {
                throw new InvalidArgumentException('L\'utilisateur n\'est pas conforme.');
            }

            ($this->notifier)($user);
        } catch (Throwable $e) {
            $this->logger->info('ERROR : ' . $e->getMessage());
        }
    }
}
