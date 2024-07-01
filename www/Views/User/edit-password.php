<h3>Modifier utilisateur</h3>
<section>
    <h4>Informations de l'utilisateur</h4>
    <?php echo $form ?>
</section>

<footer>
    <a href="/profile/edit-password?id=<?php echo $userId; ?>">Modifier mon mot de passe</a>
    <a href="/profile/edit?action=delete">Supprimer mon compte</a>
</footer>