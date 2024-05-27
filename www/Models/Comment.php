<?php

namespace App\Models;

use App\Core\SQL;

class Comment extends SQL
{
    private ?int $id = null; // Ajoutez cette propriété
    private ?int $id_content = null;
    protected string $Title;
    protected string $content;
    protected \DateTime $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getid_content(): ?int
    {
        return $this->id_content;
    }

    public function setid_content(?int $id_content): void
    {
        $this->id_content = $id_content;
    }

    public function getTitle(): string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): void
    {
        $this->Title = $Title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime|string $date
     * @throws \Exception
     */
    public function setDate($date): void
    {
        if (is_string($date)) {
            $date = new \DateTime($date);
        }
        $this->date = $date;
    }
}
