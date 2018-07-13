<?php

namespace App\Doctrine;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Hydratation de la propriété date d'ajout lors de la création d'une entité
 *
 * Class DateListener
 * @package App\Doctrine
 */
class DateListener implements EventSubscriber {

	/**
	 * @return array
	 */
	public function getSubscribedEvents() {
		return [ 'prePersist' ];
	}


	/**
	 * @param LifecycleEventArgs $args
	 */
	public function prePersist( LifecycleEventArgs $args ) {

		$entity = $args->getEntity();

		if ( method_exists( $entity, 'setAdded' ) && ! $entity->getAdded() ) {
			$entity->setAdded( new \DateTime() );
		}
	}


}