<?php

namespace Marcoalbarelli\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * Class User
 * @package Marcoalbarelli\EntityBundle\Entity
 * @ORM\Entity()
 * @ORM\Table(name="Users")
 */
class User extends BaseUser
{
    /**
     * @var string $id
     * @ORM\Id()
     * @ORM\Column(type="string")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var string $apiKey
     * @ORM\Column(type="string",nullable=true)
     */
    protected $apiKey;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param $apiKey
     * @return User
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
        return $this;
    }

}