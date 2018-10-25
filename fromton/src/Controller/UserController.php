<?php

namespace App\Controller;

use App\Entity\User;
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
        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findAll();
        $me = $this->getUser();

        return $this->render('user/users.html.twig', [
            'controller_name' => 'UserController',
            'users' => $users,
            'me' => $me,
        ]);
    }

    /**
     * @Route("/follow/{id}", name="follow")
     */
    public function follow(User $user)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findAll();
        $me = $this->getUser();

        return $this->render('user/users.html.twig', [
            'controller_name' => 'UserController',
            'users' => $users,
            'me' => $me,
            'follow' => $user,
        ]);
    }

    public function calculLevel($xp)
    {
        $level = 0;
        $reste = 0;
        if ($xp == 1) {
            $level = 1;
            $reste = 1;
        }
        else if ($xp > 1 && $xp < 10) {
            $level = 2;
            $reste = 10 - $xp;
        }
        else if ($xp >= 10 && $xp < 50) {
            $level = 3;
            $reste = 50 - $xp;
        }
        else if ($xp >= 50 && $xp < 100) {
            $level = 4;
            $reste = 100 - $xp;
        }
        else if ($xp >= 100 && $xp < 250) {
            $level = 5;
            $reste = 250 - $xp;
        }
        else if ($xp >= 250 && $xp < 500) {
            $level = 6;
            $reste = 500 - $xp;
        }
        else if ($xp >= 500 && $xp < 750) {
            $level = 7;
            $reste = 750 - $xp;
        }
        else if ($xp >= 750 && $xp < 1000) {
            $level = 8;
            $reste = 1000 - $xp;
        }
        if ($xp / 500 > 2){
            $ret = $xp / 500;
            $level = $ret + 6;
            $reste = $xp % 500;
        }
        $tab = [$level, $reste];
        return $tab;
    }
}
