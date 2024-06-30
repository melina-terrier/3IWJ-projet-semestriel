<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <meta name="description" content="Dashboard du CMS">
    <link rel="stylesheet" href="../Assets/Style/dist/main.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.tiny.cloud/1/stqcjxqqgksnn9nkz2g0l1zda7dcsz9o5smv1jpbkbydtlis/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header id="header" class="back-office-header">
        <nav>
            <div class="right-nav">
                <ul>
                    <li>
                        <div class="notification-icon">
                            <i class="fa fa-bell"></i>
                            <span id="notification-count" class="notification-count"></span>
                            <div id="notification-list" class="notification-list"></div>
                        </div>
                    </li>
                    <li><a href="/logout"><i class="fas fa-sign-out-alt"></i></a></li>
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
