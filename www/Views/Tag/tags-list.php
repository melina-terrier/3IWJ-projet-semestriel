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


    <h3>Toutes les catégories</h3>

    <a href="/dashboard/tags/tag">Ajouter une catégorie</a>

    <section>
        <table>
            <thead>
                <tr>
                    <th><a href="#published">Toutes</a></th>
                    <th><a href="#deleted">Supprimés</a></th>
                </tr>
            </thead>
        </table>
    </section>

    <section id="#published">
        <h2>Catégories publiées</h2>
        <table id="publishedTable">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Slug</th>
                    <th>Description</th>
                    <th>Date de création</th>
                    <th>Total</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (isset($this->data['tags'])) {
                        foreach ($this->data['tags'] as $tag) {
                            if ($tag->getStatus() === 1) {
                                $tagId = $tag->getId();
                                $tagName = $tag->getName();
                                $tagDescription = $tag->getDescription();
                                $tagSlug = $tag->getSlug();
                                $tagNumber = "";
                                // $tag->getSlug(); -> a voir
                                $creationDate = (new DateTime($tag->getCreationDate()))->format('Y-m-d');
                                
                                echo "
                                    <tr>
                                        <td>$tagName</td>
                                        <td>$tagSlug</td>
                                        <td>$tagDescription</td>
                                        <td>$creationDate</td>
                                        <td>$tagNumber</td>
                                        <td>
                                            <a href='/dashboard/tags/tag?id=$tagId'>Modifier</a>
                                        </td>
                                        <td>
                                            <a href='/dashboard/tags?action=delete&id=$tagId' onclick='return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');'>
                                                Supprimer
                                            </a>
                                        </td>
                                    </tr>
                                ";
                            }
                        }
                    }
                    ?>
            </tbody>
        </table>
    </section>


    <section id="deleted">
    <h2>Catégories supprimées</h2>
        <table id="deletedTable">
            <thead>
                <tr>
                <th>Nom</th>
                <th>Slug</th>
                <th>Description</th>
                <th>Date de création</th>
                <th>Total</th>
                <th>Modifier</th>
                <th>Supprimer (définitif)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($this->data['tags'])) {
                    foreach ($this->data['tags'] as $tag) {
                        if ($tag->getStatus() === 2) {
                        $tagId = $tag->getId();
                        $tagName = $tag->getName();
                        $tagDescription = $tag->getDescription();
                        $tagSlug = $tag->getSlug();
                        $tagNumber = ""; // Assuming tag number logic is implemented
                        $creationDate = (new DateTime($tag->getCreationDate()))->format('Y-m-d');
                        echo "
                        <tr>
                            <td>$tagName</td>
                            <td>$tagSlug</td>
                            <td>$tagDescription</td>
                            <td>$creationDate</td>
                            <td>$tagNumber</td>
                            <td>
                            <a href='/dashboard/tags/tag?id=$tagId'>Modifier</a>
                            </td>
                            <td>
                            <a href='/dashboard/tags?action=permanent-delete&id=$tagId' onclick='return confirm('Êtes-vous sûr de vouloir supprimer définitivement cette catégorie ?');'>
                                Supprimer définitivement
                            </a>
                            </td>
                        </tr>
                        ";
                        }
                    }
                }
            ?>
            </tbody>
        </table>
    </section>
<script>

$(document).ready(function() {
    // Initialize DataTables for published table
    var publishedTable = $('#publishedTable').DataTable({
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

$(document).ready(function() {
// Initialize DataTables for deleted table (separate initialization)
    var deletedTable = $('#deletedTable').DataTable({
      "rowCallback": function(row, data, index) {
        if (index % 2 === 0) {
          $(row).css("background-color", "white");
        } else {
          $(row).css("background-color", "");
        }
      },
      "drawCallback": function(settings) {
        var rows = deletedTable.rows({ page: 'current' }).nodes();
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