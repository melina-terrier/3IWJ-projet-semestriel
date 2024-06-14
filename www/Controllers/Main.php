<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\SQL;
use App\Models\User;
use App\Models\Page;
use App\Models\Media;
use App\Models\StatUser;
use App\Models\Comment;
use App\Models\Project;

class Main
{
    private $statUser;

    public function __construct() {
        $this->statUser = new StatUser();
    }

    public function home() {
        $view = new View("Main/home", "front");
        $view->render();
    }

    public function displayDashboard() {
        return $this->statUser->getAllUserStats();
    }

    public function dashboard() {
       

        $user = new User();
        $page = new Page();
        $media = new Media();
        $project = new Project();
        $comment = new Comment();

        $nombre_utilisateurs_inscrits = $user->getNbElements();
        $elementsCount = [
            'users' => $user->getNbElements(),
            'medias' => $media->getNbElements(),
            'projects' => $project->getNbElements(),
            'comments' => $comment->getNbElements(),
            'pages' => $page->getNbElements(),
        ];

        if (isset($_SESSION['user'])) {
            $userSerialized = $_SESSION['user'];
            $user = unserialize($userSerialized);
            $lastname = $user->getLastname();
            $firstname = $user->getFirstname();
        } else {
            $lastname = '';
            $firstname = '';
        }

        // Initialiser le compteur si nécessaire
        if (!isset($_SESSION['nombre_visiteurs_non_inscrits'])) {
            $_SESSION['nombre_visiteurs_non_inscrits'] = 0;
        }

        // Vérifier si le cookie 'visiteur_unique' n'existe pas
        if (!isset($_COOKIE['visiteur_unique'])) {
            // Incrémenter le compteur de visiteurs non inscrits dans la session
            $_SESSION['nombre_visiteurs_non_inscrits'] += 1;

            // Définir le cookie pour une durée de 30 jours
            $cookie_value = uniqid();
            setcookie('visiteur_unique', $cookie_value, time() + 3600 * 24 * 30, "/");
            $_COOKIE['visiteur_unique'] = $cookie_value; // Pour assurer que $_COOKIE contient la valeur actuelle
        }

        // Récupérer le compteur depuis la session
        $nombre_visiteurs_non_inscrits = $_SESSION['nombre_visiteurs_non_inscrits'];

        // var_dump($_SESSION);
        // var_dump($_COOKIE);
        // var_dump($nombre_visiteurs_non_inscrits);

        $sql = new SQL();
        $usersProjects = $sql->sql_users_projects();

        $labels = [];
        $data = [];
        foreach ($usersProjects as $userProject) {
            $labels[] = $userProject['firstname'] . ' ' . $userProject['lastname'];
            $data[] = (int)$userProject['project_count'];
        }

        // Initialiser l'objet View avant de l'utiliser
        $view = new View("Main/dashboard", "back");

        // Assigner les variables à la vue
        $view->assign("labels", $labels);
        $view->assign("data", $data);
        $view->assign("elementsCount", $elementsCount);
        $view->assign("lastname", $lastname);
        $view->assign("firstname", $firstname);
        $view->assign("nombreUtilisateursInscrits", $nombre_utilisateurs_inscrits);
        $view->assign("nombreVisiteursNonInscrits", $nombre_visiteurs_non_inscrits);

        $view->render();
    }
}
?>
