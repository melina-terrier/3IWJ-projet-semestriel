<section>
    <div id="welcome-message" class="welcome-message">
        <h1>
            <?php
            if (isset($title)) {
                echo htmlspecialchars($title);
            } else {
                echo "Bienvenue sur la page d'accueil"; 
            }
            ?>
        </h1>
    </div>

    <div class="projects-list">
        <h3>Les projets de nos utilisateurs</h3>

        <div class="articles-container">
            <?php
            if (isset($projects) && !empty($projects)) {
                foreach ($projects as $project) {
                    echo '<article>
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
            ?>
        </div>
    </div>
</section>
