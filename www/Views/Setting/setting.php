<section  class="add-element">

    <h1>Paramêtres du site</h1>
    
    <?= $form ?>
    
    <?php if (!empty($errors)): ?>
        <ul class="errors">
            <?php foreach ($errors as $error): ?>
                <li class="error"><?php htmlentities($error); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

</section>