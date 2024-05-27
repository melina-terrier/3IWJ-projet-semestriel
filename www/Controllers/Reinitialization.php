<?php
namespace App\Controller;
use App\Core\Form;
use App\Core\Reinitialization as Auth;
use App\Core\View;
use App\Models\User;

class Reinitialization{

   

    public function reinitialization(): void
    {

        $form = new Form("Reinitialization");

        if( $form->isSubmitted() && $form->isValid() )
        {
            $user = new User();
            $user->setemail($_POST["email"]);
            $user->save();
        }

        $view = new View("Reinitialization/reinitialization");
        $view->assign("form", $form->build());
        $view->render();
    }

  
}



















