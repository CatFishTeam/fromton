<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Cheese;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
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

        return $this->render('admin/dashboard.html.twig', [
            'cheesesNb' => $cheesesNb,
            'usersNb' => $usersNb,
            'categoriesNb' => $categoriesNb,
        ]);
    }

    public function indexAction(Request $request)
    {
        return parent::indexAction($request); // TODO: Change the autogenerated stub
    }


}
