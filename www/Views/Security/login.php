<section>

    <h1>Connexion</h1>

    <article>
        <?php

            echo $form;

            if($successes){
                echo "<ul>"; 
                foreach ($successes as $success){
                    echo "<li>".htmlentities($success)."</li>";
                }
                echo "</ul>";
            }

            if ($errors) {
                echo "<ul>"; 
                foreach ($errors as $error){
                    echo "<li>".htmlentities($error)."</li>";
                }
                echo "</ul>";
            } 
        ?>
        
        <a href="/request-password">Mot de passe oublié ?</a>
    
    </article>
        
    <footer>
        <p>Vous êtes un nouvel utilisateur ?</p>
        <a href="/register" class="secondary-button">Créez un compte</a>
    </footer>

</section>