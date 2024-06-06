<section>
    <h3>Récupération de Mot de Passe</h3>
    <p class="text">Entrez votre e-mail et nous allons vous envoyer un lien pour récupérer votre compte</p>
    <?= $form ?>
    <p class="text">Vous avez déjà un compte ? <a href="/login">Connectez-vous</a></p>
</section>

<?php if (!empty($errors)): ?>
    <div class="error">
        <?php foreach ($errors as $error): ?>
            <p class="text"><?php echo htmlspecialchars($error); ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="success">
        <?php foreach ($success as $message): ?>
            <p class="text"><?php echo htmlspecialchars($message); ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>