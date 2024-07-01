<?php
namespace App\Models;
use App\Core\SQL;

class PageHistory extends SQL
{
    protected ?int $id = null;
    protected int $page_id;
    protected string $title;
    protected string $content;
    protected string $slug;
    protected string $creation_date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getPageId(): int
    {
        return $this->page_id;
    }

    public function setPageId(int $page_id): void
    {
        $this->page_id = $page_id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $title = trim($title);
        $this->title = $title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $content = trim($content);
        $this->content = $content;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $slug = trim(strtolower($slug));
        $slug->slug = $slug;
    }

    public function getCreationDate(): string
    {
        return $this->creation_date;
    }

    public function setCreationDate(string $creation_date): void
    {
        $this->creation_date = $creation_date;
    }
}
