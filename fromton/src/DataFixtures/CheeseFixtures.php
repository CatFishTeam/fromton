<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Cheese;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class CheeseFixtures extends AbstractFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $faker = Faker\Factory::create('fr_FR');

        $categories = [];
        for($i = 0; $i < 5; $i++) {
            $categories[$i] = new Category();
            $categories[$i]->setName($faker->name);
            $categories[$i]->setDescription($faker->text);
            $manager->persist($categories[$i]);
        }

        for ($i = 0; $i < 10; $i++) {
            $cheese = new Cheese();
            $cheese->setName($faker->name);
            $cheese->setDescription($faker->text);
            $cheese->setCategory($categories[rand(0,4)]);
            $manager->persist($cheese);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array('App\DataFixtures\CategoryFixtures');
    }
}