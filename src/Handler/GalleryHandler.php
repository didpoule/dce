<?php

namespace App\Handler;

use App\Entity\Image;
use App\Form\GalleryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use TBoileau\FormHandlerBundle\Handler;

/**
 * Class GalleryHandler
 * @package App\Handler
 */
class GalleryHandler extends Handler {

	/**
	 * @var EntityManagerInterface
	 */
	private $em;

	/**
	 * GalleryHandler constructor.
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

		// Traitements images
		foreach ( $gallery->getPictures() as $picture ) {
			// Si une seule image
			if ( $picture instanceof Image ) {
				$picture->setAlt( $gallery->getEvent()->getTitle() );
				$gallery->addPicture( $picture );
			} elseif ( is_array( $picture ) ) {
				// Si plusieurs fichiers envoyés
				foreach ( $picture as $file ) {
					if ( $file instanceof UploadedFile ) {
						$image = new Image();
						$image->setFile( $file );
						$image->setGallery( $gallery );
						$image->setAlt( $gallery->getEvent()->getTitle() );

						$gallery->addPicture( $image );

					}
				}

				$gallery->removePicture( $picture );
			}

		}

		$this->em->persist( $gallery );

		$this->em->flush();

		$this->flashBag->add( 'success', 'Galerie mise à jour.' );

		return new RedirectResponse( $this->router->generate( 'back_galleries' ) );

	}
}