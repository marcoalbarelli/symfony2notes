<?php


namespace Marcoalbarelli\APIBundle\Service;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Security\Http\Firewall;

class APIAuthEntrypoint implements AuthenticationEntryPointInterface
{
    /**
     * Starts the authentication scheme.
     *
     * @param Request $request The request that resulted in an AuthenticationException
     * @param AuthenticationException $authException The exception that started the authentication process
     *
     * @return Response
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $content = array('success'=>false);
        $response = new Response(json_encode($content),401);
        $response->headers->set('Content-Type','application/json');
        $response->headers->set('WWW-Authenticate','OpenID realm="api_area"'); //TODO: retrieve the firewall name dynamically
        return $response;
    }

}