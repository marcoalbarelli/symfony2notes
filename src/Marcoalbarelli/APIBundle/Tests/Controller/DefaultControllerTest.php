<?php

namespace Marcoalbarelli\APIBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
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
}
