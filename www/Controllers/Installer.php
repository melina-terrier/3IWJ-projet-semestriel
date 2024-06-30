<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\Form;
use App\Models\User;
use PDO;
use PDOException;
use App\Controllers\Security;

class Installer
{
    public function install()
    {

        $form = new Form("Installer");
        $errors = [];
        $success = [];
        if( $form->isSubmitted() && $form->isValid() ) {
            $adminFirstname = $_POST['firstname'] ?? ''; 
            $adminLastname = $_POST['lastname'] ?? ''; 
            $adminEmail = $_POST['email'] ?? ''; 
            $adminPassword = $_POST['password'] ?? ''; 
            $adminPasswordConfirm = $_POST['passwordConfirm'] ?? ''; 
            $dbname = $_POST['dbname'] ?? ''; 
            $dbuser = $_POST['dbuser'] ?? ''; 
            $dbpassword = $_POST['dbpwd'] ?? ''; 
            // $tablePrefix = $_POST['Prefixe_des_tables'] ?? ''; 

            $configContent = "<?php\n";
            $configContent .= "// Configuration de la base de données\n";
            $configContent .= "define('DB_HOST', 'postgres');\n";
            $configContent .= "define('DB_PORT', '5432');\n";
            $configContent .= "define('DB_NAME', '" . addslashes($dbname) . "');\n";
            $configContent .= "define('DB_USER', '" . addslashes($dbuser) . "');\n";
            $configContent .= "define('DB_PASSWORD', '" . addslashes($dbpassword) . "');\n";
            // $configContent .= "define('TABLE_PREFIX', '" . addslashes($tablePrefix) . "');\n";

            $myfile = fopen("config.php", "w");

            fwrite($myfile, $configContent);

            fclose($myfile);
            $envPath = __DIR__ . '/../.env';

            // Assurez-vous de construire votre contenu de .env ici
            $envContent = "POSTGRES_USER={$dbuser}\n";
            $envContent .= "POSTGRES_PASSWORD={$dbpassword}\n";
            $envContent .= "POSTGRES_DB={$dbname}\n";

            $myenv = fopen(".env", "w");
            fwrite($myenv, $envContent);
            fclose($myenv);


            try {
                $pdo = new \PDO("pgsql:host=postgres;port=5432;dbname=$dbname;user=$dbuser;password=$dbpassword");
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $bddPath = '/../Script.sql';
                $sqlScript = file_get_contents($bddPath);
                $sqlScript = str_replace($sqlScript);
                $sqlStatements = explode(";", $sqlScript);

                foreach ($sqlStatements as $statement) {
                    $trimmedStatement = trim($statement);
                    if ($trimmedStatement) {
                        $stmt = $pdo->prepare($trimmedStatement);
                        $stmt->execute();
                    }
                }
            } catch (PDOException $e) {
                var_dump('Erreur lors de l\'exécution du script SQL ou de la connexion à la base de données : ' . $e->getMessage());
            }

            $user = new User();
            $user->setFirstname($adminFirstname);
            $user->setLastname($adminLastname);
            $user->setEmail($adminEmail);
            $user->setPassword($adminPassword);
            $user->setRoles("admin");
            $user->setIsActive(true);
            $user->save();
            $success[] = "Votre compte a bien été créé";

            header("Location: /");
        }

        $view = new View("Installer/install", "front");
        $view->assign("form", $form->build());
        $view->assign("errorsForm", $errors);
        $view->assign("successForm", $success);
        $view->render();
    }

}