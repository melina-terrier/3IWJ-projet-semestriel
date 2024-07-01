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
        
        <h1>Utilisateurs</h1>

        <?php
        if (isset($_GET['message']) && $_GET['message'] === 'success') {
            echo "<p class='success'>Le nouveau compte a été créé.</p>";
        } else if (isset($_GET['message']) && $_GET['message'] === 'permanent-delete-success') {
            echo "<p class='success'>Le compte a été définitivement supprimé.</p>";
        }
        ?>
        <a href="/dashboard/user" class="primary-button">Ajouter un utilisateur</a>
    
    </header>

    <article class="element-nav">
        <a href="?role=all" class="<?= !isset($_GET['role']) || $_GET['role'] === 'all' ? 'active' : '' ?>">Tous</a>
        <a href="?role=Administrateur" class="<?= isset($_GET['role']) && $_GET['role'] === 'Administrateur' ? 'active' : '' ?>">Administrateur</a>
        <a href="?role=Utilisateur" class="<?= isset($_GET['role']) && $_GET['role'] === 'Utilisateur' ? 'active' : '' ?>">Utilisateurs</a>
    </article>

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
        echo "<div id=".htmlentities($title).">
        <h2>".htmlentities($title)."</h2>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>";
        foreach ($users as $user) {
            $userId = $user['id'];
            $userName = htmlentities($user['firstname']) . ' ' . htmlentities($user['lastname']);
            $email = htmlentities($user['email']);
            $role = htmlentities($user['role_name']);
            echo "<tr>
                <td>$userName</td>
                <td>$email</td>
                <td>$role</td>
                <td>
                    <a href='/dashboard/user?id=$userId'></a>
                    <a href='/dashboard/users?action=delete&id=$userId' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cet utilisateur ?\");'></a>
                </td>
            </tr>";
        }
        echo "</tbody>
        </table>
        </div>";
    }
    ?>
</section>


<script>
$(document).ready(function() {
    $('table').DataTable({
        order: [[ 1, 'asc' ]],
        pagingType: 'simple_numbers'
    });
});
</script>

