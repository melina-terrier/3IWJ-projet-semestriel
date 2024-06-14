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

    <h1>Médias</h1>

    <?php
        if (isset($_GET['message']) && $_GET['message'] === 'success') {
        echo "<p>Le média a été ajouté.</p>";
        } else if (isset($_GET['message']) && $_GET['message'] === 'delete-success'){
        echo "<p>Le média a été supprimé.</p>";
        }
    ?>

    <a href="/dashboard/add-media">Ajouter un média</a>

</header>

<section>
    <table>
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
        if ($medias) {
            foreach ($medias as $media) {
                $mediaId = $media['id'];
                $path = $media['url'];
                $user_id = $media['user_name'];
                $title = $media['title'];
                $filename = $media['name'];
                $date = $media['creation_date'];
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

