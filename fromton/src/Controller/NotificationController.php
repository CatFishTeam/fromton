<?php

namespace App\Controller;

use App\Entity\Notification;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NotificationController extends AbstractController {

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param Notification $notification
     * @Route('/notification/setSeen', methods={POST})
     */
    /*
    public function IsSeen(Notification $notification) {
        $notification->setSeen(true);
        $this->em->persist($notification);
        $this->em->flush();
    }
    */

}