<?php

namespace App\Models;
use App\Core\SQL;


class PageHistory extends SQL
{
    protected ?int $id = null;
    protected $page_id;
    protected $title;
    protected $content;
    protected $slug;
    protected $creation_date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getPageId()
    {
        return $this->page_id;
    }

    public function setPageId($page_id): void
    {
        $this->page_id = $page_id;
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

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug): void
    {
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

    public function getNbElements() {
        return $this->countElements();
    }
}
