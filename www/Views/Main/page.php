<?php
    if (!empty($projects)){
        usort($projects, function($a, $b) {
            return strtotime($a['publication_date']) - strtotime($b['publication_date']);
        });
        $projects = array_reverse($projects);
    }
?>

<section>

        <?php

        if (!empty($pageTitle) || !empty($pageContent)) {
            echo '<h1>'.$pageTitle.'</h1>';
            echo $pageContent;
        } else { ?>

        <h1>Bienvenue sur la page d'accueil<h1> 
        
        <div class="grid-container">

            <h3>Les projets de nos utilisateurs</h3>

            <div class="card-container">
            
            <?php 
            if (isset($projects) && !empty($projects)) {
                foreach ($projects as $project) {
                    echo '<article class="card">
                        <a href="/projects/' . htmlentities($project['slug']) . '">
                            <h3>' . htmlentities($project['title']) . '</h3>';
                            if (isset($project['featured_image'])) {
                                echo '<img src="' . htmlentities($project['featured_image']) . '" alt="'.htmlentities($project['image_description']).'">';
                            }
                            echo '<div class="project-info">';
    
                            if (isset($project['tag_name']) && $project['tag_name']) {
                                foreach($project['tag_name'] as $tag) {
                                    echo '<p class="tag">' . htmlentities($tag) . '</p>';
                                }
                            }
            
                            echo '</div>
                                <a class="user-info" href="/profiles/'.htmlentities($project['userSlug']).'">
                                    <img src="' . htmlentities($project['userPhoto']) . '" alt="Photo de profil">' .htmlentities($project['username']) . '
                            </a>
                    </article>';
                }
            } else {
                echo "<p>Aucun projet n'est encore disponible.</p>";
            }
        echo '</div>
        </div>';

        }
?>
</section>
