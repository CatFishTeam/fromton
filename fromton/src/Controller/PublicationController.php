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

class PublicationController extends AbstractController
{
    /**
     * @Route(path="/{id}", methods={"GET"}, name="publications")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function index(Request $request, $id)
    {
        
    }

}
