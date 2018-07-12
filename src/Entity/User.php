<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=50, unique=true)
	 */
	private $email;
	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $password;

	/**
	 * @var string
	 */
	private $plainPassword;

	/**
	 * @ORM\Column(type="array")
	 */
	private $roles;

	public function getId() {
		return $this->id;
	}

	public function getRoles() {
		$roles = $this->roles;

		if ( ! in_array( 'ROLE_USER', $roles ) ) {
			$roles[] = 'ROLE_USER';
		}

		return $roles;
	}

	public function getPassword() {
		return $this->password;
	}

	public function getSalt() {
		// TODO: Implement getSalt() method.
	}

	public function getUsername() {
		return $this->email;
	}

	public function eraseCredentials() {

		$this->plainPassword = null;

		return $this;
	}

	public function getEmail(): ?string {
		return $this->email;
	}

	public function setEmail( string $email ): self {
		$this->email = $email;

		return $this;
	}

	public function setPassword( string $password ): self {
		$this->password = $password;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getPlainPassword() {
		return $this->plainPassword;
	}

	/**
	 * @param string $plainPassword
	 */
	public function setPlainPassword( string $plainPassword ): void {
		$this->plainPassword = $plainPassword;

		$this->password = null;
	}

	public function setRoles( array $roles ): self {
		$this->roles = $roles;

		return $this;
	}

}
