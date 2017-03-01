<?php namespace App\Controller;

use App\Models\User;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AuthController extends Controller {

    /**
     * Render login view
     *
     * @param Application $app
     * @return mixed
     */
    public function showLoginForm(Application $app){

        $user = new User();
        $form = $app['form.factory']->create('App\\Form\\LoginType', $user);

        return $app['twig']->render('auth/login.html.twig',
            ['form'  => $form->createView()]
        );
    }

    /**
     * Register a user
     *
     * @param Application $app
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function registerUser(Application $app, Request $request)
    {
        // 1) build the form
        $user = new User();
        $form = $app['form.factory']->create('App\\Form\\UserType', $user);

        // 2) handle the submit if it's a POST
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password
            $password = $app['security.encoder_factory']->getEncoder($user)
                ->encodePassword($user->getPlainPassword(), $user->getSalt());
            $user->setPassword($password);

            // 4) save the User!
            $app['orm.em']->persist($user);
            $app['orm.em']->flush();


            // create and store an authenticated token for auto-login
            $token = new UsernamePasswordToken(
                $user,
                $user->getPassword(),
                'main',
                $user->getRoles()
            );
            $app['security.token_storage']->setToken($token);

            //Update session with new user authenticated token
            $app['session']->set('_security_main', serialize($token));
            $app['session']->save();

            return $this->redirect('/');
        }

        return $app['twig']->render(
            'auth/register.html.twig',
            ['form'  => $form->createView()]
        );
    }

}