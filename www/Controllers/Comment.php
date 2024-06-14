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
        $comments = $comment->getAllData();
        $successes = [];
        $errors = [];

        if (isset($_GET['action']) && isset($_GET['id'])) {
            if ($_GET['action'] === "delete") {
                $currentComment = $comment->getOneBy(['id' => $_GET['id']], 'object');
                print_r($currentComment);
                $currentComment->setStatus(-2);
                $currentComment->save();
                header('Location: /dashboard/comments?message=delete-success');
                exit;
            } else if ($_GET['action'] === "approuved") {
                $currentComment = $comment->getOneBy(['id' => $_GET['id']], 'object');
                $currentComment->setStatus(1);
                $currentComment->save();
                header('Location: /dashboard/comments?message=approuved-success');
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

        foreach ($comments as &$comment) {
            $comment['project'] = '';
            $projectId = $comment['project_id'];
            $projectModel = new ProjectModel();
            $project = $projectModel->getOneBy(['id' => $projectId], 'object');
            $projectName = $project->getTitle();
            $comment['project'] = $projectName;
        }

        $view = new View("Comment/comments-list", "back");
        $view->assign("comments", $comments);
        $view->assign("errors", $errors);
        $view->assign("successes", $successes);
        $view->render();
    }
}

