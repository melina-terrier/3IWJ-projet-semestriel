<?php
namespace App\Models;
use App\Core\SQL;

class Formation extends SQL
{
    protected ?int $id = null;
    protected $title;
    protected $start_date;
    protected $end_date;
    protected $mention;
    protected $domain;
    protected $establishment;
    protected $description;
    protected $user_id;
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

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function getStartDate()
    {
        return $this->start_date;
    }

    public function setStartDate($start_date): void
    {
        $this->start_date = $start_date;
    }

    public function getEndDate()
    {
        return $this->end_date;
    }

    public function setEndDate($end_date): void
    {
        $this->end_date = $end_date;
    }

    public function getMention()
    {
        return $this->mention;
    }

    public function setMention($mention): void
    {
        $this->mention = $mention;
    }

    public function getDomain()
    {
        return $this->domain;
    }

    public function setDomain($domain): void
    {
        $this->domain = $domain;
    }

    public function getEstablishment()
    {
        return $this->establishment;
    }

    public function setEstablishment($establishment): void
    {
        $this->establishment = $establishment;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description): void
    {
        $this->description = $description;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
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