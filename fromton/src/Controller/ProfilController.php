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
        $tab = $this->calculLevel($user->getXp());
        // affichage des amis
        // affichage des ratings
        // affichage des notes
        return $this->render('profil/index.html.twig', ['user'=> $user, 'level'=> $tab[0], 'reste'=> $tab[1]]);
    }

    public function calculLevel($xp)
    {
        $level = 0;
        $reste = 0;
        if ($xp == 1) {
            $level = 1;
            $reste = 9;
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
