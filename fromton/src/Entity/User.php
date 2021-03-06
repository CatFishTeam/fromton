<?php

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\TimestampableTrait;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields="email", message="Email déjà pris")
 * @UniqueEntity(fields="username", message="Username déjà pris")
 */
class User implements UserInterface, \Serializable
{
    use TimestampableTrait;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $fullName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64, nullable=false)
     */
    private $token;

    /**
     * @var array
     *
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", options={"default" : 0})
     */
    private $validate;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $xp;


    /**
     * @ORM\OneToMany(targetEntity="UsersCheesesRatings", mappedBy="user")
     */
    private $usersCheesesRatings;

    /**
     * @ORM\OneToMany(targetEntity="Notification", mappedBy="user", fetch="EAGER")
     */
    private $notifications;

    /**
     * @ORM\OneToMany(targetEntity="Publication", mappedBy="user", fetch="EAGER")
     */
    private $publication;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cheeze", mappedBy="user")
     */
    private $cheezes;

    /**
     * @ORM\OneToMany(targetEntity="Friendship", mappedBy="user")
     */
    private $friends;

    /**
     * Many Users have many Users.
     * @ORM\OneToMany(targetEntity="Friendship", mappedBy="friend", cascade={"persist"})
     */
    private $friendsWithMe;

    /**
     * ORM\OneToMany(targetEntity="Cheese", mappedBy="cheese")
     */
    private $cheese;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Badge", mappedBy="users")
     */
    private $badges;

    public function __construct()
    {
        $this->usersCheesesRatings = new ArrayCollection();
        $this->friendsWithMe = new ArrayCollection();
        $this->myFriends = new ArrayCollection();
        $this->badges = new ArrayCollection();
        $this->notifications = new ArrayCollection();
        $this->publication = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
    }

    // le ? signifie que cela peut aussi retourner null
    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * Retourne les rôles de l'user
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        // Afin d'être sûr qu'un user a toujours au moins 1 rôle
        if (empty($roles)) {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function addFriendship(Friendship $friendship)
    {
        $this->friends->add($friendship);
        $friendship->getFriend()->addFriendshipWithMe($friendship);
    }

    public function addFriendshipWithMe(Friendship $friendship)
    {
        $this->friendsWithMe->add($friendship);
    }

    public function addFriend(User $friend)
    {
        $friendship = new Friendship();
        $friendship->setUser($this);
        $friendship->setFriend($friend);
        $this->addFriendship($friendship);
    }

    public function isValidate(): ?bool
    {
        return $this->validate;
    }

    public function setValidate(bool $validate): void
    {
        $this->validate = $validate;
    }

    public function getXp(): ?int
    {
        return $this->xp;
    }

    public function setXp(int $xp): void
    {
        $this->xp = $xp;
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

    public function getCheeses() {
        return $this->cheeses;
    }


    public function addCheese(Cheese $cheese)
    {
        $cheese->addUser($this); // synchronously updating inverse side
        $this->cheeses[] = $cheese;
    }

    /**
     * Retour le salt qui a servi à coder le mot de passe
     *
     * {@inheritdoc}
     */
    public function getSalt(): ?string
    {
        // See "Do you need to use a Salt?" at https://symfony.com/doc/current/cookbook/security/entity_provider.html
        // we're using bcrypt in security.yml to encode the password, so
        // the salt value is built-in and you don't have to generate one

        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * {@inheritdoc}
     */
    public function eraseCredentials(): void
    {
        // Nous n'avons pas besoin de cette methode car nous n'utilions pas de plainPassword
        // Mais elle est obligatoire car comprise dans l'interface UserInterface
        // $this->plainPassword = null;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(): string
    {
        return serialize([$this->id, $this->username, $this->password]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized): void
    {
        [$this->id, $this->username, $this->password] = unserialize($serialized, ['allowed_classes' => false]);
    }

    /**
     * @return Collection|Badge[]
     */
    public function getBadges(): Collection
    {
        return $this->badges;
    }

    public function addBadge(Badge $badge): self
    {
        if (!$this->badges->contains($badge)) {
            $this->badges[] = $badge;
            $badge->addUser($this);
        }

        return $this;
    }

    public function removeBadge(Badge $badge): self
    {
        if ($this->badges->contains($badge)) {
            $this->badges->removeElement($badge);
            $badge->removeUser($this);
        }

        return $this;
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
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * @return mixed
     */
    public function getPublication()
    {
        return $this->publication;
    }
}