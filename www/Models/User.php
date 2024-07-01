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
    protected string $slug;
    protected int $status;
    protected ?string $reset_token = null;
    protected ?string $reset_expires = null;
    protected ?string $activation_token = null;
    protected ?string $photo = null;
    protected ?string $occupation;
    protected ?string $birthday = '';
    protected ?string $country;
    protected ?string $city;
    protected ?string $website;
    protected ?string $link;
    protected ?string $description;
    protected ?string $experience;
    protected ?string $formation;
    protected ?string $skill;
    protected ?string $interest;
    protected string $creation_date;
    protected string $modification_date;

    public function getUserName(): string
    {
        return $this->getFirstname()." ".$this->getLastname();
    }

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
        $firstname = ucwords(strtolower(trim($firstname)));
        $this->firstname = $firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): void
    {
        $lastname = strtoupper(trim($lastname));
        $this->lastname = $lastname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $email = strtolower(trim($email));
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $this->password = $password;
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
    public function getResetToken(): string
    {
        return $this->reset_token;
    }

    public function setResetToken(?string $reset_token): void
    {
        $this->reset_token = $reset_token;
    }

    public function getResetExpires(): string
    {
        return $this->reset_expires;
    }

    public function setResetExpires(?string $reset_expires): void {
        $this->reset_expires = $reset_expires;
    }

    public function getActivationToken(): string
    {
        return $this->activation_token;
    }

    public function setActivationToken(?string $activationtoken): void
    {
        $this->activation_token = $activationtoken;
    }
    
    public function getPhoto(): string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): void
    {
        $this->photo = $photo;
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

    public function setSlug(string $slug)
    {
        $fullName = $this->getUserName();
        $slug = strtolower($fullName);
        $slug = trim($slug);
        $slug = str_replace(' ', '-', $slug);
        $search  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
        $replace = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');
        $slug = str_replace($search, $replace, $slug);
        $allowedChars = 'abcdefghijklmnopqrstuvwxyz09-';
        $slug = preg_replace('/[^' . $allowedChars . ']/', '', $slug);
        $randomDigits = rand(1000, 9999);
        $slug .= '-' . $randomDigits;
        $this->slug = $slug;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getOccupation(): string
    {
        return $this->occupation;
    }

    public function setOccupation(?string $occupation): void
    {
        $occupation = strip_tags(ucwords(trim(strtolower($occupation))));
        $this->occupation = $occupation;
    }

    public function getBirthday(): string
    {
        return $this->birthday;
    }

    public function setBirthday(?string $birthday): void
    {
        $this->birthday = $birthday;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(?string $country): void
    {
        $this->country = $country;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(?string $city): void
    {
        $city = strip_tags(ucwords(trim(strtolower($city))));
        $this->city = $city;
    }

    public function getWebsite(): string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): void
    {
        $website = strip_tags(strtolower(trim($website)));
        $this->website = $website;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): void
    {
        $link = strip_tags(strtolower(trim($link)));
        $this->link = $link;
    }


    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $description = strip_tags(trim($description));
        $this->description = $description;
    }

    public function getExperience(): ?string
    {
        return $this->experience;
    }

    public function setExperience(?string $experience): void
    {
        $experience = strip_tags(strtolower(trim($experience)));
        $this->experience = $experience;
    }

    public function getFormation(): ?string
    {
        return $this->formation;
    }

    public function setFormation(?string $formation): void
    {
        $formation = strip_tags(strtolower(trim($study)));
        $this->formation = $formation;
    }

    public function getSkill(): ?string
    {
        return $this->skill;
    }

    public function setSkill(?string $skill): void
    {
        $skill = strip_tags(strtolower(trim($skill)));
        $this->skill = $skill;
    }

    public function getInterest(): string
    {
        return $this->interest;
    }

    public function setInterest(?string $interest): void
    {
        $interest = strip_tags(trim($interest));
        $this->interest = $interest;
    }

    public function getNbElements() {
        return $this->countElements();
    }
  
}
