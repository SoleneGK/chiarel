<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="text")
 * @ORM\DiscriminatorMap({"photo" = "Photo", "cyano" = "Cyano"})
 */
abstract class Image
{
	/**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
	protected $id;

	/**
     * @ORM\Column(type="text", unique=true)
     */
    private $file_name;
	
	/**
	 * @ORM\Column(type="text", unique=true)
	 */
	protected $title;
	
	/**
	 * @ORM\Column(type="text", unique=true)
	 * @Gedmo\Slug(fields={"title"}, updatable=false)
     */
	private $slug;
	
	/**
	 * @ORM\Column(type="date", nullable=true)
     */
	private $creation_date;
	
    /**
	 * @ORM\Column(type="text", nullable=true)
     */
	private $description;
	
    /**
	 * @ORM\Column(type="float", nullable=true)
     */
	private $height;
	
    /**
	 * @ORM\Column(type="float", nullable=true)
     */
	private $width;

	/**
     * @ORM\Column(type="boolean")
     */
    private $active;

	/**
     * @ORM\ManyToOne(targetEntity=Technique::class)
     */
	private $technique;
	
	/**
     * @ORM\ManyToOne(targetEntity=Series::class, inversedBy="photos")
     */
	private $series;
	
	/**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="photos")
     */
	private $tags;
	
	public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

	public function getId(): ?int
	{
		return $this->id;
	}
	
	public function getFileName(): ?string
	{
		return $this->file_name;
	}

	public function setFileName(string $file_name): self
	{
		$this->file_name = $file_name;

		return $this;
	}

	public function getTitle(): ?string
	{
		return $this->title;
	}

	public function setTitle(string $title): self
	{
		$this->title = $title;

		return $this;
	}

	public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
	}
	
	public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creation_date;
    }

    public function setCreationDate(?\DateTimeInterface $creation_date): self
    {
        $this->creation_date = $creation_date;

        return $this;
	}
	
	public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
	}
	
	public function getHeight(): ?float
    {
        return $this->height;
    }

    public function setHeight(?float $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getWidth(): ?float
    {
        return $this->width;
    }

    public function setWidth(?float $width): self
    {
        $this->width = $width;

        return $this;
	}
	
	public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
	}
	
	public function getTechnique(): ?Technique
    {
        return $this->technique;
    }

    public function setTechnique(?Technique $technique): self
    {
        $this->technique = $technique;

        return $this;
	}
	
	public function getSeries(): ?Series
    {
        return $this->series;
    }

    public function setSeries(?Series $series): self
    {
        $this->series = $series;

        return $this;
	}
	
	/**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }

        return $this;
    }

	public function __toString()
    {
        return $this->getTitle();
    }
}