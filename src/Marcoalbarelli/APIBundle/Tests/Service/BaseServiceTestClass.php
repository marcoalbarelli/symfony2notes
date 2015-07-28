<?php


namespace Marcoalbarelli\APIBundle\Tests\Service;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BaseServiceTestClass extends WebTestCase
{
    /**
     * @var ContainerInterface $container
     */
    protected $container;

    public function setUp(){
        $kernel = self::createKernel();
        $kernel->boot();
        $this->container = $kernel->getContainer();
    }

}