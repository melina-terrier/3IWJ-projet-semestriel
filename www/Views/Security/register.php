<section class="connection-box">
    <div class="box-title"><h3>Inscription</h3></div>
    <div class="box-content">
    <?= $form ?>

    <?php foreach ($errorsForm as $error): ?>
        <li><?= $error ?></li>
    <?php endforeach; ?>

    <?php foreach ($successForm as $succes): ?>
        <li><?= $succes ?></li>
    <?php endforeach; ?>
    </div>
</section>