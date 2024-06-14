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

    <h1>Utilisateurs</h1>

    <?php
    if (isset($_GET['message']) && $_GET['message'] === 'succes') {
        echo "<p>Le nouveau compte a été créé.</p>";
    } else if (isset($_GET['message']) && $_GET['message'] === 'permanent-delete-success') {
        echo "<p>Le compte a été définitivement supprimé.</p>";
    }
    ?>

    <a href="/dashboard/add-user">Ajouter un utilisateur</a>

</header>

<section>
    <a href="adminUser">Tous</a>
    <a href="adminUser">Administrateur</a>
    <a href="editorUser">Editeur</a>
</section>

<?php
$allUsers = [];
$usersByRole = [];

if (isset($users)) {
  foreach ($users as $user) {
    $role = $user['role_name'];
    $allUsers[] = $user;
    if (!isset($usersByRole[$role])) {
      $usersByRole[$role] = [];
    }
    $usersByRole[$role][] = $user;
  }
}

if (!empty($allUsers)) {
  echo "
  <section>
  <h2>Tous les utilisateurs</h2>";
  displayUsers($allUsers);
  echo "</section>";
}

foreach ($usersByRole as $role => $users) {
  echo "<section>
  <h2>$role</h2>";
  displayUsers($users);
  echo "</section>";
}

function displayUsers($users) {
    echo "<table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Etat</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>"; 
        foreach ($users as $user){
            $userId = $user['id'];
            $userName = $user['firstname'].' '.$user['lastname'];
            $email = $user['email'];
            $role = $user['role_name'];
            $status = $user['status'];

            $statusText = "";
            switch ($status) {
                case -1:
                    $statusText = "Supprimé";
                    break;
                case 0:
                    $statusText = "En attente";
                    break;
                case 1:
                    $statusText = "Verifié";
                    break;
                default:
                    $statusText = "Inconnu";
            }
            echo "
            <tr>
                <td>$userName</td>
                <td>$email</td>
                <td>$role</td>
                <td>$statusText</td>
                <td>
                    <a href='/profiles/".$user["slug"]."'>Voir</a>
                    <a href='/dashboard/edit-user?id=$userId'>Modifier</a>
                    <a href='/dashboard/users?action=delete&id=$userId' onclick='return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');'>Supprimer</a>
                </td>
            </tr>"; 
        }
        echo "</tbody>
    </table>"; 
    }
?>

<script>

$(document).ready( function () {
  $('table').DataTable({
    order: [[ 3, 'desc' ], [ 0, 'asc' ]],
    pagingType: 'simple_numbers'
  });
});