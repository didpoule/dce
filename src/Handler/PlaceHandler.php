<?php

namespace App\Handler;

use App\Form\PlaceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use TBoileau\FormHandlerBundle\Handler;

/**
 * Class PlaceHandler
 * @package App\Handler
 */
class PlaceHandler extends Handler {

	/**
	 * @var EntityManagerInterface
	 */
	private $em;

	/**
	 * PlaceHandler constructor.
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
		return PlaceType::class;
	}

	/**
	 * @return string
	 */
	public function getView(): string {
		return "back/place.html.twig";
	}

	/**
	 * @return Response
	 */
	public function onSuccess(): Response {
		$place = $this->form->getData();

		$this->em->persist( $place );

		$this->em->flush();

		$this->flashBag->add( 'success', 'Adresse enregistrée.' );

		return new RedirectResponse( $this->router->generate( "back_home" ) );

	}
}