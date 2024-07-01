<section>
   

    <?php
    if (isset($title) && isset($content)) {
        echo '<h1>'.$pageTitle.'</h1>';
        echo $content;
    } else {
        echo "Bienvenue sur la page d'accueil"; 
        echo '<div class="list">
        <h3>Les projets de nos utilisateurs</h3>

        <div class="card-container">';
        if (isset($projects) && !empty($projects)) {
            foreach ($projects as $project) {
                echo '<article class="card">
                    <a href="/projects/' . htmlspecialchars($project['slug']) . '">
                        <h4>' . htmlspecialchars($project['title']) . '</h4>
                        <img src="" alt="">
                    </a>
                    <a href="/profiles/' . htmlspecialchars($project['userSlug']) . '">' . htmlspecialchars($project['username']) . '</a>
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
