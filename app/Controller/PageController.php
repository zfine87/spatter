<?php namespace App\Controller;

use App\Models\Post;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller {

    public function home(Application $app, Request $request){

        $post = new Post();
        $form = $app['form.factory']->create('App\\Form\\PostType', $post);
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $app['orm.em']->persist($post);
            $app['orm.em']->flush();

            return $this->redirect('/');
        }

        $user = $app['security.token_storage']->getToken()->getUser();

        return $app['twig']->render('pages/index.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);

    }

}