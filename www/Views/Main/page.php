<section>

    <h1>
        <?php
        if (isset($title)) {
            echo $title;
        } else {
            echo "Bienvenue sur la page d'accueil"; 
        }
        ?>
    </h1>

    <?php
        if (isset($content)){
            echo $content;
        } else {
            echo "<h3>Les projets de nos utilisateurs</h3>";

            if (isset($projects) && !empty($projects)){
                foreach ($projects as $project){
                    echo '<article>
                        <a href="/projects/'.$project['slug'].'">
                            <h4>'.$project['title'].'</h4>
                            <img href="" alt="">
                        </a>
                        <a href="/profiles/'.$project['userSlug'].'">'.$project['username'].'</a>
                    </article>';
                }
            } else {
                echo "<p>Aucun projet n'est encore disponible.</p>";
            }
        }
    ?>
    
</section>