<?php

namespace App\Repository;

use App\Entity\Cheese;
use App\Entity\User;
use \App\Entity\UsersCheesesRatings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UsersCheesesRatings|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsersCheesesRatings|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsersCheesesRatings[]    findAll()
 * @method UsersCheesesRatings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersCheesesRatingsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UsersCheesesRatings::class);
    }

    public function getRating(User $user, Cheese $cheese){
        return $this->findBy(['user' => $user, 'cheese' => $cheese]);
    }
}