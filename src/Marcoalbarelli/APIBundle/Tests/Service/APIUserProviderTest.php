<?php


namespace Marcoalbarelli\APIBundle\Tests\Service;


use Marcoalbarelli\APIBundle\Tests\BaseTestClass;

class APIUserProviderTest extends BaseTestClass
{
    public function testServiceExists(){
        $this->container->get('marcoalbarelli.api_user_provider');
    }

    public function testServiceImplementsCorrectInterface(){
        $service = $this->container->get('marcoalbarelli.api_user_provider');
        $this->assertInstanceOf('Symfony\Component\Security\Core\User\UserProviderInterface',$service);
    }
}