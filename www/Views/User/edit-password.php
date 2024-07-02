<section class="user">

    <h1>Modifier son mot de passe</h1>

    <?php echo $form;

    if ($errors) {
        echo "<ul>"; 
        foreach ($errors as $error){
            echo "<li>".htmlentities($error)."</li>";
        }
        echo "</ul>";
    } 

    if($successes){
        echo "<ul>"; 
        foreach ($successes as $success){
            echo "<li>".htmlentities($success)."</li>";
        }
        echo "</ul>";
    }
    ?>

</section>