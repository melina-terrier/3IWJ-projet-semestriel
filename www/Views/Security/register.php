<?php

echo "<section>
  <header>
    <h1>S'inscrire</h1>
  </header>
  
  <article>";
  echo $form; 

  if ($errors) {
    echo "<ul>"; 
    foreach ($errors as $error){
        echo "<li>$error</li>";
    }
    echo "</ul>";
  } else if ($successes) {
    echo "<ul>"; 
    foreach ($successes as $success){
        echo "<li>$success</li>";
    }
    echo "</ul>";
  }

echo "
    <p>Ou</p>
    <a href='/login'>Se connecter</a>
  </article>
</section>";

?>