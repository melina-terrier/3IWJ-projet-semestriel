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

<h2>Commentaires</h2>

<?php
    if (isset($_GET['message']) && $_GET['message'] === 'delete-success'){
      echo "<p>Le commentaire a été supprimée.</p>";
    } else if (isset($_GET['message']) && $_GET['message'] === 'approuved-success'){
      echo "<p>Le commentaire a été publié</p>";
    } else if (isset($_GET['message']) && $_GET['message'] === 'disapprouved-success'){
        echo "<p>Le commentaire a été mis en indésirable</p>";
    } else if (isset($_GET['message']) && $_GET['message'] === 'restore-success'){
        echo "<p>Le commentaire a été restauré</p>";
    } else if (isset($_GET['message']) && $_GET['message'] === 'permanent-delete-success'){
        echo "<p>Le commentaire a été définitivement supprimé</p>";
    }
?>

<section>
    <a href="#">Tous</a>
    <a href="#">En attente</a>
    <a href="#">Approuvés</a>
    <a href="#">Indésirables</a>
    <a href="#">Supprimés</a>
</section>


<?php
if (isset($this->data['comments'])) {
    $allComments = [];
    $pendingComments = [];
    $approvedComments = [];
    $unwantedComments = [];
    $deletedComments = [];
  
    foreach ($this->data['comments'] as $comment) {
      $status = $comment->getStatus();
  
      switch ($status) {
        case -2:
          $deletedComments[] = $comment;
          break;
        case -1:
            $allComments[] = $comment;
          $unwantedComments[] = $comment;
          break;
        case 0:
            $allComments[] = $comment;
          $pendingComments[] = $comment;
          break;
        case 1:
            $allComments[] = $comment;
          $approvedComments[] = $comment;
          break;
      }
    }

    displayComments('all', $allComments);
    displayComments('pending', $pendingComments);
    displayComments('approved', $approvedComments);
    displayComments('unwanted', $unwantedComments);
    displayComments('deleted', $deletedComments);
  }


function displayComments($status, $comments) {
  echo "<section id=\"$status\">";
  echo "<h2>$status</h2>";

  echo "<table id=\"{$status}Comments\">";
  echo "<thead>";
  echo "<tr>";
  echo "<th>Commentaire</th>";
  echo "<th>Auteur</th>";
  echo "<th>Projet</th>";
  echo "<th>Status</th>";
  echo "<th>Actions</th>";
  echo "</tr>";
  echo "</thead>";
  echo "<tbody>";

  if ($comments) {
    foreach ($comments as $comment) {
      $commentId = $comment->getId();
      $content = $comment->getComment();
      $username = $comment->getName();
      $status = $comment->getStatus();

      echo "<tr>";
      echo "<td>$content</td>";
      echo "<td>$username</td>";
      echo "<td>A faire</td>";

      $statusText = "";
      switch ($status) {
        case -2:
            $statusText = "Supprimé";
            break;
        case -1:
            $statusText = "Indésirable";
            break;
        case 0:
          $statusText = "En attente";
          break;
        case 1:
          $statusText = "Approuvé";
          break;
        default:
          $statusText = "Inconnu";
      }

      echo "<td>$statusText</td>"; 
      echo "<td>";

      switch ($status) {
        case -2:
            echo "<a href='/dashboard/comments?action=restore&id=$commentId'>Restorer</a>";
            echo "<a href='/dashboard/comments?action=permanent-delete&id=$commentId'>Supprimer définitivement</a>";
            break;
        case -1:
          echo "<a href='/dashboard/comments?action=approuved&id=$commentId'>Approuver</a>";
          echo "<a href='/dashboard/comments?action=delete&id=$commentId' onclick='return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?');'>Supprimer</a>";
          break;
        case 0:
          echo "<a href='/dashboard/comments?action=approuved&id=$commentId'>Approuver</a>";
          echo "<a href='/dashboard/comments?action=disapprouved&id=$commentId'>Indésirable</a>";
          echo "<a href='/dashboard/comments?action=delete&id=$commentId' onclick='return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?');'>Supprimer</a>";
          break;
        case 1:
          echo "<a href='/dashboard/comments?action=disapprouved&id=$commentId'>Indésirable</a>";
          echo "<a href='/dashboard/comments?action=delete&id=$commentId' onclick='return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?');'>Supprimer</a>";
          break;
      }
      echo "</td>";
      echo "</tr>";
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
  function initDataTable(tableId) {
    var table = $('#' + tableId).DataTable({
      "rowCallback": function(row, data, index) {
        if (index % 2 === 0) {
          $(row).css("background-color", "white");
        } else {
          $(row).css("background-color", "");
        }
      },
      "drawCallback": function(settings) {
        var rows = table.rows({ page: 'current' }).nodes();
        $(rows).each(function(index) {
          if (index % 2 === 0) {
            $(this).css("background-color", "white");
          } else {
            $(this).css("background-color", "");
          }
        });
      }
    });
  }

  // Call the function for each table with its unique ID
  initDataTable('allComments');  // Replace with your table ID
  initDataTable('pendingComments');  // Replace with your table ID
  initDataTable('approvedComments'); // Replace with your table ID
  initDataTable('unwantedComments'); // Replace with your table ID
  initDataTable('deletedComments');  // Replace with your table ID
});
</script>
