<?php
namespace App\Models;
use App\Core\SQL;

class Comment extends SQL
{

    protected ?int $id = null;
    protected $comment;
    protected $user_id;
    protected $mail;
    protected $name;
    protected int $is_reported;
    protected int $project_id;
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

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment): void
    {
        $this->comment = $comment;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function setMail($mail): void
    {
        $this->mail = $mail;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getReport()
    {
        return $this->is_reported;
    }

    public function setReport($is_reported): void
    {
        $this->is_reported = $is_reported;
    }

     public function getProject()
    {
        return $this->project_id;
    }

    public function setProject($project_id): void
    {
        $this->project_id = $project_id;
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