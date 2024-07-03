<section class="dashboard-list">

    <header>

        <?php
        if ($errors) {
            echo "<ul class='errors'>"; 
            foreach ($errors as $error){
                echo "<li class='error'>".htmlentities($error)."</li>";
            }
            echo "</ul>";
        } else if ($successes) {
            echo "<ul class='successes'>"; 
            foreach ($successes as $success){
                echo "<li class='success'>".htmlentities($success)."</li>";
            }
            echo "</ul>";
        }
        ?>

        <h1>Projets</h1>

        <?php
        if (isset($_GET['message']) && $_GET['message'] === 'success'){
            echo "<p class='success'>Le projet a été publié.</p>";
        } else if (isset($_GET['message']) && $_GET['message'] === 'delete-success'){
            echo "<p class='success'>Le projet a été supprimé.</p>";
        } else if (isset($_GET['message']) && $_GET['message'] === 'permanent-delete-success'){
            echo "<p class='success'>Le projet a été définitivement supprimé.</p>";
        } else if (isset($_GET['message']) && $_GET['message'] === 'restore-success'){
            echo "<p class='success'>Le projet a été restauré.</p>";
        }
        ?>

        <a href="/dashboard/project" class="primary-button">Ajouter un projet</a>

    </header>

    <article class="element-nav">
        <a href="?status=all" class="<?= !isset($_GET['status']) || $_GET['status'] === 'all' ? 'active' : '' ?>">Tous</a>
        <a href="?status=draft" class="<?= isset($_GET['status']) && $_GET['status'] === 'draft' ? 'active' : '' ?>">Brouillons</a>
        <a href="?status=published" class="<?= isset($_GET['status']) && $_GET['status'] === 'published' ? 'active' : '' ?>">Publiés</a>
        <a href="?status=deleted" class="<?= isset($_GET['status']) && $_GET['status'] === 'deleted' ? 'active' : '' ?>">Supprimés</a>
    </article>

    <?php
    $allProjects = [];
    $projectsByStatus = [];

    if (isset($projects)) {
        foreach ($projects as $project) {
            $status = $project['status_name'];
            $allProjects[] = $project;
            if (!isset($projectsByStatus[$status])) {
                $projectsByStatus[$status] = [];
            }
            $projectsByStatus[$status][] = $project;
        }
    }

    if (!empty($allProjects)) {
        echo "
        <div id='all'>";
        displayProjects($allProjects, "Tous");
        echo "</div>";
      }
      foreach ($projectsByStatus as $status => $projects) {
        echo "<div id=".$status.">";
        displayProjects($projects, $status);
        echo "</div>";
      }

    function displayProjects($projects, $title){

        echo "
            <h2>$title</h2>
            <table>
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Auteur</th>
                        <th>Status</th>
                        <th>SEO</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>";

        foreach ($projects as $project) {
            $status = htmlentities($project['status_name']);
            $projectId = htmlentities($project['id']);
            $title = htmlentities($project['title']);
            $userName = htmlentities($project['user_name']);
            $creationDate = $project['creation_date'];
            $publicationDate = $project['publication_date'];
            $modificationDate = $project['modification_date'];
           
            echo "<td>".$title."</td>";
            echo "<td>".$userName."</td>";
            echo "<td>$status</td>"; 
            echo "<td>".$project['seo_status']."</td>";

            switch ($project['status_id']) {
                case 1:
                    echo "<td>$publicationDate</td>
                        <td>
                            <a href='/projects/".$project['slug']."'>Voir</a>
                            <a href='/dashboard/project?id=$projectId'>Modifier</a>
                            <a href='/dashboard/projects?action=delete&id=$projectId'>Supprimer</a>
                        </td>";
                    break;
                case 2:
                    echo "<td>$modificationDate</td>
                        <td>
                            <a href='/dashboard/projects?action=restore&id=$projectId'>Restaurer</a>
                            <a href='/dashboard/projects?action=permanent-delete&id=$projectId'>Supprimer</a>
                        </td>";
                    break;
                case 3:
                    echo "<td>$modificationDate</td>
                        <td>
                            <a href='/projects/".$project['slug']."?preview=true'>Prévisualiser</a>
                            <a href='/dashboard/project?id=$projectId'>Modifier</a>
                            <a href='/dashboard/projects?action=delete&id=$projectId'>Supprimer</a>
                        </td>";
                    break;
            }
            echo "</tr>";
        }

        echo "</tbody>
            </table>";
    }
    
    ?>

</section>


<script>
$(document).ready(function() {
    $('table').DataTable({
        order: [[ 1, 'asc' ]],
        pagingType: 'simple_numbers'
    });
});
</script>
