<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * Class Team
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\TeamRepository")
 */
class Team {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Teammate", mappedBy="team", cascade={"persist"})
	 */
	private $teammates;

	public function __construct() {
		$this->teammates = new ArrayCollection();
	}

	public function getId() {
		return $this->id;
	}

	public function getTeammates(): Collection {
		return $this->teammates;
	}

	public function addTeammate( Teammate $teammate ): self {
		if ( ! $this->teammates->contains( $teammate ) ) {
			$this->teammates[] = $teammate;
		}

		return $this;
	}

	public function removeTeammate( Teammate $teammate ): self {
		if ( ! $this->teammates->contains( $teammate ) ) {
			$this->teammates->removeElement( $teammate );
		}

		return $this;
	}
}