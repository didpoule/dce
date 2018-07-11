<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 */
class Contact {
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
	 *     maxMessage =  "Votre nom ne peux faire plus de {{limit }} caractères."
	 * )
	 */
	private $name;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Assert\Length(
	 *     min=3,
	 *     max=50,
	 *     minMessage = "Votre prénom doit faire au moins {{ limit }} caractères.",
	 *     maxMessage =  "Votre prénom ne peux faire plus de {{limit }} caractères."
	 * )
	 */
	private $firstname;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $company;

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
	 * @ORM\Column(type="string", length=255)
	 * @Assert\Length(
	 *     min=5,
	 *     max=100,
	 *     minMessage = "Le sujet doit faire au moins {{ limit }} caractères.",
	 *     maxMessage =  "Le sujet ne peut faire plus de {{limit }} caractères."
	 * )
	 */
	private $subject;

	/**
	 * @ORM\Column(type="text")
	 * @Assert\Length(
	 *     min=5,
	 *     max=500,
	 *     minMessage = "Le mesasge doit faire au moins {{ limit }} caractères.",
	 *     maxMessage =  "Le message ne peut faire plus de {{limit }} caractères."
	 * )
	 */
	private $content;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $added;

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

	public function getCompany(): ?string {
		return $this->company;
	}

	public function setCompany( ?string $company ): self {
		$this->company = $company;

		return $this;
	}

	public function getEmail(): ?string {
		return $this->email;
	}

	public function setEmail( string $email ): self {
		$this->email = $email;

		return $this;
	}

	public function getSubject(): ?string {
		return $this->subject;
	}

	public function setSubject( string $subject ): self {
		$this->subject = $subject;

		return $this;
	}

	public function getContent(): ?string {
		return $this->content;
	}

	public function setContent( string $content ): self {
		$this->content = $content;

		return $this;
	}

	public function getAdded(): ?\DateTimeInterface {
		return $this->added;
	}

	public function setAdded( \DateTimeInterface $added ): self {
		$this->added = $added;

		return $this;
	}
}
