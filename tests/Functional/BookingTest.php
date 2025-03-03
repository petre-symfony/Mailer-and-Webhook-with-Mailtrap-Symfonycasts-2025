<?php

namespace App\Tests\Functional;

use App\Factory\BookingFactory;
use App\Factory\CustomerFactory;
use App\Factory\TripFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class BookingTest extends KernelTestCase
{
    use ResetDatabase, Factories, HasBrowser;

    /**
     * @test
     */
    public function testCreateBooking(): void
    {
        $trip = TripFactory::createOne([
            'name' => 'Visit Mars',
            'slug' => 'mars',
            'tagLine' => 'The red planet',
        ]);

        BookingFactory::assert()->empty();
        CustomerFactory::assert()->empty();

        $this->browser()
            ->visit('/trip/mars')
            ->assertSuccessful()
            ->fillField('Name', 'Bruce Wayne')
            ->fillField('Email', 'bruce@wayne-enterprises.com')
            ->fillField('Travel Date', (new \DateTime('+1 month'))->format('Y-m-d'))
            ->clickAndIntercept('Book Trip')
            ->assertRedirectedTo('/booking/'.BookingFactory::first()->getUid())
            ->assertSuccessful()
            ->assertSeeIn('h1', 'Visit Mars')
            ->assertSee('The red planet')
        ;

        CustomerFactory::assert()
            ->count(1)
            ->exists(['name'=>'Bruce Wayne', 'email'=>'bruce@wayne-enterprises.com'])
        ;
        BookingFactory::assert()
            ->count(1)
            ->exists(['trip'=>$trip, 'customer' => CustomerFactory::first()])
        ;
    }
}
