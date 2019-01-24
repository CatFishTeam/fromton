<?php

namespace App\DataFixtures;

use App\Entity\Cheese;
use App\Entity\CheeseOfTheWeek;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class CheeseOfTheWeekFixtures extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {

        $faker = Faker\Factory::create('fr_FR');

        $cheeses = $manager->getRepository(Cheese::class)->findAll();
        $cheeseOfTheWeek = new CheeseOfTheWeek();
        $cheeseOfTheWeek->setStartingDateOfPromotion($faker->dateTimeBetween('-8 days', '-6 days'));
        $cheeseOfTheWeek->setEndingDateOfPromotion($faker->dateTimeBetween('+2 days', '+3 days'));
        $cheeseOfTheWeek->setCreatedAt($faker->dateTime);
        $cheeseOfTheWeek->setUpdatedAt($faker->dateTime);

        $cheese = $cheeses[array_rand($cheeses, 1)];
        $cheeseOfTheWeek->setCheese($cheese);

        $cheeseOfTheWeek->setClicks(0);
        $manager->persist($cheeseOfTheWeek);

        $manager->flush();

    }

    public function getDependencies()
    {
        return [
            'App\DataFixtures\CheeseFixtures',
        ];
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 7;
    }
}
