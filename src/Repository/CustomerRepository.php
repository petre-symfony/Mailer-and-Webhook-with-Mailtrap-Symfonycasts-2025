<?php

namespace App\Repository;

use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Customer>
 */
class CustomerRepository extends ServiceEntityRepository {
	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, Customer::class);
	}

	public function findOrCreate(string $name, string $email): Customer {
		if ($existing = $this->findOneBy(['email' => $email])) {
			$existing->setName($name);

			return $existing;
		}

		return new Customer($name, $email);
	}
}
