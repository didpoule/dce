<?php

namespace App\Handler;

use App\Entity\Image;
use App\Form\EventType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use TBoileau\FormHandlerBundle\Handler;

class EventHandler extends Handler {
	private $em;

	public function __construct( EntityManagerInterface $em ) {
		$this->em = $em;
	}

	/**
	 * @return string
	 */
	public static function getFormType(): string {
		return EventType::class;
	}

	/**
	 * @return string
	 */
	public function getView(): string {
		return "back/event.html.twig";
	}

	/**
	 * @return Response
	 */
	public function onSuccess(): Response {

		$event = $this->form->getData();

		// Si une image existait déjà
		if ( $event->getImage()->getId() && $file = $event->getImage()->getFile() ) {
			$image = new Image();
			$event->setImage( $image );
			$event->getImage()->setFile( $file );

		}

		$event->getImage()->setAlt( $event->getTitle() );

		foreach($event->getFormulas() as $formula) {
			$formula->setEvent($event);
		}


		$this->em->persist( $event );

		$this->em->flush();

		$this->flashBag->add( 'success', 'Workshop créé avec succès' );

		return new RedirectResponse( $this->router->generate( 'back_events' ) );
	}

}