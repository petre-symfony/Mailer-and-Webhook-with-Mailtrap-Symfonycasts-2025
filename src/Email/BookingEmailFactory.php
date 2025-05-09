<?php

namespace App\Email;

use App\Entity\Booking;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\Header\MetadataHeader;
use Symfony\Component\Mailer\Header\TagHeader;
use Symfony\Component\Mime\Address;

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
		$customer = $booking->getCustomer();
		$trip = $booking->getTrip();
		$email = (new TemplatedEmail())
			->to(new Address($customer->getEmail(), $customer->getName()))
			->context([
				'customer' => $customer,
				'trip' => $trip,
				'booking' => $booking
			])
		;

		$email->getHeaders()->add(new TagHeader($tag));
		$email->getHeaders()->add(new MetadataHeader('booking_uid', $booking->getUid()));
		$email->getHeaders()->add(new MetadataHeader('customer_uid', $customer->getUid()));

		return $email;
	}
}