<?php

namespace Marcoalbarelli\APIBundle\Tests\Service;

use Marcoalbarelli\APIBundle\Constants;
use Marcoalbarelli\APIBundle\Tests\BaseTestClass;
use Marcoalbarelli\EntityBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class APIUserAuthenticatorTest extends BaseTestClass
{
    public function testServiceExists(){
        $this->container->get('marcoalbarelli.api_user_authenticator');
    }

    public function testServiceImplementsCorrectInterface(){
        $service = $this->container->get('marcoalbarelli.api_user_authenticator');
        $this->assertInstanceOf('Symfony\Component\Security\Core\Authentication\SimplePreAuthenticatorInterface',$service);
    }

    public function testAuthenticatorCreatesTokenForValidJWT(){
        $this->markTestIncomplete('the actual token still needs work to be provided');
        $jwt = $this->createValidJWT($this->container->getParameter('secret'));
        $service = $this->container->get('marcoalbarelli.api_user_authenticator');
        $token = $service->createToken(new Request(),'pippo');

    }

    public function testAuthenticatorCreatesValidTokenIfRequestIsValid(){
        $jwt = $this->createValidJWT($this->container->getParameter('secret'));
        $request = new Request();
        $request->headers->add(array('Authorization'=> Constants::JWT_BEARER_PREFIX .$jwt));

        $this->container->set('marcoalbarelli.api_user_provider',$this->getMockedUserProvider());
        $service = $this->container->get('marcoalbarelli.api_user_authenticator');

        $preauthenticatedToken = $service->createToken($request,'pippo');
        $this->assertNotNull($preauthenticatedToken);
        $this->assertEquals($preauthenticatedToken->getCredentials(),$jwt);

    }

    public function testAuthenticatorThrowsExceptionIfRequestIsInvalid(){
        $this->markTestIncomplete("TODO");
    }
}