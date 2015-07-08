<?php

namespace Marcoalbarelli\SiteBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $router =$client->getContainer()->get('router');
        $route = $router->generate('site_hello',array('name'=>"Fabien"));

        $crawler = $client->request('GET', $route);

        $this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() > 0);
    }
}
