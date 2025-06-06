<?php

namespace App\Entity;

use App\Repository\TripRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TripRepository::class)]
class Trip {
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column]
	private ?string $name = null;

	#[ORM\Column(unique: true)]
	private ?string $slug = null;

	#[ORM\Column]
	private ?string $tagLine = null;

	public function getId(): ?int {
		return $this->id;
	}

	public function getName(): ?string {
		return $this->name;
	}

	public function setName(string $name): static {
		$this->name = $name;

		return $this;
	}

	public function getSlug(): ?string {
		return $this->slug;
	}

	public function setSlug(string $slug): static {
		$this->slug = $slug;

		return $this;
	}

	public function getTagLine(): ?string {
		return $this->tagLine;
	}

	public function setTagLine(string $tagLine): static {
		$this->tagLine = $tagLine;

		return $this;
	}
}
