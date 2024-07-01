<?php
use App\Models\Setting;
use App\Models\User;

$setting = new Setting();
$title = '';
if ($setting) {
    $titleData = $setting->getOneBy(['key' => "title"]);
    $title = $titleData ? $titleData['value'] : '';
}

$user = new User();
$userId = $user->populate($_SESSION['user_id']);
$userSlug = $userId ? $userId->getSlug() : '';

?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
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
        <h1><?= htmlspecialchars($title) ?></h1>
        <nav>
            <ul>
                <li><a href="<?= htmlspecialchars($userSlug) ?>">Mon profil</a></li>
                <li><a href="/logout" title="Se déconnecter"><i class="fa-solid fa-arrow-right-from-bracket"></i></a></li>
            </ul>
        </nav>
    </header>

    <aside class="sidebar">
        <ul>
            <li class="menu-item active">
                <a href="/dashboard"><i class="fas fa-home"></i> Accueil</a>
            </li>
            <!-- Autres éléments du menu -->
        </ul>
    </aside>

    <main>
        <?php include "../Views/".$this->view.".php";?>
    </main>
    
</body>
</html>
