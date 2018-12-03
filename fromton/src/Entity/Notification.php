<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity(repositoryClass="App\Repository\NotificationRepository")
 */
class Notification
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
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    private $seen;


    /**
     * @var datetime $createdAt
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * Get createdAt
     * @return datetime
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }


    /**
     * Set createdAt
     * @param datetime $createdAt
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }


    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="notifications")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTexte(): ?string
    {
        return $this->texte;
    }

    public function setTexte(string $texte): self
    {
        $this->texte = $texte;

        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getSeen()
    {
        return $this->seen;
    }

    /**
     * @param mixed $seen
     */
    public function setSeen($seen): void
    {
        $this->seen = $seen;
    }

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

    public function addNotification(User $user, $text)
    {
        $this->setTexte($text);
        $this->setUser($user);
        $this->setSeen(false);
    }
}
