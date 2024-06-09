<?php

namespace App\Models;

use App\Core\SQL;

class Project extends SQL
{
    protected ?int $id = null;
    protected $title;
    protected $content;
    protected $slug;
    protected $status_id;
    protected $creation_date;
    protected $modification_date;
    protected $publication_date;
    protected $user_id;
    protected $tag_id;

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
        return $this->status_id;
    }

    public function setStatus($status_id): void
    {
        $this->status_id = $status_id;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug): void
    {
        $slug = strtolower(preg_replace('/\s+|[^\w-]/', '-', $slug));
        $this->slug = $slug;
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

    public function getPublicationDate()
    {
        return $this->publication_date;
    }

    public function setPublicationDate($publication_date): void
    {
        $this->publication_date = $publication_date;
    }

    public function getUser()
    {
        return $this->user_id;
    }

    public function setUser($user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getTag()
    {
        return $this->tag_id;
    }

    public function setTag($tag_id): void
    {
        $this->tag_id = $tag_id;
    }

    public function getNbElements() {
        return $this->countElements();
    }

}
