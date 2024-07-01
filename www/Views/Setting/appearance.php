<section>
    <h1>Menu du site</h1>
    <?= $form ?>
    <?php if (!empty($errors)): ?>
            <ul class="errors">
                <?php foreach ($errors as $error): ?>
                    <li class="error"><?php echo htmlentities($error); ?></li>
                <?php endforeach; ?>
            </ul>
    <?php endif; ?>
</section>