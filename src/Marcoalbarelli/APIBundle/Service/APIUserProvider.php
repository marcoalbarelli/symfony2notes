<?php


namespace Marcoalbarelli\APIBundle\Service;


use Marcoalbarelli\EntityBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;

class APIUserProvider implements APIUserProviderInterface
{
    public function loadUserByUsername($username)
    {
        // TODO: Implement loadUserByUsername() method.
    }

    public function refreshUser(UserInterface $user)
    {
        throw new UnsupportedUserException();
    }

    public function supportsClass($class)
    {
        return $class === 'Marcoalbarelli\EntityBundle\Entity\User';
    }

    /**
     * @param string $apiKey
     * @return User|null
     */
    public function findUserByAPIKey($apiKey)
    {
        //TODO: test and implement
        return null;
    }

}