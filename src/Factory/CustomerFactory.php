<?php

namespace App\Factory;

use App\Entity\Customer;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Customer>
 */
final class CustomerFactory extends PersistentProxyObjectFactory {
	public static function class(): string {
		return Customer::class;
	}

	protected function defaults(): array|callable {
		return [
			'email' => self::faker()->unique()->email(),
			'name' => implode(' ', [self::faker()->firstName(), self::faker()->lastName()]),
		];
	}
}
