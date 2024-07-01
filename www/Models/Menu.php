<?php
namespace App\Models;

use App\Core\SQL;

class Menu extends SQL
{
    protected ?int $id = null;
    protected string $type;
    protected string $position;
    protected string $alignement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    public function setPosition(string $position): void
    {
        $this->position = $position;
    }

    public function getAlignement(): string
    {
        return $this->alignement;
    }

    public function setAlignement(string $alignement): void
    {
        $this->alignement = $alignement;
    }

    public function getNbElements() {
        return $this->countElements();
    }

}