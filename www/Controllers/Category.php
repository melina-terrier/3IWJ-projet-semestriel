<?php
namespace App\Controller;
use App\Core\Form;
use App\Core\Category as Auth;
use App\Core\View;
use App\Models\User;

class Category{



    public function category(): void
    {

        $form = new Form("Category");

        if( $form->isSubmitted() && $form->isValid() )
        {
            $user = new User();
            $user->setTitle($_POST["title"]);
            $user->save();
        }

        $view = new View("Category/category");
        $view->assign("form", $form->build());
        $view->render();
    }

}



















