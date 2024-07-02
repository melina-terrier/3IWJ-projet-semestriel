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
        if (!empty($_SESSION['user_id'])){
            $userId = $_SESSION['user_id'];
        } else {
            $userId = '';
        }
       
        if( $form->isSubmitted() && $form->isValid()) { 
            $media = new MediaModel();
            if (isset($_FILES['media']) && $_FILES['media']['error'] === UPLOAD_ERR_OK) {
                $mediaFile = $_FILES['media'];
                $fileName = $mediaFile['name']; 
                $fileSize = $mediaFile['size'];
                $fileType = $mediaFile['type']; 
                $tmpName = $mediaFile['tmp_name'];                
                $slug = trim(strtolower($fileName));
                $slug = str_replace(' ', '-', $slug);
                $search  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
                $replace = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');
                $url = str_replace($search, $replace, $slug);
                $pattern = '/[^a-zA-Z0-9\/-]/'; 
                $slug = preg_replace('[' . $pattern . ']', '', $slug);
                $destinationPath = '../Public/Assets/Uploads/media/' . $slug;
                if (move_uploaded_file($tmpName, $destinationPath)) {
                    $media->setType($fileType);
                    $media->setSize($fileSize);
                    $media->setName($slug);
                    if (!$media->isUnique(['url'=>'/Assets/Uploads/media/'. $slug])>0) {
                        $media->setUrl('/Assets/Uploads/media/'. $slug); 
                    } else {
                        $errors[] = 'Un média avec ce nom existe déjà.';
                    }
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
            if (empty($errors)) {
                $media->save();
                header('Location: /dashboard/medias?message=success');
                exit;
            }
        } 
        $view = new View('Media/add-media', 'back');
        $view->assign('form', $form->build());
        $view->assign('errors', $errors);
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
                if ( $media->delete(['id' => (int)$_GET['id']])) {
                    header('Location: /dashboard/medias?message=delete-success');
                } else {
                    $errors[] = 'Une erreur est survenue lors de la suppression du média.';
                }
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
        $media = new MediaModel();

        if (isset($_GET['id']) && $_GET['id']) {
            $mediaId = $_GET['id'];
            $selectedMedia = $media->populate($mediaId, 'array');

            if ($selectedMedia) {
                $form = new Form('EditMedia');
                $form->setField($selectedMedia);
                $formattedDate = date('Y-m-d H:i:s');

                if( $form->isSubmitted() && $form->isValid() )
                {
                    $userId = $_SESSION['user_id'];
                    $media->setId($selectedMedia['id']);
                    $media->setTitle($_POST['title']);
                    $media->setUrl($selectedMedia['url']);
                    $media->setDescription($_POST['description']);
                    $media->setCreationDate($selectedMedia['creation_date']);
                    $media->setName($selectedMedia['name']);
                    $media->setSize($selectedMedia['size']);
                    $media->setType($selectedMedia['type']);
                    $media->setModificationDate($formattedDate);
                    $media->setUser($userId);
                    if ($media->save()) {
                        header('Location: /dashboard/medias?message=update-success');
                        exit;
                    } else {
                        $errors[] = 'Une erreur est survenue lors de la modification du média.';
                    }
                }
            } else {
                $errors[] = 'Aucun média trouvé';
            }
        }
        $view = new View('Media/add-media', 'back');
        $view->assign('form', $form->build());
        $view->assign('errors', $errors);
        $view->assign('media', $selectedMedia);
        $view->render();
    }

}