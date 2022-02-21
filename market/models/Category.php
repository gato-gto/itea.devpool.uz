<?php

use Dacota\Model\BaseModel;
use Doctrine\ORM\Mapping as ORM;

require_once 'Dacota/Model.php';

/**
 * @ORM\Entity
 * @ORM\Table(name="categories")
 */
class Category extends BaseModel
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\OneToOne(targetEntity="Category")
     */
    private $parent;

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

    public function setParent($parent): void
    {
        $this->parent = $parent;
    }


    public function getName()
    {
        return $this->name;
    }


    public function getParent()
    {
        return $this->parent;
    }

}