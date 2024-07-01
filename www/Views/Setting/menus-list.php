<header class="dashboard-list">

    <?php
    if (!empty($errors)) {
      echo "<ul class='errors'"; 
      foreach ($errors as $error){
          echo "<li class='error'>".htmlentities($error)."</li>";
      }
      echo "</ul>";
    }
    ?>

    <h1>Menus</h1>

    <?php
    if (isset($_GET['message']) && $_GET['message'] === 'delete-success'){
      echo "<p class='success'>Le menu a été supprimée.</p>";
    }
    ?>

    <a href="/dashboard/menu" class="primary-button">Ajouter un menu</a>

</header>

<div>
  <table>
    <thead>
        <tr>
            <th>Nom</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($menus) {
          foreach ($menus as $menu) {
            $menuId = $menu['id'];
            $menuName = $menu['type'];
                                              
            echo "
                <tr>
                    <td>$menuName</td>
                    <td>
                        <a href='/dashboard/menu?id=$menuId'>Modifier</a>
                        <a href='/dashboard/menus?action=delete&id=$menuId' onclick='return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');'>
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
    order: [[ 1, 'asc' ]],
    pagingType: 'simple_numbers'
  });
});
</script>
