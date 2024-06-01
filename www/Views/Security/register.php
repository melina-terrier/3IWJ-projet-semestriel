<?php


$checkMailMessage = isset($_GET['message']) && $_GET['message'] === 'checkmail';
if ($checkMailMessage) {
  echo "<p>Merci pour votre inscription. Avant de pouvoir vous connecter, nous avons besoin que vous activiez votre compte en cliquant sur le lien d'activation dans l'email que nous venons de vous envoyer.</p>";
} else {
  ?>
  <section>
   <h3>Inscription</h3>
    <?= $form ?>

    <?php foreach ($errorsForm as $error): ?>
    <li><?= $error ?></li>
    <?php endforeach; ?>

    <?php foreach ($successForm as $succes): ?>
    <li><?= $succes ?></li>
    <?php endforeach; ?>
  </section>
  <?php
}
?>