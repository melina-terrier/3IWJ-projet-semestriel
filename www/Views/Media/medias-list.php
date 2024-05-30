<h2>Mes médias</h2>

<div class="media-page">
    <section class="section1-status-tab">
        <table class="status-tab">
            <thead>
            <tr class="tab">
                <th class="tab-item active"><a href="#">Tous</a></th>
                <th class="tab-item"><a href="#">Publiées</a></th>
                <th class="tab-item"><a href="#">Brouillon</a></th>
            </tr>
            </thead>
        </table>
    </section>
    <section class="section2-search-bar">
        <div class="block-line-search">
            <label for="input-name"></label>
            <input type="text" id="input-name" class="search-input" placeholder="Rechercher..."/>
        </div>
    </section>
    <section class="section3-information-page">
        <table class="status-tab">
            <thead>
            <tr class="tab">
                <th class="tab-item active">Titre</th>
                <th class="tab-item">Description</th>
                <th class="tab-item">Date</th>
                <th class="tab-item">Modifier</th>
            </tr>
            </thead>
            <?php
            if (isset($this->data['medias'])) {
                foreach ($this->data['medias'] as $media) {
                    $mediaId = $media->getId();
                    $title = $media->getTitle();
                    $desc = $media->getDescription() ?? '';
                    $createdAt = (new DateTime($media->getCreationDate()))->format('Y-m-d');
                    echo "
                    <tr class='tab-page'>
                        <td>$title</td>
                        <td>$desc</td>
                        <td>$createdAt</td>
                        <td>
                            <button class='button button-primary'>
                                <a href='/bo/medias/media?id=$mediaId' class='add-content'>Modifier</a>
                            </button>
                        </td>
                    </tr>
                    ";
                }
            }
            ?>
        </table>
    </section>
    <section class="section4-add">
        <a href="/bo/medias/media" class="add-content">
            <button class="button button-primary">Ajouter</button>
        </a>
    </section>
</div>