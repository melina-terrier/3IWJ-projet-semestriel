<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8">
        <title>dashboard</title>
        <meta name="description" content="Dashboard du CMS">

        <link rel="stylesheet" href="Assets/Style/dist/main.css">
        <!-- <link rel="stylesheet" href="Assets/Style/dist/css/style.css"> -->
        <script type="text/javascript" src="Assets/Style/dist/js/main.js"></script>


        <link rel="stylesheet" href="../Assets/Style/dist/css/style.css">
        <script type="text/javascript" src="../Assets/Style/dist/js/main.js"></script>


        <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="https://cdn.tiny.cloud/1/stqcjxqqgksnn9nkz2g0l1zda7dcsz9o5smv1jpbkbydtlis/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
        
    </head>

    <body> 
        
    <header>
    <nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.php">
            <span class="align-middle">Onligne</span>
        </a>
        <a class="sidebar-brand" href="index.php">
            <img src="img/avatars/logo.png" style="border-color:#F50615;" border='1' width="140px" height="70px" alt="Icône" class="icone-image" style="text-align: center;">
        </a>
        <ul class="sidebar-nav">
            <li class="sidebar-item active">
                <a class="sidebar-link" href="/dashboard">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="/dashboard/pages">
                    <i class="align-middle" data-feather="file-text"></i> <span class="align-middle">Pages</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="/dashboard/projects">
                    <i class="align-middle" data-feather="briefcase"></i> <span class="align-middle">Projets</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="/dashboard/medias">
                    <i class="align-middle" data-feather="image"></i> <span class="align-middle">Médias</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="/dashboard/users">
                    <i class="align-middle" data-feather="users"></i> <span class="align-middle">Utilisateurs</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="/dashboard/comments">
                    <i class="align-middle" data-feather="message-square"></i> <span class="align-middle">Commentaires</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="/dashboard/settings">
                    <i class="align-middle" data-feather="settings"></i> <span class="align-middle">Paramètres</span>
                </a>
            </li>
        </ul>
    </div>
</nav>

    <body>        
        <header id="header" class="back-office-header">

            <nav>
                <ul>
                    <li><a href="">Mes notifications</a></li>
                    <li><a href="/dashboard/profile">Mon profil</a></li>
                    <li><a href="/logout">Se déconnecter</a></li>
                </ul>
            </nav>

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
                    <li><a href="/dashboard/settings">Paramètres</a></li>
                </ul>
            </nav>
        </header>


</header>

        <main style="margin-left: 250px; padding: 1rem;">
            <?php include "../Views/".$this->view.".php";?>
        </main>

    </body>
</html>