<?php

namespace Marcoalbarelli\APIBundle\Tests\Service;

class APIUserAuthenticatorTest extends BaseServiceTestClass
{

    public function testServiceExists(){
        $this->container->get('marcoalbarelli.api_user_authenticator');
    }

    public function testServiceImplementsCorrectInterface(){
        $service = $this->container->get('marcoalbarelli.api_user_authenticator');
        $this->assertInstanceOf('Symfony\Component\Security\Core\Authentication\SimplePreAuthenticatorInterface',$service);
    }
}