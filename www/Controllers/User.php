<?php

namespace App\Controllers;
use App\Core\View;
use App\Core\SQL;
use App\Core\Form;
use App\Models\User as UserModel;

class User
{

    public function allUsers(): void
    {
        $errors = [];
        $success = [];
        $user = new UserModel();
        if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
            // $currentUser = $user->getOneBy(['id' => $_GET['id']], 'object');
            // $currentUser->setStatus(-1);
            // print_r($currentUser);
            // $currentUser->save();
            // header('Location: /dashboard/users?message=delete-success');
        }
        $allUsers = $user->getUsers();
        $view = new View("User/users-list", "back");
        $view->assign("users", $allUsers);
        $view->assign("errors", $errors);
        $view->assign("success", $success);
        $view->render();
    }

    public function addUser(): void {
        $form = new Form("AddUser");
        $errors = [];

        if( $form->isSubmitted() && $form->isValid() )
        {
            $user = new UserModel();
            $formattedDate = date('d/m/Y H:i:s');

            if ($user->emailExists($_POST["email"])) {
                $errors[] = "L'email est déjà utilisé par un autre compte.";
            } else {
                $user->setLastname($_POST["lastname"]);
                $user->setFirstname($_POST["firstname"]);
                $user->setEmail($_POST["email"]);
                $user->setRole($_POST["role"]);
                $user->setCreationDate($formattedDate);
                $user->setModificationDate($formattedDate);
                $user->setStatus(0);

                $activationToken = bin2hex(random_bytes(16));
                $user->setActivationToken($activationToken);
                $user->save();

                // Redirect after successful creation (optional success message)
                header("Location: /dashboard/users?message=success");
                exit; 

                // Voir pour envoyer un mail de création de mot de passe
                // $emailResult = $this->sendActivationEmail($user->getEmail(), $activationToken);

                // if (isset($emailResult['success'])) {
                //     $success[] = $emailResult['success'];
                // } elseif (isset($emailResult['error'])) {
                //     $errors[] = $emailResult['error'];
                // }
            }
        }
        $view = new View("User/add-user", "back");
        $view->assign("form", $form->build());
        $view->assign("errorsForm", $errors);
        $view->render();
    }


    public function editUser(): void {
        $userId = $_GET['id'] ?? null;
        $user = new UserModel();
        $errors = [];
        $success = [];

        if ($userId) {
            $userData = $user->getOneBy(['id' => $userId], 'object');
            if (!$userData) {
                $errors[] = "Utilisateur non trouvé.";
            }
        } else {
            $errors[] = "Aucun ID d'utilisateur spécifié.";
        }

        $form = new Form("AddUser");
        $form->setField('firstname', $userData->getFirstname());
        $form->setField('lastname', $userData->getLastname());
        $form->setField('email', $userData->getEmail());
        
        if( $form->isSubmitted() && $form->isValid() )
        {
            $formattedDate = date('d/m/Y H:i:s');
            $user->setLastname($_POST["lastname"]);
            $user->setFirstname($_POST["firstname"]);
            $user->setEmail($_POST["email"]);
            // $user->setRole($_POST["role"]);
            $user->setModificationDate($formattedDate);
            $user->setStatus(0);
            $user->setCreationDate($userData->getCreationDate());
            // $user->setActivationToken($userData->getActivationToken());
            $user->save();
            // Redirect after successful creation (optional success message)
            header("Location: /dashboard/users?message=update-success");
            exit; 
            
        }
        $view = new View("User/edit-user", "back");
        $view->assign("form", $form->build());
        $view->assign("errorsForm", $errors);
        $view->assign("successForm", $success);
        $view->render();
    }

    
    public function viewUser(): void
    {
        $userId = $_GET['id'] ?? null;
        $errors = [];
        $success = [];
        if ($userId === null) {
            $errors[] = "Aucun ID utilisateur spécifié.";
        }
        $userModel = new UserModel();
        $userData = $userModel->getOneBy(['id' => $userId]);
        if (!$userData) {
            $errors[] = "Utilisateur non trouvé.";
        }
        $view = new View("User/user", "back");
        $view->assign("userData", $userData);
        $view->assign("errors", $errors);
        $view->assign("success", $success);
        $view->render();
    }

}
