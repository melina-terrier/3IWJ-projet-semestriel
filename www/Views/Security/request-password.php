<section>

    <header>
        <h1>Réinitialiser votre mot de passe</h1>
        <p>Saisissez votre adresse e-mail ci-dessous pour récupérer votre mot de passe</p>
    </header>

    <?php 
    echo $form;

    if ($errors) {
        echo "<ul class='errors'>"; 
        foreach ($errors as $error){
            echo "<li class='error'>".htmlentities($error)."</li>";
        }
        echo "</ul>";
    }
    ?>

    <footer>
        <a href="/login" class="primary-button">Retour à la connexion</a>
    </footer>

</section>