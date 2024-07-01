   
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <meta name="description" content="Dashboard du CMS">
    <link rel="stylesheet" href="/Assets/Style/dist/css/main.css">
    <script type="text/javascript" src="/Assets/Style/dist/js/main.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.tiny.cloud/1/stqcjxqqgksnn9nkz2g0l1zda7dcsz9o5smv1jpbkbydtlis/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>


<body>
    <header id="header" class="back-office-header">
        <nav id="site-menu"></nav>
        <form action="/search" method="post">
            <label for="search-bar">Rechercher : </label>
            <input type="search" id="search-bar" name="search-term">
            <button type="submit" id="search">Rechercher</button>
        </form>
    </header>
   
    <main>
    <aside class="sidebar">
            <ul>
                <li class="menu-item active">
                    <a href="/"><i class="fas fa-home"></i> Accueil</a>
                </li>
                <li class="menu-item">
                    <a href="#"><i class="fas fa-file-alt"></i> Nos Utilisateurs</a>
                    <ul class="submenu">
                        <li><a href="/profiles">Tous les profils</a></li>
                    </ul>
                </li>
                <li class="menu-item">
                    <a href="/projects"><i class="fas fa-project-diagram"></i> Projets</a>
                    <ul class="submenu">
                        <li><a href="/projects">Tous les projets</a></li>
                    </ul>
                </li>
                <li class="menu-item">
                    <a href="/register">
                        <img src="Assets/Style/images/register.jpg" alt="Register Icon" style="width: 20px; height: 20px;"> Register
                    </a>
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