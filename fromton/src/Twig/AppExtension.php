<?php

namespace App\Twig;

use App\Entity\User;
use Symfony\Component\Validator\Constraints\Date;
use Twig\TwigFunction;
use Symfony\Component\Asset\Packages;
use Twig\Extension\AbstractExtension;


class AppExtension extends AbstractExtension
{

    protected $assetsPackage;
    protected $user;
    public function __construct(Packages $assetsPackage)
    {
        $this->assetsPackage = $assetsPackage;
    }

    public function getFunctions()
    {
        return array(
            new TwigFunction('notifications', array($this,'getNotifications',['is_safe' => ['html']]))
        );
    }

    public function getNotifications(User $user)
    {
        $notifications = $user->getNotifications();
        $notifications_count = count($notifications);
        $url = $this->assetsPackage->getUrl("build/assets/images/svg/notification_new.svg"  );
        /*
        if ($notifications_count >= 1){
            $output = "<img src=".$url." class='notification' alt='notification'><span class='notification__number ". ($notifications_count > 10 ? 'notification__number--overten' : '')." ".($notifications_count > 99 ? 'notification__number--overninethousand' : '') ."'>".($notifications_count > 99 ? '99' : $notifications_count)."</span>";
            $output .= '<div class="notification__container">';
            foreach($notifications as $notification) {
                $output_notification = '<div class="notification__content" data-id="' . $notification->getId() . '">' . $notification->getTexte() . '<br><span>Le : ' . $notification->getCreatedAt()->format("d/m H:i") . '</span></span></div>';
                $output .= $output_notification;
            }
            $output .= "</div>";
            return $output;
        }
        */
        $url = $this->assetsPackage->getUrl("build/assets/images/svg/notification.svg");
        return "<img src=".$url." class='notification' alt='notification'>";
    }
}