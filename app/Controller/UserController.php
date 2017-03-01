<?php namespace App\Controller;


use Silex\Application;

class UserController {

    public function index(Application $app){
        return $app['twig']->render('app.html.twig');
    }

    public function edit(Application $app, $id){
        // show edit form
    }

    public function show(Application $app, $id){

        $user = $app['orm.em']->find('App\Models\User', $id);

        return $app['twig']->render('index.html.twig', [
            'user'  => $user,
        ]);
    }

    public function store(){
        // create a new user, using POST method
    }

    public function update($id){
        // update the user #id, using PUT method
    }

    public function destroy($id){
        // delete the user #id, using DELETE method
    }
}