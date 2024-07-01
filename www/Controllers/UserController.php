<?php
namespace App\Controllers;
use App\Core\View;
use App\Core\Form;
use App\Models\Media;
use App\Models\Comment;
use App\Models\Page;
use App\Models\Tag;
use App\Models\Role;
use App\Models\Formation;
use App\Models\Experience;
use App\Models\Skill;
use App\Models\Contact;
use App\Models\Project;
use App\Models\User as UserModel;
use App\Controllers\Security as UserSecurity;

class UserController
{

    public function allUsers(): void
    {
        $errors = [];
        $success = [];
        $user = new UserModel();
        $allUsers = $user->getAllData(null, null, 'array');

        if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {

            $userToDelete = $user->populate($_GET['id']);
            if (!$userToDelete) {
                $errors[] = 'Utilisateur introuvable.';
            }

            $this->deleteAssociatedData($_GET['id'], $errors);

            $projectObj = new Project();
            $projects = $projectObj->getAllData(['user_id'=>$_GET['id']]);
            foreach ($projects as $project) {
              $projectObj->delete(['id'=>$project['id']]);
            }

            $user->delete(['id' => $_GET['id']]);

            if ($_GET['id'] == ($_SESSION['user_id'])){
                header('Location: /logout');
            } else {    
                header('Location: /dashboard/users?message=permanent-delete-success');
            }
        }

        $roleModel = new Role();
        foreach ($allUsers as &$user) {
            $roleId = $user['id_role'];
            $user['role_name'] ='';
            if ($roleId) {
                $role = $roleModel->populate($roleId);
                if ($role) {
                    $user['role_name'] = $role->getName();
                }
            }
        }

        $view = new View('User/users-list', 'back');
        $view->assign('users', $allUsers);
        $view->assign('errors', $errors);
        $view->render();
    }

    public function addUser(): void {
        $form = new Form('AddUser');
        $user = new UserModel();
        $userSecurity = new UserSecurity();
        $errors = [];
        $success = [];
        $formattedDate = date('Y-m-d H:i:s');

        if (isset($_GET['id']) && $_GET['id']) {
            $userId = $_GET['id'];
            $selectedUser = $user->populate($userId);
            if ($selectedUser) {
                $form->setField('firstname', $selectedUser->getFirstname());
                $form->setField('lastname', $selectedUser->getLastname());
                $form->setField('email', $selectedUser->getEmail());
                $form->setField('role', $selectedUser->getRole());
            } else {
                $errors[] = 'Utilisateur introuvable.';
            }
        }

        if( $form->isSubmitted() && $form->isValid() )
        {
            if ($user->isUnique(['email'=>$_POST['email']]) && !isset($_GET['id'])) {
                $errors[] = 'L\'adresse email est déjà utilisé par un autre compte.';
            } else {
                $resetToken = bin2hex(random_bytes(50));
                $expires = new \DateTime('+1 hour');
                $expiresTimestamp = $expires->getTimestamp();
                $expiresDateTime = $expires->format('Y-m-d H:i:s');
                $activationToken = bin2hex(random_bytes(16));
                $userData = [
                    'firstname' => $_POST['firstname'],
                    'lastname' => $_POST['lastname'],
                    'email' => $email,
                    'role' => $_POST['role'],
                    'status' => 0,
                    'modification_date' => $formattedDate,
                    'activation_token' => $activationToken,
                    'reset_token' => $resetToken,
                    'reset_expires' => $expiresDateTime,
                ];

                if(isset($_GET['id']) && $_GET['id']){
                    $userData['id'] = $selectedUser->getId();
                    $userData['creation_date'] = $selectedUser->getCreationDate();
                } else {
                    $userData['creation_date'] = $formattedDate;
                }

                if ($user->save()) {
                    $emailResult = $userSecurity->sendCreateAccount($user->getEmail(), $resetToken);
    
                    if (isset($emailResult['success'])) {
                        $success[] = $emailResult['success'];
                    } elseif (isset($emailResult['error'])) {
                        $errors[] = $emailResult['error'];
                    }
                    header('Location: /dashboard/users?message=success');
                    exit; 
                } else {
                    $errors[] = 'Une erreur est survenue lors de la création de l\'utilisateur.';
                }

            }
        }
        $view = new View('User/add-user', 'back');
        $view->assign('form', $form->build());
        $view->assign('errorsForm', $errors);
        $view->render();
    }

    public function editUser(): void {
        $user = new UserModel();
        $errors = [];
        $success = [];
        $userId = $_SESSION['user_id'];
        $userModel = $user->populate($userId, 'array');
        $form = new Form('EditUser');
        
        $form->setField($userModel);

        if( $form->isSubmitted() && $form->isValid())
        {
            $user->setDataFromArray($userModel);
            $formattedDate = date('Y-m-d H:i:s');
            $user->setLastname($_POST['lastname']);
            $user->setFirstname($_POST['firstname']);
            $user->setEmail($_POST['email']);
            $media = new Media();
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $mediaFile = $_FILES['photo'];
                $fileName = $mediaFile['name']; 
                $fileSize = $mediaFile['size'];
                $fileType = $mediaFile['type']; 
                $tmpName = $mediaFile['tmp_name'];                
                $destinationPath = '../Public/Assets/Uploads/users/' . $fileName;
                if (move_uploaded_file($tmpName, $destinationPath)) {
                    $media->setType($fileType);
                    $media->setSize($fileSize);
                    $media->setName($fileName);
                    $media->setUrl('/Assets/Uploads/users/'. $fileName); 
                } else {
                    $errors[] = 'Erreur lors du téléchargement du média.';
                }
                $media->setTitle($fileName);
                $media->setDescription('Photo de profil de l\'utilisateur');
                $media->setCreationDate($formattedDate);
                $media->setModificationDate($formattedDate);
                $media->setUser($userId);
                $media->save();
                $user->setPhoto('/Assets/Uploads/users/'. $fileName);
            }

            $user->setSkill($_POST['skill']);
            $user->setFormation($_POST['formation']);
            $user->setExperience($_POST['experience']);
            $user->setLink($_POST['link']);
            $user->setOccupation($_POST['occupation']);
            $user->setCountry($_POST['country']);
            $user->setCity($_POST['city']);
            $user->setWebsite($_POST['website']);
            $user->setDescription($_POST['description']);
            $user->setInterest($_POST['interest']);
            $user->setModificationDate($formattedDate);
            $user->save();
            header('Location: /profiles/'.$user->getSlug().'?message=update-success');
            exit; 
        } 
        
        if (isset($_GET['action']) && $_GET['action'] === 'delete') {
            $this->deleteAssociatedData($userId, $errors);
            $projectObj = new Project();
            $projects = $projectObj->getAllData(['user_id'=>$userId]);
            foreach ($projects as $project) {
              $projectObj->delete(['id'=>$project['id']]);
            }
            $user->delete(['id' => $userId]);
            header('Location: /logout');
        }

        $view = new View('User/edit-user', 'front');
        $view->assign('form', $form->build());
        $view->assign('userId', $userId);
        $view->assign('errorsForm', $errors);
        $view->assign('successForm', $success);
        $view->render();
    }

    public function editPassword(): void 
    {
        $userId = $_GET['id'] ?? null;
        $errors = [];
        $success = [];

        if (!$userId){
            $errors[] = 'Utilisateur inconnu.';
        } else {

            $user = new UserModel();
            $userData = $user->populate($userId);
            if (!$userData) {
                $errors[] = 'Utilisateur non trouvé.';
            }
    
            $form = new Form('EditPassword');
            if ($form->isSubmitted() && $form->isValid()) {
                if (password_verify($_POST['old-password'], $user->getPassword())) {
                    $user->setDataFromArray($userData);
                    $user->setPassword($_POST['password']);
                    if ($user->save()) {
                        $success[] = 'Le mot de passe de l\'utilisateur a été mis à jour avec succès.';
                    } else {
                        $errors[] = 'Une erreur est survenue lors de la modification du mot de passe. Veuillez réessayer.';
                    }
                } else {
                    $errors[] = 'Le mot de passe actuel est incorrect';
                }
        }

        }
        $view = new View('User/edit-password', 'front');
        $view->assign('form', $form->build());
        $view->assign('errors', $errors);
        $view->assign('successes', $success);
        $view->render();
    }

    public function deleteAssociatedData($userId, $errors){
        $media = new Media();
        $medias = $media->getAllData(['user_id'=>$userId], 'object');
        foreach ($medias as $media){
            $media->setUser(null);
            if (!$media->save()) {
                $errors[] = "Une erreur est survenue lors de la suppression des médias associés à l'utilisateur.";
            }
        }

        $page = new Page();
        $pages = $page->getAllData(['user_id'=>$userId], 'object');            
        foreach ($pages as $page){
            $page->setUser(null);
            if (!$media->save()) {
                $page[] = "Une erreur est survenue lors de la suppression des pages associées à l'utilisateur.";
            }
        }

        $comment = new Comment();
        $comments = $comment->getAllData(['user_id'=>$userId], 'object');
        foreach ($comments as $comment){
            $comment->setUserId(null);
            if (!$media->save()) {
                $comment[] = "Une erreur est survenue lors de la suppression des commentaires associés à l'utilisateur.";
            }
        }

        $tag = new Tag();
        $tags = $tag->getAllData(['user_id'=>$userId], 'object');
        foreach ($tags as $tag){
            $tag->setUserId(null);
            if (!$tag->save()) {
                $errors[] = "Une erreur est survenue lors de la suppression des catégories associées à l'utilisateur.";
            }
        }
    }
}