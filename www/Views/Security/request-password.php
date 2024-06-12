<section>
    <header>
        <h3>Réinitialiser votre mot de passe</h3>
        <p>Saisissez votre adresse e-mail ci-dessous pour récupérer votre mot de passe</p>
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

    <footer>
        <a href="/login">Retour à la connexion</a>
    </footer>
</section>