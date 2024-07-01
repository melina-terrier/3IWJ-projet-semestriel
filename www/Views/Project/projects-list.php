<header class="proj_header">
    <?php
    if ($errors) {
        echo "<ul class='user_errors'>"; 
        foreach ($errors as $error){
            echo "<li>$error</li>";
        }
        echo "</ul>";
    } else if ($successes) {
        echo "<ul class='user_successes'>"; 
        foreach ($successes as $success){
            echo "<li>$success</li>";
        }
        echo "</ul>";
    }
    ?>

    <h1>Projets Réaliser</h1>

    <?php
    if (isset($_GET['message']) && $_GET['message'] === 'delete-success'){
        echo "<p class='user_message'>Le projet a été publié.</p>";
    } else if (isset($_GET['message']) && $_GET['message'] === 'delete-success'){
        echo "<p class='user_message'>Le projet a été supprimé.</p>";
    } else if (isset($_GET['message']) && $_GET['message'] === 'permanent-delete-success'){
        echo "<p class='user_message'>Le projet a été définitivement supprimé.</p>";
    } else if (isset($_GET['message']) && $_GET['message'] === 'restore-success'){
        echo "<p class='user_message'>Le projet a été restauré.</p>";
    }
    ?>

<a href="/dashboard/add-project" class="add_user_btn proj_add_project">Ajouter un projet</a>
</header>


<section class="user_section">
    <a href="?status=all" class="<?= !isset($_GET['status']) || $_GET['status'] === 'all' ? 'active' : '' ?>">Tous</a>
    <a href="?status=draft" class="<?= isset($_GET['status']) && $_GET['status'] === 'draft' ? 'active' : '' ?>">Brouillons</a>
    <a href="?status=published" class="<?= isset($_GET['status']) && $_GET['status'] === 'published' ? 'active' : '' ?>">Publiés</a>
    <a href="?status=deleted" class="<?= isset($_GET['status']) && $_GET['status'] === 'deleted' ? 'active' : '' ?>">Supprimés</a>
</section>



<?php
$allProjects = [];
$projectsByStatus = [];

// Logique PHP pour filtrer les projets par statut
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

function displayProjects($projects){
  echo "<table>
    <thead>
      <tr>
        <th>Titre</th>
        <th>Auteur</th>
        <th>Status</th>
        <th>SEO</th>
        <th>Date</th>
        <th>Actions</th>
      </tr>
    </thead>";

$selectedStatus = $_GET['status'] ?? 'all';


switch ($selectedStatus) {
    case 'draft':
        $title = 'Brouillons';
        break;
    case 'published':
        $title = 'Projets Publiés';
        break;
    case 'deleted':
        $title = 'Projets Supprimés';
        break;
    default:
        $title = 'Tous les projets';
}

if ($selectedStatus === 'all') {
    displayProjects($allProjects, 'Tous les projets');
} else if (isset($projectsByStatus[$selectedStatus])) {
    displayProjects($projectsByStatus[$selectedStatus], $title);
}

function displayProjects($projects, $title) {
    echo "<section>
        <h2>$title</h2>
        <table class='user_table proj_table'>
            <thead>
                <tr>
                    <th><input type='checkbox' id='select_all'></th>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>";

    foreach ($projects as $project) {
        $status = $project['status_name'];
        $projectId = $project['id'];
        $title = $project['title'];
        $userName = $project['user_name'];
        $creationDate = $project['creation_date'];
        $publicationDate = $project['publication_date'];
        $modificationDate = $project['modification_date'];
        echo "<tr>";
          echo "<td>$title</td>";
          echo "<td>$userName</td>";
          echo "<td>$status</td>"; 
          echo "<td>".$project['seo_status']."</td>";
        echo "<tr>
            <td><input type='checkbox' class='select_user'></td>
            <td>$title</td>
            <td>$userName</td>
            <td>$status</td>";

        switch ($status) {
            case "Publié":
                echo "<td>$publicationDate</td>
                      <td>
                          <a href='/projects/".$project['slug']."' class='user_action user_edit proj_action'>Voir</a>
                          <a href='/dashboard/add-project?id=$projectId' class='user_action user_edit proj_action'>Modifier</a>
                          <a href='/dashboard/projects?action=delete&id=$projectId' class='user_action user_delete proj_action' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer ce projet ?\");'></a>
                      </td>";
                break;
            case "Supprimé":
                echo "<td>$modificationDate</td>
                      <td>
                          <a href='/dashboard/projects?action=restore&id=$projectId' class='user_action proj_action'>Restaurer</a>
                          <a href='/dashboard/projects?action=permanent-delete&id=$projectId' class='user_action user_delete proj_action' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer définitivement ce projet ?\");'></a>
                      </td>";
                break;
            case "Brouillon":
                echo "<td>$modificationDate</td>
                      <td>
                          <a href='/projects/".$project['slug']."?preview=true' class='user_action proj_action'>Prévisualiser</a>
                          <a href='/dashboard/add-project?id=$projectId' class='user_action user_edit proj_action'>Modifier</a>
                          <a href='/dashboard/projects?action=delete&id=$projectId' class='user_action user_delete proj_action' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer ce projet ?\");'></a>
                      </td>";
                break;
        }
        echo "</tr>";
    }

    echo "</tbody>
        </table>
        </section>";
}
?>

<script>
$(document).ready(function() {
    $('#select_all').on('click', function() {
        $('.select_user').prop('checked', this.checked);
    });

    $('.select_user').on('click', function() {
        if (!this.checked) {
            $('#select_all').prop('checked', false);
        }
    });

    $('table').DataTable({
        order: [[ 3, 'desc' ], [ 0, 'asc' ]],
        pagingType: 'simple_numbers'
    });
});
</script>
