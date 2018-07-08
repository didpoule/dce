<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeammateRepository")
 */
class Teammate
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Image")
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Team", inversedBy="teammates")
	 */
    private $team;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    public function getId()
    {
        return $this->id;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTitle() {
    	return $this->name;
    }

	/**
	 * @return Team
	 */
	public function getTeam() {
		return $this->team;
	}

	/**
	 * @param Team $team
	 */
	public function setTeam(Team $team ): void {
		$this->team = $team;
	}


}
