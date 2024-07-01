<?php

echo "<section>
      <header>
        <h1>S'inscrire</h1>
      </header>
      
  <article>";
    echo $form; 

  if ($errors) {
    echo "<ul class='errors'>"; 
    foreach ($errors as $error){
        echo "<li class='error'>$error</li>";
    }
    echo "</ul>";
  } else if ($successes) {
    echo "<ulclass='successes'>"; 
    foreach ($successes as $success){
        echo "<li class='success'>$success</li>";
    }
    echo "</ul>";
  }

echo "
    <p>Ou</p>
    <a href='/login' class='primary-button'>Se connecter</a>
  </article>
</section>";

?>