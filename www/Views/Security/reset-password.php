<section>
    <div><h3>Changement du mot de passe</h3></div>
    <div>
        <?= $form ?>
        <p class="text"><a href="/login">Connectez-vous</a></p>
    </div>
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