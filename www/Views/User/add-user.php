<section class="add-element">

  <h1>Ajouter un utilisateur</h1>

  <?php echo $form; 

  if (isset($errors) && !empty($errors)) {
      echo "<ul class='errors'>";
      foreach ($errorsForm as $message) {
        echo "<li class='error'>".htmlentities($message)."</li>";
      }
      echo "</ul>";
  }
  ?>

</section>