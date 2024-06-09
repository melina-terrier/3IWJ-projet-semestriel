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

<h2>Pages</h2>

<a href="/dashboard/add-page">Ajouter une page</a>

<?php
    if (isset($_GET['message']) && $_GET['message'] === 'delete-success'){
      echo "<p>La page a été supprimée.</p>";
    } else if (isset($_GET['message']) && $_GET['message'] === 'permanent-delete-success'){
        echo "<p>La page a été définitivement supprimée.</p>";
    } else if (isset($_GET['message']) && $_GET['message'] === 'restore-success'){
        echo "<p>La page a été restaurée.</p>";
    }
?>

<section class="section1-status-tab"> 
    <a href="#allPages">Toutes</a>
    <a href="#publishedPages">Publiées</a>
    <a href="#draftPages">Brouillons</a>
    <a href="#suppressedPages">Supprimées</a>
</section>

<?php

// print_r($statuses);
// $statusNames = [];
// foreach ($statuses as $status) {
//     $statusName = $status->getName(); 
//     $statusId = $status->getId();
//     displayPages($statusName, $pages, $statusId);
// }


// function displayPages($status, $pages, $statusId){
    echo "<section id=''>";
    echo "<h2></h2>";
    echo "<table id=''>";
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

    if ($pages) {
    foreach ($pages as $page) {
        $status = $page['status_name'];
        // if ($status == $statusId){
            $pageId = $page['id'];
            $title = $page['title'];
            $userName = $page['user_name'];
            $creationDate = $page['creation_date'];
            $publicationDate = $page['publication_date'];
            $modificationDate = $page['modification_date'];
            echo "<tr>";
            echo "<td>$title</td>";
            echo "<td>$userName</td>";
            echo "<td>$status</td>"; 

           switch ($status) {
              case "published":
                  echo "<td>$publicationDate</td>";
                  echo "<td><a href='/".$page['slug']."'>Voir</a>
                  <a href='/dashboard/add-page?id=$pageId'>Modifier</a>
                  <a href='/dashboard/pages?action=delete&id=$pageId'>Supprimer</a></td>";
                  break;
              case "deleted":
                  echo "<td>$modificationDate</td>";
                  echo "<td>
                  <a href='/dashboard/pages?action=restore&id=$pageId'>Restaurer</a>
                  <a href='/dashboard/pages?action=permanent-delete&id=$pageId'>Supprimer définitivement</a></td>";
                  break;
              case "draft":
                  echo "<td>$modificationDate</td>";
                  echo "<td><a href='/".$page['slug']."?preview=true'>Prévisualiser</a>
                  <a href='/dashboard/add-page?id=$pageId'>Modifier</a>
                  <a href='/dashboard/pages?action=delete&id=$pageId'>Supprimer</a></td>"; 
                  break;
          }
          echo "</tr>";
        }
    }
//   } else {
//     echo "<tr><td colspan='5'>Aucun commentaire trouvé</td></tr>";
//   }

  echo "</tbody>";
  echo "</table>";
  echo "</section>";
// }
?>
