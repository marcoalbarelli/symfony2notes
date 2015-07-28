<?php


namespace Marcoalbarelli\APIBundle\Tests\Service;


class APIUserProvider extends BaseServiceTestClass
{
    public function testServiceExists(){
        $this->container->get('marcoalbarelli.api_user_provider');
    }

    public function testServiceImplementsCorrectInterface(){
        $service = $this->container->get('marcoalbarelli.api_user_provider');
        $this->assertInstanceOf('Symfony\Component\Security\Core\User\UserProviderInterface',$service);
    }
}