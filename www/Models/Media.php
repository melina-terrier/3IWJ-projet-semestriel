<?php
namespace App\Models;
use App\Core\SQL;

class Media extends SQL
{
    protected ?int $id;
    protected string $title;
    protected string $url;
    protected string $description;
    protected $creation_date;
    protected $modification_date;
    protected $status;
    // protected $user_name;

    public function getId()
    {
        if (isset($this->id)) {
            return $this->id;
        }
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getTitle()
    {
        if (isset($this->title)) {
            return $this->title;
        }
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getUrl()
    {
        if (isset($this->url)) {
            return $this->url;
        }
    }

    public function setUrl($url): void
    {
        $this->url = $url;
    }

    public function getDescription()
    {
        if (isset($this->description)) {
            return $this->description;
        }
    }

    public function setDescription($description): void
    {
        $this->description = $description;
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

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status): void
    {
        $this->status = $status;
    }

    // public function getUserName()
    // {
    //     return $this->user_name;
    // }

    // public function setUserName($user_name): void
    // {
    //     $this->user_name = $user_name;
    // }

    public function setModificationDate($modification_date): void
    {
        $this->modification_date = $modification_date;
    }

    public function getNbElements() {
        return $this->countElements();
    }

    public function getElementsByType($column, $value) {
        return $this->countElements($column, $value);
    }

}
