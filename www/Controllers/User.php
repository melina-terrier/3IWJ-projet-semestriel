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
            $userId = $_POST['id'];
            if ($user->delete(['id' => $userId])) {
                $success[] = "L'utilisateur a été supprimé avec succès.";
            } else {
                $errors[] = "La suppression a échoué.";
            }
        }
        $allUsers = $user->getUsers();
        $view = new View("User/users-list", "back");
        $view->assign("users", $allUsers);
        $view->assign("errors", $errors);
        $view->assign("success", $success);
        $view->render();
    }

    public function editUser(): void {
        $userId = $_GET['id'] ?? null;
        $user = new UserModel();
        $errors = [];
        $success = [];
        if ($userId) {
            // Charger les données existantes de l'utilisateur
            $userData = $user->getOneBy(['id' => $userId]);
            if (!$userData) {
                $errors[] = "Utilisateur non trouvé.";
            } else {
                $form = new EditUser($userData);
            }
        } else {
            $errors[] = "Aucun ID d'utilisateur spécifié.";
        }

        $form = new Form("EditUser");
        
        if( $form->isSubmitted() && $form->isValid() )
        {
            $user->setDataFromArray($userData);
            $user->setFirstname($_POST['firstname']);
            $user->setLastname($_POST['lastname']);
            $user->setEmail($_POST['email']);
            $user->setImgPath($_POST['user_image']);
            $user->setRoles($_POST['role']);
            $user->save();
            $success[] = "Les informations de l'utilisateur ont été mises à jour avec succès.";
        }
        $view = new View("User/edit-user", "back");
        $view->assign("userInfo", $userData);
        $view->assign("form", $form->build());
        $view->assign("errorsForm", $errors);
        $view->assign("successForm", $success);
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
