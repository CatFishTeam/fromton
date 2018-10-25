<?php

namespace App\Controller;

use App\Entity\UsersCheesesRatings;
use App\Form\ArticleType;
use App\Entity\User;
use App\Utils\Tools;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\UserController;

/**
 * @Route(path="/profil")
 */
class ProfilController extends AbstractController
{
    /**
     * @Route(path="/{id}", methods={"GET"}, name="profil_index")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function index(Request $request, $id, Tools $tools)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var User $user */
        $user = $em->getRepository(User::class)->find($id);

        $badges = $user->getBadges();

        $ratings = $this->getDoctrine()->getRepository(UsersCheesesRatings::class)->findBy(['user' => $user]);

        $tab = $tools->calculLevel($user->getXp());
        //@TODO :
        // affichage des amis
        // affichage des ratings
        // affichage des cheezes


        return $this->render('profil/index.html.twig',
            [
                'user' => $user,
                'level' => $tab[0],
                'reste' => $tab[1],
                'badges' => $badges,
                'ratings' => $ratings,
            ]
        );
    }

}
