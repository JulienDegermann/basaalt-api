<?php

namespace App\Events\EventsSubscribers;

use DateTimeImmutable;
use Doctrine\Common\EventSubscriber;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class UpdateSubscriber implements EventSubscriber
{
    public function getSubscribedEvents(): array
    {
        return ['preUpdate'];
    }

    public function preUpdate(LifecycleEventArgs $event): void
    {
        $entity = $event->getObject();
        $entity->setUpdatedAt(new DateTimeImmutable());
    }
}
