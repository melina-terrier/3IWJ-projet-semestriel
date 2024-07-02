<?php
use App\Models\Setting;
$setting = new Setting();
if ($setting) {
    $title = $setting->getOneBy(['key' => "title"]) ?? '';
    $content = $setting->getOneBy(['key' => "content"]) ?? '';
}

use App\Models\User;
$user = new USER();
$userId = $user->populate($_SESSION['user_id']);
$userSlug = $userId->getSlug();

?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?= $title['value'] ?></title>
        <meta name="description" content="<?php echo $content['value'] ?>">
        <link rel="stylesheet" href="./Assets/Style/dist/css/style.css">
        <script type="text/javascript" src="./Assets/Style/dist/js/main.js"></script>
        <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="https://cdn.tiny.cloud/1/stqcjxqqgksnn9nkz2g0l1zda7dcsz9o5smv1jpbkbydtlis/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
        <script src="https://kit.fontawesome.com/cd44d84840.js" crossorigin="anonymous"></script>
        
    </head>
    <body>        
        <header class="bo-header">
            <nav>
                <ul>
                    <li><a href="<?php echo $userSlug ?>">Mon profil</a></li>
                    <li><a href="/logout" title="Se déconnecter"><i class="fa-solid fa-arrow-right-from-bracket"></i></a></li>
                </ul>
            </nav>

            <aside class="sidebar">
                <ul>
                    <li class="menu-item active">
                        <a href="/dashboard"><i class="fas fa-home"></i> Accueil</a>
                    </li>
                    <li class="menu-item">
                        <a href="#"><i class="fas fa-file-alt"></i> Pages</a>
                        <ul class="submenu">
                            <li><a href="/dashboard/pages">Toutes les pages</a></li>
                            <li><a href="/dashboard/page">Ajouter une page</a></li>
                        </ul>
                    </li>
                    <li class="menu-item">
                        <a href="#"><i class="fas fa-project-diagram"></i> Projets</a>
                        <ul class="submenu">
                            <li><a href="/dashboard/projects">Tous les projets</a></li>
                            <li><a href="/dashboard/project">Ajouter un projet</a></li>
                            <li><a href="/dashboard/tags">Catégories</a></li>
                        </ul>
                    </li>
                    <li class="menu-item">
                        <a href="#"><i class="fas fa-images"></i> Médias</a>
                        <ul class="submenu">
                            <li><a href="/dashboard/medias">Médiathèque</a></li>
                            <li><a href="/dashboard/add-media">Ajouter un média</a></li>
                        </ul>
                    </li>
                    <li class="menu-item">
                        <a href="#"><i class="fas fa-users"></i> Utilisateurs</a>
                        <ul class="submenu">
                            <li><a href="/dashboard/users">Tous les utilisateurs</a></li>
                            <li><a href="/dashboard/user">Ajouter un utilisateur</a></li>
                            <li><a href="/dashboard/user?id=<?php echo $_SESSION['user_id'];?>">Modifier mon profil</a></li>
                        </ul>
                    </li>
                    <li class="menu-item">
                        <a href="/dashboard/comments"><i class="fas fa-comments"></i> Commentaires</a>
                        <ul class="submenu">
                            <li><a href="/dashboard/comments">Tous les Commentaires</a></li>
                        </ul>
                    </li>
                    <li class="menu-item">
                        <a href="#"><i class="fas fa-cog"></i> Paramètres</a>
                        <ul class="submenu">
                            <li><a href="/dashboard/settings">Paramêtres généraux</a></li>
                            <li><a href="/dashboard/appearance">Apparence</a></li>
                            <li><a href="/dashboard/menus">Menus</a></li>
                        </ul>
                    </li>
                </ul>
            </aside>
    </header>

    <main>
        <?php include "../Views/".$this->view.".php";?>
    </main>
    
</body>
</html>
