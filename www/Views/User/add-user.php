<h1>Ajouter un utilisateur</h1>
<?php echo $form; 

if (isset($successForm) && !empty($successForm)) {
  echo "<div class='success-message'>";
  foreach ($successForm as $message) {
    echo "<p>$message</p>";
  }
  echo "</div>";
}

if (isset($errorsForm) && !empty($errorsForm)) {
    echo "<div class='success-message'>";
    foreach ($errorsForm as $message) {
      echo "<p>$message</p>";
    }
    echo "</div>";
}


?>