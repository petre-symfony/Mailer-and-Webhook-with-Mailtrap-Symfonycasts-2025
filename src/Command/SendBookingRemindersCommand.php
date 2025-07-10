<?php

namespace App\Command;

use App\Email\BookingEmailFactory;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Scheduler\Attribute\AsCronTask;

#[AsCommand(
	name: 'app:send-booking-reminders',
	description: 'Send booking reminder emails',
)]
#[AsCronTask('# # * * *')]
class SendBookingRemindersCommand extends Command {
	public function __construct(
		private BookingRepository $bookingRepo,
		private EntityManagerInterface $em,
		private MailerInterface $mailer,
		private BookingEmailFactory $emailFactory
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

			$this->mailer->send($this->emailFactory->createBookingRemainder($booking));
			$booking->setReminderSentAt(new \DateTimeImmutable('now'));
		}

		$this->em->flush();

		$io->success(sprintf('Sent %d booking reminders', count($bookings)));

		return Command::SUCCESS;
	}
}
