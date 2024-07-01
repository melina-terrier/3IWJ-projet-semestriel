<section class="installer">
    <h1>Installation</h1>
    <p>Pour commencer à utiliser votre CMS, veuillez compléter les champs ci-dessous. Cette étape cruciale permet de créer un administrateur principal et de configurer la base de données qui hébergera votre contenu.</p>
    <?php echo $form;

    if ($errors) {
        echo "<ul class='errors'>"; 
        foreach ($errors as $error){
            echo "<li class='error'>$error</li>";
        }
        echo "</ul>";
    } else if ($successes) {
        echo "<ul class='successes'>"; 
        foreach ($successes as $success){
            echo "<li class='success'>$success</li>";
        }
        echo "</ul>";
    }
    ?>
</section>