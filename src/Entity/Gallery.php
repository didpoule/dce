<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Place;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity(repositoryClass="App\Repository\GalleryRepository")
 */
class Gallery {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="boolean")
	 */
	private $published;


	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="gallery", cascade={"persist"})
	 */
	private $pictures;

	/**
	 * @ORM\OneToOne(targetEntity="App\Entity\Event", inversedBy="gallery", cascade={"persist", "remove"})
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $event;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $added;

	public function __construct() {
		$this->pictures = new ArrayCollection();
	}


	public function getId() {
		return $this->id;
	}

	public function getPublished(): ?bool {
		return $this->published;
	}

	public function setPublished( bool $published ): self {
		$this->published = $published;

		return $this;
	}

	public function getNbPictures() {

		return sizeof( $this->pictures );
	}

	public function setPictures( $pictures ) {
		foreach ( $pictures->getFiles() as $file ) {

			$image = new Image();

			$image->setFile( $file );
			$this->addPicture( $image );

		}

	}

	/**
	 * @return Collection|Image[]
	 */
	public function getPictures(): Collection {

		return $this->pictures;
	}

	public function addPicture( Image $picture ): self {
		if ( ! $this->pictures->contains( $picture ) ) {
			$this->pictures[] = $picture;
			$picture->setGallery( $this );
		}

		return $this;
	}

	public function removePicture( $picture ): self {
		if ( $this->pictures->contains( $picture ) ) {
			$this->pictures->removeElement( $picture );

			if ( $picture instanceof Image && $picture->getGallery() === $this ) {
				// set the owning side to null (unless already changed)

				$picture->setGallery( null );
			}
		}

		return $this;
	}

	public function getEvent(): ?Event {
		return $this->event;
	}

	public function setEvent( Event $event ): self {
		$this->event = $event;

		return $this;
	}

	/**
	 * @return Collection|Image[]
	 */
	public function getExtract(): Collection {
		$criteria = Criteria::create()
		                    ->setMaxResults( 12 );

		return $this->pictures->matching( $criteria );

	}

	public function getAdded(): ?\DateTimeInterface {
		return $this->added;
	}

	public function setAdded( \DateTimeInterface $added ): self {
		$this->added = $added;

		return $this;
	}

}
