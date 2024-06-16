<section>
    <h3>Installation</h3>
    <p>Pour commencer à utiliser votre CMS, veuillez compléter les champs ci-dessous. Cette étape cruciale permet de créer un administrateur principal et de configurer la base de données qui hébergera votre contenu.</p>
    <?php echo $form;
    if ($errors) {
        echo "<ul>"; 
        foreach ($errors as $error){
            echo "<li>$error</li>";
        }
        echo "</ul>";
    } else if ($successes) {
        echo "<ul>"; 
        foreach ($successes as $success){
            echo "<li>$success</li>";
        }
        echo "</ul>";
    }
    ?>
</section>