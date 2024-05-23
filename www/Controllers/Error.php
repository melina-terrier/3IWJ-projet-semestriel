<?php

namespace App\Controller;
use App\Core\View;

class Error
{
    public function page404(): void
    {
        $myView = new View("Error/page404");
    }

    public function page403(): void
    {
        $myView = new View("Error/page403");
    }


}