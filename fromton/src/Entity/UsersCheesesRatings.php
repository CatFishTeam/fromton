<?php

namespace App\Entity;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersCheesesRatingsRepository")
 * @ORM\Table(name="`users_cheeses_ratings`")
 */
class UsersCheesesRatings
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="usersCheesesRatings", cascade={"persist"})
     * @JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @ManyToOne(targetEntity="Cheese", inversedBy="usersCheesesRatings", cascade={"persist"})
     * @JoinColumn(name="cheese_id", referencedColumnName="id", nullable=false)
     */
    private $cheese;

    /**
     * @ManyToOne(targetEntity="Rating", inversedBy="usersCheesesRatings", cascade={"persist"})
     * @JoinColumn(name="rating_id", referencedColumnName="id", nullable=false)
     */
    private $rating;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
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
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param mixed $rating
     */
    public function setRating($rating): void
    {
        $this->rating = $rating;
    }

}