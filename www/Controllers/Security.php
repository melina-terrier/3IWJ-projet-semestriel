<?php
namespace App\Controllers;
use App\Core\Form;
use App\Core\View;
use App\Models\User;
use App\Models\Role;
use App\Models\Setting;
use App\Core\SecurityCore;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class Security{

    public function login(): void
    {
        $form = new Form('Login');
        $security = new SecurityCore();
        $errors = [];
        $success = [];
        
        $token = $_GET['token'] ?? '';
        if (!empty($token)) {
            $user = new User();
            $userModel = $user->getOneBy(['activation_token' => $token]);
            if ($userModel) {
                if ($userModel->getStatus() === 0) {
                    $user->setDataFromArray($userModel);
                    $user->setStatus(1);
                    $user->setActivationToken(null);
                    if ($user->save()){
                        $success[] = 'Votre compte a été activé avec succès. Vous pouvez désormais vous connecter.';
                    } else {
                        $errors[] = 'Une erreur est survenue. Veuillez réessayer.';
                    }
                } else {
                    $errors[] = 'Votre compte est déjà activé. Veuillez vous connecter.';
                }
            } else {
                $errors[] = 'Le lien d\'activation de votre compte est invalide. Veuillez réessayer.';
            }
        }

        if ($security->isLogged()) {
            $view = new View('Security/already-login', 'front');
            $view->render();
            return;
        }
        
        if ($form->isSubmitted() && $form->isValid()) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $userModel = new User();
            $user = $userModel->checkUserCredentials($email, $password);
            if ($user) {
                if ($user->getStatus() === 1) {
                    $_SESSION['user_id'] = $user->getId();
                    $roleModel = new Role();
                    $role = $roleModel->getByName('Administrateur');
                    if ($user->getRole() === $role) {
                        header('Location: /dashboard');
                    } else {
                        header('Location: /profiles/' . $user->getSlug());
                    }
                    exit();
                } else {
                    $errors[] = 'Votre compte n\'est pas encore activé. Vérifiez vos emails pour le lien d\'activation.';
                }
            } else {
                $errors[] = 'Identifiants incorrects. Veuillez vérifier votre adresse e-mail et votre mot de passe.';
            }
        }
        $view = new View('Security/login', 'front');
        $view->assign('form', $form->build());
        $view->assign('successes', $success);
        $view->assign('errors', $errors);
        $view->render();
    }

    public function logout(): void
    {
        session_start();
        $_SESSION = array();
        session_destroy();
        header('Location: /login');
        exit();
    }

    public function register(): void
    {
        $form = new Form('Register');
        $roles = new Role();
        $security = new SecurityCore();
        $errors = [];
        $success = [];
        $role = $roles->getByName('Utilisateur');

        if ($security->isLogged()){
            $view = new View('Security/already-login', 'front');
            $view->render();
            return;
        } 

        if( $form->isSubmitted() && $form->isValid() )
        {
            $user = new User();
            
            if ($user->isUnique($_POST['email'])) {
                $errors[] = 'Cette adresse e-mail est déjà utilisée pour un autre compte, essayez de vous connecter ou de vous inscrire avec une autre adresse e-mail.';
            } else {
                $formattedDate = date('Y-m-d H:i:s');
                $activationToken = bin2hex(random_bytes(16));
                $userData = [
                    'firstname' => $_POST['firstname'],
                    'lastname' => $_POST['lastname'],
                    'email' => $_POST['email'],
                    'role' => $_POST['role'],
                    'status' => 0, 
                    'modification_date' => $formattedDate,
                    'password' => $_POST['password'],
                    'slug' => '',
                    'activation_token' => $activationToken,
                ];
                $user->setDataFromArray($userData);
                $emailResult = $this->sendActivationEmail($user->getEmail(), $activationToken);
                if (isset($emailResult['success'])) {
                    $user->save();
                    $success[] = 'Merci pour votre inscription. Avant de pouvoir vous connecter, nous avons besoin que vous activiez votre compte en cliquant sur le lien d\'activation dans l\'email que nous venons de vous envoyer.';
                } elseif (isset($emailResult['error'])) {
                    $errors[] = 'Une erreur est survenu lors de votre inscription : '. $emailResult['error'] .' Merci de réessayer ultérieurement.';
                }
            }
        }
        $view = new View('Security/register', 'front');
        $view->assign('form', $form->build());
        $view->assign('errors', $errors);
        $view->assign('successes', $success);
        $view->render();
    }

    public function requestPassword(): void {
        $form = new Form('RequestPassword');
        $errors = [];
        $success = [];

        if( $form->isSubmitted() && $form->isValid() ) {
            $userModel = new User();
            $userarray = $userModel->getOneBy(['email' =>  $_POST['email']]);
            if ($userarray) {
                $resetToken = bin2hex(random_bytes(50));
                $expires = new \DateTime('+1 hour');
                $expiresDateTime = $expires->format('Y-m-d H:i:s');
                $userModel->setDataFromArray($userarray);
                $userModel->setResetToken($resetToken);
                $userModel->setResetExpires($expiresDateTime);
                if ($user->save()) {
                    $emailResult = $this->sendResetEmail($email, $resetToken);
                    if (isset($emailResult['success'])) {
                        $success[] = $emailResult['success'];
                    } elseif (isset($emailResult['error'])) {
                        $errors[] = $emailResult['error'];
                    }
                } else {
                    $errors[] = 'Une erreur est survenue lors de la demande de réinitialisation du mot de passe.';
                }
            } else {
                $errors[] = 'L\'adresse email fourni n\'est associé à aucun compte.';
            }
        }
        $view = new View('Security/request-password', 'front');
        $view->assign('form', $form->build());
        $view->assign('errors', $errors);

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
            $setting = new Setting();
            $siteSetting = $setting->getOneBy(['key' => 'title']);
            $siteName = '';
            if (!$siteSetting) {
                $siteName = 'FolioPro';
            } else {
                $siteName = $siteSetting['value'];
            }
            $phpmailer->setFrom($siteName.'@gmail.com', $siteName);
            $phpmailer->addAddress($email);
            $phpmailer->Subject = 'Réinitialisation de votre mot de passe';
            $resetLink = 'http://localhost/reset-password?token=' . $resetToken;
            $phpmailer->Body = 'Bonjour,\n\nVous avez demandé la réinitialisation de votre mot de passe pour votre compte sur '.$siteName.'.\n\nCliquez sur le lien suivant pour choisir un nouveau mot de passe:\n\n$resetLink\n\nCe lien est valide pendant 1 heure.\n\nSi vous n\'avez pas demandé la réinitialisation de votre mot de passe, veuillez ignorer cet email.\n\nCordialement,\nL\'équipe de '.$siteName;
            $phpmailer->send();
            return ['success' => 'Un email de réinitialisation de mot de passe a été envoyé à votre adresse e-mail.'];
        } catch (Exception $e) {
            return ['error' => 'Nous n\'avons pas pu envoyer l\'email de réinitialisation de mot de passe à votre adresse e-mail. Merci de réessayer ultérieurement.'];
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
            $setting = new Setting();
            $siteSetting = $setting->getOneBy(['key' => 'title']);
            $siteName = '';
            if (!$siteSetting) {
                $siteName = 'FolioPro';
            } else {
                $siteName = $siteSetting['value'];
            }
            $phpmailer->setFrom($siteName.'@gmail.com', $siteName);
            $phpmailer->addAddress($email);
            $phpmailer->Subject = 'Activez votre compte'.$siteName;
            $activationLink = 'http://localhost/login?token=' . $activationToken;
            $phpmailer->Body = 'Bonjour,\n\nBienvenue sur '.$siteName.'! Nous sommes ravis que vous ayez rejoint notre communauté de créateurs.\n\nPour activer votre compte et commencer à explorer toutes les fonctionnalités de notre plateforme, veuillez cliquer sur le lien suivant:\n\n$activationLink\n\nCordialement,\nL\'équipe de '.$siteName;
            $phpmailer->send();
            return ['success' => 'Le lien d\'activation du compte a été envoyé'];
        } catch (Exception $e) {
            return ['error' => 'nous n\'avons pas pu envoyer l\'email d\'activation à votre adresse e-mail.'];
        }
        
    }

    public function resetPassword(): void
    {
        $form = new Form('ResetPassword');
        $token = $_GET['token'] ?? '';
        $errors = [];
        $success = [];

        if (empty($token)) {
            $errors[] = 'Le lien de réinitialisation de votre mot de passe est invalide. Veuillez réessayer.';
        }

        $userModel = new User();
        $user = $userModel->getOneBy(['reset_token' => $token]);
        if (!$user || strtotime($user['reset_expires']) < time()) {
            $errors[] = 'Le lien de réinitialisation de votre mot de passe est incorrect ou a expiré. Veuillez demander un nouveau lien.';
        }
        
        if( $form->isSubmitted() && $form->isValid() ) {
            $pwd = $_POST['password'];
            $userModel->setDataFromArray($user);
            $userModel->setPassword($pwd);
            $userModel->setResetToken(null);
            $userModel->setResetExpires(null);
            if ($userModel->save()) {
                $success[] = 'Votre mot de passe a été modifié avec succès !';
            } else {
                $errors[] = 'Une erreur est survenue lors de la modification de votre mot de passe. Veuillez réessayer.';
            }
        }
        $view = new View('Security/reset-password', 'front');
        $view->assign('form', $form->build());
        $view->assign('errors', $errors);
        $view->assign('successes', $success);
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
            $setting = new Setting();
            $siteSetting = $setting->getOneBy(['key' => 'title']);
            $siteName = '';
            if (!$siteSetting) {
                $siteName = 'FolioPro';
            } else {
                $siteName = $siteSetting['value'];
            }
            $phpmailer->setFrom($siteName.'@gmail.com', $siteName);
            $phpmailer->addAddress($email);
            $phpmailer->Subject = 'Activation de votre compte';
            $activationLink = 'http://localhost/reset-password?token=' . $activationToken;
            $phpmailer->Body = 'Bonjour,\n\Un compte a été créé pour vous sur '.$siteName.'.\n\nPour finaliser la création de votre compte et commencer à explorer toutes les fonctionnalités de notre plateforme, veuillez cliquer sur le lien suivant:\n\n$activationLink\n\nCordialement,\nL\'équipe de '.$siteName;
            $phpmailer->send();
            return ['success' => 'Le lien d\'activation du compte a été envoyé'];
        } catch (Exception $e) {
            return ['error' => 'Nous n\'avons pas pu envoyer l\'email d\'activation à l\'adresse e-mail.'];
        }
    }
}