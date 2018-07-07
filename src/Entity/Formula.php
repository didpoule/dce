<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FormulaRepository")
 */
class Formula {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $name;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $price;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Event", inversedBy="formulas")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $event;

	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Booking", mappedBy="formula", orphanRemoval=true)
	 */
	private $bookings;

	public function __construct() {
		$this->bookings = new ArrayCollection();
	}

	public function getId() {
		return $this->id;
	}

	public function getName(): ?string {
		return $this->name;
	}

	public function setName( string $name ): self {
		$this->name = $name;

		return $this;
	}

	public function getPrice(): ?int {
		return $this->price;
	}

	public function setPrice( int $price ): self {
		$this->price = $price;

		return $this;
	}

	public function getEvent(): ?Event {
		return $this->event;
	}

	public function setEvent( ?Event $event ): self {
		$this->event = $event;

		return $this;
	}

	public function __toString() {
		return sprintf( "%s (%s€)", $this->getName(), $this->getPrice() );
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
			$booking->setFormula( $this );
		}

		return $this;
	}

	public function removeBooking( Booking $booking ): self {
		if ( $this->bookings->contains( $booking ) ) {
			$this->bookings->removeElement( $booking );
			// set the owning side to null (unless already changed)
			if ( $booking->getFormula() === $this ) {
				$booking->setFormula( null );
			}
		}

		return $this;
	}
}
