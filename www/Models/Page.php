<?php

namespace App\Models;
use App\Core\SQL;


class Page extends SQL
{
    protected ?int $id;
    protected string $slug;
    protected string $title;
    protected string $content;
    protected string $status;
    protected $creation_date;
    protected $modification_date;
    // protected string $user_name;

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

    public function getSlug()
    {
        if (isset($this->slug)) {
            return $this->slug;
        }
    }

    public function setSlug($slug): void
    {
        $this->slug = $slug;
    }

    public function getTitle()
    {
        if (isset($this->title)) {
            return $this->title;
        }
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function getContent()
    {
        if (isset($this->content)) {
            return $this->content;
        }
    }

    public function setContent($content): void
    {
        $this->content = $content;
    }

    public function getStatus()
    {
        if (isset($this->status)) {
            return $this->status;
        }
    }

    public function setStatus($status): void
    {
        $this->status = $status;
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

    public function validate(): array
    {
        $missingFields = array();

        if (empty($this->getSlug()) ) {
            $missingFields['slug'] = 'Le nom de la page est obligatoire';
        }

        if (empty($this->getTitle())) {
            $missingFields['title'] = 'Le titre de la page est obligatoire';
        }

        if (empty($this->getContent())) {
            $missingFields['content'] = 'Le contenu de la page est obligatoire';
        }

        return $missingFields;
    }

    // public function setUserName($user): void
    // {
    //     $this->user_name = $user;
    // }

    // public function getUserName()
    // {
    //     if (isset($this->user_name)) {
    //         return $this->user_name;
    //     }
    // }

    public function getNbElements() {
        return $this->countElements();
    }
}
