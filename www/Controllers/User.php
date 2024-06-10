<?php

namespace App\Controllers;
use App\Core\View;
use App\Core\SQL;
use App\Core\Form;
use App\Models\Project;
use App\Models\Media;
use App\Models\Comment;
use App\Models\Page;
use App\Models\Tag;
use App\Models\Role;
use App\Models\User as UserModel;
use App\Controllers\Security as UserSecurity;

class User
{

    public function allUsers(): void
    {
        $errors = [];
        $success = [];
        $user = new UserModel();
        $allUsers = $user->getAllData("array");
        if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
            $project = new Project();
            $projects = $project->getAllDataWithWhere(["user_id"=>$_GET['id']], "object");
            foreach ($projects as $project){
                $project->setUser(null);
                $project->save();
            }

            $media = new Media();
            $medias = $media->getAllDataWithWhere(["user_id"=>$_GET['id']], "object");
            foreach ($medias as $media){
                $media->setUser(null);
                $media->save();
            }

            $page = new Page();
            $pages = $page->getAllDataWithWhere(["user_id"=>$_GET['id']], "object");            foreach ($pages as $page){
                $page->setUser(null);
                $page->save();
            }

            $comment = new Comment();
            $comments = $comment->getAllDataWithWhere(["user_id"=>$_GET['id']], "object");
            foreach ($comments as $comment){
                $comment->setUserId(null);
                $comment->save();
            }

            $tag = new Tag();
            $tags = $tag->getAllDataWithWhere(["user_id"=>$_GET['id']], "object");
            foreach ($tags as $tag){
                $tag->setUserId(null);
                $tag->save();
            }

            $user->delete(['id' => $_GET['id']]);
            header('Location: /dashboard/users?message=permanent-delete-success');
        }

        $roleModel = new Role();
        foreach ($allUsers as &$user) {
            $roleId = $user['id_role'];
            $user['role_name'] ='';
            if ($roleId) {
                $role = $roleModel->getOneBy(['id' => $roleId], 'object');
                if ($role) {
                    $user['role_name'] = $role->getName();
                }
            }
        }
        $view = new View("User/users-list", "back");
        $view->assign("users", $allUsers);
        $view->assign("errors", $errors);
        $view->assign("success", $success);
        $view->render();
    }

    public function addUser(): void {
        $form = new Form("AddUser");
        $user = new UserModel();
        $userSecurity = new UserSecurity();
        $errors = [];
        $success = [];
        $formattedDate = date('d/m/Y H:i:s');

        if (isset($_GET['id']) && $_GET['id']) {
            $userId = $_GET['id'];
            $selectedUser = $user->getOneBy(["id"=>$userId], 'object');
            if ($selectedUser) {
                $form->setField('firstname', $selectedUser->getFirstname());
                $form->setField('lastname', $selectedUser->getLastname());
                $form->setField('email', $selectedUser->getEmail());
                $form->setField('role', $selectedUser->getRole());
            } else {
                echo "Projet non trouvé.";
            }
        }

        if( $form->isSubmitted() && $form->isValid() )
        {
            if ($user->emailExists($_POST["email"]) && !isset($_GET['id'])) {
                $errors[] = "L'email est déjà utilisé par un autre compte.";
            } else {
                if(isset($_GET['id']) && $_GET['id']){
                    $user->setId($selectedUser->getId());
                    $user->setModificationDate($formattedDate);
                    $user->setCreationDate($selectedUser->getCreationDate());
                } else {
                    $user->setModificationDate($formattedDate);
                    $user->setCreationDate($formattedDate);
                }
                $user->setLastname($_POST["lastname"]);
                $user->setFirstname($_POST["firstname"]);
                $user->setEmail($_POST["email"]);
                $user->setRole($_POST["role"]);
                $user->setStatus(0);
                $resetToken = bin2hex(random_bytes(50));
                $expires = new \DateTime('+1 hour');

                $expiresTimestamp = $expires->getTimestamp();
                $expiresDateTime = date('Y-m-d H:i:s', $expiresTimestamp);
                $activationToken = bin2hex(random_bytes(16));
                $user->setActivationToken($activationToken);
                $user->setResetToken($resetToken);
                $user->setResetExpires($expiresDateTime);
                $user->save();
                $emailResult = $userSecurity->sendCreateAccount($user->getEmail(), $resetToken);

                if (isset($emailResult['success'])) {
                    $success[] = $emailResult['success'];
                } elseif (isset($emailResult['error'])) {
                    $errors[] = $emailResult['error'];
                }

                header("Location: /dashboard/users?message=success");
                exit; 
            }
        }
        $view = new View("User/add-user", "back");
        $view->assign("form", $form->build());
        $view->assign("errorsForm", $errors);
        $view->render();
    }


    public function editUser(): void {
        $userId = 
        $user = new UserModel();
        $errors = [];
        $success = [];

        $userSerialized = null;
        if (isset($_SESSION['user'])) {
            $userSerialized = unserialize($_SESSION['user']);
        }

        if (!$userSerialized) {
            $errors[] = "Utilisateur non trouvé.";
        }

        $form = new Form("EditUser");
        $form->setField('firstname', $userSerialized->getFirstname());
        $form->setField('lastname', $userSerialized->getLastname());
        $form->setField('email', $userSerialized->getEmail());
        
        if( $form->isSubmitted() && $form->isValid() )
        {
            $formattedDate = date('d/m/Y H:i:s');
            $user->setLastname($_POST["lastname"]);
            $user->setFirstname($_POST["firstname"]);
            $user->setEmail($_POST["email"]);
            // $user->setRole($_POST["role"]);
            $user->setModificationDate($formattedDate);
            $user->setStatus(0);
            $user->setCreationDate($userSerialized->getCreationDate());
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

    
    public function showUser($slug): void
    {
        $slugParts = explode('/', $slug);
        $slug = end($slugParts);
        $db = new UserModel();
        $slugTrim = str_replace('/', '', $slug);
        $arraySlug = ["slug" => $slugTrim];
        $user = $db->getOneBy($arraySlug);
        $requestUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        if (!empty($user)) {          
            $routeFound = false;
            if ('/profiles/'.$slug === $requestUrl) {
                $routeFound = true;
            }

            if ($routeFound) {
                $view = new View("Main/user", "front");
                $view->assign("user", $user);
                $view->render(); 
            }
        } else if($requestUrl === '/profiles' || $requestUrl === '/profiles//') {
            $users = $db->getAllData();      
            $view = new View("Main/users", "front");
            $view->assign("users", $users);
            $view->render();
        }else {
            header("Status 404 Not Found", true, 404);
            $error = new Error();
            $error->page404();
        }
    }
}
