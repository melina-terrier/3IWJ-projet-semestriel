<section class="add-tag">

        <?php
        if (isset($_GET['id']) && $_GET['id']) {
            echo "<h2>Modifier la catégorie</h2>";
        } else {
            echo "<h2>Ajouter une catégorie</h2>";
        }
        ?>
        
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