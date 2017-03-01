<?php namespace App\Controller\Provider;

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

        $users->post("/", "App\\Controller\\PostController::store");

        $users->delete("/{id}", "App\\Controller\\PostController::destroy");

        return $users;
    }
}