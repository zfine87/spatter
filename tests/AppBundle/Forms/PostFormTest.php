<?php namespace App\Tests;

use Silex\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class PostFormTest extends WebTestCase
{
    public function createApplication()
    {
        // app.php must return an Application instance
        $app = require __DIR__.'/../../../public/index.php';

        $app['debug'] = true;
        unset($app['exception_handler']);

        return $app;
    }

    private function logIn($client)
    {
        $session = $this->app['session'];
        $firewall = 'main';
        $token = new UsernamePasswordToken('test', null, $firewall, ['ROLE_USER']);
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();
        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);

        return $client;
    }

    /**
     * Test index page post form (and index page because this is a tiny one page site)
     * @test
     */
    public function testInitialPage()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/', [], [], [
            'PHP_AUTH_USER' => 'username',
            'PHP_AUTH_PW'   => 'pa$$word',
        ]);

        //Check URI
        $this->assertCount(1, $crawler->filter('button#post-submit'));
        $this->assertEquals($crawler->getUri(), 'http://localhost/');


        $form = $crawler->selectButton('post-submit')->form([
            'body' => 'this is a test'
        ]);

        // submit the form
        $crawler = $client->submit($form);

        //Verify redirect back with error
        $this->assertCount(0, $crawler->filter('div#form-errors'));
    }


}