<?php
namespace App\Models;
use App\Core\SQL;

class SiteSetting extends SQL{

    protected ?int $id = null;
    protected $icon;
    protected $title;
    protected $description;
    protected $logo;
    protected $user_id;
    protected $status_id;
    protected $created_at;
    protected $updated_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    public function setIcon($icon): void
    {
        $this->icon = $icon;
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

    public function getLogo()
    {
        return $this->logo;
    }

    public function setLogo($logo): void
    {
        $this->logo = $logo;
    }

    public function getUser()
    {
        return $this->user_id;
    }

    public function setUser($user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getStatus()
    {
        return $this->status_id;
    }

    public function setStatus($status_id): void
    {
        $this->status_id = $status_id;
    }

    public function getCreated_at()
    {
        return $this->created_at;
    }

    public function setCreated_at($creation_date): void
    {
        $this->created_at = $created_at;
    }

    public function getUpdated_at()
    {
        return $this->updated_at;
    }

    public function setUpdated_at($updated_at): void
    {
        $this->updated_at = $updated_at;
    }


   

    public function getNbElements() {
        return $this->countElements();
    }

}

