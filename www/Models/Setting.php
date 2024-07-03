<?php
namespace App\Models;
use App\Core\SQL;

class Setting extends SQL{
    protected ?int $id = null;
    protected string $key; 
    protected string $value;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }


    public function setKey($key)
    {
        $this->key = $key;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function setValue($value)
    {
        $value = strip_tags(strtolower(trim($value)));
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getNbElements() {
        return $this->countElements();
    }
    
}