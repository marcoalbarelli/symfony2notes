<?php


namespace Marcoalbarelli\APIBundle\Tests\Service;


class APIAuthEntrypoint extends BaseServiceTestClass
{
    public function testServiceExists(){
        $this->container->get('marcoalbarelli.api_auth_entrypoint');
    }

    public function testServiceImplementsCorrectInterface(){
        $service = $this->container->get('marcoalbarelli.api_auth_entrypoint');
        $this->assertInstanceOf('use Symfony\Component\Security\Core\Authentication\SimplePreAuthenticatorInterface;',$service);
    }
}