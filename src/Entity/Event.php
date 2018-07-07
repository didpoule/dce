<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectManagerAware;
use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $title;

	/**
	 * @Gedmo\Slug(fields={"title"})
	 * @ORM\Column(type="string", length=255)
	 */
	private $slug;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $added;

	/**
	 * @ORM\Column(type="text")
	 */
	private $content;

	/**
	 * @ORM\Column(type="boolean")
	 */
	private $published;

	/**
	 * @ORM\OneToOne(targetEntity="App\Entity\Gallery", mappedBy="event", cascade={"persist", "remove"})
	 */
	private $gallery;

	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Booking", mappedBy="event")
	 */
	private $bookings;

	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Formula", mappedBy="event", cascade={"persist", "remove"})
	 */
	private $formulas;

 /**
  * @ORM\ManyToOne(targetEntity="App\Entity\Image", cascade="persist")
  */
 private $image;
 /**
  * @ORM\ManyToOne(targetEntity="App\Entity\Place", cascade="persist")
  */
 private $place;

	public function __construct() {
		$this->bookings = new ArrayCollection();
		$this->formulas = new ArrayCollection();
	}

	public function getId() {
		return $this->id;
	}

	public function getTitle(): ?string {
		return $this->title;
	}

	public function setTitle( string $title ): self {
		$this->title = $title;

		return $this;
	}

	public function getAdded(): ?\DateTimeInterface {
		return $this->added;
	}

	public function setAdded( \DateTimeInterface $added ): self {
		$this->added = $added;

		return $this;
	}

	public function getContent(): ?string {
		return $this->content;
	}

	public function setContent( string $content ): self {
		$this->content = $content;

		return $this;
	}

	public function getPublished(): ?bool {
		return $this->published;
	}

	public function setPublished( bool $published ): self {
		$this->published = $published;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getSlug() {
		return $this->slug;
	}

	/**
	 * @param string $slug
	 */
	public function setSlug( string $slug ): self {
		$this->slug = $slug;

		return $this;
	}

	/**
	 * @return Place
	 */
	public function getPlace() {
		return $this->place;
	}

	/**
	 * @param Place $place
	 */
	public function setPlace( Place $place = null ): self {
		$this->place = $place;

		return $this;
	}

	/**
	 * @return Image
	 */
	public function getImage() {
		return $this->image;
	}

	/**
	 * @param Image $image
	 */
	public function setImage( Image $image = null ): self {
		$this->image = $image;

		return $this;
	}

	public function getGallery(): ?Gallery {
		return $this->gallery;
	}

	public function setGallery( Gallery $gallery ): self {
		$this->gallery = $gallery;
		// set the owning side of the relation if necessary
		if ( $this !== $gallery->getEvent() ) {
			$gallery->setEvent( $this );
		}

		return $this;
	}

	public function getNbBookings() {
		return sizeof($this->bookings);
	}

	/**
	 * @return Collection|Booking[]
	 */
	public function getBookings(): Collection {
		return $this->bookings;
	}

	public function addBooking( Booking $booking ): self {
		if ( ! $this->bookings->contains( $booking ) ) {
			$this->bookings[] = $booking;
			$booking->setEvent( $this );
		}

		return $this;
	}

	public function removeBooking( Booking $booking ): self {
		if ( $this->bookings->contains( $booking ) ) {
			$this->bookings->removeElement( $booking );
			// set the owning side to null (unless already changed)
			if ( $booking->getEvent() === $this ) {
				$booking->setEvent( null );
			}
		}

		return $this;
	}

	/**
	 * @return Collection|Formula[]
	 */
	public function getFormulas(): Collection {
		return $this->formulas;
	}

	public function addFormula( Formula $formula ): self {
		if ( ! $this->formulas->contains( $formula ) ) {
			$this->formulas[] = $formula;
			$formula->setEvent( $this );
		}

		return $this;
	}

	public function removeFormula( Formula $formula ): self {
		if ( $this->formulas->contains( $formula ) ) {
			$this->formulas->removeElement( $formula );
			// set the owning side to null (unless already changed)
			if ( $formula->getEvent() === $this ) {
				$formula->setEvent( null );
			}
		}

		return $this;
	}
}
