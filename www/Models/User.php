<?php
namespace App\Models;

use App\Core\SQL;

class User extends SQL
{
    protected ?int $id = null;
    protected string $firstname;
    protected string $lastname;
    protected string $email;
    protected ?string $password = null;
    protected int $id_role;
    protected ?string $slug = null;
    protected int $status;
    protected ?string $reset_token = null;
    protected ?string $reset_expires = null;
    protected ?string $activation_token = null;
    protected ?string $photo = null;
    protected ?string $occupation = null;
    protected ?string $birthday = null;
    protected ?string $country = null;
    protected ?string $city = null;
    protected ?string $website = null;
    protected ?string $link = null;
    protected ?string $description = null;
    protected ?string $experience = null;
    protected ?string $study = null;
    protected ?string $competence = null;
    protected ?string $interest = null;
    protected ?string $creation_date = null;
    protected ?string $modification_date = null;

    public function getUserName(): string
    {
        return $this->getFirstname() . " " . $this->getLastname();
    }

    // Getter et Setter pour les propriétés
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = ucwords(strtolower(trim($firstname)));
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = strtoupper(trim($lastname));
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = strtolower(trim($email));
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        if ($password) {
            $this->password = password_hash($password, PASSWORD_DEFAULT);
        }
    }

    public function getRole(): int
    {
        return $this->id_role;
    }

    public function setRole(int $id_role): void
    {
        $this->id_role = $id_role;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function getResetToken(): ?string
    {
        return $this->reset_token;
    }

    public function setResetToken(?string $reset_token): void
    {
        $this->reset_token = $reset_token;
    }

    public function getResetExpires(): ?string
    {
        return $this->reset_expires;
    }

    public function setResetExpires(?string $reset_expires): void
    {
        $this->reset_expires = $reset_expires;
    }

    public function getActivationToken(): ?string
    {
        return $this->activation_token;
    }

    public function setActivationToken(?string $activation_token): void
    {
        $this->activation_token = $activation_token;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): void
    {
        $this->photo = $photo;
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

    public function setSlug(): void
    {
        $fullName = $this->getUserName();
        $slug = strtolower(trim($fullName));
        $slug = str_replace(' ', '-', $slug);
        $search = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
        $replace = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');
        $slug = str_replace($search, $replace, $slug);
        $slug = preg_replace('/[^a-z0-9-]/', '', $slug);
        $slug .= '-' . rand(1000, 9999);
        $this->slug = $slug;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function getOccupation(): ?string
    {
        return $this->occupation;
    }

    public function setOccupation(?string $occupation): void
    {
        $this->occupation = $occupation;
    }

    public function getBirthday(): ?string
    {
        return $this->birthday;
    }

    public function setBirthday(?string $birthday): void
    {
        $this->birthday = $birthday;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): void
    {
        $this->country = $country;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): void
    {
        $this->website = $website;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): void
    {
        $this->link = $link;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getExperience(): ?string
    {
        return $this->experience;
    }

    public function setExperience(?string $experience): void
    {
        $this->experience = $experience;
    }

    public function getStudy(): ?string
    {
        return $this->study;
    }

    public function setStudy(?string $study): void
    {
        $this->study = $study;
    }

    public function getCompetence(): ?string
    {
        return $this->competence;
    }

    public function setCompetence(?string $competence): void
    {
        $this->competence = $competence;
    }

    public function getInterest(): ?string
    {
        return $this->interest;
    }

    public function setInterest(?string $interest): void
    {
        $this->interest = $interest;
    }

    public function getUsers()
    {
        return $this->getAllData();
    }

    public function getNbElements()
    {
        return $this->countElements();
    }

    public function __sleep()
    {
        return array_diff(array_keys(get_object_vars($this)), array('pdo'));
    }
}
