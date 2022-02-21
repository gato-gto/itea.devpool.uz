<?php

use Dacota\Model\BaseModel;
use Doctrine\ORM\Mapping as ORM;

require_once 'Dacota/Model.php';

/**
 * @ORM\Entity
 * @ORM\Table(name="brands")
 */
class Brand extends BaseModel
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $name;

    public function getId()
    {
        return $this->id;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

}