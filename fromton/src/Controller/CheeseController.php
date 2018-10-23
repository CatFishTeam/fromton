<?php

namespace App\Controller;

use App\Entity\Cheese;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CheeseController extends AbstractController {

    /**
     * @Route ("/cheese/{name}", name="cheese_show", methods={"GET"})
     */
    public function show(Cheese $cheese)
    {
        return $this->render('cheese/show.html.twig', ['cheese' => $cheese]);
    }
}