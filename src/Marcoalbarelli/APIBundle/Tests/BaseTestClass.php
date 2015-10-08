<?php


namespace Marcoalbarelli\APIBundle\Tests;


use Doctrine\ORM\EntityManagerInterface;
use Firebase\JWT\JWT;
use Marcoalbarelli\APIBundle\Constants;
use Marcoalbarelli\EntityBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Finder\Finder;

class BaseTestClass   extends WebTestCase
{

    /**
     * @var ContainerInterface $container
     */
    protected $container;

    /**
     * @var Client
     */
    protected $client;

    public function setUp(){
        $this->client = static::createClient();
        $this->container = static::$kernel->getContainer();
    }

    /**
     * @param $key
     * @param string $role
     * @return mixed
     */
    public function createValidJWT($key,$role = 'ROLE_USER',$apiKey = null)
    {

        $now = new \DateTime('now');
        $role = 'ROLE_USER';
        if($apiKey == null){
            $apiKey = md5(rand(0,10));
        }

        $token = array(
            "iss" => "http://example.org",
            "aud" => "http://example.com",
            "iat" => $now->getTimestamp(),
            "nbf" => $now->sub(new \DateInterval('P1D'))->getTimestamp(),
            "role" => $role,
            Constants::JWT_APIKEY_PARAMETER_NAME => $apiKey
        );
        return JWT::encode($token,$key);
    }

    public function createInvalidJWT($key,$role = 'ROLE_USER')
    {

        $now = new \DateTime('now');
        $role = 'ROLE_USER';
        //Missing apikey and valid since tomorrow
        $token = array(
            "iss" => "http://example.org",
            "aud" => "http://example.com",
            "iat" => $now->getTimestamp(),
            "nbf" => $now->add(new \DateInterval('P1D'))->getTimestamp(),
            "role" => $role
        );
        return JWT::encode($token,$key);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function getMockedFOSUserManager()
    {
        $mockedUM = $this->getMockBuilder('FOS\UserBundle\Model\UserManager')
            ->disableOriginalConstructor()
            ->getMock();
        $mockedUM->
        expects($this->atLeastOnce())->
        method('updateUser');
        return $mockedUM;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockedUserProvider($timesCalled = 1){
        $mockedUserProvider = $this->getMockBuilder('Marcoalbarelli\APIBundle\Service\APIUserProvider')
            ->disableOriginalConstructor()
            ->getMock();

        $mockedUser = new User();
        $mockedUser->
            addRole('ROLE_USER')->
            setUsername('mocked')->
            setEmail('mocked@mocked.mo')->
            setEnabled(true)->
            setPlainPassword('mocked')
        ;

        $mockedUserProvider->expects($this->exactly($timesCalled))->
        method('findUserByAPIKey')->
        will($this->returnValue($mockedUser))
        ;
        return $mockedUserProvider;
    }

    /**
     * Attempts to guess the kernel location.
     *
     * When the Kernel is located, the file is required.
     *
     * @return string The Kernel class name
     *
     * @throws \RuntimeException
     */
    protected static function getKernelClass()
    {
        $dir = isset($_SERVER['KERNEL_DIR']) ? $_SERVER['KERNEL_DIR'] : static::getPhpUnitXmlDir();

        $finder = new Finder();
        $finder->name('*TestKernel.php')->depth(0)->in($dir);
        $results = iterator_to_array($finder);
        if (!count($results)) {
            throw new \RuntimeException('Either set KERNEL_DIR in your phpunit.xml according to http://symfony.com/doc/current/book/testing.html#your-first-functional-test or override the WebTestCase::createKernel() method.');
        }


        $file = current($results);
        $class = $file->getBasename('.php');

        require_once $file;

        return $class;
    }

    protected function truncateDB(EntityManagerInterface $em)
    {
        $bundle = 'MarcoalbarelliEntityBundle';
        $entities = [
            'User',
        ];

        foreach ($entities as $entity) {
            $em->createQuery(
                'DELETE ' .
                'FROM ' . $bundle . ':' . $entity
            )->execute();
        }

    }


}