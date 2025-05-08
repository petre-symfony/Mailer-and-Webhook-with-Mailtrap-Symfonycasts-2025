<?php

namespace App\Command;

use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Mailer\Header\MetadataHeader;
use Symfony\Component\Mailer\Header\TagHeader;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

#[AsCommand(
	name: 'app:send-booking-reminders',
	description: 'Send booking reminder emails',
)]
class SendBookingRemindersCommand extends Command {
	public function __construct(
		private BookingRepository $bookingRepo,
		private EntityManagerInterface $em,
		private MailerInterface $mailer
	) {
		parent::__construct();
	}

	protected function execute(InputInterface $input, OutputInterface $output): int {
		$io = new SymfonyStyle($input, $output);

		$io->title('Sending Booking reminders');

		$bookings = $this->bookingRepo->findBookingsToRemind();

		foreach ($io->progressIterate($bookings) as $booking) {
			$customer = $booking->getCustomer();
			$trip = $booking->getTrip();
			$email = (new TemplatedEmail())
				->to(new Address($customer->getEmail(), $customer->getName()))
				->subject('Booking Reminder for '. $trip->getName())
				->htmlTemplate('email/booking_reminder.html.twig')
				->context([
					'customer' => $customer,
					'trip' => $trip,
					'booking' => $booking
				])
			;

			$email->getHeaders()->add(new TagHeader('booking reminder'));
			$email->getHeaders()->add(new MetadataHeader('booking_uid', $booking->getUid()));
			$email->getHeaders()->add(new MetadataHeader('customer_uid', $customer->getUid()));

			$this->mailer->send($email);
			$booking->setReminderSentAt(new \DateTimeImmutable('now'));
		}

		$this->em->flush();

		$io->success(sprintf('Sent %d booking reminders', count($bookings)));

		return Command::SUCCESS;
	}
}
