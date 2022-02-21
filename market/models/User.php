<?php

use Dacota\Model\BaseModel;
use Doctrine\ORM\Mapping as ORM;

require_once 'Dacota/Model.php';

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseModel
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string")
     */
    private $password;

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username): void
    {
        $this->username = $username;
    }

    public function setPassword($password): void
    {
        $this->password = md5($password);
    }

    public function getPasswordHash()
    {
        return $this->password;
    }

}