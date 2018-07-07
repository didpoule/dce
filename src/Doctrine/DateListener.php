<?php

namespace App\Doctrine;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;

class DateListener implements EventSubscriber {

	public function getSubscribedEvents() {
		return [ 'prePersist', 'preUpdate' ];
	}


	public function prePersist( LifecycleEventArgs $args ) {

		$entity = $args->getEntity();

		if (method_exists($entity, 'setAdded') && ! $entity->getAdded()) {
			$entity->setAdded(new \DateTime());
		}


	}


}