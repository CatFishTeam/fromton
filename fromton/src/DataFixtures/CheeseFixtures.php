<?php
/**
 * Created by IntelliJ IDEA.
 * User: robin
 * Date: 02/10/18
 * Time: 16:25
 */

namespace App\DataFixtures;

use App\Entity\Cheese;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class CheeseFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $cheese = new Cheese();
            $cheese->setName($faker->name);
            $cheese->setDescription($faker->text);
            $cheese->setCategory($faker->name);
            $manager->persist($cheese);
        }

        $manager->flush();
    }
}