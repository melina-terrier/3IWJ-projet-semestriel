<h3>Modifier utilisateur</h3>

<section>

<?php
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
    
    <p>Modifier le mot de passe </p>
    <?php echo $form ?>
</section>
