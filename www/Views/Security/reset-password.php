<section>

    <header>
        <h1>Nouveau mot de passe</h1>
    </header>

    <article>
        <?php
         echo $form;

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
    </article>
</section>