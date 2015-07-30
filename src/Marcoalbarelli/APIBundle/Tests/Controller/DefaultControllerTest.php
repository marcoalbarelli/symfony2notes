<?php

namespace Marcoalbarelli\APIBundle\Tests\Controller;

use Marcoalbarelli\APIBundle\Tests\BaseTestClass;

class DefaultControllerTest extends BaseTestClass
{
    public function testIndex()
    {

        $router =$this->client->getContainer()->get('router');
        $route = $router->generate('api_hello',array('name'=>"Fabien"));

        $this->setupMocks();

        $this->client->setServerParameter('HTTP_Authorization','Bearer '.$this->createValidJWT($this->container->getParameter('secret')));
        $this->client->request('GET', $route);

        $this->assertEquals(200,$this->client->getResponse()->getStatusCode());
        $response = json_decode($this->client->getResponse()->getContent(),true);

        $this->assertTrue(is_array($response));
        $this->assertArrayHasKey('hello',$response);
        $this->assertEquals("Fabien",$response['hello']);
    }

    /**
     * @param $method
     * @param $route
     * @param $params
     * @dataProvider apiEndpointsProvider
     */
    public function testApiEndpointsAreInaccessibleWithoutAJWTAuthorizationHeader($method,$route,$params){
        $router = $this->container->get('router');
        $uri = $router->generate($route,$params);
        $client = static::createClient();
        $client->request($method,$uri,$params);
        $this->assertEquals(401,$client->getResponse()->getStatusCode());
    }

    /**
     * @param $method
     * @param $route
     * @param $params
     * @dataProvider apiEndpointsProvider
     */
    public function testApiEndpointsAreAccessibleWithAValidJWTAuthorizationHeader($method,$route,$params){
        $this->setupMocks();
        $router = $this->container->get('router');
        $uri = $router->generate($route,$params);

        $this->client->setServerParameter('HTTP_Authorization','Bearer '.$this->createValidJWT($this->container->getParameter('secret')));
        $this->client->request($method,$uri,$params);
        $this->assertEquals(200,$this->client->getResponse()->getStatusCode());
    }

    public function apiEndpointsProvider(){
        $out = [];
        $out[] = array('GET', 'api_hello', array('name'=>'Pippo'));
        return $out;
    }

    public function setupMocks()
    {
        $mockedApiUserProvider = $this->getMockedUserProvider();
        $mockedUM = $this->getMockedFOSUserManager();

        static::$kernel->setKernelModifier(function ($kernel) use ($mockedApiUserProvider, $mockedUM) {
            $kernel->getContainer()->set('marcoalbarelli.api_user_provider', $mockedApiUserProvider);
            $kernel->getContainer()->set('fos_user.user_manager', $mockedUM);
        });
    }


}
