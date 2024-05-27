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

        if ($form->isSubmitted() && $form->isValid()) {
            $user = new Update();
            $user->setAddress($_POST["address"]);
            $user->setPhoto($_POST["photo"]);
            $user->setTelephone($_POST["telephone"]);
            $user->setDate($_POST["date"]);
            $user->setDescription($_POST["description"]);
            $user->save();
        }


        $view = new View("Update/update");
        $view->assign("form", $form->build());
        $view->render();
    }

    

}
