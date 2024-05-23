<?php

namespace App;

//Autoloader
spl_autoload_register("App\myAutoloader");

function myAutoloader($class){
    $classExploded = explode("\\", $class);
    $class = end($classExploded);

    if(file_exists("../Core/".$class.".php")){
        include "../Core/".$class.".php";
    }
    if(file_exists("../Models/".$class.".php")){
        include "../Models/".$class.".php";
    }
    if(file_exists("../Controllers/".$class.".php")){
        include "../Controllers/".$class.".php";
    }
}

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

if(empty($listOfRoutes[$uri])) {
    header("Status 404 Not Found", true, 404);
    $object = new Controller\Error();
    $object->page404();
}

if(empty($listOfRoutes[$uri]["Controller"]) || empty($listOfRoutes[$uri]["Action"]) ) {
    header("Internal Server Error", true, 500);
    die("Le fichier routes.yml ne contient pas de controller ou d'action pour l'uri :".$uri);
}

$controller = $listOfRoutes[$uri]["Controller"];
$action = $listOfRoutes[$uri]["Action"];

if (isset($listOfRoutes[$uri]['Security']) && $listOfRoutes[$uri]['Security'] === true) {
    session_start();
    if (!isset($_SESSION['user'])) { 
        $error = new Controller\Error();
        $error->page403();
        die();
    }
}

if (!empty($listOfRoutes[$uri]['Role'])) {
    $user = unserialize($_SESSION['user']); 

    if (!in_array($user->getRoles(), $listOfRoutes[$uri]['Role'])) {
        $error = new Controller\Error();
        $error->page403();
        die();
    }
}

//include "../Controllers/".$controller.".php";
if(!file_exists("../Controllers/".$controller.".php")){
    die("Le fichier controller ../Controllers/".$controller.".php n'existe pas");
}
include "../Controllers/".$controller.".php";

$controller = "App\\Controller\\".$controller;

if( !class_exists($controller) ){
    die("La class controller ".$controller." n'existe pas");
}
$objetController = new $controller();

if( !method_exists($controller, $action) ){
    die("Le methode ".$action." n'existe pas dans le controller ".$controller);
}
$objetController->$action();






