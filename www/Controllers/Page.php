<?php
namespace App\Controller;
use App\Core\Form;
use App\Core\Page as Auth;
use App\Core\View;
use App\Models\User;

class Page{



    public function page(): void
    {

        $form = new Form("Page");

        if( $form->isSubmitted() && $form->isValid() )
        {
            $user = new User();
            $user->setTitle($_POST["title"]);
            $user->save();
        }

        $view = new View("Page/page");
        $view->assign("form", $form->build());
        $view->render();
    }

}