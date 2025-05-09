<?php

namespace App\Webhook;

use Symfony\Component\RemoteEvent\Attribute\AsRemoteEventConsumer;
use Symfony\Component\RemoteEvent\Consumer\ConsumerInterface;
use Symfony\Component\RemoteEvent\Event\Mailer\MailerDeliveryEvent;
use Symfony\Component\RemoteEvent\Event\Mailer\MailerEngagementEvent;
use Symfony\Component\RemoteEvent\RemoteEvent;

#[AsRemoteEventConsumer('mailtrap')]
class EmailEventConsumer implements ConsumerInterface {
	/**
	 * @param MailerDeliveryEvent|MailerEngagementEvent $event
	 * @return void
	 */
	public function consume(RemoteEvent $event): void {
		dump($event);
	}

}