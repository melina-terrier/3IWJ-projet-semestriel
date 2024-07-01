<?php
namespace App\Models;
use App\Core\SQL;

class Role extends SQL
{
    protected ?int $id = null;
    protected string $role;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->role;
    }

    public function setName($role): void
    {
        $role = ucwords(strtolower(trim($role)));
        $this->role = $role;
    }

    public function getByName($roleName): ?int
    {
        $role = $this->getOneBy(["role"=>$roleName], 'object');
        if ($role) {
            $roleId = $role->getId();
            return $roleId;
        }
        return null;
    }
}
