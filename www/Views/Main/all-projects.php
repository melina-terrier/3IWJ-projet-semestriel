<?php
    usort($projects, function($a, $b) {
        return strtotime($a['publication_date']) - strtotime($b['publication_date']);
    });
    $projects = array_reverse($projects);
?>

<section>

    <header>
        <?php

        if (isset($title) && isset($description)) {
            echo '<h1>' . $title . '</h1>
                  <p>' . $description . '</p>';

        }
        ?>
    </header>

    <div class="cards-container">
        <?php

        foreach ($projects as $project) {
            echo '<article class="card">

                    <a href="/projects/' . $project['slug'] . '">';

                if (isset($project['featured_image'])) {
                    echo '<img src="' . $project['featured_image'] . '" alt="">';
                }

            echo '<div class="project-info">
                    <h3>' . $project['title'] . '</h3>';

            if (isset($project['category_name']) && $project['category_name']) {
                echo '<p class="category">' . $project['category_name'] . '</p>';
            }

            echo '</div>
                  <div class="user-info">
                      <img src="' . $project['profile_photo'] . '" alt="Photo de profil">' . $project['username'] . '
                  </div>
                  </a>
                  <div class="additional-info">
                      <p>Date de publication : ' . date('d/m/Y', strtotime($project['publication_date'])) . '</p>';

            if (isset($project['description'])) {
                echo '<p class="project-description">' . $project['description'] . '</p>';
            }

            echo '</div>
                  </article>';
            echo '</div>';
        }

        ?>
    </div>
</section>
