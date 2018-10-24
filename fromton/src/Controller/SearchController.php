<?php
/**
 * Created by IntelliJ IDEA.
 * User: robin
 * Date: 24/10/18
 * Time: 11:26
 */

namespace App\Controller;

use App\Entity\Cheese;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route ("/search", name="search", methods={"GET"})
     */
    public function search(Request $request) {
        $cheeses = $this->getDoctrine()->getRepository(Cheese::class)->search($request->get('q'));

        return $this->json($cheeses);
    }

}