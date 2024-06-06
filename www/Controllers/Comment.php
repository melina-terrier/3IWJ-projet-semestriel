<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\Form;
use App\Models\User;
use App\Models\Project as ProjectModel;
use App\Models\Comment as  CommentModel;

class Comment{

    public function allComments(): void
    {
        $comment = new CommentModel();
        $comments = $comment->getAllData("object");

        $projects = []; // Initialize as an empty array
        foreach ($comments as $comment) {
            $projectId = $comment->getProject(); // Assuming a method to get project ID
            $projectModel = new ProjectModel();
            $project = $projectModel->getOneBy(['id' => $projectId], 'object');
            $projectName = $project->getTitle();
            $projects[] = ["id" => $projectId, "title" => $projectName];
        }

        if (isset($_GET['action']) && isset($_GET['id'])) {
            if ($_GET['action'] === "delete") {
                $currentComment = $comment->getOneBy(['id' => $_GET['id']], 'object');
                $currentComment->setStatus(-2);
                $currentComment->save();
                header('Location: /dashboard/comments?message=delete-success');
                exit;
            } else if ($_GET['action'] === "approuved") {
                $currentComment = $comment->getOneBy(['id' => $_GET['id']], 'object');
                $currentComment->setStatus(1);
                $currentComment->save();
                header('Location: /dashboard/comments?message=approuved-succes');
                exit;
            } else if ($_GET['action'] === "disapprouved") {
                $currentComment = $comment->getOneBy(['id' => $_GET['id']], 'object');
                $currentComment->setStatus(-1);
                $currentComment->save();
                header('Location: /dashboard/comments?message=disapprouved-success');
                exit;
            } else if ($_GET['action'] === "restore") {
                $currentComment = $comment->getOneBy(['id' => $_GET['id']], 'object');
                $currentComment->setStatus(0);
                $currentComment->save();
                header('Location: /dashboard/comments?message=restore-success');
                exit;
            } else if ($_GET['action'] === "permanent-delete") {
                $comment->delete(['id' => (int)$_GET['id']]);
                header('Location: /dashboard/comments?message=permanent-delete-success');
                exit;
            }
        }
        $view = new View("Comment/comments-list", "back");
        $view->assign("comments", $comments);
        $view->assign("projects", $projects);
        $view->render();
    }
}

