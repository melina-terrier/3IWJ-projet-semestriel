<?php

namespace App\Controllers;

use App\Core\Form;
use App\Core\View;
use App\Models\User;
use App\Models\Settiing as  SettingModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

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
