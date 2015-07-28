<?php


namespace Marcoalbarelli\APIBundle\Tests\Service;

class JWTChecker extends BaseServiceTestClass
{

    public function testServiceExists(){
        $this->container->get('marcoalbarelli.jwt_checker');
    }

}