<?php

namespace App\Events\EventsSubscribers;

use DateTimeImmutable;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber;

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
