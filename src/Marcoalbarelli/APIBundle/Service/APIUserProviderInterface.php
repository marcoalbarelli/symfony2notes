<?php


namespace Marcoalbarelli\APIBundle\Service;


use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

interface APIUserProviderInterface extends UserProviderInterface
{
    /**
     * @param string $apiKey
     * @return UserInterface
     */
    public function findUserByAPIKey($apiKey);

}