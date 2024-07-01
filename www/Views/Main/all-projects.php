<?php
    usort($projects, function($a, $b) {
        return strtotime($a['publication_date']) - strtotime($b['publication_date']);
    });
    $projects = array_reverse($projects);
?>

<section>

    <header>
        <?php
        if (isset($tagTitle) && isset($tagDescription)) {
            echo '<h1>' . $tagTitle . '</h1>
                  <p>' . $tagDescription . '</p>';
        }
        ?>
    </header>

    <div class="cards-container">
        <?php

        foreach ($projects as $project) {
            echo '<article class="card">

                <a href="/projects/' . htmlentities($project['slug']) . '">';

                if (isset($project['featured_image'])) {
                    echo '<img src="' . htmlentities($project['featured_image']) . '" alt="'.$projectImageDescription.'">';
                }

                echo '<div class="project-info">
                        <h3>' . htmlentities($project['title']) . '</h3>';

                if (isset($project['tag_name']) && $project['tag_name']) {
                    foreach($project['tag_name'] as $tag) {
                        echo '<p class="tag">' . htmlentities($tag) . '</p>';
                    }
                }

                echo '</div>
                    <a class="user-info" href="/profiles/'.htmlentities($project['userSlug']).'">
                        <img src="' . htmlentities($project['profile_photo']) . '" alt="Photo de profil">' .htmlentities($project['username']) . '
                    </a>';
            echo '</article>';
            }
        ?>
    </div>
</section>
