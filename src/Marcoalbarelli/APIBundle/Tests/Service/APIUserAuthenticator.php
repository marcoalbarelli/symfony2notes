<?php

namespace Marcoalbarelli\APIBundle\Tests\Service;

class APIUserAuthenticator extends BaseServiceTestClass
{

    public function testServiceExists(){
        $this->container->get('marcoalbarelli.api_user_authenticator');
    }

    public function testServiceImplementsCorrectInterface(){
        $service = $this->container->get('marcoalbarelli.api_user_authenticator');
        $this->assertInstanceOf('use Symfony\Component\Security\Core\Authentication\SimplePreAuthenticatorInterface;',$service);
    }
}