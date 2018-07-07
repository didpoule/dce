<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 */
class Image {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $url;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $alt;

	/**
	 * @var UploadedFile
	 */
	private $file;

	/**
	 * @var array
	 */
	private $files;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Gallery", inversedBy="pictures")
	 */
	private $gallery;

	public function unsetId() {
		$this->id = null;
	}
	public function getId() {
		return $this->id;
	}

	public function getUrl(): ?string {
		return $this->url;
	}

	public function setUrl( string $url ): self {
		$this->url = $url;

		return $this;
	}

	public function getAlt(): ?string {
		return $this->alt;
	}

	public function setAlt( string $alt ): self {
		$this->alt = $alt;

		return $this;
	}

	public function getGallery(): ?Gallery {
		return $this->gallery;
	}

	public function setGallery( ?Gallery $gallery ): self {
		$this->gallery = $gallery;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getFile() {
		return $this->file;
	}

	/**
	 * @param mixed $file
	 */
	public function setFile( UploadedFile $file ): void {
		$this->file = $file;

	}

	/**
	 * @return array
	 */
	public function getFiles() {
		return $this->files;
	}

	/**
	 * @param array $files
	 */
	public function setFiles( array $files ): void {
		$this->files = $files;
	}

	public function addFile(UploadedFile $file): void {

		$this->files[] = $file;
	}


}
