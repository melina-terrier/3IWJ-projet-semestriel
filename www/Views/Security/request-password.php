<section>
    <header>
        <h1>Réinitialiser votre mot de passe</h1>
        <p>Saisissez votre adresse e-mail ci-dessous pour récupérer votre mot de passe</p>
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
        }
        ?>
    </article>

    <footer>
        <a href="/login">Retour à la connexion</a>
    </footer>
</section>