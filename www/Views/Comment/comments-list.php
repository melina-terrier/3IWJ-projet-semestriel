
<section class="add-element">

    <header>
        <?php
        if ($errors) {
            echo "<ul class='errors'>";
            foreach ($errors as $error){
                echo "<li class='error'>$error</li>";
            }
            echo "</ul>";
        } else if ($successes) {
            echo "<ul class='successes'>";
            foreach ($successes as $success){
                echo "<li>$success</li>";
            }
            echo "</ul>";
        }
        ?>
        <h1>Commentaires</h1>
        <?php
        if (isset($_GET['message']) && $_GET['message'] === 'delete-success') {
            echo "<p class='com_message'>Le commentaire a été supprimé.</p>";
        } else if (isset($_GET['message']) && $_GET['message'] === 'approve-success') {
            echo "<p class='com_message'>Le commentaire a été approuvé.</p>";
        }
        ?>
    </header>
</section>

<section class="com_section">
    <a href="?status=all" class="<?= $status === 'all' ? 'active' : '' ?>">Tous</a>
    <a href="?status=pending" class="<?= $status === 'pending' ? 'active' : '' ?>">En attente</a>
    <a href="?status=approved" class="<?= $status === 'approved' ? 'active' : '' ?>">Approuvés</a>
    <a href="?status=unwanted" class="<?= $status === 'unwanted' ? 'active' : '' ?>">Indésirables</a>
    <a href="?status=deleted" class="<?= $status === 'deleted' ? 'active' : '' ?>">Supprimés</a>
</section>

<?php if ($comments) : ?>
    <section id="comments">
        <h2><?php echo ucfirst($status); ?></h2>
        <table id="<?php echo $status; ?>Comments">
            <thead>
                <tr>
                    <th>Commentaire</th>
                    <th>Auteur</th>
                    <th>Projet</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($comments as $comment) : ?>
                    <tr>
                        <td><?php echo $comment['comment']; ?></td>
                        <td><?php echo $comment['name']; ?></td>
                        <td><?php echo $comment['project']; ?></td>
                        <td><?php echo getStatusText($comment['status']); ?></td>
                        <td><?php echo date('d/m/y H:i', strtotime($comment['creation_date'])); ?></td>
                        <td>
                        <a href='/dashboard/signal-user?id=<?php echo $comment['user_id']; ?>' class='signal-icon'> Signal </a>
                        <i class='fas fa-flag'></i>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
<?php else : ?>
    <p>Aucun commentaire à afficher.</p>
<?php endif; ?>

</body>
</html>

<?php
function getStatusText($status) {
    switch ($status) {
        case -2:
            return "Supprimé";
        case -1:
            return "Indésirable";
        case 0:
            return "En attente";
        case 1:
            return "Approuvé";
        default:
            return "Inconnu";
    }
}
?>
