<?php


namespace Marcoalbarelli\APIBundle\Tests\Service;

use Marcoalbarelli\APIBundle\Tests\BaseTestClass;

class JWTCheckerTest extends BaseTestClass
{

    public function testServiceExists(){
        $this->container->get('marcoalbarelli.jwt_checker');
    }

    public function testServiceAcceptsValidJWTToken(){
        $key = $key = $this->container->getParameter('secret');
        $token = $this->createValidJWT($key);

        $service = $this->container->get('marcoalbarelli.jwt_checker');

        $this->assertTrue($service->decodeToken($token));
    }

}