<?php

namespace App\Handler;

use App\Form\GalleryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use TBoileau\FormHandlerBundle\Handler;

class GalleryHandler extends Handler {

	private $em;

	public function __construct( EntityManagerInterface $em ) {
		$this->em = $em;
	}

	/**
	 * @return string
	 */
	public static function getFormType(): string {
		return GalleryType::class;
	}

	/**
	 * @return string
	 */
	public function getView(): string {
		return "back/gallery.html.twig";
	}

	/**
	 * @return Response
	 */
	public function onSuccess(): Response {
		$gallery = $this->form->getData();

		foreach ( $gallery->getPictures() as $picture ) {
			$picture->setAlt( $gallery->getEvent()->getTitle() );
		}
		$this->em->persist( $gallery );

		$this->em->flush();

		$this->flashBag->add( 'success', 'Galerie mise à jour.' );

		return new RedirectResponse( $this->router->generate( 'back_galleries' ) );

	}
}