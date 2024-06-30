
<h3 class="edit-header">Modifier utilisateur</h3>
<div class="edit-container">
    <section class="edit-section">
        <h4>Informations de l'utilisateur</h4>
        <?php echo $form ?>
    </section>

    <footer class="edit-footer">
        <a href="/profile/edit-password?id=<?php echo $userId; ?>">Modifier mon mot de passe</a>
        <a href="/profile/edit?action=delete">Supprimer mon compte</a>
    </footer>
    
    <button class="save-button">Sauvegarder les modifications</button>
</div>
