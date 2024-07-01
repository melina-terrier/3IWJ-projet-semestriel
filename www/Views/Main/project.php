
    <h1><?php echo htmlentities($projectTitle) ?></h1>

    <?php
        if (!empty($featured_image)){
            echo '<img src="'.htmlentities($featured_image).'" alt="'.isset($imageDescription) ? $imageDescription : ''.'">';
        }
        foreach($tagName as $tag){
            echo '<p class="tag">'.htmlentities($tag).'</p>';
        }
        echo $projectContent;
    ?>

    <section class="comments">

        <?php 
        foreach ($comments as $comment){
            echo '<p class="comment">'.htmlentities($comment["comment"]).'<p>';
        }
        ?>

    </section>

    <section>
        <h2>Ecrire un commentaire</h2>

        <?php

            echo $form; 

            if (!empty($errors)){
                echo '<ul class="errors">'; 
                foreach ($errors as $error){
                echo '<li class="error">'.htmlentities($error).'</li>';
                }
                echo '</ul>';
            } else if (!empty($successes)){
                echo '<ul class="successes">'; 
                foreach ($successes as $success){
                echo '<li class="success">'.htmlentities($success).'</li>';
                }
                echo '</ul>';
            }
        ?>
    </section>