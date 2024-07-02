<section class="user">

    <h1>Modifier utilisateur</h1>

    <?php echo $form;

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
    <footer class="edit-footer">
        <a href="/profile/edit-password?id=<?php echo $userId; ?>" class="secondary-button">Modifier mon mot de passe</a>
        <a href="/profile/edit?action=delete" class="red--secondary-button secondary-button">Supprimer mon compte</a>
    </footer>

</section>