<?php

namespace App\Repository;

use App\Entity\Cheeze;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Cheeze|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cheeze|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cheeze[]    findAll()
 * @method Cheeze[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CheezeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Cheeze::class);
    }

//    /**
//     * @return Cheeze[] Returns an array of Cheeze objects
//     */

    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }


    public function findOneBySomeField($value): ?Cheeze
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}
