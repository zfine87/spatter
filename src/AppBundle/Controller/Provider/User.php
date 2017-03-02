<?php namespace AppBundle\Controller\Provider;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;

class User implements ControllerProviderInterface{

    /**
     * User REST resource controller
     *
     * @param Application $app
     *
     * @return Response $users
     */
    public function connect(Application $app)
    {

        $users = $app["controllers_factory"];

        $users->get("/", 'AppBundle\\Controller\\UserController::index');

        $users->post("/", "AppBundle\\Controller\\UserController::store");

        $users->get("/{id}", 'AppBundle\\Controller\\UserController::show');

        $users->get("/edit/{id}", "AppBundle\\Controller\\UserController::edit");

        $users->put("/{id}", "AppBundle\\Controller\\UserController::update");

        $users->delete("/{id}", "AppBundle\\Controller\\UserController::destroy");

        return $users;
    }
}