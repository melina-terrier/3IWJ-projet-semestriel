<?php
namespace App\Controllers;
use App\Core\Form;
use App\Core\View;
use App\Models\Media as MediaModel;
use App\Models\Page;
use App\Models\User;
use App\Controllers\Security;


class Media{

    public function addMedia(): void
    {
        $form = new Form("AddMedia");
        $errors = [];
        $success = [];
        
        $formattedDate = date('Y-m-d H:i:s');

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $media = new MediaModel();
            $media->setTitle($_POST['title']);
            $media->setDescription($_POST['description']);
            $media->setUrl($_POST['url']);
            $media->setCreationDate($formattedDate);
            $media->setModificationDate($formattedDate);
            $media->setStatus('Publié');
            $media->save();
            $success[] = "Votre média a été créé";
        }

        $view = new View("Media/add-media", "back");
        $view->assign("form", $form->build());
        $view->assign("errorsForm", $errors);
        $view->assign("successForm", $success);
        $view->render();
    }

    public function allMedias(): void
    {
        $media = new MediaModel();
        $medias = $media->getAllData("object");

        $view = new View("Media/medias-list", "back");
        $view->assign("medias", $medias);
        $view->render();
    }

}



















