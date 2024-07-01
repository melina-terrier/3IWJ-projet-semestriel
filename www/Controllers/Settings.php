<?php

namespace App\Controllers;
use App\Core\Form;
use App\Core\View;
use App\Models\Menu;
use App\Models\itemMenu;
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

            $settingKeys = [
                'title',
                'logo',
                'slogan',
                'site_description',
                'timezone',
                'homepage',
                'comment',
            ];

            foreach ($settingKeys as $key) {
                $setting = $settingsManager->getOneBy(['key'=>$key], 'object');
                if ($setting) {
                    $setting->setValue($_POST[$key]);
                    $setting->setId($setting->getId());
                } else {
                    $setting = new SettingModel();
                    $setting->setKey($key);
                    $setting->setValue($_POST[$key]);
                    $setting->setCreationDate($formattedDate);
                }
                $setting->setModificationDate($formattedDate);
                $setting->save();
                if ($setting->save()) {
                    $success[] = "Les paramètres du site ont été mis à jour.";
                } else {
                    $errors[] = "Les paramètres du site n'ont pas pu être mis à jour.";
                }
            }          
        }
        $view = new View("Setting/setting", "back");
        $view->assign("form", $form->build());
        $view->assign("errors", $errors);
        $view->render();
    }


    public function setMenu(){
        $errors = [];
        $menu = new Menu();
        $itemMenu = new itemMenu();
        $form = new Form("SetMenu");

        if (isset($_GET['id']) && $_GET['id']) {
            $menuId = $_GET['id'];
            $selectedMenu = $menu->populate($menuId, 'array');
            $selectedMenuItem = $itemMenu->getAllData(['menu_id'=>$menuId]);
            if ($selectedMenu) {
                $form->setField($selectedMenu);
                if ($selectedMenu['position'] == 'horizontal'){
                    $form->setField(['horizontal-alignement'=>$selectedMenu['alignement']]);
                } else if ($selectedMenu['position'] == 'vertical' || $selectedMenu['position'] == 'burger'){
                    print_r('true');
                    $form->setField(['vertical-alignement'=>$selectedMenu['alignement']]);
                }
                $form->setField($selectedMenuItem, 'menu', 'menu');
            } else {
                $errors[] = 'Menu introuvable.';
            }
        }
          
        if( $form->isSubmitted() && $form->isValid() )
        {
            if (isset($menuId)){
                $menu->setId($menuId);
                foreach($selectedMenuItem as $menuItem){
                    $itemMenu->delete($menuItem);
                }
            }
            
            $menu->setType($_POST['type']);
            $menu->setPosition($_POST['position']);
            if (isset($_POST['vertical-alignement'])) {
                $menu->setAlignement($_POST['vertical-alignement']);
            } else if (isset($_POST['horizontal-alignement'])) {
                $menu->setAllignement($_POST['horizontal-alignement']);
            }
            $menuId = $menu->save();
            foreach (json_decode($_POST['menu'], true) as $menuItem){
                $itemMenu->setMenu($menuId);
                $itemMenu->setTitle($menuItem['title']);
                $itemMenu->setUrl($menuItem['url']);
                $itemMenu->setItemPosition($menuItem['position']);
                $itemMenu->save();
            }
        }
        $view = new View("Setting/menu", "back");
        $view->assign("form", $form->build());
        $view->assign("errors", $errors);
        $view->render();
    }

    public function setAppearance()
    {
        $errors = [];
        $settingsManager = new SettingModel();
        $form = new Form("SetAppearance");

        if( $form->isSubmitted() && $form->isValid() )
        {

            $settingKeys = [
                'light_primary_color',
                'light_accent_color',
                'light_secondary_color',
                'dark_primary_color',
                'dark_secondary_color',
                'dark_accent_color',
                'primary_font',
                'secundary_font',
            ];

            foreach ($settingKeys as $key) {
                $setting = $settingsManager->getOneBy(['key'=>$key], 'object');
                if ($setting) {
                    $setting->setValue($_POST[$key]);
                    $setting->setId($setting->getId());
                } else {
                    $setting = new SettingModel();
                    $setting->setKey($key);
                    $setting->setValue($_POST[$key]);
                    $setting->setCreationDate($formattedDate);
                }
                $setting->setModificationDate($formattedDate);
                $setting->save();
                if ($setting->save()) {
                    $success[] = "Les paramètres du site ont été mis à jour.";
                } else {
                    $errors[] = "Les paramètres du site n'ont pas pu être mis à jour.";
                }
            }   
        }
        $view = new View("Setting/appearance", "back");
        $view->assign("form", $form->build());
        $view->assign("errors", $errors);
        $view->render();
    }

}