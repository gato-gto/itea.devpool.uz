<?php


namespace Dacota\Model;

interface IBaseModel
{
    static function objects();

    public function getId();
}


class BaseModel implements IBaseModel
{

    public function getId()
    {
        return $this->id;
    }

    static function objects()
    {
        $className = get_called_class();
        global $entityManager;
        return $entityManager->getRepository($className);
    }
    public function __toString()
    {
       return get_called_class();
    }

    public function getArray()
    {
        $rtn = [];
        foreach ((array)$this as $key => $val) {
            $aux = explode("\0", $key);
            $newkey = $aux[count($aux) - 1];
            if (is_object($val)) {
                $rtn[$newkey] = $val->getArray();
            } else {
                $rtn[$newkey] = $val;
            }
        }
        return $rtn;
    }

    public function save($commit = true)
    {
        global $entityManager;
        $entityManager->merge($this);
        if ($commit) {
            $entityManager->flush();
            return $this;
        }
        return false;
    }
    public function remove($commit = true)
    {
        global $entityManager;
        $entityManager->remove($this);
        if ($commit) {
            $entityManager->flush();
            return true;
        }
        return false;
    }
}