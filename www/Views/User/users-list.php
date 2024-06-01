<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<h3>Tous les utilisateurs</h3>

    <?php 
    echo $_GET['success'];
    
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

<section class="section1-user-table">
<div class="user-table">
    <table class="responsive-table" id="myTable">
        <thead class="responsive-th">
            <tr>
                <th>Pseudo</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="responsive-tb">
            <?php

                foreach ($users as $userData): ?>
                <tr>
                    <td><?php echo $userData['firstname']; ?></td>
                    <td><?php echo $userData['email']; ?></td>
                    <td><?php echo $userData['status']; ?></td>
                    <td class="link-list">
                        <a href="/bo/user/view-user?id=<?php echo $userData['id']; ?>" class="link-primary">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                        <a href="/bo/user/edit-user?id=<?php echo $userData['id']; ?>" class="link-primary"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <a href="/bo/user?action=delete&id=<?php echo $userData['id']; ?>" class="link-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                            <i class="fa fa-minus-square-o" aria-hidden="true"></i>
                        </a>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</section>

<script>
    $(document).ready(function() {
        var table = $('#myTable').DataTable({
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