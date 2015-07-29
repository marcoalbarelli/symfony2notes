<?php


namespace Marcoalbarelli\APIBundle\Tests\Service;

use Exception;
use Marcoalbarelli\APIBundle\Tests\BaseTestClass;

class JWTCheckerTest extends BaseTestClass
{

    public function testServiceExists(){
        $this->container->get('marcoalbarelli.jwt_checker');
    }

    public function testServiceReturnsValidJWTTokenDecoded(){
        $key = $key = $this->container->getParameter('secret');
        $token = $this->createValidJWT($key);

        $service = $this->container->get('marcoalbarelli.jwt_checker');

        $decoded = $service->decodeToken($token);

        $this->assertNotNull($decoded);
        $this->assertTrue(is_object($decoded)); //No point in testing further an external library
    }

    /**
     * @expectedException Exception
     */
    public function testServiceThrowsExceptionForInvalidJWTToken(){
        $key = $key = $this->container->getParameter('secret');
        $token = $this->createInvalidJWT($key);

        $service = $this->container->get('marcoalbarelli.jwt_checker');

        $service->decodeToken($token);
    }

}