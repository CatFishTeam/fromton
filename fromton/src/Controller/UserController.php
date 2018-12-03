<?php

namespace App\Controller;

use App\Entity\Friendship;
use App\Entity\Notification;
use App\Entity\Publication;
use App\Entity\User;
use App\Events;
use App\Repository\FriendshipRepository;
use App\Repository\UserRepository;
use App\Utils\Tools;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/users", name="users")
     */
    public function users()
    {
        /** @var UserRepository $repository */
        $repository = $this->getDoctrine()->getRepository(User::class);
        /** @var FriendshipRepository $friendRepo */
        $friendRepo = $this->getDoctrine()->getRepository(Friendship::class);

        $users = $repository->findAll();
        $me = $this->getUser();

        $friendsArray = [];

        if ($me) {
            $friends = $friendRepo->getAllFriends($me);

            foreach ($friends as $friend) {
                $friendsArray[] = $friend->getFriend()->getFullName();
            }
        }

        return $this->render('user/users.html.twig', [
            'controller_name' => 'UserController',
            'users' => $users,
            'me' => $me,
            'friends' => $friendsArray,
        ]);
    }

    /**
     * @Route("/follow/{id}", name="follow")
     * @param User $user
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function follow(User $user, EntityManagerInterface $em, EventDispatcherInterface $eventDispatcher)
    {
        /** @var User $me */
        $tools = new Tools();
        $me = $this->getUser();
        $me->addFriend($user);
        $em->persist($me);

        // xp + notif xp + publication xp
        $xp = $me->getXp();
        $me->setXp($xp + 3);
        $tab = $tools->calculLevel($xp);
        $tab2 = $tools->calculLevel($me->getXp());
        if ($tab[0] != $tab2[0]) {
            $notificationLevel = new Notification();
            $notificationLevel->addNotification($me, "Vous avez gagné un niveau. Vous êtes maintenant niveau " . $tab2[0]);
            $em->persist($notificationLevel);
            $this->addFlash('success', 'Vous avez gagné un niveau. Vous êtes maintenant niveau ' . $tab2[0]);

            $publicationLevel = new Publication();
            $publicationLevel->addPublication($me, 'Vous avez gagné un niveau. Vous êtes maintenant niveau ' . $tab2[0]);
            $em->persist($publicationLevel);

            $usersFriends = $this->getDoctrine()->getRepository(Friendship::class)->getAllFollowers($me);
            foreach ($usersFriends as $usersFriend){
                $friend = $this->getDoctrine()->getRepository(User::class)->find($usersFriend->getUser());
                $publicationLevelFriend = new Publication();
                $publicationLevelFriend->addPublication($friend,'Votre ami '.$me->getUsername().' ('.$me->getFullName().') est passé niveau '.$tab2[0]);
                $this->em->persist($publicationLevelFriend);
            }
        }
        $em->persist($user);

        $publicationThis = new Publication();
        $publicationThis->addPublication($this->getUser(), 'Vous suivez '.$user->getUsername().' ('.$user->getFullName().')');
        $em->persist($publicationThis);

        $publicationUser = new Publication();
        $publicationUser->addPublication($user, $me->getUsername().' ('.$me->getFullName().') a commencé à vous suivre.');
        $em->persist($publicationUser);

        $this->addFlash('success', 'Vous suivez ' . $user->getUsername());

        $em->flush();

        $event = new GenericEvent($me);
        $eventDispatcher->dispatch(Events::FRIEND_ADD, $event);

        return $this->redirectToRoute('friends');
    }

    /**
     * @Route("/unfollow/{id}", name="unfollow")
     * @param User $friend
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function unfollow(User $friend, EntityManagerInterface $em)
    {
        /** @var User $me */
        $me = $this->getUser();

        /** @var FriendshipRepository $friendRepo */
        $friendRepo = $this->getDoctrine()->getRepository(Friendship::class);
        $friendship = $friendRepo->findOneBy([
            'user' => $me,
            'friend' => $friend,
        ]);

        $em->remove($friendship);
        $em->flush();

        $this->addFlash('success', 'Vous ne suivez plus ' . $friend->getUsername());

        return $this->redirectToRoute('friends');
    }
}
