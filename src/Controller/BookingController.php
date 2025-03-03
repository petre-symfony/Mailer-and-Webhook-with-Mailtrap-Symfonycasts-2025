<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Customer;
use App\Repository\BookingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BookingController extends AbstractController {
	#[Route('/bookings/{uid:customer}', name: 'bookings')]
	public function bookings(Customer $customer, BookingRepository $bookings): Response {
		return $this->render('booking/index.html.twig', [
			'customer' => $customer,
			'upcoming' => $bookings->findUpcomingFor($customer),
			'previous' => $bookings->findPreviousFor($customer),
		]);
	}

	#[Route('/booking/{uid:booking}', name: 'booking_show')]
	public function show(Booking $booking): Response {
		return $this->render('booking/show.html.twig', [
			'booking' => $booking,
		]);
	}
}
