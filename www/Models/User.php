<?php
namespace App\Models;
use App\Core\SQL;

class User extends SQL
{
    protected ?int $id = null;
    protected string $firstname;
    protected string $lastname;
    protected string $email;
    
    protected string $password;
    // protected ?string $id_role = '1';
    protected int $status;
    protected ?string $reset_token = null;
    protected ?string $reset_expires = null;
    protected ?string $activation_token = null;
    protected ?string $photo = null;
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

    // public function getRole(): int
    // {
    //     return $this->id_role;
    // }

    // public function setRole($id_role): void
    // {
    //     $this->id_role = $id_role;
    // }

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
