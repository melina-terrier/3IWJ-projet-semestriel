<?php
namespace App\Controllers;

class displayResult{

    public function displayResult()
    {
        $view = new View("Main/search", "front");
        $view->render();
    }

}