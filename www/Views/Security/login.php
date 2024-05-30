<h2>Se connecter</h2>

<?= $form ?>
<<<<<<< HEAD
<?php if ($errorsForm): ?>
    <ul class="error-messages">  <?php foreach ($errorsForm as $errorMessage): ?>
            <li><?= $errorMessage; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if ($successForm): ?>
    <ul class="success-messages">  <?php foreach ($successForm as $successMessage): ?>
            <li><?= $errorMessage; ?></li> <?php endforeach; ?>
    </ul>
<?php endif; ?>

<p class="text">Pas encore de compte ? <a href="/register">Inscrivez-vous</a></p>
<p class="text">Mot de passe oublié ? <a href="/request-password">Cliquez ici</a></p>
=======

<?php

if (isset($_POST['email']) && isset($_POST['password'])) {
    session_start ();
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['password'] = $_POST['password'];
    header ('location: /');
} 

?>
>>>>>>> 831169c (mise en place des formulaires)
