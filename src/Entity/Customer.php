<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\ByteString;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
class Customer {
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(unique: true)]
	private string $uid;

	#[ORM\Column]
	private string $name;

	#[ORM\Column(unique: true)]
	private string $email;

	public function __construct(string $name, string $email, ?string $uid = null) {
		$this->uid = $uid ?? ByteString::fromRandom();
		$this->name = $name;
		$this->email = $email;
	}

	public function getId(): ?int {
		return $this->id;
	}

	public function getUid(): string {
		return $this->uid;
	}

	public function getName(): ?string {
		return $this->name;
	}

	public function setName(string $name): void {
		$this->name = $name;
	}

	public function getEmail(): ?string {
		return $this->email;
	}
}
