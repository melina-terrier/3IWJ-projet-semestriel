<?php
namespace App\Models;
use App\Core\SQL;

class Comment extends SQL
{

    protected ?int $id = null;
    protected $comment;
    // protected $user_name;
    // protected $project_id;
    protected $status;
    protected $isReported = 0;
    protected $creation_date;
    protected $modification_date;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    // public function getUserName()
    // {
    //     return $this->user_name;
    // }

    // public function setUserName($user_name): void
    // {
    //     $this->user_name = $user_name;
    // }

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment): void
    {
        $this->comment = $comment;
    }

    // public function getProjectId()
    // {
    //     return $this->project_id;
    // }

    // public function setProjectId($project_id): void
    // {
    //     $this->project_id = $project_id;
    // }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status): void
    {
        $this->status = $status;
    }

    public function getIsReported()
    {
        return $this->isReported;
    }

    public function setIsReported($isReported): void
    {
        $this->isReported = $isReported;
    }

    public function getCreationDate()
    {
        return $this->creation_date;
    }

    public function setCreationDate($creation_date): void
    {
        $this->creation_date = $creation_date;
    }

    public function getModificationDate()
    {
        return $this->modification_date;
    }

    public function setModificationDate($modification_date): void
    {
        $this->modification_date = $modification_date;
    }
    
    public function getNbElements() {
        return $this->countElements();
    }

    public function getElementsByType($column, $value) {
        return $this->countElements($column, $value);
    }

}
>>>>>>> 439b247 (Mise en place du CRUD)
