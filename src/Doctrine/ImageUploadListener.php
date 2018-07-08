<?php

namespace App\Doctrine;

use App\Entity\Event;
use App\Entity\Image;
use App\Service\FileUploader;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageUploadListener implements EventSubscriber {

	private $uploader;

	private $url;

	public function __construct( FileUploader $uploader, $url ) {
		$this->uploader = $uploader;
		$this->url      = $url;
	}

	public function getSubscribedEvents() {
		return [ 'prePersist', 'preUpdate' ];
	}


	public function prePersist( LifecycleEventArgs $args ) {

		$entity = $args->getEntity();
		$this->uploadFile( $entity );


	}

	public function preUpdate( PreUpdateEventArgs $args ) {
		$entity = $args->getEntity();


		$this->uploadFile( $entity );
	}

	private function uploadFile( $entity ) {

		if ( ! $entity instanceof Image ) {
			return;
		}

		if ( ! $entity->getFiles() ) {
			$file = $entity->getFile();
		} else {
			$files = $entity->getFiles();
		}

		if ( $file instanceof UploadedFile ) {
			$fileName = $this->uploader->upload( $file );
			$entity->setUrl( $this->url . '/' . $fileName );

		} elseif(isset($files)) {
			foreach ( $files as $file ) {
				$fileName = $this->uploader->upload( $file );
				$entity->setUrl( $this->url . '/' . $fileName );
				unset( $file );
			}
		}

	}

}