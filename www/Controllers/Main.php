<?php
namespace App\Controllers;
use App\Core\View;
use App\Models\User;
use App\Models\Page;
use App\Models\Media;
use App\Models\Comment;
class Main
{
    public function home()
    {
        //Appeler un template Front et la vue Main/Home
        $view = new View("Main/home", "front");
        //$view->setView("Main/Home");
        //$view->setTemplate("Front");
        $view->render();
    }

    public function dashboard()
    {
        $user = new User();
        $post = new Page();
        $media = new Media();

        $elementsCount = [
            'users' => $user->getNbElements(),
            // 'pages' => $post->getElementsByType('type', 'page'),
            'medias' => $media->getNbElements(),
            // 'projects' => $post->getElementsByType('type', 'project'),
        ];

        if(isset($_SESSION['user'])) {
            $userSerialized = $_SESSION['user'];
            $user = unserialize($userSerialized);
            $lastname = $user->getLastname();
            $firstname = $user->getFirstname();
            // $roles = $user->getRole();

        }
        $view = new View("Main/dashboard", "back");
        $view->assign("elementsCount", $elementsCount);
        $view->assign("lastname", $lastname);
        $view->assign("firstname", $firstname);
        // $view->assign("roles", $roles);
        $view->render();
    }

}