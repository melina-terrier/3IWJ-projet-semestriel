<?php
namespace App\Controller;
use App\Core\Form;
use App\Core\Comment as Auth;
use App\Core\View;
use App\Models\User;

class Comment{



    public function comment(): void
    {

        $form = new Form("Comment");

        if( $form->isSubmitted() && $form->isValid() )
        {
            $user = new User();
            $user->setPseudo($_POST["pseudo"]);
            $user->setemail($_POST["email"]);
            $user->setcomment($_POST["comment"]);
            $user->save();
        }

        $view = new View("Comment/comment");
        $view->assign("form", $form->build());
        $view->render();
    }

}



















