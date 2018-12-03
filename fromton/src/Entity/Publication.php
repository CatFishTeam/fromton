<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PublicationRepository")
 */
class Publication
{
    use TimestampableTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $texte;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cheeze", mappedBy="publication")
     */
    private $cheezes;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="publications")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTexte()
    {
        return $this->texte;
    }

    /**
     * @param mixed $texte
     */
    public function setTexte($texte): void
    {
        $this->texte = $texte;
    }

    /**
     * @return mixed
     */
    public function getCheezes()
    {
        return $this->cheezes;
    }

    /**
     * @param mixed $cheezes
     */
    public function setCheezes($cheezes): void
    {
        $this->cheezes = $cheezes;
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
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * @param mixed $notifications
     */
    public function setNotifications($notifications): void
    {
        $this->notifications = $notifications;
    }

    public function addPublication(User $user, $text)
    {
        $this->setTexte($text);
        $this->setUser($user);
    }

}
