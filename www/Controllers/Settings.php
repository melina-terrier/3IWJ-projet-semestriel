<?php

namespace App\Controllers;

use App\Core\Form;
use App\Core\View;
use App\Models\Setting as SettingModel;

class Settings{

    public function setSetting()
    {
        $errors = [];
        $settingsManager = new SettingModel();
        $form = new Form("SetSetting");

        if( $form->isSubmitted() && $form->isValid() )
        {
            $formattedDate = date('Y-m-d H:i:s');

            $settingsTitle = $settingsManager->getOneBy(['key'=>'title'], 'object');
            if ($settingsTitle){
                $settingsTitle->setValue($_POST['title']);
                $settingsTitle->setModificationDate($formattedDate);
            } else {
                $settingsTitle = new SettingModel();
                $settingsTitle->setKey('title');
                $settingsTitle->setValue($_POST['title']);
                $settingsTitle->setCreationDate($formattedDate);
                $settingsTitle->setModificationDate($formattedDate);
            }
            $settingsTitle->save();

            $settingsSlogan = $settingsManager->getOneBy(['key'=>'slogan'], 'object');
            if ($settingsSlogan){
                $settingsSlogan->setValue($_POST['slogan']);
                $settingsSlogan->setModificationDate($formattedDate);
            } else {
                $settingsSlogan = new SettingModel();
                $settingsSlogan->setKey('slogan');
                $settingsSlogan->setValue($_POST['slogan']);
                $settingsSlogan->setCreationDate($formattedDate);
                $settingsSlogan->setModificationDate($formattedDate);
            }
            $settingsSlogan->save();

            $settingsDescription = $settingsManager->getOneBy(['key'=>'site_description'], 'object');
            if ($settingsDescription){
                $settingsDescription->setValue($_POST['site_description']);
                $settingsDescription->setModificationDate($formattedDate);
            } else {
                $settingsDescription = new SettingModel();
                $settingsDescription->setKey('site_description');
                $settingsDescription->setValue($_POST['site_description']);
                $settingsDescription->setCreationDate($formattedDate);
                $settingsDescription->setModificationDate($formattedDate);
            }
            $settingsDescription->save();

            $settingsLogo = $settingsManager->getOneBy(['key'=>'logo'], 'object');
            if ($settingsLogo){
                $settingsLogo->setValue($_POST['logo']);
                $settingsLogo->setModificationDate($formattedDate);
            } else {
                $settingsLogo = new SettingModel();
                $settingsLogo->setKey('logo');
                $settingsLogo->setValue($_POST['logo']);
                $settingsLogo->setCreationDate($formattedDate);
                $settingsLogo->setModificationDate($formattedDate);
            }
            $settingsLogo->save();

            $settingsTimezone = $settingsManager->getOneBy(['key'=>'timezone'], 'object');
            if ($settingsTimezone){
                $settingsTimezone->setValue($_POST['timezone']);
                $settingsTimezone->setModificationDate($formattedDate);
            } else {
                $settingsTimezone = new SettingModel();
                $settingsTimezone->setKey('timezone');
                $settingsTimezone->setValue($_POST['timezone']);
                $settingsTimezone->setCreationDate($formattedDate);
                $settingsTimezone->setModificationDate($formattedDate);
            }
            $settingsTimezone->save();

            $settingsHomepage = $settingsManager->getOneBy(['key'=>'homepage'], 'object');
            if ($settingsHomepage){
                $settingsHomepage->setValue($_POST['homepage']);
                $settingsHomepage->setModificationDate($formattedDate);
            } else {
                $settingsHomepage = new SettingModel();
                $settingsHomepage->setKey('homepage');
                $settingsHomepage->setValue($_POST['homepage']);
                $settingsHomepage->setCreationDate($formattedDate);
                $settingsHomepage->setModificationDate($formattedDate);
            }
            $settingsHomepage->save();

            $settingsPrimaryColor = $settingsManager->getOneBy(['key'=>'primary_color'], 'object');
            if ($settingsPrimaryColor){
                $settingsPrimaryColor->setValue($_POST['primary_color']);
                $settingsPrimaryColor->setModificationDate($formattedDate);
            } else {
                $settingsPrimaryColor = new SettingModel();
                $settingsPrimaryColor->setKey('primary_color');
                $settingsPrimaryColor->setValue($_POST['primary_color']);
                $settingsPrimaryColor->setCreationDate($formattedDate);
                $settingsPrimaryColor->setModificationDate($formattedDate);
            }
            $settingsPrimaryColor->save();

            $settingsSecondaryColor = $settingsManager->getOneBy(['key'=>'secondary_color'], 'object');
            if ($settingsSecondaryColor){
                $settingsSecondaryColor->setValue($_POST['secondary_color']);
                $settingsSecondaryColor->setModificationDate($formattedDate);
            } else {
                $settingsSecondaryColor = new SettingModel();
                $settingsSecondaryColor->setKey('secondary_color');
                $settingsSecondaryColor->setValue($_POST['secondary_color']);
                $settingsSecondaryColor->setCreationDate($formattedDate);
                $settingsSecondaryColor->setModificationDate($formattedDate);
            }
            $settingsSecondaryColor->save();

            $settingsAccentColor = $settingsManager->getOneBy(['key'=>'accent_color'], 'object');
            if ($settingsAccentColor){
                $settingsAccentColor->setValue($_POST['accent_color']);
                $settingsAccentColor->setModificationDate($formattedDate);
            } else {
                $settingsAccentColor = new SettingModel();
                $settingsAccentColor->setKey('accent_color');
                $settingsAccentColor->setValue($_POST['accent_color']);
                $settingsAccentColor->setCreationDate($formattedDate);
                $settingsAccentColor->setModificationDate($formattedDate);
            }
            $settingsAccentColor->save();

            $settingsPrimaryFont = $settingsManager->getOneBy(['key'=>'primary_font'], 'object');
            if ($settingsPrimaryFont){
                $settingsPrimaryFont->setValue($_POST['primary_font']);
                $settingsPrimaryFont->setModificationDate($formattedDate);
            } else {
                $settingsPrimaryFont = new SettingModel();
                $settingsPrimaryFont->setKey('primary_font');
                $settingsPrimaryFont->setValue($_POST['primary_font']);
                $settingsPrimaryFont->setCreationDate($formattedDate);
                $settingsPrimaryFont->setModificationDate($formattedDate);
            }
            $settingsPrimaryFont->save();

            $settingsSecundaryFont = $settingsManager->getOneBy(['key'=>'secundary_font'], 'object');
            if ($settingsSecundaryFont){
                $settingsSecundaryFont->setValue($_POST['secundary_font']);
                $settingsSecundaryFont->setModificationDate($formattedDate);
            } else {
                $settingsSecundaryFont = new SettingModel();
                $settingsSecundaryFont->setKey('secundary_font');
                $settingsSecundaryFont->setValue($_POST['secundary_font']);
                $settingsSecundaryFont->setCreationDate($formattedDate);
                $settingsSecundaryFont->setModificationDate($formattedDate);
            }
            $settingsSecundaryFont->save();

        } else {
            $errors[]="Les settings n'ont pas été mis à jour.";
        }
        $view = new View("Setting/setting", "back");
        $view->assign("form", $form->build());
        $view->assign("errors", $errors);
        $view->render();
    }

}