<?php
namespace App\Controller;
use App\Core\Form;
use App\Core\Security as Auth;
use App\Core\View;
use App\Models\User;

class Security{


    public function login(): void
    {
        //Je vérifie que l'utilisateur n'est pas connecté sinon j'affiche un message

        /*
        $security = new Auth();
        if($security->isLogged()){
            echo "Vous êtes déjà connecté";
        }else{
            echo "Se connecter";
        }
        */

        $form = new Form("Login");
        if( $form->isSubmitted() && $form->isValid() )
        {

        }
        $view = new View("Security/login");
        $view->assign("form", $form->build());
        $view->render();


    }
   

    public function logout(): void
    {
        echo "Se déconnecter";
    }


}