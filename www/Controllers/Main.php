<?php
namespace App\Controllers;
use App\Core\View;
use App\Models\User;
use App\Models\Page;
use App\Models\Media;
use App\Models\Comment;
use App\Models\Project;
use App\Models\Tag;
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

        $view = new View("Main/dashboard", "back");
        $view->assign("elementsCount", $elementsCount);
        $view->assign("comments", $comments);
        $view->render();
    }

}