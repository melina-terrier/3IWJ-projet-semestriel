<section>

    <?php
    if ($users){
        foreach($users as $user){
            echo '<article>
                <p>Utilisateur</p>
                <img src="'.$user['photo'].'">
                <h1>'.$user['lastname'].' '.$user['firstname'].'</h1>
                <p>'.$user['occupation'].'</p>
            </article>';
        }
    }

    if ($projects){
        foreach($projects as $project){
            echo '<article>
                <p>Projet</p>
                <img src="'.$project['featured_image'].'">
                <h1>'.$project['title'].'</h1>';
                if ($project['allTags']) {
                    foreach($project['allTags'] as $tag){
                        echo '<p>' . $tag['name'] . '</p>';
                    }
                }
            echo '</article>';
        }
    }

    if ($pages){
        foreach($pages as $page){
            echo '<article>
                <p>Page</p>
                <h1>'.$page['title'].'</h1>
            </article>';
        }
    }
    ?>
    
</section>