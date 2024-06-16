<section>

    <header>
        <h3>Nouveau mot de passe</h3>
    </header>

    <article>
        <?php
         echo $form;

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
    </article>
</section>