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
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }


}