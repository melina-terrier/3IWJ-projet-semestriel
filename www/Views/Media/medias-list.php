<header class="header-media">
    <?php
    if ($errors) {
        echo "<ul class='user_errors'>"; 
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    } else if ($successes) {
        echo "<ul class='user_successes'>"; 
        foreach ($successes as $success) {
            echo "<li>$success</li>";
        }
        echo "</ul>";
    }
    ?>

    <h1>Médias</h1>

    <?php
    if (isset($_GET['message']) && $_GET['message'] === 'success') {
        echo "<p class='user_message'>Le média a été ajouté.</p>";
    } else if (isset($_GET['message']) && $_GET['message'] === 'delete-success') {
        echo "<p class='user_message'>Le média a été supprimé.</p>";
    }
    ?>

    <a href="/dashboard/add-media" class="add_user_btn">Ajouter un média</a>
</header>

<section class="media-grid">
    <?php
    if ($medias) {
        foreach ($medias as $media) {
            $mediaId = $media['id'];
            $path = $media['url'];
            $user_id = $media['user_name'];
            $title = $media['title'];
            $filename = $media['name'];
            $date = $media['creation_date'];
            $fileType = pathinfo($filename, PATHINFO_EXTENSION);

            // Determine icon based on file type
            $iconClass = "";
            switch ($fileType) {
                case 'jpg':
                case 'jpeg':
                case 'png':
                case 'gif':
                    $iconClass = "fa fa-file-image-o";
                    break;
                case 'avi':
                case 'mp4':
                    $iconClass = "fa fa-file-video-o";
                    break;
                case 'mp3':
                case 'wav':
                    $iconClass = "fa fa-file-audio-o";
                    break;
                case 'pdf':
                    $iconClass = "fa fa-file-pdf-o";
                    break;
                case 'zip':
                case 'rar':
                    $iconClass = "fa fa-file-archive-o";
                    break;
                default:
                    $iconClass = "fa fa-file-o";
            }

            echo "
                <article class='card_media'>
                    <input type='checkbox' class='select_user' id='media_$mediaId'>
                    <img src='$path' alt='$title' />
                    <div class='content'>
                        <h1>$title</h1>
                        <p>$filename</p>
                        <p>Ajouté par: $user_id le $date</p>
                    </div>
                    <div class='media-actions'>
                        <a href='/dashboard/edit-media?id=$mediaId' class='media-action edit'><i class='fa fa-pencil'></i></a>
                        <a href='/dashboard/medias?action=delete&id=$mediaId' class='media-action delete' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer ce média définitivement ?\");'><i class='fa fa-trash'></i></a>
                        <a href='$path' class='media-action view'><i class='fa fa-eye'></i></a>
                        <a href='$path' download='$path' class='media-action download'><i class='fa fa-download'></i></a>
                    </div>
                </article>
            ";
        }
    }
    ?>
</section>

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
});
</script>
