<?php
namespace App\Controller;

use App\Form\ArticleType;
use App\Entity\User;
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
    public function index(Request $request, $id)
    {
        $userController = new UserController();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);
        $tab = $userController->calculLevel($user->getXp());
        //@TODO :
        // affichage des amis
        // affichage des ratings
        // affichage des cheezes
        // affichage des notes

        return $this->render('profil/index.html.twig', ['user'=> $user, 'level'=> $tab[0], 'reste'=> $tab[1]]);
    }

}
