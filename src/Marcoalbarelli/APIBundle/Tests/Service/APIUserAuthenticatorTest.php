<?php

namespace Marcoalbarelli\APIBundle\Tests\Service;

use Marcoalbarelli\APIBundle\Constants;
use Marcoalbarelli\APIBundle\Tests\BaseTestClass;
use Marcoalbarelli\EntityBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

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
        $apiKey = 'key';
        $jwt = $this->createValidJWT($this->container->getParameter('secret'),'ROLE_USER', $apiKey);

        if($this->container->getParameter('usemocksfortesting')){
            $this->container->set('marcoalbarelli.api_user_provider',$this->getMockedUserProvider());
        } else {
            $em = $this->container->get('doctrine.orm.entity_manager');
            $this->truncateDB($em);
            $userManager = $this->container->get('fos_user.user_manager');
            $user = new User();
            $user->setUsername('pippo');
            $user->setPlainPassword('pippo');
            $user->setEmail('pippo@pippo.pi');
            $user->setApiKey ($apiKey);
            $userManager->updateUser($user);
        }

        $service = $this->container->get('marcoalbarelli.api_user_authenticator');
        $request = new Request();
        $request->headers->add(array('Authorization'=>Constants::JWT_BEARER_PREFIX.$jwt));
        $token = $service->createToken($request,'pippo');
        $this->assertNotNull($token);
    }

    public function testAuthenticatorCreatesValidTokenIfRequestIsValidAnUserIsPresent(){
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

        $service->createToken($request,'pippo');
    }

    /**
     * @expectedException Symfony\Component\Security\Core\Exception\UsernameNotFoundException
     */
    public function testAuthenticatorThrowsExceptionIfUserIsMissing(){
        $userRepo = $this->container->get('doctrine')->getManager()->getRepository('MarcoalbarelliEntityBundle:User');

        $jwt = $this->createValidJWT($this->container->getParameter('secret'));
        $request = new Request();
        $request->headers->add(array('Authorization'=> Constants::JWT_BEARER_PREFIX .$jwt));
        $em = $this->container->get('doctrine.orm.entity_manager');
        $this->truncateDB($em);
        $users = $userRepo->findAll();
        $this->assertEquals(0,count($users));

        $service = $this->container->get('marcoalbarelli.api_user_authenticator');

        $service->createToken($request,'pippo');
    }

    public function testAuthenticatorSuccedesIfRequestIsValidAndUserIsPresent(){

        //perform the request
        //check that code is 200
    }

}