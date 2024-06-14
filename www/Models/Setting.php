<?php
namespace App\Models;
use App\Core\SQL;

class Setting extends SQL{

    protected ?int $id = null;
    protected $icon;
    protected $title;
    protected $slogan;
    protected $logo;
    protected $timezone;
    protected $homepage;
    protected $primary_color;
    protected $secondary_color;
    protected $accent_color;
    protected $primary_font;
    protected $secundary_font;
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

    public function getIcon()
    {
        return $this->icon;
    }

    public function setIcon($icon): void
    {
        $this->icon = $icon;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function getLogo()
    {
        return $this->logo;
    }

    public function setLogo($logo): void
    {
        $this->logo = $logo;
    }
    public function getSlogan()
    {
        return $this->slogan;
    }

    public function setSlogan($slogan): void
    {
        $this->slogan = $slogan;
    }

    public function getTimezone()
    {
        return $this->timezone;
    }

    public function setTimezone($timezone): void
    {
        $this->timezone = $timezone;
    }

    public function getHomepage()
    {
        return $this->homepage;
    }

    public function setHomepage($homepage): void
    {
        $this->homepage = $homepage;
    }

    public function getPrimaryColor()
    {
        return $this->primary_color;
    }

    public function setPrimaryColor($primary_color): void
    {
        $this->primary_color = $primary_color;
    }

    public function getSecondaryColor()
    {
        return $this->secondary_color;
    }

    public function setSecondaryColor($secondary_color): void
    {
        $this->secondary_color = $secondary_color;
    }

    public function getAccentColor()
    {
        return $this->accent_color;
    }

    public function setAccentColor($accent_color): void
    {
        $this->accent_color = $accent_color;
    }

    public function getPrimaryFont()
    {
        return $this->primary_font;
    }

    public function setPrimaryFont($primary_font): void
    {
        $this->primary_font = $primary_font;
    }

    public function getSecundaryFont()
    {
        return $this->secundary_font;
    }

    public function setSecundaryFont($secundary_font): void
    {
        $this->secundary_font = $secundary_font;
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
}

