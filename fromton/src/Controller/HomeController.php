<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Cheese;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $cheeses = $this->getDoctrine()
            ->getRepository(Cheese::class)
            ->findBy([],[], 4);

        dump($cheeses);

        return $this->render('home/index.html.twig', ['cheeses' => $cheeses]);
    }
}
