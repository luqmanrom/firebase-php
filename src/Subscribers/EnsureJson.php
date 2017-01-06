<?php

namespace Geckob\Firebase\Subscribers;

use GuzzleHttp\Event\BeforeEvent;
use GuzzleHttp\Event\RequestEvents;
use GuzzleHttp\Event\SubscriberInterface;

class EnsureJson implements SubscriberInterface
{

    public static function onBefore(BeforeEvent $event)
    {
        $request = $event->getRequest();
    }

    /**
     * @return array
     */
    public function getEvents()
    {
        return ['before' => ['onBefore', RequestEvents::SIGN_REQUEST]];
    }

}