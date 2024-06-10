<?php
namespace App\Models;
use App\Core\SQL;

class Media extends SQL
{
    protected ?int $id = null;
    protected string $title;
    protected string $name;
    protected $type;
    protected $size;
    protected $url;
    protected string $description;
    protected $creation_date;
    protected $modification_date;
    protected $status_id;
    protected $user_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description): void
    {
        $this->description = $description;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url): void
    {
        $this->url = $url;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type): void
    {
        $this->type = $type;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size): void
    {
        $this->size = $size;
    }

    public function getStatus()
    {
        return $this->status_id;
    }

    public function setStatus($status_id): void
    {
        $this->status_id = $status_id;
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

    public function getUser()
    {
        return $this->user_id;
    }

    public function setUser($user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getNbElements() {
        return $this->countElements();
    }

}
