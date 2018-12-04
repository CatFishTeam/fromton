<?php

namespace App\Repository;

use App\Entity\CheeseOfTheWeek;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method CheeseOfTheWeek|null find($id, $lockMode = null, $lockVersion = null)
 * @method CheeseOfTheWeek|null findOneBy(array $criteria, array $orderBy = null)
 * @method CheeseOfTheWeek[]    findAll()
 * @method CheeseOfTheWeek[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CheeseOfTheWeekRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CheeseOfTheWeek::class);
    }

    public function actualCheese()
    {

    }

}
