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

  <h1>Projets</h1>

  <?php
  if (isset($_GET['message']) && $_GET['message'] === 'delete-success'){
    echo "<p>Le projet a été publié.</p>";
  } else if (isset($_GET['message']) && $_GET['message'] === 'delete-success'){
    echo "<p>Le projet a été supprimé.</p>";
  } else if (isset($_GET['message']) && $_GET['message'] === 'permanent-delete-success'){
      echo "<p>Le projet a été définitivement supprimé.</p>";
  } else if (isset($_GET['message']) && $_GET['message'] === 'restore-success'){
    echo "<p>Le projet a été restauré.</p>";
  }
  ?>

  <a href="/dashboard/add-project">Ajouter un projet</a>

</header>

<section>
  <a href="#allProject">Tous</a> 
  <a href="#publishedProject">Publiés</a>
  <a href="#draftProject">Brouillons</a>
  <a href="#suppressedProject">Supprimés</a>
</section>

<?php

$allProjects = [];
$projectsByStatus = [];

if (isset($projects)) {
  foreach ($projects as $project) {
    $status = $project['status_name'];
    $allProjects[] = $project;
    if (!isset($projectByStatus[$status])) {
      $projectByStatus[$status] = [];
    }
    $projectByStatus[$status][] = $project;
  }
}
if (!empty($allProjects)) {
  echo "
  <section>";
  displayProjects($allProjects);
  echo "</section>";
}
foreach ($projectsByStatus as $status => $projects) {
  echo "<section>";
  displayProjects($projects);
  echo "</section>";
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
    </thead>

    <tbody>"; 
    if ($projects) {
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

          switch ($status) {
            case "Publié":
              echo "<td>$publicationDate</td>
              <td><a href='/projects/".$project['slug']."'>Voir</a>
              <a href='/dashboard/add-project?id=$projectId'>Modifier</a>
              <a href='/dashboard/projects?action=delete&id=$projectId'>Supprimer</a></td>";
              break;
            case "Supprimé":
              echo "<td>$modificationDate</td>
              <td><a href='/dashboard/projects?action=restore&id=$projectId'>Restaurer</a>
              <a href='/dashboard/projects?action=permanent-delete&id=$projectId'>Supprimer définitivement</a></td>";
              break;
            case "Brouillon":
              echo "<td>$modificationDate</td>
              <td><a href='/projects/".$project['slug']."?preview=true'>Prévisualiser</a>
              <a href='/dashboard/add-project?id=$projectId'>Modifier</a>
              <a href='/dashboard/projects?action=delete&id=$projectId'>Supprimer</a></td>"; 
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
