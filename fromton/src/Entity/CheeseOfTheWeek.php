<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CheeseOfTheWeekRepository")
 */
class CheeseOfTheWeek
{
    use TimestampableTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Cheese")
     */
    private $cheese;

    /**
     * @ORM\Column(type="integer")
     */
    private $clicks = 0;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startingDateOfPromotion;


    /**
     * @ORM\Column(type="datetime")
     */
    private $endingDateOfPromotion;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCheese()
    {
        return $this->cheese;
    }

    /**
     * @param mixed $cheese
     */
    public function setCheese($cheese): void
    {
        $this->cheese = $cheese;
    }

    /**
     * @return mixed
     */
    public function getClicks()
    {
        return $this->clicks;
    }

    /**
     * @param mixed $clicks
     */
    public function setClicks($clicks): void
    {
        $this->clicks = $clicks;
    }

    /**
     * @return mixed
     */
    public function getStartingDateOfPromotion()
    {
        return $this->startingDateOfPromotion;
    }

    /**
     * @param mixed $startingDateOfPromotion
     */
    public function setStartingDateOfPromotion($startingDateOfPromotion): void
    {
        $this->startingDateOfPromotion = $startingDateOfPromotion;
    }

    /**
     * @return mixed
     */
    public function getEndingDateOfPromotion()
    {
        return $this->endingDateOfPromotion;
    }

    /**
     * @param mixed $endingDateOfPromotion
     */
    public function setEndingDateOfPromotion($endingDateOfPromotion): void
    {
        $this->endingDateOfPromotion = $endingDateOfPromotion;
    }
}
