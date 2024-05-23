<?php
namespace App\Controller;
use App\Core\Form;
use App\Core\Media as Auth;
use App\Core\View;
use App\Models\User;

class Media{



    public function media(): void
    {

        $form = new Form("Media");

        if( $form->isSubmitted() && $form->isValid() )
        {
            $user = new User();
            $user->setUrl($_POST["url"]);
            $user->setTitle($_POST["title"]);
            $user->save();
        }

        $view = new View("Media/media");
        $view->assign("form", $form->build());
        $view->render();
    }

}



















