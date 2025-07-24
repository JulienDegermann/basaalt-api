<?php

namespace App\Events\EventsSubscribers;

use Throwable;
use App\Entity\Order;
use Psr\Log\LoggerInterface;
use InvalidArgumentException;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Doctrine\ORM\Event\PostPersistEventArgs;
use App\Service\NotifierService\NewOrderNotifierServiceInterface;
use App\Service\NotifierService\UpdateOrderNotifierServiceInterface;
use App\Service\NotifierService\NewOrderAlertNotifierServiceInterface;
use App\Service\NotifierService\EmailVerificationNotifierServiceInterface;

class UpdateOrCreateOrderSubscriber implements EventSubscriber
{
    public function __construct(
        private readonly NewOrderNotifierServiceInterface $newOrderNotifier,
        private readonly UpdateOrderNotifierServiceInterface $updateOrderNotifier,
        private readonly NewOrderAlertNotifierServiceInterface $adminNotifier,
        private readonly LoggerInterface $logger
    ) {}

    public function getSubscribedEvents(): array
    {
        return ['postPersist', 'postUpdate'];
    }

    public function postUpdate(PostUpdateEventArgs $event): void
    {
        try {
            $order = $event->getObject();
            if (!$order instanceof Order) {
                throw new InvalidArgumentException('La commande n\'est pas conforme.');
            }
            ($this->updateOrderNotifier)($order);
        } catch (Throwable $e) {
            $this->logger->error('ERROR : ' . $e->getMessage());
        }
    }

    public function postPersist(PostPersistEventArgs $event): void
    {
        try {
            $order = $event->getObject();
            if (!$order instanceof Order) {
                throw new InvalidArgumentException('La commande n\'est pas conforme.');
            }
            ($this->newOrderNotifier)($order);
            ($this->adminNotifier)($order);
        } catch (Throwable $e) {
            $this->logger->error('ERROR : ' . $e->getMessage());
        }
    }
}
