<?php

namespace App\Factory;

use App\Entity\Booking;
use DateTimeImmutable;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Booking>
 */
final class BookingFactory extends PersistentProxyObjectFactory {
	public static function class(): string {
		return Booking::class;
	}

	protected function defaults(): array|callable {
		return [
			'customer' => CustomerFactory::new(),
			'date' => DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('-1 year', '+1 year')),
			'trip' => TripFactory::new(),
		];
	}
}
