<?php

namespace Marcoalbarelli\APIBundle\Tests\Controller;

use Marcoalbarelli\APIBundle\Tests\BaseTestClass;

class DefaultControllerTest extends BaseTestClass
{
    public function testIndex()
    {
        $client = static::createClient();

        $router =$client->getContainer()->get('router');
        $route = $router->generate('api_hello',array('name'=>"Fabien"));

        $client->request('GET', $route);

        $response = json_decode($client->getResponse()->getContent(),true);

        $this->assertTrue(is_array($response));
        $this->assertArrayHasKey('hello',$response);
        $this->assertEquals("Fabien",$response['hello']);
    }

    /**
     * @dataProvider apiEndpointsProvider
     */
    public function testApiEndpointsAreInaccessibleWithoutAJWTAuthorizationHeader($method,$route,$params){
        $router = $this->container->get('router');
        $uri = $router->generate($route,$params);
        $client = static::createClient();
        $client->request($method,$uri,$params);
        $this->assertEquals(401,$client->getResponse()->getStatusCode());
    }


    public function apiEndpointsProvider(){
        $out = [];
        $out[] = array('GET', 'api_hello', array('name'=>'Pippo'));
        return $out;
    }
}
