<?php

namespace App\Handler;

use App\Form\BookingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use TBoileau\FormHandlerBundle\Handler;

class BookingHandler extends Handler {

	private $em;

	public function __construct( EntityManagerInterface $em ) {
		$this->em = $em;
	}

	/**
	 * @return string
	 */
	public static function getFormType(): string {
		return BookingType::class;
	}

	/**
	 * @return string
	 */
	public function getView(): string {
		return "front/event.html.twig";
	}

	/**
	 * @return Response
	 */
	public function onSuccess(): Response {
		$booking = $this->form->getData();


		$this->em->persist( $booking );

		$this->em->flush();

		$this->flashBag->add( 'success', 'Votre réservation a bien été prise en compte.' );

		return new RedirectResponse( $this->router->generate( 'front_event', [
			'slug' => $booking->getEvent()->getSlug()
		] ) );

	}

	public function beforeCreate() {
		$this->data->setEvent( $this->extraData['event'] );
	}
}