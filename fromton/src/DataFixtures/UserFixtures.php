<?php
/**
 * Created by IntelliJ IDEA.
 * User: robin
 * Date: 02/10/18
 * Time: 16:25
 */

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $user = new User();
        $user->setFullName("admin");
        $user->setUsername("root");
        $user->setEmail("mael.mayon@free.fr");
        $user->setPassword($this->passwordEncoder->encodePassword($user, "root"));
        $user->setCreatedAt($faker->dateTime);
        $user->setXp($faker->numberBetween(1, 3000));
        $user->setValidate(true);
        $user->setToken(md5(random_bytes(20)));
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $manager->persist($user);
        $manager->flush();

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setFullName($faker->name);
            $user->setUsername($faker->userName);
            $user->setEmail($faker->email);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $faker->password));
            $user->setCreatedAt($faker->dateTime);
            $user->setXp($faker->numberBetween(1, 3000));
            $user->setValidate(true);
            $user->setToken(md5(random_bytes(20)));
            $manager->persist($user);
        }
        $user = new User();
        $user->setFullName("admin");
        $user->setUsername("root");
        $user->setEmail("mael.mayon@free.fr");
        $user->setPassword($this->passwordEncoder->encodePassword($user, "root"));
        $user->setCreatedAt($faker->dateTime);
        $user->setXp($faker->numberBetween(1, 3000));
        $user->setValidate(true);
        $user->setToken(md5(random_bytes(20)));
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $manager->persist($user);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 5;
    }
}