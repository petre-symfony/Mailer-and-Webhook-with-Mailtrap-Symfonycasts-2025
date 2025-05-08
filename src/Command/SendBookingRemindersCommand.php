<?php

namespace App\Command;

use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Mailer\MailerInterface;

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

		}
		
		return Command::SUCCESS;
	}
}
