<section class="add-element">

    <h1>Ajouter un média</h1>

    <?php
        if (!empty($media)){
            echo '<img src="'.$media['url'].'">';
        }
    ?>

    <?= $form ?>

    <?php
     if ($errors) {
        echo "<ul class='errors'>"; 
        foreach ($errors as $error){
            echo "<li class='error'>".htmlentities($error)."</li>";
        }
        echo "</ul>";
    }
    ?>
</section>
