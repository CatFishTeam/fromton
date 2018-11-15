<?php
/**
 * Created by IntelliJ IDEA.
 * User: robin
 * Date: 25/10/18
 * Time: 11:32
 */

namespace App\DataFixtures;


use App\Entity\Badge;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class BadgeFixtures extends Fixture implements OrderedFixtureInterface
{
    
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $badge1 = new Badge();
        $badge1->setId(1);
        $badge1->setName("Premier Fromage");
        $badge1->setDescription("Vous avez noté votre premier fromage");
        $manager->persist($badge1);

        $badge2 = new Badge();
        $badge2->setId(2);
        $badge2->setName("Débutant fromager");
        $badge2->setDescription("Vous avez noté 10 fromages");
        $manager->persist($badge2);

        $badge3 = new Badge();
        $badge3->setId(3);
        $badge3->setName("Débutant fromages de chèvre");
        $badge3->setDescription("Vous avez noté 10 fromages de chèvre");
        $manager->persist($badge3);

        $badge4 = new Badge();
        $badge4->setId(4);
        $badge4->setName("Sociabilisation");
        $badge4->setDescription("Vous avez ajouté votre premier ami");
        $manager->persist($badge4);

        $badge5 = new Badge();
        $badge5->setId(5);
        $badge5->setName("Niveau 2");
        $badge5->setDescription("Vous avez atteint le niveau 2");
        $manager->persist($badge5);

        $manager->flush();
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