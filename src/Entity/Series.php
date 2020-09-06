<?php

namespace App\Entity;

use App\Repository\SeriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=SeriesRepository::class)
 */
class Series
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", unique=true)
     */
    private $name;

    /**
     * @ORM\Column(type="text", unique=true)
     * @Gedmo\Slug(fields={"name"}, updatable=false)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=Photo::class, mappedBy="series")
     */
    private $photos;

    /**
     * @ORM\OneToMany(targetEntity=Cyano::class, mappedBy="series")
     */
    private $cyanos;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|Photo[]
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setSeries($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->contains($photo)) {
            $this->photos->removeElement($photo);
            // set the owning side to null (unless already changed)
            if ($photo->getSeries() === $this) {
                $photo->setSeries(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Cyano[]
     */
    public function getCyanos(): Collection
    {
        return $this->cyanos;
    }

    public function addCyano(Cyano $cyano): self
    {
        if (!$this->cyanos->contains($cyano)) {
            $this->cyanos[] = $cyano;
            $cyano->setSeries($this);
        }

        return $this;
    }

    public function removeCyano(Cyano $cyano): self
    {
        if ($this->cyanos->contains($cyano)) {
            $this->cyanos->removeElement($cyano);
            // set the owning side to null (unless already changed)
            if ($cyano->getSeries() === $this) {
                $cyano->setSeries(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
