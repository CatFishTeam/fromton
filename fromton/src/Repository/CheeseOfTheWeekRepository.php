<?php

namespace App\Repository;

use App\Entity\Cheese;
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

    public function actualCheese(): CheeseOfTheWeek
    {
        $COWS = $this->findBy([], ['startingDateOfPromotion' => 'ASC']);
        $today = new \DateTime();
        foreach ($COWS as $i => $COW) {
            if($COW->getStartingDateOfPromotion() > $today){
                unset($COWS[$i]);
            }
            if($COW->getEndingDateOfPromotion() < $today){
                unset($COWS[$i]);
            }
        }
        return $COWS[count($COWS)];
    }

}
