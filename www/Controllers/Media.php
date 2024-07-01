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
        $form = new Form('AddMedia');
        $errors = [];
        
        $formattedDate = date('Y-m-d H:i:s');
        $userId = $_SESSION['user_id'];
       
        if( $form->isSubmitted() && $form->isValid()) { 
            $media = new MediaModel();
            if (isset($_FILES['media']) && $_FILES['media']['error'] === UPLOAD_ERR_OK) {
                $mediaFile = $_FILES['media'];
                $fileName = $mediaFile['name']; 
                $fileSize = $mediaFile['size'];
                $fileType = $mediaFile['type']; 
                $tmpName = $mediaFile['tmp_name'];                
                $destinationPath = '../Public/Assets/Uploads/media/' . $fileName;
                if (move_uploaded_file($tmpName, $destinationPath)) {
                    $media->setType($fileType);
                    $media->setSize($fileSize);
                    $media->setName($fileName);
                    $media->setUrl('/Assets/uploads/media/'. $fileName); 
                } else {
                    $errors[] = 'Erreur lors du téléchargement du média.';
                }
            } else {
                $errors[] = 'Erreur lors du téléchargement du média.';
            }
            $media->setTitle($_POST['title']);
            $media->setDescription($_POST['description']);
            $media->setCreationDate($formattedDate);
            $media->setModificationDate($formattedDate);
            $media->setUser($userId);
            if ($media->save()) {
                header('Location: /dashboard/medias?message=success');
                exit;
            } else {
                $errors[] = 'Une erreur est survenue lors de l\'ajout du média.';
            } 
        }

        $view = new View('Media/add-media', 'back');
        $view->assign('form', $form->build());
        $view->assign('errorsForm', $errors);
        $view->render();
    }

    public function allMedias(): void
    {
        $media = new MediaModel();
        $medias = $media->getAllData(null, null, 'array');
        $errors = [];
        $success = [];
        $userModel = new UserModel();
        if (isset($_GET['action']) && isset($_GET['id'])) {
            if ($_GET['action'] === 'delete') {
                if (!$media->delete(['id' => $_GET['id']])) {
                    $errors[] = 'Une erreur est survenue lors de la suppression du média.';
                }
                $media->delete(['id' => (int)$_GET['id']]);
                $success[] = 'Média supprimé avec succès.'; 
            } else {
                $errors[] = 'Action invalide.';
            }
        }
        foreach ($medias as &$media) {
            $userId = $media['user_id'];
            $media['user_name'] ='';
            if ($userId) {
                $user = $userModel->populate($userId);
                if ($user) {
                    $media['user_name'] = $user->getUserName();
                }
            }
        }
        $view = new View('Media/medias-list', 'back');
        $view->assign('medias', $medias);
        $view->assign('errors', $errors);
        $view->assign('successes', $success);
        $view->render();
    }

    public function editMedia(){
        $errors = [];
        $success = [];
        $media = new MediaModel();

        if (isset($_GET['id']) && $_GET['id']) {
            $mediaId = $_GET['id'];
            $selectedMedia = $media->populate($mediaId);

            if ($selectedMedia) {
                $form = new Form('EditMedia');
                $form->setField('title', $selectedMedia->getTitle());
                $form->setField('description', $selectedMedia->getDescription());
                $formattedDate = date('Y-m-d H:i:s');

                if( $form->isSubmitted() && $form->isValid() )
                {
                    $userId = $_SESSION['user_id'];
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
                    if ($media->save()) {
                        header('Location: /dashboard/medias?message=update-success');
                        exit;
                    } else {
                        $errors[] = 'Une erreur est survenue lors de la modification du média.';
                    }
                }
            }
        }
        $view = new View('Media/add-media', 'back');
        $view->assign('form', $form->build());
        $view->assign('errorsForm', $errors);
        $view->assign('successForm', $success);
        $view->render();
    }

}