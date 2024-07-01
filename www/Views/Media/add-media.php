<section class="add-element">

    <h1>Ajouter un média</h1>

    <?= $form ?>

    <?php
     if ($errors) {
        echo "<ul class='errors'>"; 
        foreach ($errors as $error){
            echo "<li class='error'>".htmlentities($error)."</li>";
        }
        echo "</ul>";
    } else if ($successes) {
        echo "<ul class='successes'>"; 
        foreach ($successes as $success){
            echo "<li class='success'>".htmlentities($success)."</li>";
        }
        echo "</ul>";
    }
    ?>
    ?>
</section>
