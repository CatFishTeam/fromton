<?php

namespace App\Controller;

use App\Entity\Cheese;
use App\Entity\Rating;
use App\Entity\UsersCheesesRatings;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CheeseController extends AbstractController {

    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route ("/cheese/{slug}", name="cheese_show", methods={"GET"})
     */
    public function show(Cheese $cheese)
    {
        //@todo Remove on add or get last or create globalRating column and update on click
        $usersCheesesRatingsRepo = $this->getDoctrine()->getRepository(UsersCheesesRatings::class);
        $rating = 0;
        if($this->getUser()){
            if($usersCheesesRatingsRepo->getRating($this->getUser(), $cheese) !== null){
                $rating =  $usersCheesesRatings = $usersCheesesRatingsRepo->getRating($this->getUser(), $cheese)->getRating()->getMark();
            }
        };
        $globalRating = $this->getDoctrine()->getRepository(Cheese::class)->globalRating($cheese);

        return $this->render('cheese/show.html.twig',
            [
                'cheese' => $cheese,
                'rating' => $rating,
                'globalRating' => $globalRating
            ]);
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     * @Route ("/cheese/setNote", name="cheese_setnot", methods={"POST"})
     */
    public function setMark(Request $request)
    {
        //@TODO: If user is connected -> ...  Else: toastr."Vous devez être connecté"
        $data = \GuzzleHttp\json_decode($request->getContent(), true);

        $cheese = $this->getDoctrine()->getRepository(Cheese::class)->find($data['cheese']);

        $rating = new Rating();
        $rating->setMark($data['rating']);

        $user = $this->getUser();

        $userCheeseRating = new UsersCheesesRatings();
        $userCheeseRating->setRating($rating);
        $userCheeseRating->setCheese($cheese);
        $userCheeseRating->setUser($user);
        $this->em->persist($userCheeseRating);
        $this->em->flush();

        return $this->json(['rating'=> $data['rating']]);
    }
}