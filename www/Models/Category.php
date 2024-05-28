<?php
namespace App\Models;
use App\Core\SQL;
class Category extends SQL
{
    private ?int $id = null; // Ajoutez cette propriété
    private ?int $id_categorie = null;
    protected string $Title;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getid_categorie(): ?int
    {
        return $this->id_categorie;
    }

    public function setid_categorie(?int $id_categorie): void
    {
        $this->id_categorie = $id_categorie;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}
