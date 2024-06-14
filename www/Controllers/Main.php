<?php
namespace App\Controllers;

use App\Core\SQL;
use App\Models\StatUser;
use App\Core\View;
use App\Models\User;
use App\Models\Page;
use App\Models\Media;
use App\Models\Comment;
use App\Models\Project;
use App\Models\Tag;
use App\Models\Setting;
use App\Models\Status;

class Main
{
    private $statUser;

    public function __construct() {
        $this->statUser = new StatUser();
    }

    public function home() {
        $view = new View("Main/page", "front");
        $setting = new Setting();
        $settingId = $setting->getOneBy(['id' => 1], 'object');
        if ($settingId){
            $homepageId = $settingId->getHomepage();
            $page = new Page();
            $homepage = $page->getOneBy(['id' => $homepageId]);
            if (!empty($homepage)) {
                $title = $homepage["title"];
                $content = $homepage["content"];
            } 
            $view->assign("content", $content);
            $view->assign("title", $title);
        } else {
            $project = new Project();
            $statusModel = new Status();
            $userModel = new User();
            $status = $statusModel->getOneBy(["status" => "published"], 'object');
            $publishedStatusId = $status->getId();
            $projects = $project->getAllDataWithWhere(['status_id' => $publishedStatusId]);
            foreach ($projects as &$project) {
                $userId = $project['user_id'];
                $project['username'] ='';
                $project['userSlug'] ='';
                if ($userId) {
                    $user = $userModel->getOneBy(['id' => $userId], 'object');
                    if ($user) {
                        $project['username'] = $user->getUserName();
                        $project['userSlug'] = $user->getSlug();
                  }
                }
              }
            $view->assign("projects", $projects);
        }
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
        $tag = new Tag();

        $elementsCount = [
            'users' => $user->getNbElements(),
            'pages' => $page->getNbElements(),
            'medias' => $media->getNbElements(),
            'projects' => $project->getNbElements(),
            'comments' => $comment->getNbElements(),
            'tags'=>$tag->getNbElements(),
        ];

        $comments = $comment->getAllData();

        if (!isset($_SESSION['nombre_visiteurs_non_inscrits'])) {
            $_SESSION['nombre_visiteurs_non_inscrits'] = 0;
        }

        if (!isset($_COOKIE['visiteur_unique'])) {
            $_SESSION['nombre_visiteurs_non_inscrits'] += 1;
            $cookie_value = uniqid();
            setcookie('visiteur_unique', $cookie_value, time() + 3600 * 24 * 30, "/");
            $_COOKIE['visiteur_unique'] = $cookie_value; // Pour assurer que $_COOKIE contient la valeur actuelle
        }

        $nombre_visiteurs_non_inscrits = $_SESSION['nombre_visiteurs_non_inscrits'];

        $sql = new SQL();
        $usersProjects = $sql->sql_users_projects();

        $labels = [];
        $data = [];
        foreach ($usersProjects as $userProject) {
            $labels[] = $userProject['firstname'] . ' ' . $userProject['lastname'];
            $data[] = (int)$userProject['project_count'];
        }

        $view = new View("Main/dashboard", "back");
        $view->assign("labels", $labels);
        $view->assign("data", $data);
        $view->assign("comments", $comments);
        $view->assign("elementsCount", $elementsCount);
        $view->assign("nombreVisiteursNonInscrits", $nombre_visiteurs_non_inscrits);
        $view->render();
    }
}
?>
