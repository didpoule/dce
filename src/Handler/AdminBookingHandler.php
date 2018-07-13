<?php

namespace App\Handler;

use App\Form\BookingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use TBoileau\FormHandlerBundle\Handler;

/**
 * Class AdminBookingHandler
 * @package App\Handler
 */
class AdminBookingHandler extends Handler {

	/**
	 * @var EntityManagerInterface
	 */
	private $em;

	/**
	 * AdminBookingHandler constructor.
	 *
	 * @param EntityManagerInterface $em
	 */
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
		return "back/booking.html.twig";
	}

	/**
	 * @return Response
	 */
	public function onSuccess(): Response {

		$booking = $this->form->getData();


		$this->em->persist( $booking );

		$this->em->flush();

		$this->flashBag->add( 'success', 'Modification effectuée.' );

		return new RedirectResponse( $this->router->generate( 'back_bookings', [
			'id' => $booking->getEvent()->getId()
		] ) );

	}

	public function beforeCreate() {
		if ( $this->extraData ) {
			$this->data->setEvent( $this->extraData['event'] );
		}
	}
}