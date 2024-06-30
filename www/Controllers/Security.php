<?php
namespace App\Controllers;

use App\Core\Form;
use App\Core\View;
use App\Models\User;
use App\Models\Role as RoleModel;
use App\Core\Security as CoreSecurity;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class Security{

    public function login(): void
    {
        session_start();
        $form = new Form("Login");
        $errors = [];
        $success = [];
        $security = new CoreSecurity();

        $token = $_GET['token'] ?? '';
        if (!empty($token)) {
            $user = new User();
            $userModel = $user->getOneBy(['activation_token' => $token]);
            if ($userModel) {
                $user->setDataFromArray($userModel);
                $user->setStatus(1);
                $user->setActivationToken(null);
                $user->save();
                $success[] = "Votre compte a été activé avec succès. Vous pouvez désormais vous connecter.";
            } else {
                $errors[] = "Le lien d'activation de votre compte est invalide. Veuillez réessayer.";
            }
        }

        if ($security->isLogged()) {
            $view = new View("Security/already-login", "front");
        } else {
            if ($form->isSubmitted() && $form->isValid()) {
                $email = $_POST['email'];
                $password = $_POST['password'];
                $userModel = new User();
                $user = $userModel->checkUserCredentials($email, $password);
                if ($user) {
                    if ($user->getStatus() === 1) {
                        $userSerialized = serialize($user);
                        $_SESSION['user'] = $userSerialized;
                        $roleModel = new RoleModel();
                        $role = $roleModel->getOneBy(['role' => 'Administrateur'], 'object');
                        $roleId = $role->getId();
                        if ($user->getRole() === $roleId) {
                            header("Location: /dashboard");
                        } else {
                            header("Location: /profiles/" . $user->getSlug());
                        }
                        exit();
                    } else {
                        $errors[] = 'Votre compte n\'est pas encore activé. Vérifiez vos emails pour le lien d\'activation.';
                    }
                } else {
                    $errors[] = 'Identifiants incorrects. Veuillez vérifier votre adresse e-mail et votre mot de passe.';
                }
            }
            $view = new View("Security/login", "front");
        }
        $view->assign("form", $form->build());
        $view->assign("successes", $success);
        $view->assign("errors", $errors);
        $view->render();
    }

    public function logout(): void
    {
        session_start();
        $_SESSION = array();
        session_destroy();
        header("Location: /login");
        exit();
    }

    public function register(): void
    {
        $form = new Form("Register");
        $errors = [];
        $success = [];
        $roles = new RoleModel();
        $role = $roles->getOneBy(['role'=>'Utilisateur'], 'object');
        $roleId = $role->getId();
        $security = new CoreSecurity();
        if ($security->isLogged()){
            $view = new View("Security/already-login", "front");
        } else {
            if( $form->isSubmitted() && $form->isValid() )
            {
                $user = new User();
                $formattedDate = date('Y-m-d H:i:s');
                if ($user->emailExists($_POST["email"])) {
                    $errors[] = "Cette adresse e-mail est déjà utilisée pour un autre compte, essayez de vous connecter ou de vous inscrire avec une autre adresse e-mail.";
                } else {
                    $user->setLastname($_POST["lastname"]);
                    $user->setFirstname($_POST["firstname"]);
                    $user->setEmail($_POST["email"]);
                    $user->setRole($roleId);
                    $user->setPassword($_POST["password"]);
                    $user->setCreationDate($formattedDate);
                    $user->setModificationDate($formattedDate);  
                    $user->setStatus(0);
                    $user->setSlug();
                    $activationToken = bin2hex(random_bytes(16));
                    $user->setActivationToken($activationToken);
                    $emailResult = $this->sendActivationEmail($user->getEmail(), $activationToken);
                    if (isset($emailResult['success'])) {
                        $user->save();
                        $success[] = "Merci pour votre inscription. Avant de pouvoir vous connecter, nous avons besoin que vous activiez votre compte en cliquant sur le lien d'activation dans l'email que nous venons de vous envoyer.";
                    } elseif (isset($emailResult['error'])) {
                        $errors[] = "Une erreur est survenu lors de votre inscription : ". $emailResult['error'] ." Merci de réessayer ultérieurement.";
                    }
                }
            }
            $view = new View("Security/register", "front");
        }
        $view->assign("form", $form->build());
        $view->assign("errors", $errors);
        $view->assign("successes", $success);
        $view->render();
    }

    public function requestPassword(): void {
        $form = new Form("RequestPassword");
        $errors = [];
        $success = [];
        if( $form->isSubmitted() && $form->isValid() ) {
            $email = $_POST['email'];
            $userModel = new User();
            $userarray = $userModel->getOneBy(['email' => $email]);
            if ($userarray) {
                $resetToken = bin2hex(random_bytes(50));
                $expires = new \DateTime('+1 hour');
                $expiresTimestamp = $expires->getTimestamp();
                $expiresDateTime = date('Y-m-d H:i:s', $expiresTimestamp);
                $userModel->setDataFromArray($userarray);
                $userModel->setResetToken($resetToken);
                $userModel->setResetExpires($expiresDateTime);
                $userModel->save();
                $emailResult = $this->sendResetEmail($email, $resetToken);
                if (isset($emailResult['success'])) {
                    $success[] = $emailResult['success'];
                } elseif (isset($emailResult['error'])) {
                    $errors[] = $emailResult['error'];
                }
            } else {
                $errors[] = 'L\'email fourni n\'est associé à aucun compte.';
            }
        }
        $view = new View("Security/request-password", "front");
        $view->assign("form", $form->build());
        $view->assign("errors", $errors);
        $view->assign("successes", $success);
        $view->render();
    }

    private function sendResetEmail($email, $resetToken) {
        $phpmailer = new PHPMailer(true); 
        try {
            $phpmailer->isSMTP();
            $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
            $phpmailer->SMTPAuth = true;
            $phpmailer->Port = 2525;
            $phpmailer->Username = '6ad47fd4dd8185';
            $phpmailer->Password = '077c164d29a4f5';
            $phpmailer->setFrom('azermami8@gmail.com', 'Support cms');
            $phpmailer->addAddress($email);
            $phpmailer->Subject = 'Réinitialisation de votre mot de passe';
            $resetLink = "http://localhost/reset-password?token=" . $resetToken;
            $phpmailer->Body = "Bonjour,\n\nVous avez demandé la réinitialisation de votre mot de passe pour votre compte sur [Nom de votre site web].\n\nCliquez sur le lien suivant pour choisir un nouveau mot de passe:\n\n$resetLink\n\nCe lien est valide pendant 1 heure.\n\nSi vous n'avez pas demandé la réinitialisation de votre mot de passe, veuillez ignorer cet email.\n\nCordialement,\nL'équipe de [Nom de votre site web]";
            $phpmailer->send();
            return ['success' => 'Un email de réinitialisation de mot de passe a été envoyé à votre adresse e-mail.'];
        } catch (Exception $e) {
            return ['error' => "Nous n'avons pas pu envoyer l'email de réinitialisation de mot de passe à votre adresse e-mail. Merci de réessayer ultérieurement."];
        }
    
        
    }
    
    public function sendActivationEmail($email, $activationToken) {
        $phpmailer = new PHPMailer(true); 
        
        try {
            $phpmailer->isSMTP();
            $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
            $phpmailer->SMTPAuth = true;
            $phpmailer->Port = 2525;
            $phpmailer->Username = '6ad47fd4dd8185';
            $phpmailer->Password = '077c164d29a4f5';
            $phpmailer->setFrom('azermami8@gmail.com', 'Support cms');
            $phpmailer->addAddress($email);
            $phpmailer->Subject = 'Activez votre compte [Nom de votre site web]';
            $activationLink = "http://localhost/login?token=" . $activationToken;
            $phpmailer->Body = "Bonjour,\n\nBienvenue sur [Nom de votre site web]! Nous sommes ravis que vous ayez rejoint notre communauté de créateurs.\n\nPour activer votre compte et commencer à explorer toutes les fonctionnalités de notre plateforme, veuillez cliquer sur le lien suivant:\n\n$activationLink\n\nCordialement,\nL'équipe de [Nom de votre site web]";
            $phpmailer->send();
            return ['success' => 'Le lien d\'activation du compte a été envoyé'];
        } catch (Exception $e) {
            return ['error' => "nous n'avons pas pu envoyer l'email d'activation à votre adresse e-mail."];
        }
        
    }

    public function resetPassword(): void
    {
        $form = new Form("ResetPassword");
        $token = $_GET['token'] ?? '';
        $config = $form->setField('token', $token);
        $errors = [];
        $success = [];
        if( $form->isSubmitted() && $form->isValid() ) {
            $token = $_POST['token'] ?? '';
            if (empty($token)) {
                $errors[] = "Le lien de réinitialisation de votre mot de passe est invalide. Veuillez réessayer.";
            } else {
                $userModel = new User();
                $user = $userModel->getOneBy(['reset_token' => $token]);
                if (!$user || strtotime($user['reset_expires']) < time()) {
                    $errors[] = "Le lien de réinitialisation de votre mot de passe est incorrect ou a expiré. Veuillez demander un nouveau lien.";
                } else {
                    $pwd = $_POST['password'];
                    $userModel->setDataFromArray($user);
                    $userModel->setPassword($pwd);
                    $userModel->setResetToken(null);
                    $userModel->setResetExpires(null);
                    $userModel->save();
                    $success[] = "Votre mot de passe a été modifié avec succès !";
                }
            }
        }
        $view = new View("Security/reset-password", "front");
        $view->assign("form", $form->build());
        $view->assign("errors", $errors);
        $view->assign("successes", $success);
        $view->render();
    }

    public function sendCreateAccount($email, $activationToken) {
        $phpmailer = new PHPMailer(true); 
        try {
            $phpmailer->isSMTP();
            $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
            $phpmailer->SMTPAuth = true;
            $phpmailer->Port = 2525;
            $phpmailer->Username = '6ad47fd4dd8185';
            $phpmailer->Password = 'bafabb7c681658';
            $phpmailer->setFrom('azermami8@gmail.com', 'Support cms');
            $phpmailer->addAddress($email);
            $phpmailer->Subject = 'Activation de votre compte';
            $activationLink = "http://localhost/reset-password?token=" . $activationToken;
            $phpmailer->Body = "Bonjour,\n\Un compte a été créé pour vous sur [Nom de votre site web].\n\nPour finaliser la création de votre compte et commencer à explorer toutes les fonctionnalités de notre plateforme, veuillez cliquer sur le lien suivant:\n\n$activationLink\n\nCordialement,\nL'équipe de [Nom de votre site web]";
            $phpmailer->send();
            return ['success' => 'Le lien d\'activation du compte a été envoyé'];
        } catch (Exception $e) {
            return ['error' => "Nous n'avons pas pu envoyer l'email d'activation à l'adresse e-mail."];
        }
    }
}