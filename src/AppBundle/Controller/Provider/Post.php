<?php namespace AppBundle\Controller\Provider;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;

class Post implements ControllerProviderInterface{

    /**
     * Post REST resource controller
     *
     * @param Application $app
     *
     * @return Response $users
     */
    public function connect(Application $app)
    {

        $users = $app["controllers_factory"];

        $users->post("/", "AppBundle\\Controller\\PostController::store");

        $users->delete("/{id}", "AppBundle\\Controller\\PostController::destroy");

        return $users;
    }
}