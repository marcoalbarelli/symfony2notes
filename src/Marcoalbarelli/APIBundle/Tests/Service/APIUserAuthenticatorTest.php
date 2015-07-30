<?php

namespace Marcoalbarelli\APIBundle\Tests\Service;

use Marcoalbarelli\APIBundle\Constants;
use Marcoalbarelli\APIBundle\Tests\BaseTestClass;
use Marcoalbarelli\EntityBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

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
        $this->container->set('marcoalbarelli.api_user_provider',$this->getMockedUserProvider());
        $jwt = $this->createValidJWT($this->container->getParameter('secret'));
        $service = $this->container->get('marcoalbarelli.api_user_authenticator');
        $request = new Request();
        $request->headers->add(array('Authorization'=>Constants::JWT_BEARER_PREFIX.$jwt));
        $token = $service->createToken($request,'pippo');
        $this->assertNotNull($token);
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

    /**
     * @expectedException \Exception
     */
    public function testAuthenticatorThrowsExceptionIfRequestIsInvalid(){
        $jwt = $this->createInvalidJWT($this->container->getParameter('secret'));
        $request = new Request();
        $request->headers->add(array('Authorization'=> Constants::JWT_BEARER_PREFIX .$jwt));

        $service = $this->container->get('marcoalbarelli.api_user_authenticator');

        $preauthenticatedToken = $service->createToken($request,'pippo');
        $this->assertNotNull($preauthenticatedToken);
        $this->assertEquals($preauthenticatedToken->getCredentials(),$jwt);
    }
}