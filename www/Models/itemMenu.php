<?php
namespace App\Models;

use App\Core\SQL;

class itemMenu extends SQL
{
    protected ?int $id = null;
    protected string $title;
    protected string $url;
    protected int $item_position;
    protected string $menu_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $title = strip_tags(ucwords(strtolower(trim($title))));
        $this->title = $title;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $url = strip_tags(strtolower(trim($url)));
        $this->url = $url;
    }

    public function getItemPosition(): int
    {
        return $this->item_position;
    }

    public function setItemPosition(int $item_position): void
    {
        $this->item_position = $item_position;
    }

    public function getMenu(): string
    {
        return $this->menu_id;
    }

    public function setMenu(string $menu_id): void
    {
        $this->menu_id = $menu_id;
    }

    public function getNbElements() {
        return $this->countElements();
    }

}