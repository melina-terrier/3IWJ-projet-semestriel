<h2>Se connecter</h2>

<?= $form ?>

<?php

if (isset($_POST['email']) && isset($_POST['password'])) {
    session_start ();
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['password'] = $_POST['password'];
    header ('location: /');
} 

?>
