<h1>Menu du site</h1>

<?= $form ?>

<?php if (!empty($errors)): ?>
        <div>
            <?php foreach ($errors as $error): ?>
                <p class="text"><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>