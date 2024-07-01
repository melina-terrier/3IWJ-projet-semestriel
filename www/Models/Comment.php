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
    protected string $creation_date;
    protected string $modification_date;

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
        $email = strip_tags(strtolower(trim($email)));
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
        return $this->is_reported;
    }

    public function setStatus(int $status): void
    {
        $this->is_reported = $is_reported;
    }

     public function getProject(): int
    {
        return $this->project_id;
    }

    public function setProject(int $project_id): void
    {
        $this->project_id = $project_id;
    }

    public function getCreationDate(): string
    {
        return $this->creation_date;
    }

    public function setCreationDate(string $creation_date): void
    {
        $this->creation_date = $creation_date;
    }

    public function getModificationDate(): string
    {
        return $this->modification_date;
    }

    public function setModificationDate(string $modification_date): void
    {
        $this->modification_date = $modification_date;
    }
    
    public function getNbElements() {
        return $this->countElements();
    }

}