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
    <h1>Pages</h1>
    <?php
    if (isset($_GET['message']) && $_GET['message'] === 'delete-success') {
        echo "<p class='user_message'>La page a été supprimée.</p>";
    } else if (isset($_GET['message']) && $_GET['message'] === 'permanent-delete-success') {
        echo "<p class='user_message'>La page a été définitivement supprimée.</p>";
    } else if (isset($_GET['message']) && $_GET['message'] === 'restore-success') {
        echo "<p class='user_message'>La page a été restaurée.</p>";
    }
    ?>
    <a href="/dashboard/add-page" class="add_user_btn proj_add_project">Ajouter une page</a>
</header>

<nav class="user_section">
    <a href="?status=all" class="<?= !isset($_GET['status']) || $_GET['status'] === 'all' ? 'active' : '' ?>">Toutes</a>
    <a href="?status=Publié" class="<?= isset($_GET['status']) && $_GET['status'] === 'Publié' ? 'active' : '' ?>">Publiées</a>
    <a href="?status=Brouillon" class="<?= isset($_GET['status']) && $_GET['status'] === 'Brouillon' ? 'active' : '' ?>">Brouillons</a>
    <a href="?status=Supprimé" class="<?= isset($_GET['status']) && $_GET['status'] === 'Supprimé' ? 'active' : '' ?>">Supprimées</a>
</nav>

<?php

$allPages = [];
$pagesByStatus = [];

if (isset($pages)) {
    foreach ($pages as $page) {
        $status = $page['status_name'];
        $allPages[] = $page;
        if (!isset($pagesByStatus[$status])) {
            $pagesByStatus[$status] = [];
        }
        $pagesByStatus[$status][] = $page;
    }
}

$statusFilter = $_GET['status'] ?? 'all';

if ($statusFilter === 'all') {
    displayPages($allPages, 'Toutes les pages');
} else if (isset($pagesByStatus[$statusFilter])) {
    displayPages($pagesByStatus[$statusFilter], $statusFilter);
}

function displayPages($pages, $title) {
    echo "<section>
    <h2>$title</h2>
    <table class='user_table proj_table'>
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

        if ($pages) {
            foreach ($pages as $page) {
                $status = $page['status_name'];
                $pageId = $page['id'];
                $title = $page['title'];
                $userName = $page['user_name'];
                $creationDate = $page['creation_date'];
                $publicationDate = $page['publication_date'];
                $modificationDate = $page['modification_date'];
                echo "<tr>
                    <td>$title</td>
                    <td>$userName</td>
                    <td>$status</td>
                    <td>".$page['seo_status']."</td>"; 

                    switch ($status) {
                        case "Publié":
                            echo "<td>$publicationDate</td>
                            <td><a href='/".$page['slug']."'>Voir</a>
                            <a href='/dashboard/add-page?id=$pageId'>Modifier</a>
                            <a href='/dashboard/pages?action=delete&id=$pageId'>Supprimer</a></td>";
                            break;
                        case "Supprimé":
                            echo "<td>$modificationDate</td>
                            <td><a href='/dashboard/pages?action=restore&id=$pageId'>Restaurer</a>
                            <a href='/dashboard/pages?action=permanent-delete&id=$pageId'>Supprimer définitivement</a></td>";
                            break;
                        case "Brouillon":
                            echo "<td>$modificationDate</td>
                            <td><a href='/".$page['slug']."?preview=true'>Prévisualiser</a>
                            <a href='/dashboard/add-page?id=$pageId'>Modifier</a>
                            <a href='/dashboard/pages?action=delete&id=$pageId'>Supprimer</a></td>"; 
                            break;
                    }
                echo "</tr>";
            }
            echo "</td>
        </tr>";
    }
    echo "</tbody>
    </table>
    </section>";
}
?>

<script>
$(document).ready(function() {
    $('table').DataTable({
        order: [[3, 'desc'], [0, 'asc']],
        pagingType: 'simple_numbers'
    });
});
</script>
