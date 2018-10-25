<?php
/**
 * Created by IntelliJ IDEA.
 * User: robin
 * Date: 24/10/18
 * Time: 15:34
 */

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Country;
use App\Entity\Location;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LocationFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $countries = $manager->getRepository(Country::class)->findAll();

        for ($i = 0; $i <10; $i++) {
            $location = new Location();
            $location->setName($faker->city);

            $country = $countries[array_rand($countries, 1)];

            $location->setCountry($country);

            $manager->persist($location);
        }

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 4;
    }
}