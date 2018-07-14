<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookingRepository")
 */
class Booking {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Assert\Length(
	 *     min=3,
	 *     max=50,
	 *     minMessage = "Votre nom doit faire au moins {{ limit }} caractères.",
	 *     maxMessage =  "Votre nom ne peut faire plus de {{limit }} caractères."
	 * )
	 */
	private $name;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Assert\Length(
	 *     min=3,
	 *     max=50,
	 *     minMessage = "Votre prénom doit faire au moins {{ limit }} caractères.",
	 *     maxMessage =  "Votre prénom ne peut faire plus de {{limit }} caractères."
	 * )
	 */
	private $firstname;

	/**
	 * @ORM\Column(type="datetime")
	 * @Assert\Date()
	 */
	private $birthday;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Assert\Length(
	 *     min=5,
	 *     max=100,
	 *     minMessage = "Votre addresse doit faire au moins {{ limit }} caractères.",
	 *     maxMessage =  "Votre addresse ne peut faire plus de {{limit }} caractères."
	 * )
	 */
	private $address;

	/**
	 * @ORM\Column(type="integer")
	 * @Assert\Length(
	 *     min=5,
	 *     max=5,
	 *     minMessage = "Votre code postal doit être composé de {{ limit }} caractères.",
	 *     maxMessage =  "Votre code postal doit être composé de {{limit }} caractères."
	 * )
	 */
	private $zipcode;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Assert\Length(
	 *     min=3,
	 *     max=50,
	 *     minMessage = "Votre ville doit faire au moins {{ limit }} caractères.",
	 *     maxMessage =  "Votre ville ne peut faire plus de {{limit }} caractères."
	 * )
	 */
	private $city;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Assert\Length(
	 *     min=2,
	 *     max=100,
	 *     minMessage = "Votre pays doit faire au moins {{ limit }} caractères.",
	 *     maxMessage =  "Votre pays ne peut faire plus de {{limit }} caractères."
	 * )
	 */
	private $country;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Assert\Length(
	 *     min=3,
	 *     max=12,
	 *     minMessage = "Votre numéro de téléphone doit faire au moins {{ limit }} caractères.",
	 *     maxMessage =  "Votre numéro de téléhpone ne peu faire plus de {{limit }} caractères."
	 * )
	 */
	private $phone;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Assert\Regex(
	 *     pattern = "#^[\w.-]+@[\w.-]+\.[a-z]{2,6}$#i",
	 *     match = true,
	 *     message = "Votre addresse email est incorrecte"
	 * )
	 */
	private $email;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Event", inversedBy="bookings")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $event;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Formula", inversedBy="bookings")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $formula;

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

	public function getFirstname(): ?string {
		return $this->firstname;
	}

	public function setFirstname( string $firstname ): self {
		$this->firstname = $firstname;

		return $this;
	}

	public function getBirthday(): ?\DateTimeInterface {
		return $this->birthday;
	}

	public function setBirthday( \DateTimeInterface $birthday ): self {
		$this->birthday = $birthday;

		return $this;
	}

	public function getAddress(): ?string {
		return $this->address;
	}

	public function setAddress( string $address ): self {
		$this->address = $address;

		return $this;
	}

	public function getZipcode(): ?int {
		return $this->zipcode;
	}

	public function setZipcode( int $zipcode ): self {
		$this->zipcode = $zipcode;

		return $this;
	}

	public function getCity(): ?string {
		return $this->city;
	}

	public function setCity( string $city ): self {
		$this->city = $city;

		return $this;
	}

	public function getCountry(): ?string {
		return $this->country;
	}

	public function setCountry( string $country ): self {
		$this->country = $country;

		return $this;
	}

	public function getPhone(): ?string {
		return $this->phone;
	}

	public function setPhone( string $phone ): self {
		$this->phone = $phone;

		return $this;
	}

	public function getEmail(): ?string {
		return $this->email;
	}

	public function setEmail( string $email ): self {
		$this->email = $email;

		return $this;
	}

	public function getEvent(): ?Event {
		return $this->event;
	}

	public function setEvent( ?Event $event ): self {
		$this->event = $event;

		return $this;
	}

	public function getFormula(): ?Formula {
		return $this->formula;
	}

	public function setFormula( ?Formula $formula ): self {
		$this->formula = $formula;

		return $this;
	}

}
