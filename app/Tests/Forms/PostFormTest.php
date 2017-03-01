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
        $client = $this->logIn($client);
        $crawler = $client->request('GET', '/');

        //Navbar and Post Form
        $this->assertCount(2, $crawler->filter('form'));

        //Post form field
        $this->assertTrue($client->followRedirect()->getResponse()->isOk());

        $crawler = $client->getResponse();
        $this->assertCount(1, $crawler->filter('input#body'));
    }


}