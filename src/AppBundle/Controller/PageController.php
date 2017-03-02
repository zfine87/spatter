<?php namespace AppBundle\Controller;

use AppBundle\Models\Post;
use Silex\Application;
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
        $form = $app['form.factory']->create('AppBundle\\Form\\PostType', $post);

        // Load user
        $user = $app['security.token_storage']->getToken()->getUser();

        // Render view
        return $app['twig']->render('pages/index.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);

    }

}