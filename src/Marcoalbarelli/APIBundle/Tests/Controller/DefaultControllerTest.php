<?php

namespace Marcoalbarelli\APIBundle\Tests\Controller;

use Marcoalbarelli\APIBundle\Tests\BaseTestClass;

class DefaultControllerTest extends BaseTestClass
{
    public function testIndex()
    {
        $this->markTestIncomplete("Need to inject the mock in the client's kernel");

        $mockedUserRepo = $this->getMockedUserProvider();

        static::$kernel = static::createKernel();

        static::$kernel->setKernelModifier(function($kernel) use ($mockedUserRepo) {
            $kernel->getContainer()->set('marcoalbarelli.api_user_provider', $mockedUserRepo);
        });

        $client = static::createClient();

        $router =$client->getContainer()->get('router');
        $route = $router->generate('api_hello',array('name'=>"Fabien"));

        $client->setServerParameter('HTTP_Authorization','Bearer '.$this->createValidJWT($this->container->getParameter('secret')));
        $client->request('GET', $route);

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
        $response = json_decode($client->getResponse()->getContent(),true);

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
        $this->markTestIncomplete("Need to inject the mock in the client's kernel");
        $router = $this->container->get('router');
        $uri = $router->generate($route,$params);
        $client = static::createClient();
        $client->setServerParameter('HTTP_Authorization','Bearer '.$this->createValidJWT($this->container->getParameter('secret')));
        $client->request($method,$uri,$params);
        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }

    public function apiEndpointsProvider(){
        $out = [];
        $out[] = array('GET', 'api_hello', array('name'=>'Pippo'));
        return $out;
    }
}
