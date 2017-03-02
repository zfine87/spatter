<?php namespace App\Controller;


use Silex\Application;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use App\Models\Post;

class PostController extends Controller {


    /**
     * Store post in database
     *
     * @param Application $app
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function store(Application $app, Request $request){

        // Create form and check for validity
        $post = new Post();
        $form = $app['form.factory']->create('App\\Form\\PostType', $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Connect user to post and save to DB
            $user = $app['security.token_storage']->getToken()->getUser();
            $post->setUser($user);

            $app['orm.em']->persist($post);
            $app['orm.em']->flush();
        }

        return $app->redirect('/');
    }

    public function destroy($id){
        // delete the user #id, using DELETE method
    }
}