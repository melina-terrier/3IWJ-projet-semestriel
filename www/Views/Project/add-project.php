

<section>
    <h1>Ajouter un nouveau projettt</h1>
    <?= $form ?>

    <?php if (!empty($errorsForm)): ?>
        <div>
            <?php foreach ($errorsForm as $error): ?>
                <p class="text"><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($successForm)): ?>
        <div>
            <?php foreach ($successForm as $message): ?>
                <p class="text"><?php echo htmlspecialchars($message); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</section>


<!-- <section>
    <a href="/dashboard/add-project?action=draft&id=">Enregistrer le brouillon</a>
    <a href="/?action=preview&id=">Prévisualiser</a>
</section> -->