<?php

namespace App\Dto;

use DateTimeImmutable;
use Symfony\Component\Validator\Constraints as Assert;

class BookingDto {
	#[Assert\NotBlank]
	public ?string $name = null;

	#[Assert\NotBlank]
	#[Assert\Email]
	public ?string $email = null;

	#[Assert\NotBlank]
	#[Assert\GreaterThan('today', message: 'Your travel date must be in the future.')]
	public ?DateTimeImmutable $date = null;
}
