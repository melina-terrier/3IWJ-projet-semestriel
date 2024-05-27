<?php
namespace App\Controller;
use App\Core\Form;
use App\Core\Setting as Auth;
use App\Core\View;
use App\Models\User;

class Setting{



    public function setting(): void
    {

        $form = new Form("Setting");

        if( $form->isSubmitted() && $form->isValid() )
        {
            $user = new User();
            $user->setTitle($_POST["title"]);
            $user->save();
        }

        $view = new View("Setting/setting");
        $view->assign("form", $form->build());
        $view->render();
    }

}



















