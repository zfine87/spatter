<?php namespace AppBundle\Subscriber;

use Doctrine\ORM\Events;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class TimestampSubscriber implements EventSubscriber
{

    /**
     * List events we want to listen to (only Pre-persist right now)
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            Events::prePersist,
        );
    }

    /**
     * Pre-persist actions
     *
     * Right now I am just assuming all entities will be using timestamps, in the future if pivot tables get involved
     * a trait should be added to either timestampable or non-timestampable entities to easily distinguish them.
     *
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        $entity->setCreatedAt(new \DateTime());
        $entity->setUpdatedAt(new \DateTime());
    }

}