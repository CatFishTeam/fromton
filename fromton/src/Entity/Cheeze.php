<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CheezeRepository")
 */
class Cheeze
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Cheese", inversedBy="cheezes")
     * @ORM\JoinColumn(name="cheese_id", referencedColumnName="id", nullable=true)
     */
    private $cheese;


    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="cheezes")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Publication", inversedBy="cheezes")
     * @ORM\JoinColumn(name="publication_id", referencedColumnName="id", nullable=true)
     */
    private $publication;

    public function getId(): ?int
    {
        return $this->id;
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
    public function getPublication()
    {
        return $this->publication;
    }

    /**
     * @param mixed $publication
     */
    public function setPublication($publication): void
    {
        $this->publication = $publication;
    }

}
