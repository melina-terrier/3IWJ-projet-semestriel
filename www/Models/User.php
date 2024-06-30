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
    protected INT $id_role;
    protected $slug;
    protected int $status;
    protected ?string $reset_token = null;
    protected ?string $reset_expires = null;
    protected ?string $activation_token = null;
    protected ?string $photo = null;
    protected $occupation;
    protected $birthday;
    protected $country;
    protected $city;
    protected $website;
    protected $link;
    protected $description;
    protected $experience;
    protected $study;
    protected $competence;
    protected $interest;
    protected $creation_date;
    protected $modification_date;

    public function getUserName()
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

    public function setRole($id_role): void
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

    public function setSlug()
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

    public function getSlug()
    {
        return $this->slug;
    }

    public function getOccupation(): string
    {
        return $this->occupation;
    }

    public function setOccupation(?string $occupation): void
    {
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
        $this->city = $city;
    }

    public function getWebsite(): string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): void
    {
        $this->website = $website;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function setLink(?string $link): void
    {
        $this->link = $link;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getExperience(): string
    {
        return $this->experience;
    }

    public function setExperience(?string $experience): void
    {
        $this->experience = $experience;
    }

    public function getStudy(): string
    {
        return $this->study;
    }

    public function setStudy(?string $study): void
    {
        $this->study = $study;
    }

    public function getCompetence(): string
    {
        return $this->competence;
    }

    public function setCompetence(?string $competence): void
    {
        $this->competence = $competence;
    }

    public function getInterest(): string
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

    public function getNbElements() {
        return $this->countElements();
    }

    public function __sleep() {
        return array_diff(array_keys(get_object_vars($this)), array('pdo'));
    }

   
}
