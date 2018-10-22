<?php

namespace App\Controller;

use App\Repository\CheeseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Cheese;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function index()
    {
        $cheeseRepository = $this->getDoctrine()->getRepository(Cheese::class);

        $cheeses = $cheeseRepository->findBy([],[], 4);
        $cheeseOfTheWeek = $cheeseRepository->cheeseOfTheWeek();

        dump($cheeseOfTheWeek);

        return $this->render('home/index.html.twig', ['cheeses' => $cheeses, 'cheeseOfTheWeek' => $cheeseOfTheWeek]);
    }

}