<?php
namespace App\Models;
use App\Core\SQL;

class TagProject extends SQL
{
    protected ?int $id = null;
    protected $project_id;
    protected $tag_id;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getProject()
    {
        return $this->project_id;
    }

    public function setProject($project_id): void
    {
        $this->project_id = $project_id;
    }

    public function getTag()
    {
        return $this->tag_id;
    }

    public function setTag($tag_id): void
    {
        $this->tag_id = $tag_id;
    }
}
