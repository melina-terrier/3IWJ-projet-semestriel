<section class="add-element">

  <h1>Ajouter un utilisateur</h1>

  <?php echo $form; 

  if (isset($successes) && !empty($successes)) {
    echo "<ul class='successes'>";
    foreach ($successes as $message) {
      echo "<li class='success'>$message</li>";
    }
    echo "</ul>";
  }

  if (isset($errors) && !empty($errors)) {
      echo "<ul class='errors'>";
      foreach ($errorsForm as $message) {
        echo "<li class='error'>$message</li>";
      }
      echo "</ul>";
  }
  ?>

</section>