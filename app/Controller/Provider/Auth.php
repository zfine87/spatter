<?php namespace App\Controller\Provider;

use Silex\Api\ControllerProviderInterface;
use Symfony\Component\BrowserKit\Request;
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

        $auth->get("/login", 'App\\Controller\\AuthController::showLoginForm');

        $auth->get("/register", 'App\\Controller\\AuthController::registerUser');
        $auth->post("/register", 'App\\Controller\\AuthController::registerUser');

        return $auth;
    }
}