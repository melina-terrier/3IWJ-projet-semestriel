<?php

namespace App\Controller;

use App\Core\Form;
use App\Core\View;
use App\Models\Comment;

class CommentController
{
    public function comment()
    {
        $form = new Form("Comment");

        if ($form->isSubmitted() && $form->isValid()) {
            $comment = new Comment();
            $date = new \DateTime();
            $comment->setTitle($_POST["Title"]);
            $comment->setContent($_POST["content"]);
            $comment->setDate($date);
            $comment->save();
        }

        $view = new View("Comment/comment");
        $view->assign("form", $form->build());
        $view->render();
    }
}
