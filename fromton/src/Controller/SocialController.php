<?php

namespace App\Controller;

use App\Entity\Friendship;
use App\Repository\FriendshipRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SocialController extends AbstractController
{
    /**
     * @Route("/social", name="social")
     */
    public function index()
    {
        return $this->render('social/index.html.twig', [
            'controller_name' => 'SocialController',
        ]);
    }

    /**
     * @Route("/followers", name="followers")
     */
    public function followers()
    {
        /** @var FriendshipRepository $friendRepo */
        $friendRepo = $this->getDoctrine()->getRepository(Friendship::class);

        $me = $this->getUser();

        $followers = [];

        if ($me) {
            $followers = $friendRepo->getAllFollowers($me);
        }

        return $this->render('social/followers.html.twig', [
            'me' => $me,
            'followers' => $followers,
        ]);
    }

    /**
     * @Route("/suivis", name="friends")
     */
    public function friends()
    {
        /** @var FriendshipRepository $friendRepo */
        $friendRepo = $this->getDoctrine()->getRepository(Friendship::class);

        $me = $this->getUser();

        $friends = [];

        if ($me) {
            $friends = $friendRepo->getAllFriends($me);
        }

        return $this->render('social/friends.html.twig', [
            'me' => $me,
            'friends' => $friends,
        ]);
    }
}
