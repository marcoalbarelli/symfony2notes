<?php


namespace Marcoalbarelli\APIBundle\Tests;


use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BaseTestClass extends WebTestCase
{
    /**
     * @var ContainerInterface $container
     */
    protected $container;

    public function setUp(){
        $kernel = self::createKernel();
        $kernel->boot();
        $this->container = $kernel->getContainer();
    }

    /**
     * @param $key
     * @param string $role
     * @return mixed
     */
    public function createValidJWT($key,$role = 'ROLE_USER')
    {

        $now = new \DateTime('now');
        $role = 'ROLE_USER';
        $token = array(
            "iss" => "http://example.org",
            "aud" => "http://example.com",
            "iat" => $now->getTimestamp(),
            "nbf" => $now->sub(new \DateInterval('P1D'))->getTimestamp(),
            "role" => $role
        );
        return JWT::encode($token,$key);
    }
}