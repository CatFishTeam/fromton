<?php

namespace App\Controller;

use App\Entity\Cheese;
use App\Entity\Cheeze;
use App\Entity\Friendship;
use App\Entity\Notification;
use App\Entity\Publication;
use App\Entity\Rating;
use App\Entity\User;
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
        $cheeze = $this->getDoctrine()->getRepository(Cheeze::class)->findBy(['cheese'=>$cheese, 'user'=> $this->getUser()]);
        if ($cheeze) {
            $cheeze_to_view = 1;
        } else {
            $cheeze_to_view = 0;
        }
        return $this->render('cheese/show.html.twig',
            [
                'cheese' => $cheese,
                'rating' => $rating,
                'globalRating' => $globalRating,
                'cheeze' => $cheeze_to_view
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

            $cheeze = $this->getDoctrine()->getRepository(Cheeze::class)->findBy(['cheese'=>$cheese, 'user'=> $this->getUser()]);
            dump($cheeze);
            if ($cheeze) {
                $cheeze_to_view[$cheese->getId()] = true;
            } else {
                $cheeze_to_view[$cheese->getId()] = false;
            }
        }

        return $this->render('cheese/all.html.twig',
            [
                'cheeses' => $allCheeses,
                'ratings' => $ratings,
                'globalRatings' => $globalRatings,
                'cheeze' => $cheeze_to_view
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

        $usersFriends = $this->getDoctrine()->getRepository(Friendship::class)->findAll(['friend'=>$user]);
        dump($usersFriends);
        foreach ($usersFriends as $usersFriend){
            $friend = $this->getDoctrine()->getRepository(User::class)->find($usersFriend->getUser());
            $publicationFriend = new Publication();
            $publicationFriend->setTexte("Votre ami ".$user->getUsername()." a noté un fromage: ".$cheese->getName());
            $publicationFriend->setUser($friend);
            $this->em->persist($publicationFriend);
        }
        $publication = new Publication();
        $publication->setTexte("Vous avez noté un fromage: ".$cheese->getName());
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
        $usersCheesesRatingsRepo = $this->getDoctrine()->getRepository(UsersCheesesRatings::class);
        $rating = 0;
        if ($this->getUser()) {
            if ($usersCheesesRatingsRepo->getRating($this->getUser(), $cheese) !== null) {
                $rating = $usersCheesesRatingsRepo->getRating($this->getUser(), $cheese)->getRating()->getMark();
            }
        }
        $globalRating = $this->getDoctrine()->getRepository(Cheese::class)->globalRating($cheese);

        $user = $this->getUser();
        $xp = $user->getXp();
        $user->setXp($xp + 2);
        $tab = $tools->calculLevel($xp);
        $tab2 = $tools->calculLevel($user->getXp());
        if ($tab[0] != $tab2[0]) {
            $notificationLevel = new Notification();
            $notificationLevel->setTexte("Vous avez gagné un niveau. Vous êtes maintenant niveau " . $tab2[0]);
            $notificationLevel->setUser($user);
            $notificationLevel->setSeen(false);
            $this->em->persist($notificationLevel);
        }
        $this->em->persist($user);

        $usersFriends = $this->getDoctrine()->getRepository(Friendship::class)->findAll(['friend'=>$user]);
        dump($usersFriends);
        foreach ($usersFriends as $usersFriend){
            $friend = $this->getDoctrine()->getRepository(User::class)->find($usersFriend->getUser());
            $publicationFriend = new Publication();
            $publicationFriend->setTexte("Votre ami ".$user->getUsername()." a liké un fromage: ".$cheese->getName());
            $publicationFriend->setUser($friend);
            $this->em->persist($publicationFriend);
        }
        $publication = new Publication();
        $publication->setTexte("Vous avez liké un fromage: ".$cheese->getName());
        $publication->setUser($user);
        $this->em->persist($publication);

        $like = new Cheeze();
        $like->setUser($user);
        $like->setCheese($cheese);
        $like->setPublication(null);
        $this->em->persist($like);
        $this->em->flush();

        //@TODO: faire call ajax

        return $this->render('cheese/show.html.twig',
            [
                'cheese' => $cheese,
                'rating' => $rating,
                'globalRating' => $globalRating,
                'cheeze' => 1
            ]);
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     * @param Request $request
     * @param $id
     * @Route ("/cheese/unlike/{id}", name="cheese_unlike", methods={"GET"})
     */
    public function unlike(Request $request, $id, Tools $tools)
    {
        $em = $this->getDoctrine()->getManager();
        $cheese = $em->getRepository(Cheese::class)->find($id);
        $usersCheesesRatingsRepo = $this->getDoctrine()->getRepository(UsersCheesesRatings::class);
        $rating = 0;
        if ($this->getUser()) {
            if ($usersCheesesRatingsRepo->getRating($this->getUser(), $cheese) !== null) {
                $rating = $usersCheesesRatingsRepo->getRating($this->getUser(), $cheese)->getRating()->getMark();
            }
        }
        $globalRating = $this->getDoctrine()->getRepository(Cheese::class)->globalRating($cheese);

        $user = $this->getUser();
        $xp = $user->getXp();
        $user->setXp($xp - 2);
        $this->em->persist($user);

        $like =  $this->getDoctrine()->getRepository(Cheeze::class)->findOneBy(['cheese'=>$cheese, 'user'=> $this->getUser()]);
        $this->em->remove($like);
        $this->em->flush();

        //@TODO: faire call ajax

        return $this->render('cheese/show.html.twig',
            [
                'cheese' => $cheese,
                'rating' => $rating,
                'globalRating' => $globalRating,
                'cheeze' => 0
            ]);
    }
}