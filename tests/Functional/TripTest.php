<?php

namespace App\Tests\Functional;

use App\Factory\TripFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class TripTest extends KernelTestCase
{
    use ResetDatabase, Factories, HasBrowser;

    public function testViewTrips(): void
    {
        TripFactory::createOne([
            'name' => 'Visit Mars',
            'slug' => 'mars',
            'tagLine' => 'The red planet',
        ]);

        $this->browser()
            ->visit('/')
            ->assertSuccessful()
            ->assertSee('Visit Mars')
            ->assertSee('The red planet')
            ->click('Visit Mars')
            ->assertOn('/trip/mars')
            ->assertSeeIn('h1', 'Visit Mars')
            ->assertSee('The red planet')
        ;
    }
}
