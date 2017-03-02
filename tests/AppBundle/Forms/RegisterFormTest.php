<?php namespace App\Tests;

use Silex\WebTestCase;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;


class RegisterFormTest extends WebTestCase
{
    /**
     * Bootstrap app for testing
     * @return mixed
     */
    public function createApplication()
    {
        // app.php must return an Application instance
        $app = require __DIR__.'/../../../public/index.php';

        $app['debug'] = true;

        return $app;
    }

    /**
     * Test basic page loading
     * @test
     */
    public function testInitialPage()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/auth/register');

        //Navbar and Login Form
        $this->assertCount(2, $crawler->filter('form'));

        //Login form fields
        $this->assertCount(1, $crawler->filter('input#user_username'));
        $this->assertCount(1, $crawler->filter('input#user_email'));
        $this->assertCount(1, $crawler->filter('input#user_plainPassword_first'));
        $this->assertCount(1, $crawler->filter('input#user_plainPassword_second'));

        $this->assertTrue($client->getResponse()->isOk());
    }

    /**
     * Test unsuccessful registration attempt
     * @test
     */
    public function testBadRegistration()
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', '/auth/register');
        $form = $crawler->selectButton('register-submit')->form([
            'user[username]'              => 'Johnny',
            'user[email]'                 => 'john@test.com',
            'user[plainPassword][first]'  => 'thingone',
            'user[plainPassword][second]' => 'thingtwo',
        ]);

        // submit the form
        $crawler = $client->submit($form);

        //Verify redirect back with error
        $this->assertEquals($crawler->getUri(), 'http://localhost/auth/register');
        $this->assertCount(1, $crawler->filter('div#form-errors'));
    }

    /**
     * Test successful registration attempt
     * @test
     */
    public function testGoodRegistration()
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', '/auth/register');
        $form = $crawler->selectButton('register-submit')->form([
            'user[username]'              => 'Johnny',
            'user[email]'                 => 'johnny@test.com',
            'user[plainPassword][first]'  => 'password',
            'user[plainPassword][second]' => 'password'
        ]);

        // submit the form
        $crawler = $client->submit($form);

        //Verify no errors
        $this->assertCount(0, $crawler->filter('div#form-errors'));
    }

}