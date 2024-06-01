<?php
namespace App\Models;
use App\Core\SQL;

class Category extends SQL
{
    private ?int $id = null; // Ajoutez cette propriété
    protected string $title;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): ?int
    {
        $this->id = $id;
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
