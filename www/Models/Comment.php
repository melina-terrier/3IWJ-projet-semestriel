<?php
namespace App\Models;
use App\Core\SQL;

class Comment extends SQL
{
    protected ?int $id = null;
    protected string $comment;
    protected ?int $user_id = null;
    protected string $mail;
    protected string $name;
    protected int $status;
    protected int $project_id;
    protected $creation_date;
    protected $modification_date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment($comment): void
    {
        $comment = strip_tags(trim($comment));
        $this->comment = $comment;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getMail(): string
    {
        return $this->mail;
    }

    public function setMail(string $mail): void
    {
        $this->mail = $mail;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $name = strip_tags(ucwords(strtolower(trim($name))));
        $this->name = $name;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

     public function getProject(): int
    {
        return $this->project_id;
    }

    public function setProject(int $project_id): void
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

}