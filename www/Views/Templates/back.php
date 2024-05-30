<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ceci est mon back</title>
        <meta name="description" content="Super site avec une magnifique intégration">
    </head>
    <body>
        <h1>Template Back</h1>
        
        <header>
            <nav>
                <ul>
                    <li><a href="/dashboard">Dashboard</a></li>
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
                            <li><a href="/dashboard/tags">Catégorie du projet</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Médias</a>
                        <ul>
                            <li><a href="/dashboard/medias">Tout les médias </a></li>
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

        <?php include "../Views/".$this->view.".php";?>
    </body>
</html>