<?php
namespace App\Models;
use App\Core\SQL;

class Project extends SQL
{
    private ?int $id_project = null;
    protected string $title;
    protected string $content;
    protected \DateTime $date_to_create;

    /**
     * @return int|null
     */
    public function getId_project(): ?int
    {
        return $this->id_project;
    }

    /**
     * @param int|null $id_project
     */
    public function setId_project(?int $id_project): void
    {
        $this->id_project = $id_project;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->getId_project();
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = ucwords(strtolower(trim($title)));
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = strtoupper(trim($content));
    }

    /**
     * @return \DateTime
     */
    public function getDate_to_create(): \DateTime
    {
        return $this->date_to_create;
    }

    /**
     * @param \DateTime|string $date_to_create
     * @throws \Exception
     */
    public function setDate_to_create($date_to_create): void
    {
        if (is_string($date_to_create)) {
            $date_to_create = new \DateTime($date_to_create);
        }
        $this->date_to_create = $date_to_create;
    }
}
