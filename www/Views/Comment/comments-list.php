<section class="dashboard-list">

    <header>

      <?php
      if ($errors) {
        echo "<ul class='errors'>"; 
        foreach ($errors as $error){
            echo "<li class='error'>".htmlentities($error)."</li>";
        }
        echo "</ul>";
      }
      ?>

      <h1>Commentaires</h1>

      <?php
          if (isset($_GET['message']) && $_GET['message'] === 'delete-success'){
            echo "<p class='success'>Le commentaire a été supprimée.</p>";
          } else if (isset($_GET['message']) && $_GET['message'] === 'approuved-success'){
            echo "<p class='success'>Le commentaire a été publié</p>";
          } else if (isset($_GET['message']) && $_GET['message'] === 'disapprouved-success'){
            echo "<p class='success'>Le commentaire a été mis en indésirable</p>";
          } else if (isset($_GET['message']) && $_GET['message'] === 'restore-success'){
            echo "<p class='success'>Le commentaire a été restauré</p>";
          } else if (isset($_GET['message']) && $_GET['message'] === 'permanent-delete-success'){
            echo "<p class='success'>Le commentaire a été définitivement supprimé</p>";
          }
      ?>

    </header>

    <article class="element-nav">
      <a href="#allComments">Tous</a>
      <a href="#pendindComments">En attente</a>
      <a href="#approvedComments">Approuvés</a>
      <a href="#unwantedComments">Indésirables</a>
      <a href="#deletedComments">Supprimés</a>
    </article>

    <?php
  if (isset($comments)) {
      $allComments = [];
      $pendingComments = [];
      $approvedComments = [];
      $unwantedComments = [];
      $deletedComments = [];

      foreach ($comments as $comment) {
        $status = $comment['status'];

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

      displayComments('Tous', $allComments, 'all');
      displayComments('En attente', $pendingComments, 'pending');
      displayComments('Approuvé', $approvedComments, 'approved');
      displayComments('Indésirable', $unwantedComments, 'unwanted');
      displayComments('Supprimé', $deletedComments, 'deleted');
  }


  function displayComments($statusName, $comments, $id) {
      echo "<div id=".htmlentities($statusName).">";

          echo "<h2>".htmlentities($statusName)."</h2>";

          echo "<table>";
          echo "<thead>";
              echo "<tr>";
              echo "<th>Commentaire</th>";
              echo "<th>Auteur</th>";
              echo "<th>Projet</th>";
              echo "<th>Publié le</th>";
              if ($statusName == "Tous"){
                  echo "<th>Statut</th>";
              }
              echo "<th>Actions</th>";
              echo "</tr>";
          echo "</thead>";
          echo "<tbody>";

          if ($comments) {

            usort($comments, function($a, $b) {
              return strtotime($b['creation_date']) - strtotime($a['creation_date']);
            });

            foreach ($comments as $comment) {
              $commentId = htmlentities($comment['id']);
              $content = htmlentities($comment['comment']);
              $username = htmlentities($comment['name']);
              $status = htmlentities($comment['status']);
              $project = $comment['project'];
              $date = $comment['creation_date'];

              echo "<tr>";
              echo "<td>$content</td>";
              echo "<td>$username</td>";
              echo "<td>$project</td>";

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

              echo "<td>";
              echo date('d/m/y H:i', strtotime($date));
              echo "</td>"; 
              if ($statusName == "Tous"){
                echo "<td>$statusText</td>"; 
              }
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
          } 
        echo "</tbody>";
      echo "</table>";
    echo "</div>";
  }

  ?>


</section>


<script>
$(document).ready( function () {
  $('table').DataTable({
    order: [[ 1, 'asc' ]],
    pagingType: 'simple_numbers'
  });
});
</script>