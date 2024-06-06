<?php
namespace App\Controllers;
use App\Core\Form;
use App\Core\View;
use App\Models\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class Security{

    public function login(): void
    {
        session_start();
        $form = new Form("Login");
        $errorsLogin = [];
        $successLogin = [];
       
        if( $form->isSubmitted() && $form->isValid() )
        {
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $userModel = new User();
            $user = $userModel->checkUserCredentials($email, $password);
            if ($user) {
                $userSerialized = serialize($user);
                $_SESSION['user'] = $userSerialized; 
                header("Location: /dashboard");
                exit();
            } else {
                $errorsLogin[] = 'Email ou mot de passe incorrect';
            }
        }
        $view = new View("Security/login", "front");
        $view->assign("form", $form->build());
        $view->assign("errorsForm", $errorsLogin);
        $view->assign("successForm", $successLogin);
        $view->render();
    }
   

    public function logout(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
            session_start();
            $_SESSION = array();
            session_destroy();
            header("Location: /login");
            exit();
        }
    }

    public function register(): void
    {
        $form = new Form("Register");
        $errors = [];
        $success = [];

        if( $form->isSubmitted() && $form->isValid() )
        {
            $user = new User();
            $formattedDate = date('Y-m-d H:i:s');
            if ($user->emailExists($_POST["email"])) {
                $errors[] = "L'email est déjà utilisé par un autre compte.";
            } else {
                $user->setLastname($_POST["lastname"]);
                $user->setFirstname($_POST["firstname"]);
                $user->setEmail($_POST["email"]);

                $user->setpassword($_POST["password"]);

                $user->setCreationDate($formattedDate);
                $user->setModificationDate($formattedDate);  
                $user->setModificationDate($formattedDate); 
                $user->setStatus(0);
                $activationToken = bin2hex(random_bytes(16));
                $user->setActivationToken($activationToken);
                $user->save();
                $success[] = "Votre compte a bien été créé";
                $emailResult = $this->sendActivationEmail($user->getEmail(), $activationToken);

                if (isset($emailResult['success'])) {
                    $success[] = $emailResult['success'];
                } elseif (isset($emailResult['error'])) {
                    $errors[] = $emailResult['error'];
                }

                header("Location: /register?message=checkmail");
                exit; 

            }
        }
        $view = new View("Security/register", "front");
        $view->assign("form", $form->build());
        $view->assign("errorsForm", $errors);
        $view->assign("successForm", $success);
        $view->render();
    }

    public function requestPassword(): void {
        $form = new Form("RequestPassword");
        $errors = [];
        $success = [];

        if( $form->isSubmitted() && $form->isValid() ) {
            $email = $_REQUEST['email'];
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

                // Envoyer l'email de réinitialisation
                $emailResult = $this->sendResetEmail($email, $resetToken);

                if (isset($emailResult['success'])) {
                    $success[] = $emailResult['success'];
                } elseif (isset($emailResult['error'])) {
                    $errors[] = $emailResult['error'];
                }
            } else {
                $errors[] = 'Cet email n\'est pas associé à un compte existant.';
            }
        }
        $view = new View("Security/request-password", "front");
        $view->assign("form", $form->build());
        $view->assign("errorsForm", $errors);
        $view->assign("successForm", $success);
        $view->render();
    }

    private function sendResetEmail($email, $resetToken) {
        $phpmailer = new PHPMailer(); 
        try {

            $phpmailer->isSMTP();
            $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
            $phpmailer->SMTPAuth = true;
            $phpmailer->Port = 2525;
            $phpmailer->Username = '634e887ab334e4';
            $phpmailer->Password = '24453e62a4f0b3';
            $phpmailer->setFrom('melina.terrier@gmail.com', 'Support cms');
            $phpmailer->addAddress($email);
            $phpmailer->Subject = 'Recuperation du mot de passe';

            $resetLink = "http://localhost/reset-password?token=" . $resetToken;
            $phpmailer->Body = 'Cliquez sur ce lien pour réinitialiser votre mot de passe: ' . $resetLink;
            $phpmailer->send();
            return ['success' => 'Le lien de recuperation de mot de passe a été envoyé par mail.'];
        } catch (Exception $e) {
            return ['error' => "Le lien n'a pas pu être envoyé. Mailer Error: {$phpmailer->ErrorInfo}"];
        }
    }

    private function sendActivationEmail($email, $activationToken) {
        $phpmailer = new PHPMailer(true); 
        try {
            $phpmailer->isSMTP();
            $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
            $phpmailer->SMTPAuth = true;
            $phpmailer->Port = 2525;
            $phpmailer->Username = '634e887ab334e4';
            $phpmailer->Password = '24453e62a4f0b3';
            $phpmailer->setFrom('melina.terrier@gmail.com', 'Support cms');
            $phpmailer->addAddress($email);
            $phpmailer->Subject = 'Activation de votre compte cms';

            $activationLink = "http://localhost/activate-account?token=" . $activationToken;
            $phpmailer->Body = 'Veuillez cliquer sur ce lien pour activer votre compte: ' . $activationLink;

            $phpmailer->send();
            return ['success' => 'Le lien de recuperation de mot de passe a été envoyé par mail.'];
        } catch (Exception $e) {
            return ['error' => "Le lien n'a pas pu être envoyé. Mailer Error: {$phpmailer->ErrorInfo}"];
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
            $token = $_REQUEST['token'] ?? '';
            if (empty($token)) {
                $errors[] = "Le token de réinitialisation est manquant.";
            } else {
                $userModel = new User();
                $user = $userModel->getOneBy(['reset_token' => $token]);
                if (!$user || strtotime($user['reset_expires']) < time()) {
                    $errors[] = "Le token de réinitialisation est invalide ou a expiré.";
                } else {
                    $pwd = $_POST['password'];
                    $userModel->setDataFromArray($user);
                    $userModel->setPassword($pwd);
                    $userModel->setResetToken(null);
                    $userModel->setResetExpires(null);
                    $userModel->save();
                    $success[] = "Votre mot de passe a été réinitialisé avec succès.";
                }
            }
        }
        $view = new View("Security/reset-password", "front");
        $view->assign("form", $form->build());
        $view->assign("errorsForm", $errors);
        $view->assign("successForm", $success);
        $view->render();
    }

    public function activateAccount()
    {
        $token = $_GET['token'] ?? '';
        $errors = [];
        $success = [];
        if (empty($token)) {
            $errors[] = "Le token d'activation est manquant.";
            return;
        }
        $user = new User();
        $userModel = $user->getOneBy(['activation_token' => $token]);
        $user->setDataFromArray($userModel);
        if ($user) {
            $user->setStatus(1);
            $user->setActivationToken(null);
            $user->save();
            $success[] = "Votre compte a été activé avec succès.";
        } else {
            $errors[] = "Le token d'activation est invalide.";
        }
        $view = new View("Security/activate-account", "front"); 
        $view->assign("errors", $errors);
        $view->assign("success", $success);
        $view->render();
    }
}