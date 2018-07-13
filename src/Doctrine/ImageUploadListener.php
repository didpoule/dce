<?php

namespace App\Doctrine;

use App\Entity\Event;
use App\Entity\Image;
use App\Service\FileUploader;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Gestion upload images
 *
 * Class ImageUploadListener
 * @package App\Doctrine
 */
class ImageUploadListener implements EventSubscriber {

	/**
	 * @var FileUploader
	 */
	private $uploader;

	/**
	 * @var string
	 */
	private $url;

	/**
	 * ImageUploadListener constructor.
	 *
	 * @param FileUploader $uploader
	 * @param $url
	 */
	public function __construct( FileUploader $uploader, $url ) {
		$this->uploader = $uploader;
		$this->url      = $url;
	}

	/**
	 * @return array
	 */
	public function getSubscribedEvents() {

		return [ 'prePersist', 'preUpdate' ];
	}

	/**
	 * @param LifecycleEventArgs $args
	 */
	public function prePersist( LifecycleEventArgs $args ) {

		$entity = $args->getEntity();
		$this->uploadFile( $entity );

	}

	/**
	 * @param PreUpdateEventArgs $args
	 */
	public function preUpdate( PreUpdateEventArgs $args ) {
		$entity = $args->getEntity();


		$this->uploadFile( $entity );
	}

	/**
	 * Upload un fichier image
	 *
	 * @param $entity
	 */
	private function uploadFile( $entity ) {

		if ( ! $entity instanceof Image ) {
			return;
		}

		if ( ! $entity->getFiles() ) {
			// Si une seule image

			$file = $entity->getFile();
		} else {
			// Si plusieurs images

			$files = $entity->getFiles();
		}

		if ( $file instanceof UploadedFile ) {
			$fileName = $this->uploader->upload( $file );
			$entity->setUrl( $this->url . '/' . $fileName );

		} elseif ( isset( $files ) ) {
			// boucle pour traiter toute les images
			foreach ( $files as $file ) {
				$fileName = $this->uploader->upload( $file );
				$entity->setUrl( $this->url . '/' . $fileName );
				unset( $file );
			}
		}

	}

}