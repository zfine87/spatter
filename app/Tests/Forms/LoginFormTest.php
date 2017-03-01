<?php namespace App\Tests;

use Silex\WebTestCase;

class LoginFormTest extends WebTestCase
{

    /**
     * Bootstrap app for testing
     * @return mixed
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../../../public/index.php';

        $app['debug'] = true;
        unset($app['exception_handler']);

        return $app;
    }

    /**
     * Test basic page loading
     * @test
     */
    public function testInitialPage()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/auth/login');

        //Navbar and Login Form
        $this->assertCount(2, $crawler->filter('form'));

        //Login form fields
        $this->assertCount(1, $crawler->filter('input#username'));
        $this->assertCount(1, $crawler->filter('input#password'));

        $this->assertCount(1, $crawler->filter('h4:contains("Login!")'));
        $this->assertTrue($client->getResponse()->isOk());
    }


    /**
     * Test unsuccessful login attempt
     * @test
     */
    public function testBadLogin()
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', '/auth/login');
        $form = $crawler->selectButton('login-submit')->form([
            'username' => 'Johnny',
            'password' => 'test'
            ]);

        // submit the form
        $crawler = $client->submit($form);

        //Verify redirect back
        $this->assertEquals($crawler->getUri(), 'http://localhost/auth/login');
    }

    /**
     * Test successful login attempt
     * @test
     */
    public function testGoodLogin()
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', '/auth/login');
        $form = $crawler->selectButton('login-submit')->form([
            'username' => 'Johnny',
            'password' => 'password'
        ]);

        // submit the form
        $crawler = $client->submit($form);
    }

}