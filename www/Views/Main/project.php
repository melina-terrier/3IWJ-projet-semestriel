<section>
   

    <?php

        echo '<h1>'.$projectTitle.'</h1>';
        echo $projectContent;
        echo $form;
     
        foreach($comments as $comment){
            echo '<article>
                <p>'.$comment['name'].'</p>
                <p>'.$comment['creation_date'].'</p>
                <p>'.$comment['comment'].'</p>
            </article>';
        }
        print_r($successes);
        print_r($errors);
    ?>

</section>
