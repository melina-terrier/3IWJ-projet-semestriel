<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\Form;
use App\Models\User;
use App\Models\Comment as  CommentModel;

class Comment{

    public function addComment(): void
    {
        $form = new Form("AddComment");
        $errors = [];
        $success = [];
        $formattedDate = date('Y-m-d H:i:s');
        if( $form->isSubmitted() && $form->isValid() )
        {
            $comment = new CommentModel();

            $comment->setComment($_POST['comment']);
            $comment->setCreationDate($formattedDate);
            $comment->setModificationDate($formattedDate);
            // $comment->setProject(1);
            $comment->setStatus(0);

            if (isset($_SESSION['user'])) {
                $user = unserialize($_SESSION['user']);
                $userId = $user->getId();
                $userEmail = $user->getEmail();
                $userName = $user->getUserName();
                $comment->setUserId($userId);
                $comment->setMail($userEmail);
                $comment->setName($userName);
                $comment->save();
                $success[] = "Votre commentaire a été publié";
            } else {
                $user = new User();
                if ($user->emailExists($_POST["email"])) {
                    $errors[] = "L'email correspond à un compte, merci de bien vouloir vous connecter";
                } else {
                    $comment->setMail($_POST['email']);
                    $comment->setName($_POST['name']);
                    $comment->save();
                    $success[] = "Votre commentaire a été publié";
                }
            }
        }
        $view = new View("Comment/add-coment", "front");
        $view->assign("form", $form->build());
        $view->assign("errorsForm", $errors);
        $view->assign("successForm", $success);
        $view->render();
    }


    public function allComments(): void
    {
        $comment = new CommentModel();
        $comments = $comment->getAllData("object");

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
        $view->render();
    }
}

