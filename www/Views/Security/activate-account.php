<?php if (!empty($errors)): ?>
    <div class="errors">
        <?php foreach ($errors as $error): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="success">
        <?php foreach ($success as $message): ?>
            <p><?= htmlspecialchars($message) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<p>Pour vous connecter cliquez <a href="/login">ici</a></p>