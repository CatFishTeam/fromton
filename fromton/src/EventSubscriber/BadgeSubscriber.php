<?php

namespace App\EventSubscriber;


use App\Badge;
use App\Entity\Category;
use App\Entity\User;
use App\Entity\UsersCheesesRatings;
use App\Events;
use App\Repository\BadgeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class BadgeSubscriber implements EventSubscriberInterface
{

    private $em;
    private $badgeRepository;

    public function __construct(EntityManagerInterface $em, BadgeRepository $badgeRepository)
    {
        $this->em = $em;
        $this->badgeRepository = $badgeRepository;
    }


    public static function getSubscribedEvents(): array
    {
        return [
            // le nom de l'event et le nom de la fonction qui sera déclenché
            Events::CHEESE_RATE => 'onCheeseRated',
        ];
    }

    public function onCheeseRated(GenericEvent $event): void
    {

        /** @var UsersCheesesRatings $userCheeseRating */
        $userCheeseRating = $event->getSubject();

        /** @var User $user */
        $user = $userCheeseRating->getUser();

        $usersCheeseRatings = $this->em->getRepository(UsersCheesesRatings::class)->getAllCheesesRatedByUser($user);

        dump($usersCheeseRatings);

        switch (count($usersCheeseRatings)) {
            case 1:
                $user->addBadge($this->badgeRepository->find(Badge::BADGE_CHEESE_1));
                $this->em->persist($user);
                break;
            case 10:
                $user->addBadge($this->badgeRepository->find(Badge::BADGE_CHEESE_1));
                $this->em->persist($user);
                break;
            default:
                break;

        }
        $this->em->flush();

    }

}