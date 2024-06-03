<?php

namespace App;

use App\Controllers\Error;
use App\Controllers\Main;
use App\Controllers\Security;
use App\Models\User;

use App\Controllers\Page;
use App\Controllers\Project;

date_default_timezone_set('Europe/Paris');

//Autoloader
spl_autoload_register("App\myAutoloader");

function myAutoloader($class){
    $classExploded = explode("\\", $class);
    $class = end($classExploded);

    if(file_exists("../Core/".$class.".php")){
        include_once "../Core/".$class.".php";
    }
    if(file_exists("../Models/".$class.".php")){
        include_once "../Models/".$class.".php";
    }
    if(file_exists("../Controllers/".$class.".php")){
        include_once "../Controllers/".$class.".php";
    }
    if(file_exists("../Forms/".$class.".php")){
        include_once "../Forms/".$class.".php";
    }
    if(file_exists("../vendor/phpmailer/phpmailer/src/".$class.".php")){
        include_once "../vendor/phpmailer/phpmailer/src/".$class.".php";
    }
}




// if (!file_exists('./config.php')) {
//     $controller = new App\Controller\Install();
//     $controller->run();
//     die();
// }



$uri = $_SERVER["REQUEST_URI"];
if(strlen($uri) > 1)
    $uri = rtrim($uri, "/");
$uriExploded = explode("?",$uri);
$uri = $uriExploded[0];


if(file_exists("../Routes.yml")) {
    $listOfRoutes = yaml_parse_file("../Routes.yml");
}else{
    header("Internal Server Error", true, 500);
    die("Le fichier de routing ../Routes.yml n'existe pas");
}


if( !empty($listOfRoutes[$uri]) ) {

    if (isset($listOfRoutes[$uri]['Security']) && $listOfRoutes[$uri]['Security'] === true) {
        session_start();
        if (!isset($_SESSION['user'])) {
            $error = new Error();
            $error->page403();
            die();
        }
    }

    if (!empty($listOfRoutes[$uri]['Role'])) {
        $user = unserialize($_SESSION['user']);

        if (!in_array($user->getRoles(), $listOfRoutes[$uri]['Role'])) {
            $error = new Error();
            $error->page403();
            die();
        }
    }

    if (!empty($listOfRoutes[$uri]['Controller']) && !empty($listOfRoutes[$uri]['Action'])) {
        $controller = $listOfRoutes[$uri]['Controller'];
        $action = $listOfRoutes[$uri]['Action'];
        if (file_exists("../Controllers/" . $controller . ".php")) {
            include "../Controllers/".$controller.".php";
            $controller = "App\\Controllers\\".$controller;
            if (class_exists($controller)) { 
                $objetController = new $controller();
                if (method_exists($controller, $action)) {
                    $objetController->$action();
                } else {
                    die("La méthode ".$action." n'existe pas dans le controller ".$controller);
                }
            } else {
                die("La class controller ".$controller." n'existe pas");
            }
        } else {
            die("Le fichier controller ../Controllers/".$controller.".php n'existe pas");
        }
    } else {
        header("Internal Server Error", true, 500);
    die("Le fichier routes.yml ne contient pas de controller ou d'action pour l'uri :".$uri);
    }
}
else if($uri){
    session_start();
    if (strpos($uri, 'projects') !== false) {
        $projectBuilder = new Project();
        $projectBuilder->showProject($uri);
    } else {
        $pageBuilder = new Page();
        $pageBuilder->showPage($uri);
    }
}
else{
    header("Status 404 Not Found", true, 404);
    $error = new Error();
    $error->page404();
}
