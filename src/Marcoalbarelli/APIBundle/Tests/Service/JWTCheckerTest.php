<?php


namespace Marcoalbarelli\APIBundle\Tests\Service;

use Firebase\JWT\JWT;

class JWTCheckerTest extends BaseServiceTestClass
{

    public function testServiceExists(){
        $this->container->get('marcoalbarelli.jwt_checker');
    }

    public function testServiceAcceptsValidJWTToken(){
        $key = $this->container->getParameter('secret');
        $algs = $this->container->getParameter('jwt_algs');
        $now = new \DateTime('now');
        $token = array(
            "iss" => "http://example.org",
            "aud" => "http://example.com",
            "iat" => $now->getTimestamp(),
            "nbf" => $now->sub( new \DateInterval('P1D'))->getTimestamp(),
            "role" => 'ROLE_USER'
        );

        $service = $this->container->get('marcoalbarelli.jwt_checker');
        $encodedToken = JWT::encode($token,$key);

        $this->assertTrue($service->decodeToken($encodedToken));

//        $decodedToken = JWT::decode($encodedToken,$key,$algs);
    }
}