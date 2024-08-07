<?php
use App\Models\Setting;
use App\Models\Menu;
use App\Models\itemMenu;

if (file_exists('../config.php')) {
    $setting = new Setting();
    if ($setting) {
        $title = $setting->getOneBy(['key' => "title"]) ?? '';
        $description = $setting->getOneBy(['key' => "description"]) ?? '';
        $slogan = $setting->getOneBy(['key' => "slogan"]) ?? '';
        $logo = $setting->getOneBy(['key' => "logo"]) ?? '';
        $lightPrimaryColor = $setting->getOneBy(['key' => "light_primary_color"]) ?? '';
        $lightAccentColor = $setting->getOneBy(['key' => "light_accent_color"]) ?? '';
        $lightSecondaryColor = $setting->getOneBy(['key' => "light_secondary_color"]) ?? '';
        $darkPrimaryColor = $setting->getOneBy(['key' => "dark_primary_color"]) ?? '';
        $darkSecondaryColor = $setting->getOneBy(['key' => "dark_secondary_color"]) ?? '';
        $darkAccentColor = $setting->getOneBy(['key' => "dark_accent_color"]) ?? '';
        $primaryFont = $setting->getOneBy(['key' => "primary_font"]) ?? '';
        $secondaryFont = $setting->getOneBy(['key' => "secundary_font"]) ?? '';
    }

    $menu = new Menu();
    $itemMenu = new itemMenu();
    if (!empty($menu) && is_object($menu)) {
        $header = $menu->getOneBy(['type'=>'menu-principal']);
        if (!empty($header) && isset($header)) {
            $position = $header['position'];
            $alignement = $header['alignement'];
            $items = $itemMenu->getAllData(['menu_id'=>$header['id']]);
            usort($items, function($a, $b) {
                return $a['item_position'] - $b['item_position'];
            });
        } 
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo $title['value']; ?></title>
    <meta name="description" content="">
    <link rel="stylesheet" href="/Style/dist/css/main.css">
    <script type="text/javascript" src="/Style/dist/js/main.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.tiny.cloud/1/stqcjxqqgksnn9nkz2g0l1zda7dcsz9o5smv1jpbkbydtlis/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<style>
<?php if (isset($lightPrimaryColor) && isset($lightSecondaryColor) &&
              isset($darkPrimaryColor) && isset($darkSecondaryColor) &&
              isset($darkAccentColor) && isset($primaryFont) && isset($secondaryFont)) : ?>
    :root {
      --light-primary: <?php echo $lightPrimaryColor; ?>; 
      --light-secondary: <?php echo $lightSecondaryColor; ?>;
      --light-accent: <?php echo $lightAccentColor; ?>;

      --dark-primary: <?php echo $darkPrimaryColor; ?>;
      --dark-secondary: <?php echo $darkSecondaryColor; ?>;
      --dark-accent: <?php echo $darkAccentColor; ?>;
    }
    <?php endif; ?>
</style>



</style>

<body>


    <header id="header" class="back-office-header">
        <?php if (isset($header) && isset($items)) : ?>
        <nav id="site-menu" class="menu-align-<?php echo $alignement; ?> menu-position-<?php echo $position; ?>">
            <?php foreach ($items as $item) : ?>
            <li>
                <a href="<?php echo $item['url']; ?>"><?php echo $item['title']; ?></a>
            </li>
            <?php endforeach; ?>
        </nav>
        <?php endif; ?>

        <form action="/search" method="post">
        <label for="search-bar">Rechercher : </label>
        <input type="search" id="search-bar" name="search-term">
        <button type="submit" id="search">Rechercher</button>
        </form>

        <?php 
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
            echo "<a href='/logout'>Se déconnecter</a>";
        }
        ?>
    </header>
   
   
    <main>   
        <?php include "../Views/".$this->view.".php";?>

        <!-- <script>
        window.addEventListener("scroll", function () {
            console.log(window.scrollY);
            const header = document.getElementById("header");
            if (window.scrollY > 0) {
                header.classList.add("sticky");
            } else {
                header.classList.remove("sticky");
            }
        });
    </script>   -->
    </main>
    
</body>

</html>