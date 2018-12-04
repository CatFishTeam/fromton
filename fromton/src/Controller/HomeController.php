<?php

namespace App\Controller;

use App\Entity\Cheese;
use App\Repository\CheeseOfTheWeekRepository;
use App\Repository\CheeseRepository;
use http\Env\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Template;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home", methods={"GET"}, host="dev.fromton.io")
     * @param CheeseRepository $cheeseRepository
     * @param CheeseOfTheWeekRepository $cheeseOfTheWeekRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(CheeseRepository $cheeseRepository, CheeseOfTheWeekRepository $cheeseOfTheWeekRepository)
    {
        $cheeses = $cheeseRepository->findBy([],[], 4);
        foreach ($cheeses as $cheese){
            $cheese->rating = $cheeseRepository->globalRating($cheese);
        }

        $cheeseOfTheWeek = $cheeseOfTheWeekRepository->actualCheese();
        $cheeseOfTheWeek = $cheeseRepository->find($cheeseOfTheWeek->getCheese());

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