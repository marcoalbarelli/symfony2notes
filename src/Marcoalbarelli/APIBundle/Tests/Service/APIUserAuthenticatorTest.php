<?php

namespace Marcoalbarelli\APIBundle\Tests\Service;

use Marcoalbarelli\APIBundle\Tests\BaseTestClass;

class APIUserAuthenticatorTest extends BaseTestClass
{

    public function testServiceExists(){
        $this->container->get('marcoalbarelli.api_user_authenticator');
    }

    public function testServiceImplementsCorrectInterface(){
        $service = $this->container->get('marcoalbarelli.api_user_authenticator');
        $this->assertInstanceOf('Symfony\Component\Security\Core\Authentication\SimplePreAuthenticatorInterface',$service);
    }

    public function testAuthenticatorAcceptsValidJWT(){
        $jwt = $this->createValidJWT($this->container->getParameter('secret'));

        $service = $this->container->get('marcoalbarelli.api_user_authenticator');
//        $service->authenticateToken();
    }
}