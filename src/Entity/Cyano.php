<?php

namespace App\Entity;

use App\Entity\Image;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Cyano extends Image
{
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	private $etsy_id;

	public function getEtsyId(): ?int
	{
		return $this->etsy_id;
	}

	public function setEtsyId(int $etsy_id): self
	{
		$this->etsy_id = $etsy_id;

		return $this;
	}
}