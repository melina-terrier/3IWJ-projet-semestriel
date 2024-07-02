<?php

    usort($projects, function($a, $b) {
        return strtotime($a['publication_date']) - strtotime($b['publication_date']);
    });
    $projects = array_reverse($projects);

    if (!empty($projects)){
        usort($projects, function($a, $b) {
            return strtotime($a['publication_date']) - strtotime($b['publication_date']);
        });
        $projects = array_reverse($projects);
    }

?>

<section>



        <h1>Bienvenue sur la page d'accueil<h1> 
        
        <div class="grid-container">

            <h3>Les projets de nos utilisateurs</h3>

            <div class="card-container">
            
            <?php 
            if (isset($projects) && !empty($projects)) {
                foreach ($projects as $project) {
                    echo '<article class="card">
                        <a href="/projects/' . htmlentities($project['slug']) . '">

                            <h4>' . htmlentities($project['title']) . '</h4>
                            <img src="'.htmlentities($project['featured_image']).'" alt="'.htmlentities($project['image_description']).'">
                        </a>
                        <a href="/profiles/' . htmlentities($project['userSlug']) . '">  <img src="'.htmlentities($project['userPhoto']).'" src="'.htmlentities($project['userPhotoDescription']).'" "'. htmlentities($project['username']) . '</a>

                    </article>';
                }
            } else {
                echo "<p>Aucun projet n'est encore disponible.</p>";
            }
        echo '</div>
        </div>';

?>
</section>
