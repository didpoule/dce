<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 */
class Post {
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
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	private $published;

	/**
	 * @ORM\Column(type="text")
	 */
	private $content;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="posts")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $category;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Image", cascade="persist")
	 */
	private $image;


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

	public function getPublished(): ?bool {
		return $this->published;
	}

	public function setPublished( ?bool $published ): self {
		$this->published = $published;

		return $this;
	}

	public function getContent(): ?string {
		return $this->content;
	}

	public function setContent( string $content ): self {
		$this->content = $content;

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

	/**
	 * @return string
	 */
	public function getSlug() {
		return $this->slug;
	}

	/**
	 * @param string $slug
	 */
	public function setSlug( $slug ): self {
		$this->slug = $slug;

		return $this;
	}

	public function getCategory(): ?Category {
		return $this->category;
	}

	public function setCategory( ?Category $category ): self {
		$this->category = $category;

		return $this;
	}
}
