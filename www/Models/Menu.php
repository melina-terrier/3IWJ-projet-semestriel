<?php
namespace App\Models;

use App\Core\SQL;

class Menu extends SQL
{

    protected ?int $id = null;
    protected $place;
    protected $page;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getPlace()
    {
        return $this->place;
    }

    public function setPlace($place): void
    {
        $this->place = $place;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function setPage($page): void
    {
        $this->page = $page;
    }

    
    

    public function getNbElements() {
        return $this->countElements();
    }

}