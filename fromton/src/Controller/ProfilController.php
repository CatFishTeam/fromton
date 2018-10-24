<?php
namespace App\Controller;

use App\Form\ArticleType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);
        $level = $this->calculLevel($user->getXp());
        return $this->render('profil/index.html.twig', ['user'=> $user, 'level'=> $level]);
    }

    public function calculLevel($xp)
    {
        $level = 0;
        if ($xp == 1) {
            $level = 1;
        }
        else if ($xp > 1 && $xp < 10) {
            $level = 2;
        }
        else if ($xp >= 10 && $xp < 50) {
            $level = 3;
        }
        else if ($xp >= 50 && $xp < 100) {
            $level = 4;
        }
        else if ($xp >= 100 && $xp < 250) {
            $level = 5;
        }
        else if ($xp >= 250 && $xp < 500) {
            $level = 6;
        }
        else if ($xp >= 500 && $xp < 750) {
            $level = 7;
        }
        else if ($xp >= 750 && $xp < 1000) {
            $level = 8;
        }
        if ($xp / 500 > 2){
            $ret = $xp / 500;
            $level = $ret + 6;
        }
        return $level;
    }

}
