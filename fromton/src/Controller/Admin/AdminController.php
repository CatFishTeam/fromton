<?php

namespace App\Controller\Admin;

use App\Entity\Animal;
use App\Entity\Badge;
use App\Entity\Category;
use App\Entity\Cheese;
use App\Entity\CheeseOfTheWeek;
use App\Entity\Country;
use App\Entity\Location;
use App\Entity\User;
use App\Repository\CheeseOfTheWeekRepository;
use App\Repository\CheeseRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends BaseAdminController
{
    /**
     * @Route("/dashboard", name="admin_dashboard", host="admin.fromton.io")
     */
    public function dashboard()
    {
        $cheesesNb = $this->getDoctrine()->getRepository(Cheese::class)->count([]);
        $usersNb = $this->getDoctrine()->getRepository(User::class)->count([]);
        $categoriesNb = $this->getDoctrine()->getRepository(Category::class)->count([]);
        $locationsNb = $this->getDoctrine()->getRepository(Location::class)->count([]);
        $countriesNb = $this->getDoctrine()->getRepository(Country::class)->count([]);
        $animalsNb = $this->getDoctrine()->getRepository(Animal::class)->count([]);
        $badgesNb = $this->getDoctrine()->getRepository(Badge::class)->count([]);

        return $this->render('admin/dashboard.html.twig', [
            'cheesesNb' => $cheesesNb,
            'usersNb' => $usersNb,
            'categoriesNb' => $categoriesNb,
            'locationsNb' => $locationsNb,
            'countriesNb' => $countriesNb,
            'animalsNb' => $animalsNb,
            'badgesNb' => $badgesNb,
        ]);
    }

    public function indexAction(Request $request)
    {
        return parent::indexAction($request); // TODO: Change the autogenerated stub
    }

    /**
     * @Route("/cheeseOfTheWeek", name="admin_cheeseOfTheWeek", host="admin.fromton.io")
     */
    public function cheeseOfTheWeek(Request $request, CheeseOfTheWeekRepository $cheeseOfTheWeekRepository, CheeseRepository $cheeseRepository)
    {
        $cheeseOfTheWeek = $cheeseOfTheWeekRepository->actualCheese();
        $cheese = $cheeseOfTheWeek->getCheese();

        $form = $this->createFormBuilder()
            ->add('cheese', EntityType::class, array(
                'class' => Cheese::class,
                'choice_label' => 'name',
            ))
            ->add('starting_date_of_promotion', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('ending_date_of_promotion', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('save', SubmitType::class, array('label' => 'Programmer'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $cheeseOfTheWeek = new CheeseOfTheWeek();
            $cheeseOfTheWeek->setCheese($form->get('cheese')->getData());
            $cheeseOfTheWeek->setStartingDateOfPromotion($form->get('starting_date_of_promotion')->getData());
            $cheeseOfTheWeek->setEndingDateOfPromotion($form->get('ending_date_of_promotion')->getData());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cheeseOfTheWeek);
            $entityManager->flush();

            return $this->redirectToRoute('admin_cheeseOfTheWeek');
            //@TODO Add success onitifcation !
        }

        return $this->render('admin/cheese_of_the_week.html.twig',
            [
                'form' => $form->createView(),
                'cheeseOfTheWeek' => $cheeseOfTheWeek,
                'cheese' => $cheese
            ]);
    }

}
