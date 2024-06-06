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

<h2>Médias</h2>

<?php $successMessage = isset($_GET['message']) && $_GET['message'] === 'success';
    if (isset($_GET['message']) && $_GET['message'] === 'success') {
      echo "<p>Le média a été ajouté.</p>";
    } else if (isset($_GET['message']) && $_GET['message'] === 'delete-success'){
      echo "<p>Le média a été supprimé.</p>";
    }
?>

<a href="/dashboard/add-media">
    Ajouter un média
</a>

<section>
    <table id="mediaTable">
        <thead>
            <tr>
                <th>Fichier</th>
                <th>Auteur</th>
                <th>Date</th>
                <th>Téléversé sur</th>
                <th>Actions</th>
            </tr>
        </thead>
        <?php
        if (isset($this->data['medias'])) {
            foreach ($this->data['medias'] as $media) {
                $mediaId = $media->getId();
                $path = $media->getUrl();
                $user_id = $media->getUser();
                $title = $media->getTitle();
                $filename = $media->getName();
                $date = (new DateTime($media->getCreationDate()))->format('d/m/Y');
                echo "
                    <tr class='tab-page'>
                        <td><img style='width:10%' src='".$path."'><p>$title</p><p>$filename</p></td>
                        <td>$user_id</td>
                        <td>$date</td>
                        <td>
                            <a href='/dashboard/edit-media?id=$mediaId'>Modifier</a>
                            <a href='/dashboard/medias?action=delete&id=$mediaId' onclick='return confirm('Êtes-vous sûr de vouloir supprimer cet média définitivement ?');'>Supprimer définitivement</a>
                            <a href='".$path."'>Voir</a>
                            <a href='".$path."' download='".$path."'>Télécharger le fichier</a>   
                        </td>
                    </tr>
                ";
            }
        }
    ?>
    </table>
</section>  

