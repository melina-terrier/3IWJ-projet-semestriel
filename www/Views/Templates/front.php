<?php
use App\Models\Setting;
use App\Models\Menu;
use App\Models\itemMenu;

$setting = new Setting();
if ($setting) {
    $title = $setting->getOneBy(['key' => "title"]) ?? '';
    $description = $setting->getOneBy(['key' => "description"]) ?? '';
    $slogan = $setting->getOneBy(['key' => "slogan"]) ?? '';
    $logo = $setting->getOneBy(['key' => "logo"]) ?? '';
}

$menu = new Menu();
$itemMenu = new itemMenu();
if ($menu){
    $header = $menu->getOneBy(['type'=>'menu-principal']);
    print_r($header);
    if ($header) {
        $position = $header['position'];
        $alignement = $header['alignement'];
        $items = $itemMenu->getAllData(['menu_id'=>$header['id']]);
        print_r($items);
    } 
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?php echo $title['value']; ?></title>
    <meta name="description" content="">
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
        <?php include "../Views/".$this->view.".php";?>
    </main>
</body>

</html>