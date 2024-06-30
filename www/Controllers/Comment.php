<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\Form;
use App\Models\User;
use App\Models\Project as ProjectModel;
use App\Models\Comment as CommentModel;
use App\Forms\AddComment;

class Comment
{
    public function allComments(): void
    {
        $comment = new CommentModel();
        $comments = $comment->getAllData();
        $successes = [];
        $errors = [];
    
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
    
        $projects = [];
        foreach ($comments as &$comment) {
            $projectId = $comment['project_id'];
            $projectModel = new ProjectModel();
            $project = $projectModel->getOneBy(['id' => $projectId], 'object');
            $comment['project'] = $project->getTitle();
            $projects[$projectId] = $project->getTitle();
        }
    
        $view = new View("Comment/comments-list", "back");
        $view->assign("comments", $comments);
        $view->assign("projects", $projects);
        $view->assign("errors", $errors);
        $view->assign("successes", $successes);
        $view->render();
    }
    

    public function addComment(): void
    {
        $form = AddComment::getConfig();
        $errorsForm = [];
        $successForm = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validation du formulaire
            $commentText = $_POST['comment'] ?? '';
            $email = $_POST['email'] ?? null;
            $name = $_POST['name'] ?? null;

            if (strlen($commentText) < 2 || strlen($commentText) > 4000) {
                $errorsForm['comment'] = "Votre commentaire doit faire entre 2 et 4000 caractères";
            }
            if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errorsForm['email'] = "Le format de l'email est incorrect";
            }
            if ($name && (strlen($name) < 4 || strlen($name) > 100)) {
                $errorsForm['name'] = "Le nom et le prénom doivent faire entre 4 et 100 caractères";
            }

            if (empty($errorsForm)) {
                // Ajouter le commentaire à la base de données
                $commentModel = new CommentModel();
                $commentModel->addComment([
                    'comment' => $commentText,
                    'email' => $email,
                    'name' => $name
                ]);

                $successForm[] = "Votre commentaire a été publié avec succès.";
            }
        }

        // Afficher le formulaire avec les messages d'erreur et de succès
        $view = new View('Comment/add-comment', 'back');
        $view->assign("form", $form);
        $view->assign("errorsForm", $errorsForm);
        $view->assign("successForm", $successForm);
        $view->render();
    }
}
