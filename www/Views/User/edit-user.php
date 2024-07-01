<section>
    <h1>Modifier utilisateur</h1>

    <?php echo $form ?>

    
    <footer class="edit-footer">
        <a href="/profile/edit-password?id=<?php echo $userId; ?>" class="secondary-button">Modifier mon mot de passe</a>
        <a href="/profile/edit?action=delete" class="red--secondary-button secondary-button">Supprimer mon compte</a>
    </footer>

</section>