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
        $badge5->setName("Déjà 10");
        $badge5->setDescription("Vous avez ajouté 10 amis");
        $manager->persist($badge5);

        $badge6 = new Badge();
        $badge6->setId(6);
        $badge6->setName("Niveau 2");
        $badge6->setDescription("Vous avez atteint le niveau 2");
        $manager->persist($badge6);

        $badge7 = new Badge();
        $badge7->setId(7);
        $badge7->setName("Niveau 5");
        $badge7->setDescription("Vous avez atteint le niveau 5");
        $manager->persist($badge7);

        $badge8 = new Badge();
        $badge8->setId(8);
        $badge8->setName("Niveau 10");
        $badge8->setDescription("Vous avez atteint le niveau 10");
        $manager->persist($badge8);

        $badge9 = new Badge();
        $badge9->setId(9);
        $badge9->setName("Degueulasse !");
        $badge9->setDescription("Vous avez note un fromage 0.1 etoiles");
        $manager->persist($badge9);

        $badge10 = new Badge();
        $badge10->setId(10);
        $badge10->setName("Mouais");
        $badge10->setDescription("Vous avez note un fromage 2.5 etoiles");
        $manager->persist($badge10);

        $badge11 = new Badge();
        $badge11->setId(11);
        $badge11->setName("Delicieux !");
        $badge11->setDescription("Vous avez note un fromage 5 etoiles");
        $manager->persist($badge11);

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