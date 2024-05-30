<?php

namespace App\Controllers;

class Error
{
    public function __construct(){
        define('BASE_DIR', __DIR__ . '/..'); 
    }

    public function page404(): void
    {
        include(BASE_DIR . "/Views/Error/error.php");
    }

}