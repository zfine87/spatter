<?php namespace App\Controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use App\Models\Post;

class PostController {


    public function store(Application $app, Request $request){
        $post = new Post();

        $form = $app['form.factory']->create('App\\Form\\PostType', $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

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