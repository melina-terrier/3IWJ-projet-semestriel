<?php
namespace App\Models;
use App\Core\SQL;

class Tag extends SQL
{
    protected ?int $id = null;
    protected string $name;
    protected string $slug;
    protected string $description;
    protected ?string $creation_date = null;
    protected string $modification_date ;
    protected int $user_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
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

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $slug = strtolower($slug);
        $slug = trim($slug);
        $slug = str_replace(' ', '-', $slug);
        $search  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
        $replace = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');
        $slug = str_replace($search, $replace, $slug);
        $allowedChars = 'abcdefghijklmnopqrstuvwxyz09-';
        $slug = preg_replace('/[^' . $allowedChars . ']/', '', $slug);
        $this->slug = $slug;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $description = strip_tags(trim($description));
        $this->description = $description;
    }

    public function getCreationDate(): ?string
    {
        return $this->creation_date;
    }

    public function setCreationDate(?string $creation_date): void
    {
        $this->creation_date = $creation_date;
    }

    public function getModificationDate(): ?string
    {
        return $this->modification_date;
    }

    public function setModificationDate(?string $modification_date): void
    {
        $this->modification_date = $modification_date;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(?int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getNbElements() {
        return $this->countElements();
    }

<<<<<<< HEAD
}
=======
    public function getElementsByType($column, $value) {
        return $this->countElements($column, $value);
    }

}
>>>>>>> dev
