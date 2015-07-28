<?php


namespace Marcoalbarelli\APIBundle\Service;


use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class APIUserProvider implements UserProviderInterface
{
    public function loadUserByUsername($username)
    {
        // TODO: Implement loadUserByUsername() method.
        $a= 2;
    }

    public function refreshUser(UserInterface $user)
    {
        // TODO: Implement refreshUser() method.
        $a= 2;
        return $user;
    }

    public function supportsClass($class)
    {
        return $class === 'Marcoalbarelli\EntityBundle\Entity\User';
    }

}