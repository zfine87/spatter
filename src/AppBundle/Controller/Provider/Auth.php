<?php namespace AppBundle\Controller\Provider;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;

class Auth implements ControllerProviderInterface{

    /**
     * User REST resource controller
     *
     * @param Application $app
     *
     * @return Controller $auth
     */
    public function connect(Application $app)
    {
        $auth = $app["controllers_factory"];

        $auth->get("/login", 'AppBundle\\Controller\\AuthController::showLoginForm');

        $auth->get("/register", 'AppBundle\\Controller\\AuthController::registerUser');
        $auth->post("/register", 'AppBundle\\Controller\\AuthController::registerUser');

        return $auth;
    }
}