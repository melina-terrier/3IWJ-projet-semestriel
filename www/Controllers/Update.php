<?php
namespace App\Controller;
use App\Core\Form;
use App\Core\Update as Auth;
use App\Core\View;
use App\Models\User;

class Update{

    
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

        $view = new View("Update/update");
        $view->assign("form", $form->build());
        $view->render();
    }


}



















