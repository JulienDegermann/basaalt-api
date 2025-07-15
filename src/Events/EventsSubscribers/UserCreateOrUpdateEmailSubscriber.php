<?php

namespace App\Events\EventsSubscribers;

use Throwable;
use App\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use App\Service\Interface\UserRepositoryInterface;
use App\Service\NotifierService\PasswordRecoveryNotifierService;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;

final class UserCreateOrUpdateEmailSubscriber implements EventSubscriber
{
    public function __construct(
        private readonly PasswordRecoveryNotifierService $notifier,
        private readonly UserRepositoryInterface $repo,
        private readonly LoggerInterface $logger
    ) {}

    public function getSubscribedEvents(): array
    {
        return [
            'preUpdate'
        ];
    }


    /**
     * Send an e-mail to verify user's e-mail after create or update e-mail
     * @param PreUpdateEventArgs $event - event to listen
     * @return string
     */
    public function preUpdate(PreUpdateEventArgs $event): string
    {
        try {
            $user = $event->getObject() instanceof User ? $event->getObject() : null;

            if (!$user) {
                throw new InvalidArgumentException('L\'utilisateur n\'est pas conforme.');
            }

            $user_db = $this->repo->find($user->getId()) ?? null;


            if ($event->hasChangedField('email') || !$user_db) {
                ($this->notifier)->notify($user);
                return 'Veuillez confirmer votre e-mail via le lien envoyé à l\'adresse renseignée.';
            }

            return 'Les modifications ont été prises en compte.';
        } catch (Throwable $e) {
            $this->logger->info('ERROR : ' . $e->getMessage());

            return 'Une erreur est survenue. Veuillez réessayer.';
        }
    }
}
