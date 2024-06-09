<?php

namespace App\Models;
use App\Core\SQL;


class Role extends SQL
{
    protected ?int $id = null;
    protected $role;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->role;
    }

    public function setName($role): void
    {
        $this->role = $role;
    }
}
