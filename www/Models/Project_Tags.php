<?php
namespace App\Models;
use App\Core\SQL;

class Project_Tags extends SQL
{
    protected ?int $id = null;
    protected int $project_id;
    protected int $tag_id;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getProjectId(): int
    {
        return $this->project_id;
    }

    public function setProjectId(int $project_id): void
    {
        $this->project_id = $project_id;
    }

    public function getTagId(): int
    {
        return $this->tag_id;
    }

    public function setTagId(int $tag_id): void
    {
        $this->tag_id = $tag_id;
    }
}