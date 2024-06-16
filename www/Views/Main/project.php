<?= $title ?>
<?= '<br>'.$tagName  ?>
<?= $content ?>

<?php 
foreach ($comments as $comment){
    echo '<p>'.$comment["name"].'</p>
        <p>'.$comment["comment"].'<p>';
}
?>
<h2>Ecrire un commentaire</h2>
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

<?php

?>