<?php
namespace App\Controllers;
use App\Core\Form;
use App\Core\View;
use App\Models\Media as MediaModel;
use App\Core\SQL;


class Media{

    public function addMedia(): void
    {
        $form = new Form("AddMedia");
        $errors = [];
        $success = [];
        
        $formattedDate = date('Y-m-d H:i:s');
        $userSerialized = $_SESSION['user'];
        $user = unserialize($userSerialized);
        $userId = $user->getId();

        if( $form->isSubmitted() && $form->isValid()) { 
            $media = new MediaModel();
            if (isset($_FILES['media']) && $_FILES['media']['error'] === UPLOAD_ERR_OK) {
                $mediaFile = $_FILES['media'];
                $fileName = $mediaFile['name']; 
                $fileSize = $mediaFile['size'];
                $fileType = $mediaFile['type']; 
                $tmpName = $mediaFile['tmp_name'];                
                $destinationPath = '../Public/uploads/media/' . $fileName;
                if (move_uploaded_file($tmpName, $destinationPath)) {
                    $media->setType($fileType);
                    $media->setSize($fileSize);
                    $media->setName($fileName);
                    $media->setUrl('/uploads/media/'. $fileName); 
                } else {
                    $errors[] = "Erreur lors du téléchargement du média.";
                }
              } else {
                $errors[] = "Erreur lors du téléchargement du média.";
              }
            $sql = new SQL();
            $status = $sql->getDataId("published");

            $media->setTitle($_POST['title']);
            $media->setDescription($_POST['description']);
            $media->setCreationDate($formattedDate);
            $media->setModificationDate($formattedDate);
            $media->setStatus($status);
            $media->setUser($userId);
            $media->save();
            $success[] = "Le média a été ajouté";
            header("Location: /dashboard/medias?message=success");
            exit; 
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