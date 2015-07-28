<?php


namespace Marcoalbarelli\APIBundle\Tests\Service;


use Marcoalbarelli\APIBundle\Tests\BaseTestClass;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class APIAuthEntrypointTest extends BaseTestClass
{
    public function testServiceExists(){
        $this->container->get('marcoalbarelli.api_user_auth_entrypoint');
    }

    public function testServiceImplementsCorrectInterface(){
        $service = $this->container->get('marcoalbarelli.api_user_auth_entrypoint');
        $this->assertInstanceOf('Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface',$service);
    }

    public function testAuthEntrypointGives401ErrorForMissingJWT(){
        $authException = new AuthenticationException("missing JWT");
        $request = new Request();
        $service = $this->container->get('marcoalbarelli.api_user_auth_entrypoint');
        $response = $service->start($request,$authException);
        $this->assertTrue($response instanceof Response);
        $this->assertEquals('application/json',$response->headers->get('Content-Type'));
        $this->assertEquals('OpenID realm="api_area"',$response->headers->get('WWW-Authenticate'));
    }

    public function testAuthEntrypointGives401ErrorForInvalidJWT(){
        $authException = new AuthenticationException("missing JWT");
        $request = new Request();
        $service = $this->container->get('marcoalbarelli.api_user_auth_entrypoint');
        $response = $service->start($request,$authException);
        $this->assertTrue($response instanceof Response);
        $this->assertEquals('application/json',$response->headers->get('Content-Type'));
        $this->assertEquals('OpenID realm="api_area"',$response->headers->get('WWW-Authenticate')); //TODO: move the realm name to a provider
    }
}