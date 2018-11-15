<?php

namespace App\Controller;

use App\Entity\Friendship;
use App\Entity\Publication;
use App\Entity\User;
use App\Events;
use App\Repository\FriendshipRepository;
use App\Repository\UserRepository;
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
        $me = $this->getUser();
        $me->addFriend($user);
        $em->persist($me);

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
