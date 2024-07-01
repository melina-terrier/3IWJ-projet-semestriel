<<<<<<< HEAD
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
        $successe = [];

        if( $form->isSubmitted() && $form->isValid() ) {

            if (file_exists('../config.php') || file_exists('../.env')) {
                $errors[] = 'Le fichier de configuration existe déjà.';
            } else {
                $configContent = '<?php\n';
                $configContent .= '// Configuration de la base de données\n';
                $configContent .= 'define("DB_HOST", '' '.addslashes($_POST['dbhost']).' '');\n';
                $configContent .= 'define("DB_PORT", "5432");\n';
                $configContent .= 'define("DB_NAME", '' '.addslashes($_POST['dbname']).' '');\n';
                $configContent .= 'define("DB_USER", '' '.addslashes($_POST['dbuser']).' '');\n';
                $configContent .= 'define("DB_PASSWORD", '' '.addslashes($_POST['dbpwd']).' '');\n';
                $configContent .= 'define("TABLE_PREFIX", '' '.addslashes($_POST['table_prefix']).' '');\n';
                $myfile = fopen('../config.php', 'w');
                fwrite($myfile, $configContent);
                fclose($myfile);
                $envPath = '../.env';
    
                $envContent = 'POSTGRES_USER='.$_POST['dbuser'].'\n';
                $envContent .= 'POSTGRES_PASSWORD='.$_POST['dbpwd'].'\n';
                $envContent .= 'POSTGRES_DB='.$_POST['dbname'].'\n';
    
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
            }

            if (empty($errors)){
                $user = new User();
                $user->setFirstname($_POST['firstname']);
                $user->setLastname($_POST['lastname']);
                $user->setEmail($_POST['email']);
                $user->setPassword($_POST['password']);
                $roleModel = new Role();
                $role = $roleModel->getByName('Administrateur');
                $user->setRole($role);
                $user->setCreationDate();
                $user->setModificationDate();  
                $user->setStatus(0);
                $user->setSlug();
                $user->setActivationToken();
                $setting = new Setting();
                $setting->setTitle($_POST['site_title']);
                $setting->setCreationDate();
                $setting->setModificationDate();  
            }

            try {
                $emailResult = $security->sendActivationEmail($user->getEmail(), $activationToken);
                $user->save();
                $setting->save();
                $successe[] = 'Installation réussie ! Avant de pouvoir vous connecter, nous avons besoin que vous activiez votre compte en cliquant sur le lien d\'activation dans l\'email que nous venons de vous envoyer. <a href="/login">Se connecter</a>';
            } catch (Exception $e) {
                $errors[] = 'Erreur lors de la création de l\'utilisateur et des paramètres : ' . $e->getMessage();
            }
        }
        $view = new View('Installer/install', 'front');
        $view->assign('form', $form->build());
        $view->assign('errors', $errors);
        $view->assign('successes', $successes);
        $view->render();
    }
}