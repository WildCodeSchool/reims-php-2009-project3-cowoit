<?php

namespace App\DataFixtures;

use Faker;
use Faker\Factory;
use App\Entity\Trip;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TripFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $generator = Faker\Factory::create("en_US");
        for ($i = 0; $i < 10; $i++) {
            $trip = new Trip();
            $trip
                ->setDate($generator->date)
                ->setAddressStart($generator->city)
                ->setAddressEnd($generator->city)
                ->setNbPassengers($generator->numberBetween(1, 4));
            $manager->persist($trip);
        }

        $manager->flush();
    }
}
