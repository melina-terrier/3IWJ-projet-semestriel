<?php

namespace App;
session_start();

//Notre Autoloader
spl_autoload_register("App\myAutoloader");

function myAutoloader($class){
    $classExploded = explode("\\", $class);
    $class = end($classExploded);
    //echo "L'autoloader se lance pour ".$class;
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

//http://localhost/login
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
    $object = new Controllers\Error();
    $object->page404();
}

if(empty($listOfRoutes[$uri]["Controller"]) || empty($listOfRoutes[$uri]["Action"]) ) {
    header("Internal Server Error", true, 500);
    die("Le fichier routes.yml ne contient pas de controller ou d'action pour l'uri :".$uri);
}

$controller = $listOfRoutes[$uri]["Controller"];
$action = $listOfRoutes[$uri]["Action"];
$security = $listOfRoutes[$uri]["Security"];
$role = $listOfRoutes[$uri]["Role"];
$auth = new Core\Security();


print_r($auth);
print_r($security);
print_r($role);

print_r($_SESSION);
$user_mail = ($_SESSION["email"]);

if ($security && $auth) {
    if ($userStatus !== $role) {
        header("Location: /");
        exit(); // Assure que le script se termine ici pour éviter toute exécution supplémentaire
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






