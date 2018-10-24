<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersCheesesRatings")
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
     * @ManyToOne(targetEntity="User", inversedBy="eventsPeopleRoles")
     * @JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @ManyToOne(targetEntity="Cheese", inversedBy="eventsPeopleRoles")
     * @JoinColumn(name="cheese_id", referencedColumnName="id", nullable=false)
     */
    private $cheese;

    /**
     * @ManyToOne(targetEntity="Rating", inversedBy="eventsPeopleRoles")
     * @JoinColumn(name="rating_id", referencedColumnName="id", nullable=false)
     */
    private $rating;

}