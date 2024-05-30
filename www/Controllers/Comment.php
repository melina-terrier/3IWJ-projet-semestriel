<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\Form;
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
            // $comment->setUserId($_POST['email']);
            $comment->setComment($_POST['comment']);
            $comment->setCreationDate($formattedDate);
            $comment->setModificationDate($formattedDate);
            $comment->setStatus('Publié');
            $comment->save();
            $success[] = "Votre commentaire a été publié";
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
