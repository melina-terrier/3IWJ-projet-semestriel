<?php
namespace App\Controller;
use App\Core\Form;
use App\Core\Project as Auth;
use App\Core\View;
use App\Models\User;

class Project{


    public function project(): void
    {

        $form = new Form("Project");

        if( $form->isSubmitted() && $form->isValid() )
        {
            $user = new User();
            $user->setTitle($_POST["title"]);
            $user->setContent($_POST["content"]);
            $user->setdate_to_create($_POST["date_to_create"]);
            $user->save();
        }

        $view = new View("Project/project");
        $view->assign("form", $form->build());
        $view->render();
    }

}