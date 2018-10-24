<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class CategoryFixtures extends Fixture implements OrderedFixtureInterface
{

    private $categories = [
        'Pressée cuite',
        'Molle à croûte naturelle',
        'Molle à croûte lavée',
        'Pressée non cuite',
        'Persillée',
        'Pressée non cuite persillée',
        'Pressée non cuite, fumée au feu de bois',
        'Molle à croute fleurie',
        'Frais à pâte filée',
        'Frais'
    ];

    public function load(ObjectManager $manager)
    {

        $faker = Faker\Factory::create('fr_FR');

        foreach ($this->categories as $value) {
            $category = new Category();
            $category->setName($value);
            $category->setDescription($faker->text);
            $manager->persist($category);
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
        return 2;
    }
}