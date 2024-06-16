<?php

namespace App\Models;
use App\Core\SQL;


class Status extends SQL
{
    protected ?int $id = null;
    protected $status;

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
        return $this->status;
    }

    public function setName($status): void
    {
        $this->status = $status;
    }
}
