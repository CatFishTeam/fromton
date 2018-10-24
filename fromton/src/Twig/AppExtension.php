<?php

namespace App\Twig;

use Twig\TwigFunction;
use Symfony\Component\Asset\Packages;
use Twig\Extension\AbstractExtension;

class AppExtension extends AbstractExtension
{

    protected $assetsPackage;
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

    public function getNotifications()
    {
        $url = $this->assetsPackage->getUrl("build/assets/images/svg/notification_new.svg");
        $notifications = 12;
        if ($notifications >= 1){
            $output = "<img src=".$url." class='notification' alt='notification'><span class='notification__number ". ($notifications > 10 ? 'notification__number--overten' : '')." ".($notifications > 99 ? 'notification__number--overninethousand' : '') ."'>".($notifications > 99 ? '99' : $notifications)."</span>";
            return $output;
        }
        $url = $this->assetsPackage->getUrl("build/assets/images/svg/notification.svg");
        return "<img src=".$url." class='notification' alt='notification'>";
    }
}