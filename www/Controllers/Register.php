<?php
namespace App\Controller;
use App\Core\Form;
use App\Core\Register as Auth;
use App\Core\View;
use App\Models\User;

class Register{


    public function register(): void
    {

        $form = new Form("Register");

        if( $form->isSubmitted() && $form->isValid() )
        {
            $user = new User();
            $user->setLastname($_POST["lastname"]);
            $user->setFirstname($_POST["firstname"]);
            $user->setEmail($_POST["email"]);
            $user->setPassword($_POST["password"]);
            $user->save();
        }

        $view = new View("Register/register");
        $view->assign("form", $form->build());
        $view->render();
    }

}