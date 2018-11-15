<?php

namespace App;

final class Events
{
    /**
     * For the event naming conventions, see:
     * https://symfony.com/doc/current/components/event_dispatcher.html#naming-conventions.
     *
     * @Event("Symfony\Component\EventDispatcher\GenericEvent")
     *
     * @var string
     */
    const CHEESE_RATE = "cheese.rate";
    const XP_UP = "xp.up";
    const FRIEND_ADD = "friend.add";
}