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
    }
?>

<section class="section1-status-tab"> 
    <a href="#">Toutes</a>
    <a href="#">Publiées</a>
    <a href="#">Brouillons</a>
    <a href="#">Supprimées</a>
</section>

<?php

// print_r($statuses);
$statusNames = [];
foreach ($statuses as $status) {
    $statusName = $status->getName(); 
    $statusId = $status->getId();
    displayPages($statusName, $pages, $statusId);
}


function displayPages($status, $pages, $statusId){
    echo "<section id=\"$status\">";
    echo "<h2>$status</h2>";
    echo "<table id=\"{$status}Pages\">";
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
        $status = $page->getStatus();
        if ($status == $statusId){
            $pageId = $page->getId();
            $title = $page->getTitle();
            $userId = $page->getUser();
            $creationDate = $page->getCreationDate();
            $publicationDate = $page->getPublicationDate();
            $modificationDate = $page->getModificationDate();
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
                    echo "<a href='/".$page->getSlug()."'>Voir</a>
                    <a href='/dashboard/edit-page?id=$pageId'>Modifier</a>
                    <a href='/dashboard/pages?action=delete&id=$pageId'>Supprimer</a>";
                    break;
                case 2:
                    echo "
                    <a href='/dashboard/pages?action=restore&id=$pageId'>Restaurer</a>
                    <a href='/dashboard/pages?action=permanent-delete&id=$pageId'>Supprimer définitivement</a>";
                    break;
                case 3:
                    echo "<a href=''>Prévisualiser</a>
                    <a href='/dashboard/edit-page?id=$pageId'>Modifier</a>
                    <a href='/dashboard/pages?action=delete&id=$pageId'>Supprimer</a>"; 
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
