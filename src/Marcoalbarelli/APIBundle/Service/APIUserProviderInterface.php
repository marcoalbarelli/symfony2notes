<?php


namespace Marcoalbarelli\APIBundle\Service;


use Symfony\Component\Security\Core\Role\RoleInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

interface APIUserProviderInterface extends UserProviderInterface
{
    /**
     * @param string $apiKey
     * @return array|RoleInterface
     */
    public function findUserByAPIKey($apiKey);

}