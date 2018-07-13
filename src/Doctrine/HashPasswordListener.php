<?php

namespace App\Doctrine;

use App\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Hashage des mots de passe
 *
 * Class HashPasswordListener
 * @package App\Doctrine
 */
class HashPasswordListener implements EventSubscriber {

	/**
	 * @var UserPasswordEncoderInterface
	 */
	private $passwordEncoder;

	/**
	 * HashPasswordListener constructor.
	 *
	 * @param UserPasswordEncoderInterface $passwordEncoder
	 */
	public function __construct( UserPasswordEncoderInterface $passwordEncoder ) {

		$this->passwordEncoder = $passwordEncoder;
	}

	/**
	 * @return array
	 */
	public function getSubscribedEvents() {

		return [ 'prePersist',  'preUpdate'  ];
	}

	/**
	 * @param LifecycleEventArgs $args
	 */
	public function prePersist( LifecycleEventArgs $args ) {

		$entity = $args->getEntity();

		if ( ! $entity instanceof User ) {
			return;
		}

		$this->encodePassword( $entity );

	}

	/**
	 * @param LifecycleEventArgs $args
	 */
	public function preUpdate( LifecycleEventArgs $args ) {

		$entity = $args->getEntity();

		if ( ! $entity instanceof User ) {
			return;
		}

		$this->encodePassword( $entity );

		$em   = $args->getEntityManager();

		$meta = $em->getClassMetadata( get_class( $entity ) );

		$em->getUnitOfWork()->recomputeSingleEntityChangeSet( $meta, $entity );
	}

	/**
	 * @param $entity
	 */
	private function encodePassword( User $entity ): void {

		if ( ! $entity->getPlainPassword() ) {
			return;
		}

		$encoded = $this->passwordEncoder->encodePassword(
			$entity,
			$entity->getPlainPassword()
		);

		$entity->setPassword( $encoded );
	}
}