<?php

namespace Marcoalbarelli\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class DefaultControllerTest extends WebTestCase
{
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

    /**
     * @dataProvider adminRouteProvider
     * @param $route
     * @param $parameters
     */
    public function testAdminUsersCanAccessAdminRoutes($route,$parameters){
        $this->client = static::createClient();
        $this->logIn();
        $router = $this->client->getContainer()->get('router');
        $route = $router->generate($route,$parameters);

        $this->client->request('GET', $route);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function adminRouteProvider(){
        $out = [];
        $out[] = array('admin_hello',array('name'=>"Fabien"));
        return $out;
    }

    private function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        $firewall = 'admin_area';
        $token = new UsernamePasswordToken('admin', null, $firewall, array('ROLE_ADMIN'));
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}
