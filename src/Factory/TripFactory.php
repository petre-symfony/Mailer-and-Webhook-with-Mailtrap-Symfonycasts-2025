<?php

namespace App\Factory;

use App\Entity\Trip;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Trip>
 */
final class TripFactory extends PersistentProxyObjectFactory {
	public static function class(): string {
		return Trip::class;
	}

	protected function defaults(): array|callable {
		return [
			'name' => self::faker()->text(),
			'slug' => self::faker()->unique()->slug(),
			'tagLine' => self::faker()->text(),
		];
	}

}
