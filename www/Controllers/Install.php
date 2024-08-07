<?php
namespace App\Controllers;
use App\Core\View;
use App\Core\Form;
use App\Models\User;
use App\Models\Role;
use App\Controllers\Security;
use App\Models\Setting;
use PDO;
use PDOException;

class Install
{
    public function install()
    {
        $form = new Form('Installer');
        $security = new Security();
        $errors = [];
        $successes = [];

        if( $form->isSubmitted() && $form->isValid() ) {

            if (file_exists('../config.php') || file_exists('../.env')) {
                $errors[] = 'Le fichier de configuration existe déjà.';
            } else {
                $configContent = "<?php\n";
                $configContent .= "// Configuration de la base de données\n";
                $configContent .= "define('DB_HOST', '".addslashes($_POST['dbhost'])."');\n";
                $configContent .= "define('DB_PORT', '5432');\n";
                $configContent .= "define('DB_NAME', '".addslashes($_POST['dbname'])."');\n";
                $configContent .= "define('DB_USER', '".addslashes($_POST['dbuser'])."');\n";
                $configContent .= "define('DB_PASSWORD', '".addslashes($_POST['dbpwd'])."');\n";
                $configContent .= "define('TABLE_PREFIX', '".addslashes($_POST['table_prefix'])."');\n";
                $myfile = fopen('../config.php', 'w');
                fwrite($myfile, $configContent);
                fclose($myfile);
                $envPath = '../.env';
    
                $envContent = "POSTGRES_USER=".$_POST['dbuser']."\n";
                $envContent .= "POSTGRES_PASSWORD=".$_POST['dbpwd']."\n";
                $envContent .= "POSTGRES_DB=".$_POST['dbname']."\n";
    
                $myenv = fopen('../.env', 'w');
                fwrite($myenv, $envContent);
                fclose($myenv);
            }

            try {
                $pdo = new PDO('pgsql:host='.$_POST['dbhost'].';dbname='.$_POST['dbname'].';port=5432;user='.$_POST['dbuser'].';password='.$_POST['dbpwd']);
                $bddPath = '../Script.sql';
                $sqlScript = file_get_contents($bddPath);
                $sqlScript = str_replace('{prefix}', $_POST['table_prefix'], $sqlScript);
                $sqlStatements = explode(';', $sqlScript);

                foreach ($sqlStatements as $statement) {
                    $trimmedStatement = trim($statement);
                    if ($trimmedStatement) {
                        $stmt = $pdo->prepare($trimmedStatement);
                        $stmt->execute();
                    }
                }
            } catch (PDOException $e) {
                $errors[] = 'Erreur lors de l\'exécution du script SQL ou de la connexion à la base de données : ' . $e->getMessage();
                exit();
            }

            $user = new User();
            $user->setFirstname($_POST['firstname']);
            $user->setLastname($_POST['lastname']);
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['password']);
            $roleModel = new Role();
            $role = $roleModel->getByName('Administrateur');
            $user->setRole($role);
            $user->setStatus(1);
            $user->setSlug();
            $setting = new Setting();
            $setting->setKey('title');
            $setting->setValue($_POST['site_title']);
            $setting->save();
            $activationToken = bin2hex(random_bytes(16));
            $user->setActivationToken($activationToken);
            $emailResult = $security->sendActivationEmail($user->getEmail(), $activationToken);
            if (isset($emailResult['success'])) {
                $user->save();
                $success[] = "Merci pour votre inscription. Avant de pouvoir vous connecter, nous avons besoin que vous activiez votre compte en cliquant sur le lien d'activation dans l'email que nous venons de vous envoyer.";
            } elseif (isset($emailResult['error'])) {
                $errors[] = "Une erreur est survenu lors de votre inscription : ". $emailResult['error'] ." Merci de réessayer ultérieurement.";
            }
        }
        $view = new View('Installer/install', 'front');
        $view->assign('form', $form->build());
        $view->assign('errors', $errors);
        $view->assign('successes', $successes);
        $view->render();
    }
}