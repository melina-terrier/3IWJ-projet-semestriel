
<section>

  <h1>S'inscrire</h1>

  <?php
    echo $form; 

    if ($errors) {
      echo "<ul class='errors'>"; 
      foreach ($errors as $error){
          echo "<li class='error'>".htmlentities($error)."</li>";
      }
      echo "</ul>";
    } else if ($successes) {
      echo "<ulclass='successes'>"; 
      foreach ($successes as $success){
          echo "<li class='success'>".htmlentities($success)."</li>";
      }
      echo "</ul>";
    } 
  ?>
    <p>Ou</p>
    <a href='/login' class='primary-button'>Se connecter</a>
</section>
