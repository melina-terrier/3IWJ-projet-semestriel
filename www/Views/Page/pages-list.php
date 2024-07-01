<header>

    <?php
    if ($errors) {
        echo "<ul>"; 
        foreach ($errors as $error){
            echo "<li>$error</li>";
        }
        echo "</ul>";
    } else if ($successes) {
        echo "<ul>"; 
        foreach ($successes as $success){
            echo "<li>$success</li>";
        }
        echo "</ul>";
    }
    ?>

    <h1>Pages</h1>

    <?php
    if (isset($_GET['message']) && $_GET['message'] === 'delete-success'){
      echo "<p>La page a été supprimée.</p>";
    } else if (isset($_GET['message']) && $_GET['message'] === 'permanent-delete-success'){
        echo "<p>La page a été définitivement supprimée.</p>";
    } else if (isset($_GET['message']) && $_GET['message'] === 'restore-success'){
        echo "<p>La page a été restaurée.</p>";
    }
    ?>

    <a href="/dashboard/add-page">Ajouter une page</a>

</header>

<section class="section1-status-tab"> 
    <a href="#allPages">Toutes</a>
    <a href="#publishedPages">Publiées</a>
    <a href="#draftPages">Brouillons</a>
    <a href="#suppressedPages">Supprimées</a>
</section>

<?php

$allPages = [];
$pagesByStatus = [];

if (isset($pages)) {
  foreach ($pages as $page) {
    $status = $page['status_name'];
    $allPages[] = $page;
    if (!isset($pageByStatus[$status])) {
      $pageByStatus[$status] = [];
    }
    $pageByStatus[$status][] = $page;
  }
}
if (!empty($allPages)) {
  echo "
  <section>";
  displayPages($allPages);
  echo "</section>";
}
foreach ($pagesByStatus as $status => $pages) {
  echo "<section>";
  displayPages($pages);
  echo "</section>";
}

function displayPages($pages){
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
        }
        echo "</tbody>";
  echo "</table>";
}
?>

<script>
$(document).ready( function () {
  $('table').DataTable({
    order: [[ 3, 'desc' ], [ 0, 'asc' ]],
    pagingType: 'simple_numbers'
  });
});
</script>