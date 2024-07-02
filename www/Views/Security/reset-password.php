<section>

    <h1>Nouveau mot de passe</h1>

    <?php
        echo $form;

    if ($errors) {
        echo "<ul class='errors'>"; 
        foreach ($errors as $error){
            echo "<li class='error'>".htmlentities($error)."</li>";
        }
        echo "</ul>";
    } else if ($successes) {
        echo "<ul class='successes'>"; 
        foreach ($successes as $success){
            echo "<li class='success'>".htmlentities($success)."</li>";
        }
        echo "</ul>";
    }
    ?>

</section>