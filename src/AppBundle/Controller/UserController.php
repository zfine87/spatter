<?php namespace AppBundle\Controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class UserController {

    /**
     * This is the User Controller, there is nothing happening here at the moment,
     * but it is inevitable that these routes will get filled out so I added the boilerplate
     * for a basic RESTful controller
     */


    /**
     * Show all users (maybe make admin firewall for this?)
     *
     */
    public function index(){}

    /**
     * Load the edit form for a user
     *
     * @param $id
     */
    public function edit($id){}

    /**
     * Show posts for a specific user (or something else if you want)
     *
     * @param $id
     */
    public function show($id){}

    /**
     * Create a new user and store them in DB
     *
     * @param Request $request
     */
    public function store(Request $request){}

    /**
     * Update a users information
     *
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id){}

    /**
     * Delete a user
     *
     * @param $id
     */
    public function destroy($id){}
}