<header class="user_header">
    <?php
    if ($errors) {
        echo "<ul class='user_errors'>"; 
        foreach ($errors as $error){
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }
    ?>
      
    <h1>Utilisateurs</h1>
    <?php
    if (isset($_GET['message']) && $_GET['message'] === 'succes') {
        echo "<p class='user_message'>Le nouveau compte a été créé.</p>";
    } else if (isset($_GET['message']) && $_GET['message'] === 'permanent-delete-success') {
        echo "<p class='user_message'>Le compte a été définitivement supprimé.</p>";
    }
    ?>
    <a href="/dashboard/add-user" class="aj_user_form_button_container">Ajouter un utilisateur</a>
</header>

<section class="user_section">
    <a href="?role=all" class="<?= !isset($_GET['role']) || $_GET['role'] === 'all' ? 'active' : '' ?>">Tous</a>
    <a href="?role=Administrateur" class="<?= isset($_GET['role']) && $_GET['role'] === 'Administrateur' ? 'active' : '' ?>">Administrateur</a>
    <a href="?role=Utilisateur" class="<?= isset($_GET['role']) && $_GET['role'] === 'Utilisateur' ? 'active' : '' ?>">Utilisateurs</a>
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

$roleFilter = $_GET['role'] ?? 'all';

if ($roleFilter === 'all') {
    displayUsers($allUsers, 'Tous les utilisateurs');
} else if (isset($usersByRole[$roleFilter])) {
    displayUsers($usersByRole[$roleFilter], $roleFilter);
}

function displayUsers($users, $title) {
    echo "<section>
    <h2>$title</h2>
    <table class='user_table'>
        <thead>
            <tr>
                <th><input type='checkbox' id='select_all'></th>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>";
    foreach ($users as $user) {
        $userId = $user['id'];
        $userName = $user['firstname'] . ' ' . $user['lastname'];
        $email = $user['email'];
        $role = $user['role_name'];
        echo "<tr>
            <td><input type='checkbox' class='select_user'></td>
            <td>$userName</td>
            <td>$email</td>
            <td>$role</td>
            <td>
                <a href='/dashboard/edit-user?id=$userId' class='user_action user_edit'></a>
                <a href='/dashboard/users?action=delete&id=$userId' class='user_action user_delete' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cet utilisateur ?\");'></a>
            </td>
        </tr>";
    }
    echo "</tbody>
    </table>
    </section>";
}
?>


<script>
$(document).ready(function() {
    $('#select_all').on('click', function() {
        $('.select_user').prop('checked', this.checked);
    });

    $('.select_user').on('click', function() {
        if (!this.checked) {
            $('#select_all').prop('checked', false);
        }
    });

    $('table').DataTable({
        order: [[ 1, 'asc' ]],
        pagingType: 'simple_numbers'
    });
});
</script>

