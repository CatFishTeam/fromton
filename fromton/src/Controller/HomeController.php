<?php

namespace App\Controller;

use App\Entity\Cheese;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home", methods={"GET"}, host="dev.fromton.io")
     */
    public function index()
    {
        $cheeseRepository = $this->getDoctrine()->getRepository(Cheese::class);

        $cheeses = $cheeseRepository->findBy([],[], 4);
        foreach ($cheeses as $cheese){
            $cheese->rating = $cheeseRepository->globalRating($cheese);
        }
        $cheeseOfTheWeek = $cheeseRepository->cheeseOfTheWeek();

        return $this->render('home/index.html.twig', ['cheeses' => $cheeses, 'cheeseOfTheWeek' => $cheeseOfTheWeek]);
    }

    /**
     * @Route("/pacman", name="pacman", methods={"GET"}, host="dev.fromton.io")
     */
    public function pacman()
    {
        return $this->render('pacman.html.twig');
    }

}