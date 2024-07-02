<section class="dashboard-list">

    <header class="header-media">

        <?php
        if ($errors) {
            echo "<ul class='errors'>"; 
            foreach ($errors as $error){
                echo "<li class='error'>".htmlentities($error)."</li>";
            }
            echo "</ul>";
        }
        ?>

        <h1>Médias</h1>

        <?php
            if (isset($_GET['message']) && $_GET['message'] === 'success') {
                echo "<p class='user_message'>Le média a été ajouté.</p>";
            } else if (isset($_GET['message']) && $_GET['message'] === 'delete-success'){
                echo "<p class='user_message'>Le média a été supprimé.</p>";
            }
        ?>

        <a href="/dashboard/add-media" class="add_user_btn">Ajouter un média</a>
    
    </header>

    <div class="media-grid">
        <?php
        if ($medias) {
            foreach ($medias as $media) {
                $mediaId = $media['id'];
                $path = htmlentities($media['url']);
                $user_id = htmlentities($media['user_name']);
                $title = htmlentities($media['title']);
                $filename = htmlentities($media['name']);
                $date = $media['creation_date'];
                $fileType = pathinfo($filename, PATHINFO_EXTENSION);

                $iconClass = "";
                switch ($fileType) {
                    case 'jpg':
                    case 'jpeg':
                    case 'png':
                        $iconClass = "fa fa-file-image-o";
                        break;
                    case 'pdf':
                        $iconClass = "fa fa-file-pdf-o";
                        break;
                    default:
                        $iconClass = "fa fa-file-o";
                }

                echo "
                    <article class='card'>
                        <img src='$path' alt='$title' />
                        <h1>$title</h1>
                        <p>$filename</p>
                        <p>Ajouté par: $user_id le $date</p>
                        <div class='media-actions'>
                            <a href='/dashboard/edit-media?id=$mediaId'><i class='fa fa-pencil'></i></a>
                            <a href='/dashboard/medias?action=delete&id=$mediaId' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer ce média définitivement ?\");'><i class='fa fa-trash'></i></a>
                            <a href='$path'><i class='fa fa-eye'></i></a>
                            <a href='$path' download='$path'><i class='fa fa-download'></i></a>
                        </div>
                    </article>
                ";
            }
        }
        ?>
    </div>

</section>
