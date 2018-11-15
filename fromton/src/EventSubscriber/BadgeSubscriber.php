<?php

namespace App\EventSubscriber;


use App\Badge;
use App\Entity\Category;
use App\Entity\Friendship;
use App\Entity\Rating;
use App\Entity\User;
use App\Entity\UsersCheesesRatings;
use App\Events;
use App\Repository\BadgeRepository;
use App\Repository\FriendshipRepository;
use App\Utils\Tools;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class BadgeSubscriber implements EventSubscriberInterface
{

    private $em;
    private $badgeRepository;
    private $tools;

    public function __construct(EntityManagerInterface $em, BadgeRepository $badgeRepository, Tools $tools)
    {
        $this->em = $em;
        $this->badgeRepository = $badgeRepository;
        $this->tools = $tools;
    }


    public static function getSubscribedEvents(): array
    {
        return [
            // le nom de l'event et le nom de la fonction qui sera déclenché
            Events::CHEESE_RATE => 'onCheeseRated',
            Events::XP_UP => 'onXpUp',
            Events::FRIEND_ADD => 'onFriendAdd',
        ];
    }

    public function onCheeseRated(GenericEvent $event): void
    {

        /** @var UsersCheesesRatings $userCheeseRating */
        $userCheeseRating = $event->getSubject();

        /** @var User $user */
        $user = $userCheeseRating->getUser();

        $usersCheeseRatings = $this->em->getRepository(UsersCheesesRatings::class)->getAllCheesesRatedByUser($user);

        switch (count($usersCheeseRatings)) {
            case 1:
                $user->addBadge($this->badgeRepository->find(Badge::BADGE_CHEESE_1));
                $this->em->persist($user);
                break;
            case 10:
                $user->addBadge($this->badgeRepository->find(Badge::BADGE_CHEESE_10));
                $this->em->persist($user);
                break;
            default:
                break;

        }


        /** @var Rating $rating */
        $rating = $userCheeseRating->getRating();
        $rating = $rating->getMark();

        switch ($rating) {
            case 0.1:
                $user->addBadge($this->badgeRepository->find(Badge::BADGE_RATE_0_1));
                $this->em->persist($user);
                break;
            case 2.5:
                $user->addBadge($this->badgeRepository->find(Badge::BADGE_RATE_2_5));
                $this->em->persist($user);
                break;
            case 5:
                $user->addBadge($this->badgeRepository->find(Badge::BADGE_RATE_5));
                $this->em->persist($user);
                break;
            default:
                break;

        }

        $this->em->flush();

    }

    public function onFriendAdd(GenericEvent $event): void
    {
        /** @var User $user */
        $user = $event->getSubject();

        /** @var FriendshipRepository $friendRepo */
        $friendRepo = $this->em->getRepository(Friendship::class);

        $friends = $friendRepo->getAllFriends($user);

        switch (count($friends)) {
            case 1:
                $user->addBadge($this->badgeRepository->find(Badge::BADGE_FRIEND_1));
                $this->em->persist($user);
                break;
            case 10:
                $user->addBadge($this->badgeRepository->find(Badge::BADGE_FRIEND_10));
                $this->em->persist($user);
                break;
            default:
                break;

        }
        $this->em->flush();

    }

    public function onXpUp(GenericEvent $event): void
    {
        /** @var User $user */
        $user = $event->getSubject();

        $xp = $user->getXp();

        $level = $this->tools->calculLevel($xp)[0];

        switch ($level) {
            case 2:
                $user->addBadge($this->badgeRepository->find(Badge::BADGE_LEVEL_2));
                $this->em->persist($user);
                break;
            case 5:
                $user->addBadge($this->badgeRepository->find(Badge::BADGE_LEVEL_2));
                $this->em->persist($user);
                break;
            case 10:
                $user->addBadge($this->badgeRepository->find(Badge::BADGE_LEVEL_2));
                $this->em->persist($user);
                break;
            default:
                break;

        }
        $this->em->flush();

    }

}