<?php

namespace App\Controllers;

use App\Core\Form;
use App\Core\View;

class Setting{

    public function setSetting() {
        $form = new Form("Setting");
        if( $form->isSubmitted() && $form->isValid() )
        {
        }
        $view = new View("Setting/setting", "back");
        $view->assign("form", $form->build());
        $view->render();
    }


}