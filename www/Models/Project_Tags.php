<?php

namespace App\Models;

use App\Core\SQL;

class Project_Tags extends SQL
{
    protected ?int $id = null;
    protected $project_id;
    protected $tag_id;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getProjectId()
    {
        return $this->project_id;
    }

    public function setProjectId($project_id): void
    {
        $this->project_id = $project_id;
    }

    public function getTagId()
    {
        return $this->tag_id;
    }

    public function setTagId($tag_id): void
    {
        $this->tag_id = $tag_id;
    }
}
