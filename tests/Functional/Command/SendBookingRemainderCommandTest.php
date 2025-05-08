<?php

namespace App\Tests\Functional\Command;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;
use Zenstruck\Mailer\Test\InteractsWithMailer;

class SendBookingRemainderCommandTest extends KernelTestCase {
	use ResetDatabase, Factories, InteractsWithMailer;

	public function testNoReminderSent() {
		$this->markTestIncomplete();
	}

	public function testReminderSent() {
		$this->markTestIncomplete();
	}
}
