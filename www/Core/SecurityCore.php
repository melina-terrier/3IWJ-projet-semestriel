<?php
namespace App\Core;
use App\Models\Role;
class SecurityCore
{
    public function isLogged(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user']) && !empty($_SESSION['user']);
    }

    public function checkRoute($route): bool
    {
        if (isset($route['Role'])){
            $securityRole = $route['Role'];
            $user = unserialize($_SESSION['user']);
            $roleUser = $user->getRole();
            $role = new Role();
            $roleDetails = $role->getOneBy(['id'=>$roleUser]);
            if (in_array($roleDetails['role'], $securityRole)) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    public function checkAuth($route): bool
    {
        session_start();
        if (isset($route['Security']) && $route['Security'] === true) {
            if (!isset($_SESSION['user'])) {
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }
}