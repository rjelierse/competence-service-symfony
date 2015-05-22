<?php

namespace Sparse\CompetenceBundle\Doctrine;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ODM\MongoDB\Events;
use Sparse\CompetenceBundle\Document\Profile;
use Sparse\CompetenceBundle\Event\CompetenceProfileEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Listener for Doctrine lifecycle events.
 * 
 * Converts events to CRUD events in the Symfony event dispatcher to allow for better targeting.
 *
 * @author Raymond Jelierse <raymond@shareworks.nl>
 */
class EventListener implements EventSubscriber 
{
    private $eventDispatcher;
    
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }
    
    public function postPersist(LifecycleEventArgs $eventArgs)
    {
        $object = $eventArgs->getObject();
        if (!$object instanceof Profile) {
            return;
        }

        $this->eventDispatcher->dispatch(CompetenceProfileEvent::CREATE, CompetenceProfileEvent::create($object));
    }
    
    public function postUpdate(LifecycleEventArgs $eventArgs)
    {
        $object = $eventArgs->getObject();
        if (!$object instanceof Profile) {
            return;
        }

        $this->eventDispatcher->dispatch(CompetenceProfileEvent::UPDATE, CompetenceProfileEvent::create($object));
    }

    public function preRemove(LifecycleEventArgs $eventArgs)
    {
        $object = $eventArgs->getObject();
        if (!$object instanceof Profile) {
            return;
        }

        $this->eventDispatcher->dispatch(CompetenceProfileEvent::DELETE, CompetenceProfileEvent::create($object));
    }
    
    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return [
            Events::preRemove,
            Events::postPersist,
            Events::postUpdate
        ];
    }
}
