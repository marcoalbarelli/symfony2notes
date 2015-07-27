<?php

namespace Marcoalbarelli\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class DefaultControllerTest extends WebTestCase
{
    const ADMIN_AREA_FIREWALL_NAME = 'admin_area';

    /**
     * @var $client Client
     */
    private $client;

    /**
     * @dataProvider adminRouteProvider
     * @param $route
     * @param $parameters
     */
    public function testAllAdminRoutesAreUnacessibleByAnonymousUsers($route,$parameters)
    {
        $this->client = static::createClient();

        $router =$this->client->getContainer()->get('router');
        $route = $router->generate($route,$parameters);

        $this->client->request('GET', $route);

        $this->assertEquals(302,$this->client->getResponse()->getStatusCode());
        $this->assertcontains('login',$this->client->getResponse()->headers->get('Location'));
    }

    public function testAdminLoginRouteExists(){
        $this->client = static::createClient();

        $router =$this->client->getContainer()->get('router');
        $route = $router->generate('admin_hello',array('name'=>"Fabien"));

        $this->client->request('GET', $route);

        $this->assertEquals(302,$this->client->getResponse()->getStatusCode());
        $this->assertcontains('login',$this->client->getResponse()->headers->get('Location'));
        $this->client->followRedirect();
        $this->assertEquals(200,$this->client->getResponse()->getStatusCode());
    }

    /**
     * @dataProvider adminRouteProvider
     * @param $route
     * @param $parameters
     */
    public function testAdminUsersCanAccessAdminRoutes($route,$parameters){
        $this->client = static::createClient();

        $this->logInAdmin();
        $router = $this->client->getContainer()->get('router');
        $route = $router->generate($route,$parameters);

        $this->client->request('GET', $route);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @dataProvider adminRouteProvider
     * @param $route
     * @param $parameters
     */
    public function testNonAdminUsersAreBlocked($route,$parameters){
        $this->client = static::createClient();
        $router = $this->client->getContainer()->get('router');
        $route = $router->generate($route,$parameters);

        //Login via SessionCookie
        $this->logInUser();
        $this->client->request('GET', $route);
        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
        //Login via http_basic (just to check that a useful test approach doesn't break
        $this->client = static::createClient(); //refresh the client to drop the session
        $this->client->request('GET', $route,array(),array(),array('PHP_AUTH_USER'=>'foo','PHP_AUTH_PW'=>'foo'));
        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
    }

    public function adminRouteProvider(){
        $out = [];
        $out[] = array('admin_hello',array('name'=>"Fabien"));
        return $out;
    }

    private function loginAdmin(){
        $this->logInViaUsernamePasswordToken('admin','ROLE_ADMIN');
    }

    private function loginUser(){
        $this->logInViaUsernamePasswordToken('user','ROLE_USER');
    }

    private function logInViaUsernamePasswordToken($username,$role)
    {
        $session = $this->client->getContainer()->get('session');

        $token = new UsernamePasswordToken($username, null, self::ADMIN_AREA_FIREWALL_NAME, array($role));
        $session->set('_security_'.self::ADMIN_AREA_FIREWALL_NAME, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}
