<?php
namespace App\Core;

class Security
{
    public function isLogged(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user']) && !empty($_SESSION['user']);
    }
}