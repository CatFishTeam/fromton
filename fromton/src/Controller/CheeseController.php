<?php

namespace App\Controller;

use App\Entity\Cheese;

class CheeseController extends AbstractController {

    /**
     * @param Cheese $cheese
     * @Route ("/{name}", name="cheese_show", methods={"GET"})
     */
    public function show(Cheese $cheese)
    {
        return $this->render('cheese/show.html.twig', ['cheese' => $cheese]);
    }
}