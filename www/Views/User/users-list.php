<?php 
if (!empty($errors)): ?>
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

<h3>Utilisateurs</h3>

<?php
if (isset($_GET['message']) && $_GET['message'] === 'success') {
    echo "<p>Le nouveau compte a été créé.</p>";
}

?>

<a href="/dashboard/add-user">Ajouter un utilisateur</a>

<section>
    <table id="userTable">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Etat</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($users as $userData): 
                    $userId = $userData['id'];
                    $userName = $userData['firstname'].' '.$userData['lastname'];
                    $email = $userData['email'];
                    $role = $userData['role'];
                    $status = $userData['status'];

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
                                <a href='/dashboard/view-user?id=$userId'>Voir</a>
                                <a href='/dashboard/edit-user?id=$userId'>Modifier</a>
                                <a href='/dashboard/users?action=delete&id=$userId' onclick='return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');'>Supprimer</a>
                            </td>
                        </tr>
                    ";
            endforeach; ?>
        </tbody>
    </table>
</section>

<script>
    $(document).ready(function() {
        var table = $('#userTable').DataTable({
            "rowCallback": function(row, data, index) {
                if (index % 2 === 0) {
                    $(row).css("background-color", "white");
                } else {
                    $(row).css("background-color", "");
                }
            },
            "drawCallback": function(settings) {
                var rows = table.rows({ page: 'current' }).nodes();
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