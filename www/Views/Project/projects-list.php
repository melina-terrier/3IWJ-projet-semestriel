<?php if (!empty($errors)): ?>
  <div class="error">
    <?php foreach ($errors as $error): ?>
      <p class="text"><?php echo htmlspecialchars($error); ?></p>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php if (!empty($success)): ?>
  <div class="success">
    <?php foreach ($success as $message): ?>
      <p class="text"><?php echo htmlspecialchars($message); ?></p>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<h2>Projets</h2>

<a href="/dashboard/add-project">Ajouter un projet</a>

<?php
if (isset($_GET['message']) && $_GET['message'] === 'delete-success'){
  echo "<p>Le projet a été supprimé.</p>";
} else if (isset($_GET['message']) && $_GET['message'] === 'permanent-delete-success'){
    echo "<p>Le projet a été définitivement supprimé.</p>";
} else if (isset($_GET['message']) && $_GET['message'] === 'restore-success'){
  echo "<p>Le projet a été restauré.</p>";
}
?>

<section>
  <a href="#allProject">Tous</a> 
  <a href="#publishedProject">Publiés</a>
  <a href="#draftProject">Brouillons</a>
  <a href="#suppressedProject">Supprimés</a>
</section>

<?php

$statusNames = [];
foreach ($statuses as $status) {
    $statusName = $status->getName(); 
    $statusId = $status->getId();
    displayProjects($statusName, $projects, $statusId);
}

function displayProjects($status, $projects, $statusId){
  echo "<section id=\"$status\">";
  echo "<h2>$status</h2>";
  echo "<table id=\"{$status}Projects\">";
  echo "<thead>";
  echo "<tr>";
  echo "<th>Titre</th>";
  echo "<th>Auteur</th>";
  echo "<th>Status</th>";
  echo "<th>Date</th>";
  echo "<th>Actions</th>";
  echo "</tr>";
  echo "</thead>";
  echo "<tbody>";

  if ($projects) {
  foreach ($projects as $project) {
      $status = $project->getStatus();
      if ($status == $statusId){
          $projectId = $project->getId();
          $title = $project->getTitle();
          $userId = $project->getUser();
          $creationDate = $project->getCreationDate();
          $publicationDate = $project->getPublicationDate();
          $modificationDate = $project->getModificationDate();
          echo "<tr>";
          echo "<td>$title</td>";
          echo "<td>$userId</td>";
          echo "<td>$status</td>"; 
          if (!empty($publicationDate)){
              echo "<td>$publicationDate</td>";
          }else{
              echo "<td>$modificationDate</td>";
          }
          echo "<td>";

          switch ($status) {
              case 1:
                  echo "<a href='/projects/".$project->getSlug()."'>Voir</a>
                  <a href='/dashboard/edit-project?id=$projectId'>Modifier</a>
                  <a href='/dashboard/projects?action=delete&id=$projectId'>Supprimer</a>";
                  break;
              case 2:
                  echo "
                  <a href='/dashboard/projects?action=restore&id=$projectId'>Restaurer</a>
                  <a href='/dashboard/projects?action=permanent-delete&id=$projectId'>Supprimer définitivement</a>";
                  break;
              case 3:
                  echo "<a href=''>Prévisualiser</a>
                  <a href='/dashboard/edit-project?id=$projectId'>Modifier</a>
                  <a href='/dashboard/projects?action=delete&id=$projectId'>Supprimer</a>"; 
                  break;
          }
          echo "</td>";
          echo "</tr>";
      }
  }
} else {
  echo "<tr><td colspan='5'>Aucun commentaire trouvé</td></tr>";
}

echo "</tbody>";
echo "</table>";
echo "</section>";
}
?>



<script>
$(document).ready(function() {
    var allTable = $('#allProjectTable').DataTable({
      "rowCallback": function(row, data, index) {
        if (index % 2 === 0) {
          $(row).css("background-color", "white");
        } else {
          $(row).css("background-color", "");
        }
      },
      "drawCallback": function(settings) {
        var rows = publishedTable.rows({ page: 'current' }).nodes();
        $(rows).each(function(index) {
          if (index % 2 === 0) {
            $(this).css("background-color", "white");
          } else {
            $(this).css("background-color", "");
          }
        });
      }
    });
});
</script>