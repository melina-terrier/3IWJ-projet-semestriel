<header>

    <?php
    if (!empty($errors)) {
      echo "<ul class='errors'"; 
      foreach ($errors as $error){
          echo "<li class='error'>".htmlentities($error)."</li>";
      }
      echo "</ul>";
    }
    ?>

    <h1>Catégories</h1>

    <?php
    if (isset($_GET['message']) && $_GET['message'] === 'success') {
      echo "<p class='success'>La catégorie a été ajoutée.</p>";
    } else if (isset($_GET['message']) && $_GET['message'] === 'delete-success'){
      echo "<p class='success'>La catégorie a été supprimée.</p>";
    } else if (isset($_GET['message']) && $_GET['message'] === 'update-success'){
      echo "<p class='success'>La catégorie a été mise à jour.</p>";
    }
    ?>

    <a href="/dashboard/add-tag" class="primary-button">Ajouter une catégorie</a>

</header>

<section>

  <table class="dashboard-list">
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
        if ($tags) {
          foreach ($tags as $tag) {
            $tagId = $tag['id'];
            $tagName = $tag['name'];
            $tagDescription = $tag['description'];
            $tagSlug = $tag['slug'];
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
$(document).ready( function () {
  $('table').DataTable({
    order: [[ 3, 'desc' ], [ 0, 'asc' ]],
    pagingType: 'simple_numbers'
  });
});
</script>
