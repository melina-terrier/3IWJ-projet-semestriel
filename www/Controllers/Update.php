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

<<<<<<< HEAD
        if ($form->isSubmitted() && $form->isValid()) {
            $user = new Update();
            $user->setAddress($_POST["address"]);
            $user->setPhoto($_POST["photo"]);
            $user->setTelephone($_POST["telephone"]);
            $user->setDate($_POST["date"]);
=======
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
>>>>>>> 6c501f1db55d62bf1e1edcc546dfce12f25dc3b4
            $user->setDescription($_POST["description"]);
            $user->save();
        }

<<<<<<< HEAD

=======
>>>>>>> 6c501f1db55d62bf1e1edcc546dfce12f25dc3b4
        $view = new View("Update/update");
        $view->assign("form", $form->build());
        $view->render();
    }

<<<<<<< HEAD
    

}
=======

}



















>>>>>>> 6c501f1db55d62bf1e1edcc546dfce12f25dc3b4
