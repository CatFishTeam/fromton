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
        $badge1->setName("Premier Fromage");
        $badge1->setDescription("Vous avez note votre premier fromage");
        $manager->persist($badge1);

        $badge2 = new Badge();
        $badge2->setName("Debutant fromager");
        $badge2->setDescription("Vous avez note 10 fromages");
        $manager->persist($badge2);

        $badge3 = new Badge();
        $badge3->setName("Debutant fromages de chevre");
        $badge3->setDescription("Vous avez note 10 fromages de chevre");
        $manager->persist($badge3);

        $badge4 = new Badge();
        $badge4->setName("Sociabilisation");
        $badge4->setDescription("Vous avez ajoute votre premier ami");
        $manager->persist($badge4);

        $badge5 = new Badge();
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