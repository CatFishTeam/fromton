<?php

namespace App\Repository;

use App\Entity\Cheese;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Cheese|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cheese|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cheese[]    findAll()
 * @method Cheese[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CheeseRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Cheese::class);
    }

    //@TODO Shall not Change
    public function cheeseOfTheWeek(): ?Cheese
    {
        $cheese = $this->findOneBy([], []);
        return $cheese;
    }
}
