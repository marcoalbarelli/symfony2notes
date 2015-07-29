<?php


namespace Marcoalbarelli\APIBundle\Service;


use Marcoalbarelli\EntityBundle\Entity\User;
use Symfony\Component\Security\Core\User\UserProviderInterface;

interface APIUserProviderInterface extends UserProviderInterface
{
    /**
     * @param string $apiKey
     * @return User|null
     */
    public function findUserByAPIKey($apiKey);

}