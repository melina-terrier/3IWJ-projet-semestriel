<?php
namespace App\Models;
use App\Core\SQL;

class Setting extends SQL{
    protected ?int $id = null;
    protected string $key; 
    protected string $value;
    protected string $creation_date;
    protected string $modification_date;

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

    public function getCreationDate()
    {
        return $this->creation_date;
    }

    public function setCreationDate($creation_date): void
    {
        $this->creation_date = $creation_date;
    }

    public function getModificationDate()
    {
        return $this->modification_date;
    }

    public function setModificationDate($modification_date): void
    {
        $this->modification_date = $modification_date;
    }
}