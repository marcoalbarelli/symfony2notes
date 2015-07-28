<?php


namespace Marcoalbarelli\APIBundle\Service;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\SimplePreAuthenticatorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class APIUserAuthenticator implements SimplePreAuthenticatorInterface
{
    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
    {
        // TODO: Implement authenticateToken() method.
    }

    public function supportsToken(TokenInterface $token, $providerKey)
    {
        // TODO: Implement supportsToken() method.
    }

    public function createToken(Request $request, $providerKey)
    {
        // TODO: Implement createToken() method.
    }

}