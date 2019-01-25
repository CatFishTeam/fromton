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
use App\Repository\CheeseOfTheWeekRepository;
use App\Repository\CheeseRepository;
use App\Repository\CheezeRepository;
use App\Repository\FriendshipRepository;
use App\Repository\UserRepository;
use App\Repository\UsersCheesesRatingsRepository;
use App\Utils\Tools;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class CheeseController
 * @package App\Controller
 */
class CheeseController extends AbstractController
{

    private $em;
    private $userRepository;
    private $cheeseRepository;
    private $cheezeRepository;

    public function __construct(EntityManagerInterface $em, UserRepository $userRepository, CheeseRepository $cheeseRepository, CheezeRepository $cheezeRepository)
    {
        $this->em = $em;
        $this->userRepository = $userRepository;
        $this->cheeseRepository = $cheeseRepository;
        $this->cheezeRepository = $cheezeRepository;
    }

    /**
     * @Route ("/cheese/{slug}", name="cheese_show", methods={"GET"})
     * @param Cheese $cheese
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
        $globalRating = $this->cheeseRepository->globalRating($cheese);
        $cheeze = $this->cheezeRepository->findBy(['cheese'=>$cheese, 'user'=> $this->getUser()]);
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
        $allCheesesQuery = $this->cheeseRepository->createQueryBuilder('c')->getQuery();

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
            $globalRatings[] = $this->cheeseRepository->globalRating($cheese);

            $cheeze = $this->getDoctrine()->getRepository(Cheeze::class)->findBy(['cheese'=>$cheese, 'user'=> $this->getUser()]);

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
     * @param Tools $tools
     * @param FriendshipRepository $friendshipRepository
     * @param UsersCheesesRatingsRepository $usersCheesesRatingsRepository
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function setMark(Request $request, EventDispatcherInterface $eventDispatcher, Tools $tools, FriendshipRepository $friendshipRepository, UsersCheesesRatingsRepository $usersCheesesRatingsRepository)
    {

        //@TODO: Update moyenne aussi...
        //@TODO: If user is connected -> ...  Else: toastr."Vous devez être connecté"
        $data = \GuzzleHttp\json_decode($request->getContent(), true);

        $cheese = $this->cheeseRepository->find($data['cheese']);

        $rating = new Rating();
        $rating->setMark($data['rating']);

        $user = $this->getUser();
        $xp = $user->getXp();
        $user->setXp($xp + 5);
        $tab = $tools->calculLevel($xp);
        $tab2 = $tools->calculLevel($user->getXp());
        if ($tab[0] != $tab2[0]) {
            $notificationLevel = new Notification();
            $notificationLevel->addNotification($user, "Vous avez gagné un niveau. Vous êtes maintenant niveau " . $tab2[0]);
            $this->em->persist($notificationLevel);
            $this->addFlash('success', 'Vous avez gagné un niveau. Vous êtes maintenant niveau ' . $tab2[0]);

            $publicationLevel = new Publication();
            $publicationLevel->addPublication($user, 'Vous avez gagné un niveau. Vous êtes maintenant niveau ' . $tab2[0]);
            $this->em->persist($publicationLevel);

            $usersFriends = $friendshipRepository->getAllFollowers($user);
            foreach ($usersFriends as $usersFriend){
                $friend = $this->userRepository->find($usersFriend->getUser());
                $publicationLevelFriend = new Publication();
                $publicationLevelFriend->addPublication($friend,'Votre ami '.$user->getUsername().' ('.$user->getFullName().') est passé niveau '.$tab2[0]);
                $this->em->persist($publicationLevelFriend);
            }
        }
        $this->em->persist($user);

        $userCheeseRating =  $usersCheesesRatingsRepository->getRating($user, $cheese);

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

        $event = new GenericEvent($user);
        $eventDispatcher->dispatch(Events::XP_UP, $event);

        $usersFriends = $friendshipRepository->getAllFollowers($user);
        foreach ($usersFriends as $usersFriend){
            $friend = $this->userRepository->find($usersFriend->getUser());
            if ($friend == $user) { continue; }
            $publicationFriend = new Publication();
            $publicationFriend->addPublication($friend, $user->getUsername()." (".$user->getFullName().") a noté un fromage: ".$cheese->getName());
            $this->em->persist($publicationFriend);
        }
        $publication = new Publication();
        $publication->addPublication($user, "Vous avez noté ".$data['rating']." le fromage ".$cheese->getName());
        $this->em->persist($publication);
        $this->em->flush();

        return $this->json(['rating' => $data['rating']]);
    }


    /**
     * @Route ("/like_cheese", name="like_cheese", methods={"POST"})
     * @param Request $request
     * @param Tools $tools
     * @param FriendshipRepository $friendshipRepository
     * @return Response
     */
    public function likeCheese(Request $request, Tools $tools, FriendshipRepository $friendshipRepository)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        $cheese = $this->cheeseRepository->find($request->get('cheeseId'));

        $xp = $user->getXp();
        $user->setXp($xp + 2);
        $tab = $tools->calculLevel($xp);
        $tab2 = $tools->calculLevel($user->getXp());
        if ($tab[0] != $tab2[0]) {
            $notificationLevel = new Notification();
            $notificationLevel->addNotification($user, "Vous avez gagné un niveau. Vous êtes maintenant niveau " . $tab2[0]);
            $em->persist($notificationLevel);
            $this->addFlash('success', 'Vous avez gagné un niveau. Vous êtes maintenant niveau ' . $tab2[0]);

            $publicationLevel = new Publication();
            $publicationLevel->addPublication($user, 'Vous avez gagné un niveau. Vous êtes maintenant niveau ' . $tab2[0]);
            $em->persist($publicationLevel);

            $usersFriends = $friendshipRepository->getAllFollowers($user);
            foreach ($usersFriends as $usersFriend){
                $friend = $this->userRepository->find($usersFriend->getUser());
                $publicationLevelFriend = new Publication();
                $publicationLevelFriend->addPublication($friend,'Votre ami '.$user->getUsername().' ('.$user->getFullName().') est passé niveau '.$tab2[0]);
                $em->persist($publicationLevelFriend);
            }
        }
        $em->persist($user);

        $usersFriends = $this->getDoctrine()->getRepository(Friendship::class)->getAllFollowers($user);
        foreach ($usersFriends as $usersFriend){
            $friend = $this->getDoctrine()->getRepository(User::class)->find($usersFriend->getUser());
            $publicationFriend = new Publication();
            $publicationFriend->addPublication($friend, "Votre ami ".$user->getUsername()." a cheezé un fromage: ".$cheese->getName());
            $em->persist($publicationFriend);
        }
        $publication = new Publication();
        $publication->addPublication($user, 'Vous avez cheezé un fromage: '.$cheese->getName());
        $em->persist($publication);

        $like = new Cheeze();
        $like->addCheeze($user, $cheese, $publication);
        $em->persist($like);
        $em->flush();

        //$this->addFlash('success', 'Vous avez cheezé le fromage '.$cheese->getName());
        return new Response("liked");
    }

    /**
     * @Route ("/unlike_cheese", name="unlike_cheese", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function unlikeCheese(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        $cheese = $this->cheeseRepository->find($request->get('cheeseId'));

        $xp = $user->getXp();
        $user->setXp($xp - 2);
        $em->persist($user);

        $like =  $this->cheeseRepository->findOneBy(['cheese'=>$cheese, 'user'=> $user]);
        $em->remove($like);
        $em->flush();

        //$this->addFlash('success', "Vous n'êtes plus fondu du fromage ".$cheese->getName());

        return new Response("unliked");
    }

    /**
     * @Route("/cheeseOfTheWeek/clicked", methods={"POST"})
     * @param $request
     * @return Response
     */
    public function clickCOW(Request $request, CheeseOfTheWeekRepository $cheeseOfTheWeekRepository)
    {
        //@Todo check login or ip
        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }
        $cheeseOfTheWeek = $cheeseOfTheWeekRepository->findOneBy(['cheese' => $parametersAsArray['cheese']]);
        $cheeseOfTheWeek->setClicks($cheeseOfTheWeek->getClicks() + 1);
        $this->em->persist($cheeseOfTheWeek);
        $this->em->flush();

        return new Response("unliked");
    }
}