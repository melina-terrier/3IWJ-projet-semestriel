<?php
use App\Models\Setting;
$setting = new Setting();
if ($setting) {
    $title = $setting->getOneBy(['key' => "title"]) ?? '';
}
?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?= $title['value'] ?></title>
        <meta name="description" content="Dashboard du CMS">

        <link rel="stylesheet" href="../Assets/Style/dist/css/style.css">
        <script type="text/javascript" src="../Assets/Style/dist/js/main.js"></script>

        <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="https://cdn.tiny.cloud/1/stqcjxqqgksnn9nkz2g0l1zda7dcsz9o5smv1jpbkbydtlis/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>

        <script src="https://kit.fontawesome.com/cd44d84840.js" crossorigin="anonymous"></script>
        
    </head>
    <body>        
        <header id="header" class="back-office-header">
            <h1><?= $title['value'] ?></h1>
            <nav>
                <ul>
                    <li><a href="/dashboard/profile">Mon profil</a></li>
                    <li><a href="/logout" title="Se déconnecter"><i class="fa-solid fa-arrow-right-from-bracket"></i></a></li>

                </ul>
            </div>
        </nav>
    </header>
   
    <main>
    <aside class="sidebar">
    <ul>
        <li class="menu-item active">
            <a href="/dashboard"><i class="fas fa-home"></i> Accueil</a>
        </li>
        <li class="menu-item">
            <a href="#"><i class="fas fa-file-alt"></i> Pages</a>
            <ul class="submenu">
                <li><a href="/dashboard/pages">Toutes les pages</a></li>
                <li><a href="/dashboard/add-page">Ajouter une page</a></li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="#"><i class="fas fa-project-diagram"></i> Projets</a>
            <ul class="submenu">
                <li><a href="/dashboard/projects">Tous les projets</a></li>
                <li><a href="/dashboard/add-project">Ajouter un projet</a></li>
                <li><a href="/dashboard/categories">Catégories</a></li>
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
                <li><a href="/dashboard/add-user">Ajouter un utilisateur</a></li>
                <li><a href="/dashboard/edit-user">Mon profil</a></li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="/dashboard/comments"><i class="fas fa-comments"></i> Commentaires</a>
            <ul class="submenu">
                <li><a href="/dashboard/comments">Tous les Commentaires</a></li>
                <li><a href="/dashboard/add-coment">Ajouter un commentaire</a></li>
                
            </ul>
        </li>
        <li class="menu-item">
            <a href="/dashboard/settings"><i class="fas fa-cog"></i> Paramètres</a>
        </li>
    </ul>
</aside>

<<<<<<< HEAD
            <nav>
                <ul>
                    <li><a href="/dashboard">Accueil</a></li>
                    <li><a href="#">Pages</a>
                        <ul>
                            <li><a href="/dashboard/pages">Toutes les pages </a></li>
                            <li><a href="/dashboard/add-page">Ajouter une page</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Projets</a>
                        <ul>
                            <li><a href="/dashboard/projects">Tous les projets </a></li>
                            <li><a href="/dashboard/add-project">Ajouter un projet</a></li>
                            <li><a href="/dashboard/tags">Catégories</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Médias</a>
                        <ul>
                            <li><a href="/dashboard/medias">Médiathèque </a></li>
                            <li><a href="/dashboard/add-media">Ajouter un média</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Utilisateurs</a>
                        <ul>
                            <li><a href="/dashboard/users">Tous les utilisateurs</a></li>
                            <li><a href="/dashboard/add-user">Ajouter un utilisateur</a></li>
                            <li><a href="/dashboard/profile">Mon profil</a></li>
                        </ul>
                    </li>
                    <li><a href="/dashboard/comments">Commentaires</a>
                    </li>
                    <li><a href="#">Paramètres</a>
                        <ul>
                        <li><a href="/dashboard/settings">Paramêtres généraux</a></li>
                            <li><a href="/dashboard/menu">Menus </a></li>
                            <li><a href="/dashboard/appearance">Apparence</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </header>
=======
>>>>>>> dev

        <?php include "../Views/".$this->view.".php";?>
    </main>

    <script>
        window.addEventListener("scroll", function () {
            console.log(window.scrollY);
            const header = document.getElementById("header");
            if (window.scrollY > 0) {
                header.classList.add("sticky");
            } else {
                header.classList.remove("sticky");
            }
        });
    </script>
</body>
</html>
