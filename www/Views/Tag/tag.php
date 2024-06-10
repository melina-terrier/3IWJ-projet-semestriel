<section class="add-tag">
        <h2>Ajouter une catégorie</h2>
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