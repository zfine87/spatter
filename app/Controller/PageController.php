<?php namespace App\Controller;

use App\Models\Post;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller {

    /**
     * Load the home page
     *
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function home(Application $app){

        // Prepare the form
        $post = new Post();
        $form = $app['form.factory']->create('App\\Form\\PostType', $post);

        // Load user
        $user = $app['security.token_storage']->getToken()->getUser();

        // Render view
        return $app['twig']->render('pages/index.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);

    }

}