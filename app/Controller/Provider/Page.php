<?php namespace App\Controller\Provider;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;

class Page implements ControllerProviderInterface{

    /**
     * Generic Page controller
     *
     * @param Application $app
     * @returns ControllerProvider $page
     */
    public function connect(Application $app)
    {
        $page = $app["controllers_factory"];

        $page->get("/", 'App\\Controller\\PageController::home');

        return $page;
    }
}