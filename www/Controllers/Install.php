<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\Form;
use App\Models\User;
use App\Models\Role as RoleModel;
use App\Controllers\Security;
use App\Models\Setting;

use PDO;
use PDOException;

class Install
{
    public function install()
    {
        $form = new Form("Installer");
        $security = new Security();
        $errors = [];
        $success = [];

        if( $form->isSubmitted() && $form->isValid() ) {
            $siteTitle = $_POST['site_title']; 
            $firstname = $_POST['firstname']; 
            $lastname = $_POST['lastname']; 
            $email = $_POST['email']; 
            $password = $_POST['password']; 
            $passwordConfirm = $_POST['passwordConfirm']; 
            $dbname = $_POST['dbname'];
            $dbhost = $_POST['dbhost']; 
            $dbuser = $_POST['dbuser']; 
            $dbpassword = $_POST['dbpwd']; 
            $tablePrefix = $_POST['table_prefix']; 

            $configContent = "<?php\n";
            $configContent .= "// Configuration de la base de données\n";
            $configContent .= "define('DB_HOST', '" . addslashes($dbhost) . "');\n";
            $configContent .= "define('DB_PORT', '5432');\n";
            $configContent .= "define('DB_NAME', '" . addslashes($dbname) . "');\n";
            $configContent .= "define('DB_USER', '" . addslashes($dbuser) . "');\n";
            $configContent .= "define('DB_PASSWORD', '" . addslashes($dbpassword) . "');\n";
            $configContent .= "define('TABLE_PREFIX', '" . addslashes($tablePrefix) . "');\n";

            $myfile = fopen("../config.php", "w");
            fwrite($myfile, $configContent);
            fclose($myfile);
            $envPath = '../.env';

            $envContent = "POSTGRES_USER={$dbuser}\n";
            $envContent .= "POSTGRES_PASSWORD={$dbpassword}\n";
            $envContent .= "POSTGRES_DB={$dbname}\n";

            $myenv = fopen("../.env", "w");
            fwrite($myenv, $envContent);
            fclose($myenv);

            try {
                $pdo = new PDO("pgsql:host=$dbhost;dbname=$dbname;port=5432;user=$dbuser;password=$dbpassword");
                $bddPath = '../Script.sql';
                $sqlScript = file_get_contents($bddPath);
                $sqlScript = str_replace("{prefix}", $tablePrefix, $sqlScript);
                $sqlStatements = explode(";", $sqlScript);

                foreach ($sqlStatements as $statement) {
                    $trimmedStatement = trim($statement);
                    if ($trimmedStatement) {
                        $stmt = $pdo->prepare($trimmedStatement);
                        $stmt->execute();
                    }
                }
            } catch (PDOException $e) {
                echo('Erreur lors de l\'exécution du script SQL ou de la connexion à la base de données : ' . $e->getMessage());
            }

            $user = new User();
            $formattedDate = date('Y-m-d H:i:s');
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setEmail($email);
            $user->setPassword($password);
            $roleModel = new RoleModel();
            $role = $roleModel->getOneBy(['role' => 'Administrateur'], 'object');
            $roleId = $role->getId();
            $user->setRole($roleId);
            $user->setCreationDate($formattedDate);
            $user->setModificationDate($formattedDate);  
            $user->setStatus(1);
            $user->setSlug();
            $activationToken = bin2hex(random_bytes(16));
            $user->setActivationToken($activationToken);
            $emailResult = $security->sendActivationEmail($user->getEmail(), $activationToken);
            $user->save();

            $setting = new Setting();
            $setting->setTitle($siteTitle);
            $setting->setCreationDate($formattedDate);
            $setting->setModificationDate($formattedDate);  
            $setting->save();
            
            header('Location: /dashboard');
        }
        $view = new View("Installer/install", "front");
        $view->assign("form", $form->build());
        $view->assign("errors", $errors);
        $view->assign("successes", $success);
        $view->render();
    }

}