<?php

namespace App\Controller;

use App\Dto\BookingDto;
use App\Entity\Booking;
use App\Entity\Trip;
use App\Form\BookingType;
use App\Repository\CustomerRepository;
use App\Repository\TripRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TripController extends AbstractController {
	#[Route('/', name: 'home')]
	public function index(TripRepository $trips): Response {
		return $this->render('trip/index.html.twig', [
			'trips' => $trips->findAll(),
		]);
	}

	#[Route('/trip/{slug:trip}', name: 'trip_show')]
	public function show(Trip $trip, Request $request, CustomerRepository $customers, EntityManagerInterface $em): Response {
		$form = $this->createForm(BookingType::class)->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			/** @var BookingDto $dto */
			$dto = $form->getData();
			$customer = $customers->findOrCreate($dto->name, $dto->email);
			$booking = new Booking($customer, $trip, $dto->date);

			$em->persist($customer);
			$em->persist($booking);
			$em->flush();

			return $this->redirectToRoute('booking_show', ['uid' => $booking->getUid()]);
		}

		return $this->render('trip/show.html.twig', [
			'trip' => $trip,
			'form' => $form,
		]);
	}
}
