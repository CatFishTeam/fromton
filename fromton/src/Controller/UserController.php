<?php

namespace App\Controller;

use App\Entity\Friendship;
use App\Entity\User;
use App\Repository\FriendshipRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

        $friends = $friendRepo->getAllFriends($me);

        $friendsArray = [];

        foreach ($friends as $friend) {
            $friendsArray[] = $friend->getFriend()->getFullName();
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
    public function follow(User $user, EntityManagerInterface $em)
    {
        /** @var User $me */
        $me = $this->getUser();
        $me->addFriend($user);
        $em->persist($me);
        $em->flush();

        $this->addFlash('success', 'Vous êtes maintenant ami avec ' . $user->getFullName());

        return $this->redirectToRoute('users');
    }
}
