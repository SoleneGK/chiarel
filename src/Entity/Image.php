<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="text")
 * @ORM\DiscriminatorMap({"photo" = "Photo", "cyano" = "Cyano"})
 */
abstract class Image
{
    /**
     * List of max sizes to resize images
     * Dimension in pixels
     */
    protected $image_sizes = [
        'thumbnail' => 90,
    ];

	/**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
	protected $id;

	/**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $file_name;
	
	/**
	 * @ORM\Column(type="string", length=180, unique=true)
	 */
	protected $title;
	
	/**
	 * @ORM\Column(type="string", length=180, unique=true)
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

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * Property to track file upload
     */
    private $updated;
    
    /**
     * Unmapped property to handle file uploads
     */
    private $file;
	
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

    public function getUpdated(): ?DateTime
    {
        return $this->updated;
    }

    public function setUpdated(DateTime $updated): self
    {
        $this->updated = $updated;

        return $this;
    }
    
    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }
    
    public function setFile(UploadedFile $file = null): self
    {
        $this->file = $file;
        
        return $this;
    }

    public function __toString(): string
    {
        return $this->getTitle();
    }

    /**
     * Manages the copying of the file to the relevant place on the server
     */
    protected function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        // Get source infos
        $data = getimagesize($this->getFile());
        $source_dimensions = [
            'width' => $data[0],
            'height' => $data[1]
        ];
        $extension = $this->determineImageExtension($data['mime']);

        // Set name of new file
        $this->setNewImageFileName($extension);

        // Create source image
        $source_path = $this->getFile()->getRealPath();
        $source = $this->createNewImage($source_path, $extension);

        // For each size, create resized image
        foreach ($this->image_sizes as $size_name => $max_dimension) {
            $this->createResizedImage($source_dimensions, $source, $extension, $size_name, $max_dimension);
        }

        // Clean up
        $this->setFile(null);
    }

    private function determineImageExtension(string $mime_type): string
    {
        $extension = '';

        switch($mime_type) {
            case 'image/jpeg':
                $extension = 'jpg';
            break;

            case 'image/png':
                $extension = 'png';
            break;

            case 'image/gif':
                $extension = 'gif';
            break;

            default:
                throw new \Exception('Le fichier n\'est pas une image');
            break;
        }

        return $extension;
    }

    private function setNewImageFileName(string $extension): void
    {
        $file_name = uniqid().'.'.$extension;
        $this->setFileName($file_name);
    }

    private function createNewImage(string $file_path, string $extension)
    {
        switch($extension) {
            case 'jpg':
                $image = imagecreatefromjpeg($file_path);
            break;
            case 'png':
                $image = imagecreatefrompng($file_path);
            break;
            case 'gif':
                $image = imagecreatefromgif($file_path);
            break;
        }

        return $image;
    }

    private function createResizedImage(array $source_dimensions, $source, string $extension, string $size_name, int $max_dimension)
    {
        $new_dimensions = $this->calculateImageNewDimensions($source_dimensions, $max_dimension);

        $new_image = imagecreatetruecolor($new_dimensions['width'], $new_dimensions['height']);

        imagecopyresampled($new_image, $source, 0, 0, 0, 0, $new_dimensions['width'], $new_dimensions['height'], $source_dimensions['width'], $source_dimensions['height']);

        $destination_folder = './images/'.$size_name.'/';
        $this->createNewImageFile($new_image, $destination_folder, $extension);
    }

    /**
     * @param array source_dimensions   Dimensions of source image
     *                                  Associative array with keys width and height
     *                                  Values in pixels
     * @param int max_dimension         Max dimension of output image
     * @return array                    Associative array with keys width and height
     *                                  Values in pixels
     */
    private function calculateImageNewDimensions(array $old_dimensions, int $max_dimension): array
    {
        $old_width = $old_dimensions['width'];
        $old_height = $old_dimensions['height'];
        $new_dimensions = [
            'width' => 0,
            'height' => 0
        ];

        if ($old_width == $old_height) {
            $new_dimensions['width'] = $max_dimension;
            $new_dimensions['height'] = $max_dimension;
        }
        else if ($old_width > $old_height) {
            $new_dimensions['width'] = $max_dimension;
            $new_dimensions['height'] = round($old_height / $old_width * $max_dimension);
        }
        else {
            $new_dimensions['height'] = $max_dimension;
            $new_dimensions['width'] = round($old_width / $old_height * $max_dimension);
        }

        return $new_dimensions;
    }

    private function createNewImageFile($working_image, string $destination_folder, string $extension)
    {
        $file_name = $destination_folder.$this->getFileName();

        switch($extension) {
            case 'jpg':
                imagejpeg($working_image, $file_name);
            break;
            case 'png':
                imagepng($working_image, $file_name);
            break;
            case 'gif':
                imagegif($working_image, $file_name);
            break;
        }
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * Lifecycle callback to upload the file to the server
     */
    public function lifecycleFileUpload()
    {
        $this->upload();
    }

    /**
     * Udpates the hash value to force the preUpdate and postUpdate events to fire
     */
    public function refreshUpdated()
    {
        $this->setUpdated(new \DateTime());
    }
}