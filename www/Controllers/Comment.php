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
            $comment->setReport(0);

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

        $view = new View("Comment/comments-list", "back");
        $view->assign("comments", $comments);
        $view->render();
    }
}

