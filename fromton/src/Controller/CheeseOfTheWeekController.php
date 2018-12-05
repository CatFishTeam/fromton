<?php

namespace App\Controller;

use App\Repository\CheeseOfTheWeekRepository;
use App\Repository\CheeseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheeseOfTheWeekController extends AbstractController
{
    /**
     * @Route("/cheeseOfTheWeek/stats", methods={"POST"})
     * @param CheeseRepository $cheeseRepository
     * @param CheeseOfTheWeekRepository $cheeseOfTheWeekRepository
     * @return Response
     */
    public function getData(CheeseRepository $cheeseRepository, CheeseOfTheWeekRepository $cheeseOfTheWeekRepository)
    {
        $cheeses = $cheeseOfTheWeekRepository->findAll();
        foreach ($cheeses as $cheese){
            $cheese->click = $cheese->getClicks();
            $cheese->startingDate = $cheese->getStartingDateOfPromotion()->format('Y-m-d H:i:s');
            $cheese->endingDate = $cheese->getEndingDateOfPromotion()->format('Y-m-d H:i:s');
            $cheese->name = $cheeseRepository->find($cheese->getCheese())->getName();
        }
        return new Response(json_encode($cheeses));
    }
}