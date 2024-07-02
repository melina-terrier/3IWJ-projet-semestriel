<?php
namespace App\Core;
use App\Models\Role;
use App\Models\User;

class SecurityCore
{
    public function isLogged(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }

    public function checkRoute($route): bool
    {
        if (isset($route['Role'])){
            $securityRole = $route['Role'];
            $userModel = new User();
            $user = $userModel->getOneBy(['id'=>$_SESSION['user_id']], 'object');
            if ($user) {
                $roleUser = $user->getRole();
                $role = new Role();
                $roleDetails = $role->getOneBy(['id'=>$roleUser]);
                if (in_array($roleDetails['role'], $securityRole)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    public function checkAuth($route): bool
    {
        if (isset($route['Security']) && $route['Security'] === true) {
            if (!isset($_SESSION['user_id'])) {
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }
}