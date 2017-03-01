<?php namespace App\Controller;

use App\Models\User;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AuthController extends Controller {

    public function showLoginForm(Application $app, Request $request){

        return $app['twig']->render('Auth/login.html.twig', array(
            'last_username' => $app['session']->get('_security.last_username'),
            'error'         => $app['security.last_error']($request),
        ));
    }

    public function registerUser(Application $app, Request $request)
    {
        // 1) build the form
        $user = new User();
        $form = $app['form.factory']->create('App\\Form\\UserType', $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $app['security.encoder_factory']->getEncoder($user)
                ->encodePassword($user->getPlainPassword(), $user->getSalt());
            $user->setPassword($password);

            // 4) save the User!
            $app['orm.em']->persist($user);
            $app['orm.em']->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user
            return $this->redirect('/');
        }

        return $app['twig']->render(
            'Auth/register.html.twig',
            ['form'  => $form->createView()]
        );
    }

}