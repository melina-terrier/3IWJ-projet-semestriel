<?php
namespace App\Models;
use App\Core\SQL;

class Status extends SQL
{
    protected ?int $id = null;
    protected string $status;

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
        return $this->status;
    }
    
    public function setName(string $status): void
    {
        $status = ucwords(strtolower(trim($status)));
        $this->status = $status;
    }

    public function getByName($statusName): ?int
    {
        $status = $this->getOneBy(["status"=>$statusName], 'object');
        if ($status) {
            $statusId = $status->getId();
            return $statusId;
        }
        return null;
    }
}
