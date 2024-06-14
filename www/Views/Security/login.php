
<section>
    <header>
        <h1>Connexion</h1>
    </header>

    <article>
        <?php

            if($successes){
                echo "<ul>"; 
                foreach ($successes as $success){
                    echo "<li>$success</li>";
                }
                echo "</ul>";
            }

            echo $form;

            if ($errors) {
                echo "<ul>"; 
                foreach ($errors as $error){
                    echo "<li>$error</li>";
                }
                echo "</ul>";
            } 

        ?>
        <a href="/request-password">Mot de passe oublié ?</a>
        </article>
        
    <footer>
        <p>Vous êtes un nouvel utilisateur ?</p>
        <a href="/register">Créez un compte</a>
    </footer>

</section>