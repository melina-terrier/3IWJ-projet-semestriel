<?php
namespace App\Controllers;
use App\Core\Form;
use App\Core\View;
use App\Models\User as UserModel;
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
            $media->setTitle($_POST['title']);
            $media->setDescription($_POST['description']);
            $media->setCreationDate($formattedDate);
            $media->setModificationDate($formattedDate);
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
        $medias = $media->getAllData("array");
        $errors = [];
        $success = [];
        $userModel = new UserModel();
            
        if (isset($_GET['action']) && isset($_GET['id'])) {
            if ($_GET['action'] === "delete") {
                $media->delete(['id' => (int)$_GET['id']]);
                header('Location: /dashboard/medias?message=delete-success');
                exit;
            }
        }
        
        foreach ($medias as &$media) {
            $userId = $media['user_id'];
            $media['user_name'] ='';
            if ($userId) {
                $user = $userModel->getOneBy(['id' => $userId], 'object');
                if ($user || $status) {
                    $media['user_name'] = $user->getUserName();
                }
            }
        }
        $view = new View("Media/medias-list", "back");
        $view->assign("medias", $medias);
        $view->assign("errors", $errors);
        $view->assign("success", $success);
        $view->render();
    }

    public function editMedia(){
        $errors = [];
        $success = [];
        
        $media = new MediaModel();
        if (isset($_GET['id']) && $_GET['id']) {
            $mediaId = $_GET['id'];
            $selectedMedia = $media->getOneBy(['id' => $mediaId], 'object');
            if ($selectedMedia) {
                $form = new Form("EditMedia");
                $form->setField('title', $selectedMedia->getTitle());
                $form->setField('description', $selectedMedia->getDescription());
                $formattedDate = date('Y-m-d H:i:s');
                $userSerialized = $_SESSION['user'];
                $user = unserialize($userSerialized);
                $userId = $user->getId();
                
                if( $form->isSubmitted() && $form->isValid() )
                {
                    $media->setId($selectedMedia->getId());
                    $media->setTitle($_POST['title']);
                    $media->setUrl($selectedMedia->getUrl());
                    $media->setDescription($_POST['description']);
                    $media->setCreationDate($selectedMedia->getCreationDate());
                    $media->setName($selectedMedia->getName());
                    $media->setSize($selectedMedia->getSize());
                    $media->setType($selectedMedia->getType());
                    $media->setModificationDate($formattedDate);
                    $media->setUser($userId);
                    $media->save();
                    header("Location: /dashboard/medias?message=update-success");
                    exit; 
                }
            }
        }
        $view = new View("Media/add-media", "back");
        $view->assign("form", $form->build());
        $view->assign("errorsForm", $errors);
        $view->assign("successForm", $success);
        $view->render();
    }
}