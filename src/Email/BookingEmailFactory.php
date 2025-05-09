<?php

namespace App\Email;

use App\Entity\Booking;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class BookingEmailFactory {
	public function __construct(
		#[Autowire('%kernel.project_dir%/assets/terms-of-service.pdf')]
		private string $termsPath
	) {
	}

	public function createBookingConfirmation(Booking $booking): TemplatedEmail {
		
	}

	public function createBookingRemainder(Booking $booking): TemplatedEmail {
		
	}

	private function createEmail(Booking $booking, string $tag): TemplatedEmail {
		
	}
}