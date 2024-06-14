<?php

namespace App\Controllers;

use App\Core\Form;
use App\Core\View;
use App\Models\Setting as  SettingModel;

class Setting{

    public function setSetting() {
        $form = new Form("Setting");
        $setting = new SettingModel();
        if( $form->isSubmitted() && $form->isValid() )
        {
            $formattedDate = date('Y-m-d H:i:s');
            $setting->setId(1);
            $setting->setTitle($_POST['title']);
            $setting->setIcon($_POST['icon']);
            $setting->setSlogan($_POST['slogan']);
            $setting->setLogo($_POST['logo']);
            $setting->setTimezone($_POST['timezone']);
            $setting->setHomepage($_POST['homepage']);
            $setting->setPrimaryColor($_POST['primary_color']);
            $setting->setSecondaryColor($_POST['secondary_color']);
            $setting->setAccentColor($_POST['accent_color']);
            $setting->setPrimaryFont($_POST['primary_font']);
            $setting->setSecundaryFont($_POST['secundary_font']);
            $setting->setModificationDate($formattedDate);
            $setting->setCreationDate($formattedDate);
            $setting->save();
        }
        $view = new View("Setting/setting", "back");
        $view->assign("form", $form->build());
        $view->render();
    }


}
