<?php

namespace App\DataFixtures;

use App\Factory\BookingFactory;
use App\Factory\CustomerFactory;
use App\Factory\TripFactory;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture {
	public function load(ObjectManager $manager): void {
		CustomerFactory::createMany(5);

		$krypton = TripFactory::createOne([
			'name' => 'Visit Krypton',
			'slug' => 'krypton',
			'tagLine' => "Explore this advanced culture's science and technology museums and bring home some crystalline souvenirs!",
		]);
		$pleiades = TripFactory::createOne([
			'name' => 'See the Pleiades',
			'slug' => 'pleiades',
			'tagLine' => 'Get an up-close look at the more than 1,000 starts that make up the Pleiades.',
		]);
		$iss = TripFactory::createOne([
			'name' => 'Culinary Tour on the ISS',
			'slug' => 'iss',
			'tagLine' => 'Try freeze-dried, thermo-stabilized, and irradiated foods on this unique culinary adventure!',
		]);
		$arrakis = TripFactory::createOne([
			'name' => 'Arrakis at sunset',
			'slug' => 'arrakis',
			'tagLine' => 'Rolling over the sands, you can see spice in the air!',
		]);
		$miller = TripFactory::createOne([
			'name' => 'Swim Planet Miller',
			'slug' => 'miller',
			'tagLine' => 'This trip is recommended for expert level swimmers!',
		]);
		$cybertron = TripFactory::createOne([
			'name' => 'Robotics Camp on Cybertron',
			'slug' => 'cybertron',
			'tagLine' => 'Try your hand at creating your own vehicle transformers!',
		]);

		BookingFactory::createMany(10, function () {
			return [
				'customer' => CustomerFactory::random(),
				'trip' => TripFactory::random(),
			];
		});

		$clark = CustomerFactory::createOne([
			'name' => 'Clark Kent',
			'email' => 'clark@krypton.com',
			'uid' => 'clark',
		]);

		CustomerFactory::createOne([
			'name' => 'Bruce Wayne',
			'email' => 'bruce@wayneenterprises.com',
			'uid' => 'bruce',
		]);

		BookingFactory::createOne([
			'customer' => $clark,
			'trip' => $krypton,
			'date' => new DateTimeImmutable('+1 month'),
		]);
		BookingFactory::createOne([
			'customer' => $clark,
			'trip' => $pleiades,
			'date' => new DateTimeImmutable('+2 weeks'),
		]);
		BookingFactory::createOne([
			'customer' => $clark,
			'trip' => $miller,
			'date' => new DateTimeImmutable('-1 month'),
		]);
		BookingFactory::createOne([
			'customer' => $clark,
			'trip' => $cybertron,
			'date' => new DateTimeImmutable('-2 weeks'),
		]);
	}
}
