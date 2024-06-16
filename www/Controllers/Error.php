<?php

namespace App\Controllers;
use App\Core\View;

class Error
{
    public function page404(): void
    {
        $view = new View("Error/page404", "front");
        $view->render();
    }

    public function page403(): void
    {
        $view = new View("Error/page403", "front");
        $view->render();
    }


}