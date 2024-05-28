<?php

namespace App\Models;

use App\Core\SQL;

class Project extends SQL
{
    protected ?int $id = null;
    protected $title;
    protected $content;
    // protected $slug;
    protected $status;
    protected $creation_date;
    protected $modification_date;
    // protected $user_name;

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

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content): void
    {
        $this->content = $content;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status): void
    {
        $this->status = $status;
    }

    // public function getSlug()
    // {
    //     return $this->slug;
    // }

    // public function setSlug($slug): void
    // {
    //     $this->slug = $slug;
    // }

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

    // public function getUserName()
    // {
    //     return $this->user_name;
    // }

    // public function setUserName($user_name): void
    // {
    //     $this->user_name = $user_name;
    // }


    public function getNbElements() {
        return $this->countElements();
    }

    public function getElementsByType($column, $value) {
        return $this->countElements($column, $value);
    }

    public function getAllProjects() {
        return $this->getProjects("Publié");
    }

    public function getPublishedProjects() {
        return $this->getPublishedProject("project");
    }

    public function getDeletedProjects() {
        return $this->getDleletedProjects("project");
    }

    public function getDraftProjects() {
        return $this->getDraftProjects("project");
    }
}
