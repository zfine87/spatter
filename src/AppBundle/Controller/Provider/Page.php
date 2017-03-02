<?php namespace AppBundle\Controller\Provider;

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

        $page->get("/", 'AppBundle\\Controller\\PageController::home');

        return $page;
    }
}