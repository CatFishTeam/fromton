<?php

namespace App\Controller;

use App\Entity\Cheese;
use App\Entity\Cheeze;
use App\Entity\Notification;
use App\Entity\Publication;
use App\Entity\Rating;
use App\Entity\UsersCheesesRatings;
use App\Events;
use App\Repository\CheeseRepository;
use App\Repository\UsersCheesesRatingsRepository;
use App\Utils\Tools;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Controller\UserController;
use Knp\Component\Pager\PaginatorInterface;

class CheeseController extends AbstractController
{

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
        if ($this->getUser()) {
            if ($usersCheesesRatingsRepo->getRating($this->getUser(), $cheese) !== null) {
                $rating = $usersCheesesRatingsRepo->getRating($this->getUser(), $cheese)->getRating()->getMark();
            }
        }
        $globalRating = $this->getDoctrine()->getRepository(Cheese::class)->globalRating($cheese);

        return $this->render('cheese/show.html.twig',
            [
                'cheese' => $cheese,
                'rating' => $rating,
                'globalRating' => $globalRating
            ]);
    }

    /**
     * @Route ("/all-cheeses", name="cheese_all", methods={"GET"})
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param PaginatorInterface $paginator
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function all(Request $request, EntityManagerInterface $entityManager, PaginatorInterface $paginator)
    {
        /** @var CheeseRepository $cheeseRepo */
        $cheeseRepo = $entityManager->getRepository(Cheese::class);
        $allCheesesQuery = $cheeseRepo->createQueryBuilder('c')->getQuery();

        $allCheeses = $paginator->paginate(
            $allCheesesQuery,
            $request->query->getInt('page', 1),
            15
        );

        $ratings = [];
        $globalRatings = [];
        /** @var UsersCheesesRatingsRepository $usersCheesesRatingsRepo */
        $usersCheesesRatingsRepo = $this->getDoctrine()->getRepository(UsersCheesesRatings::class);
        $me = $this->getUser();

        foreach ($allCheeses as $cheese) {
            $ratings[] = 0;
            if ($me) {
                if ($usersCheesesRatingsRepo->getRating($me, $cheese) !== null) {
                    $ratings[] = $usersCheesesRatingsRepo->getRating($me, $cheese)->getRating()->getMark();
                }
            }
            $globalRatings[] = $cheeseRepo->globalRating($cheese);
        }

        return $this->render('cheese/all.html.twig',
            [
                'cheeses' => $allCheeses,
                'ratings' => $ratings,
                'globalRatings' => $globalRatings,
            ]);
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     * @Route ("/cheese/setNote", name="cheese_setnot", methods={"POST"})
     * @param Request $request
     * @param EventDispatcherInterface $eventDispatcher
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function setMark(Request $request, EventDispatcherInterface $eventDispatcher, Tools $tools)
    {
        //@TODO: If user is connected -> ...  Else: toastr."Vous devez être connecté"
        $data = \GuzzleHttp\json_decode($request->getContent(), true);

        $cheese = $this->getDoctrine()->getRepository(Cheese::class)->find($data['cheese']);

        $rating = new Rating();
        $rating->setMark($data['rating']);

        $user = $this->getUser();
        $xp = $user->getXp();
        $user->setXp($xp + 5);
        $tab = $tools->calculLevel($xp);
        $tab2 = $tools->calculLevel($user->getXp());
        if ($tab[0] != $tab2[0]) {
            $notificationLevel = new Notification();
            $notificationLevel->setTexte("Vous avez gagné un niveau. Vous êtes maintenant niveau " . $tab2[0]);
            $notificationLevel->setCreatedAt(new \DateTime());
            $notificationLevel->setUser($user);
            $notificationLevel->setSeen(false);
            $this->em->persist($notificationLevel);
        }
        $this->em->persist($user);

        $userCheeseRating = $this->getDoctrine()->getRepository(UsersCheesesRatings::class)->getRating($user, $cheese);

        if (isset($userCheeseRating)) {
            $userCheeseRating->setRating($rating);
            $this->em->persist($userCheeseRating);
            $this->em->flush();

        } else {
            $userCheeseRating = new UsersCheesesRatings();
            $userCheeseRating->setRating($rating);
            $userCheeseRating->setCheese($cheese);
            $userCheeseRating->setUser($user);
            $this->em->persist($userCheeseRating);
            $this->em->flush();
        }

        $event = new GenericEvent($userCheeseRating);
        $eventDispatcher->dispatch(Events::CHEESE_RATE, $event);

        //@TODO: lister tout les amis du user et foreach sur chaque user
        $publication = new Publication();
        $publication->setTexte("Votre ami ".$user->getUsername()." a noté un fromage: ".$cheese->getName());
        $publication->setCreatedAt(new \DateTime());
        $publication->setUser($user);
        $this->em->persist($publication);
        $this->em->flush();


        return $this->json(['rating' => $data['rating']]);
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     * @param Request $request
     * @param $id
     * @Route ("/cheese/like/{id}", name="cheese_like", methods={"GET"})
     */
    public function like(Request $request, $id, Tools $tools)
    {
        $em = $this->getDoctrine()->getManager();
        $cheese = $em->getRepository(Cheese::class)->find($id);

        $user = $this->getUser();
        $xp = $user->getXp();
        $user->setXp($xp + 2);
        $tab = $tools->calculLevel($xp);
        $tab2 = $tools->calculLevel($user->getXp());
        if ($tab[0] != $tab2[0]) {
            $notificationLevel = new Notification();
            $notificationLevel->setTexte("Vous avez gagné un niveau. Vous êtes maintenant niveau " . $tab2[0]);
            $notificationLevel->setCreatedAt(new \DateTime());
            $notificationLevel->setUser($user);
            $notificationLevel->setSeen(false);
            $this->em->persist($notificationLevel);
        }
        $this->em->persist($user);

        //@TODO: avec tout les friends
        $publication = new Publication();
        $publication->setTexte("Votre ami ".$user->getUsername()." a liké un fromage: ".$cheese->getName());
        $publication->setCreatedAt(new \DateTime());
        $publication->setUser($user);
        $this->em->persist($publication);

        $like = new Cheeze();
        $like->setUser($user);
        $like->setCheese($cheese);
        $like->setPublication(null);
        $this->em->persist($like);
        $this->em->flush();

    //@TODO: faire call ajax
    }
}