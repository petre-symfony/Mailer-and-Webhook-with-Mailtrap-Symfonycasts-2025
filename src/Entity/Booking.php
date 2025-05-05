<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\ByteString;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking {
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(unique: true)]
	private string $uid;

	#[ORM\Column(type: Types::DATE_IMMUTABLE)]
	private DateTimeImmutable $date;

	#[ORM\ManyToOne]
	#[ORM\JoinColumn(nullable: false)]
	private Customer $customer;

	#[ORM\ManyToOne]
	#[ORM\JoinColumn(nullable: false)]
	private Trip $trip;

	#[ORM\Column(nullable: true)]
	private ?\DateTimeImmutable $reminderSentAt = null;

	public function __construct(Customer $customer, Trip $trip, DateTimeImmutable $date, ?string $uid = null) {
		$this->uid = $uid ?? ByteString::fromRandom();
		$this->customer = $customer;
		$this->trip = $trip;
		$this->date = $date;
	}

	public function getId(): ?int {
		return $this->id;
	}

	public function getUid(): string {
		return $this->uid;
	}

	public function getDate(): DateTimeImmutable {
		return $this->date;
	}

	public function getCustomer(): Customer {
		return $this->customer;
	}

	public function getTrip(): ?Trip {
		return $this->trip;
	}

	public function getReminderSentAt(): ?\DateTimeImmutable {
		return $this->reminderSentAt;
	}

	public function setReminderSentAt(?\DateTimeImmutable $reminderSentAt): static {
		$this->reminderSentAt = $reminderSentAt;

		return $this;
	}
}
