<?php

namespace App\EventListener;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Mailer\Event\MessageEvent;

final class GlobalFromEmailListener {
	public function __construct(
		#[Autowire('%global_from_emails%')]
		private string $fromEmail
	) {
		
	}

	#[AsEventListener]
	public function onMessageEvent(MessageEvent $event): void {
		$message = $event->getMessage();

		if (!$message instanceof TemplatedEmail) {
			return;
		}

		if ($message->getFrom()) {
			return;
		}

		$message->from($this->fromEmail);
	}
}
