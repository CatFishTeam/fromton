<?php
namespace App\Controller;

use App\Entity\Cheeze;
use App\Entity\Cheese;
use App\Entity\Notification;
use App\Entity\Publication;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\UserController;

class PublicationController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route(path="publication/{id}", methods={"GET"}, name="publications")
     * @Security("is_granted('ROLE_USER')")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function index(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $publications = $em->getRepository(Publication::class)->findBy(['user'=>$id]);

        return $this->render('publication/base.html.twig', ['publications'=> $publications]);
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     * @param Request $request
     * @param $id
     * @Route ("publication/like/{id}", name="publication_like", methods={"GET"})
     */
    public function like(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $publications = $em->getRepository(Publication::class)->findBy(['user'=>$user]);
        $publication = $em->getRepository(Publication::class)->find($id);
        $user = $this->getUser();

        $like = new Cheeze();
        $like->setUser($user);
        $like->setCheese(null);
        $like->setPublication($publication);
        $this->em->persist($like);

        $notification = new Notification();
        $notification->setTexte("Votre ami ".$user->getUsername()." a aimé votre publication");
        $notification->setCreatedAt(new \DateTime());
        $notification->setUser($publication->getUser());
        $notification->setPublication($publication);
        $notification->setSeen(false);
        $this->em->persist($notification);

        $this->em->flush();
        //@TODO ajax
        return $this->render('publication/base.html.twig', ['publications'=> $publications]);
    }
}
