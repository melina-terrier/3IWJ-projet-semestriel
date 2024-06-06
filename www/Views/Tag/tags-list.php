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


    <h3>Catégories</h3>

    <?php
    if (isset($_GET['message']) && $_GET['message'] === 'success') {
      echo "<p>La catégorie a été ajoutée.</p>";
    } else if (isset($_GET['message']) && $_GET['message'] === 'delete-success'){
      echo "<p>La catégorie a été supprimée.</p>";
    } else if (isset($_GET['message']) && $_GET['message'] === 'update-success'){
      echo "<p>La catégorie a été mise à jour.</p>";
    }
    ?>

    <a href="/dashboard/add-tag">Ajouter une catégorie</a>

    <section>
        <table id="tagTable">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Slug</th>
                    <th>Description</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (isset($this->data['tags'])) {
                        foreach ($this->data['tags'] as $tag) {
                            
                                $tagId = $tag->getId();
                                $tagName = $tag->getName();
                                $tagDescription = $tag->getDescription();
                                $tagSlug = $tag->getSlug();
                                $projectCount = "";

                                foreach($projectCounts as $project){
                                  if ($tagId == $project['id']){
                                    $projectCount = $project["projectCount"];
                                  }
                                }
                                                               
                                echo "
                                    <tr>
                                        <td>$tagName</td>
                                        <td>$tagSlug</td>
                                        <td>$tagDescription</td>
                                        <td>$projectCount</td>
                                        <td>
                                            <a href='/dashboard/edit-tag?id=$tagId'>Modifier</a>
                                            <a href='/dashboard/tags?action=delete&id=$tagId' onclick='return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');'>
                                                Supprimer
                                            </a>
                                        </td>
                                    </tr>
                                ";
                        }
                    }
                    ?>
            </tbody>
        </table>
    </section>


    
<script>

$(document).ready(function() {
    // Initialize DataTables for published table
    var publishedTable = $('#tagTable').DataTable({
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