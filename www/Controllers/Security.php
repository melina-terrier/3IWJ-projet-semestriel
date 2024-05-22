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

        $view = new View("Security/register");
        $view->assign("form", $form->build());
        $view->render();
    }

    public function update(): void
    {

        $form = new Form("Update");

        if( $form->isSubmitted() && $form->isValid() )
        {
            $user = new User();
            $user->setAdress($_POST["adress"]);
            $user->setStudy($_POST["study"]);
            $user->setExperience($_POST["experience"]);
            $user->setInterest($_POST["interest"]);
            $user->setCompetence($_POST["competence"]);
            $user->setBirthday($_POST["birthday"]);
            $user->setContact($_POST["contact"]);
            $user->setDescription($_POST["description"]);
            $user->save();
        }

        $view = new View("Security/update");
        $view->assign("form", $form->build());
        $view->render();
    }


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

        $view = new View("Security/comment");
        $view->assign("form", $form->build());
        $view->render();
    }

    public function newsletter(): void
    {

        $form = new Form("Newsletter");

        if( $form->isSubmitted() && $form->isValid() )
        {
            $user = new User();
            $user->setemail($_POST["email"]);
            $user->save();
        }

        $view = new View("Security/newsletter");
        $view->assign("form", $form->build());
        $view->render();
    }

    public function reinitialization(): void
    {

        $form = new Form("Reinitialization");

        if( $form->isSubmitted() && $form->isValid() )
        {
            $user = new User();
            $user->setemail($_POST["email"]);
            $user->save();
        }

        $view = new View("Security/reinitialization");
        $view->assign("form", $form->build());
        $view->render();
    }

    public function logout(): void
    {
        echo "Se déconnecter";
    }


}



















