<h2>Mes commentaires</h2>

<div class="page">
    <section class="section1-status-tab">
        <table class="status-tab">
            <thead>
                <tr class="tab">
                    <th class="tab-item active"><a href="#">Tous</a></th>
                    <th class="tab-item"><a href="#">Publiées</a></th>
                    <th class="tab-item"><a href="#">Signalés</a></th>
                    <th class="tab-item"><a href="#">Supprimés</a></th>
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
                <th class="tab-item active">Commentaire</th>
                <th class="tab-item">Auteur</th>
                <th class="tab-item">Date</th>
                <th class="tab-item">Status</th>
                <th class="tab-item">Signaler</th>
            </tr>
            </thead>
            <?php
            if (isset($this->data['comments'])) {
                foreach ($this->data['comments'] as $comment) {
                    $commentId = $comment->getId();
                    $content = $comment->getComment();
                    // $username = $page->getUserUsername();
                    $creationDate = (new DateTime($comment->getCreationDate()))->format('Y-m-d');
                    $status = $comment->getStatus() ? 'Publié' : "Non publié";
                    echo "
                    <tr class='tab-page'>
                        <td>$content</td>
                        <td>$creationDate</td>
                        <td>$status</td>
                        <td>
                            <a href='/dashboard/comments/comment?id=$commentId' class='link-primary'><i class='fa fa-pencil' aria-hidden='true'></i></a>
                        </td>
                    </tr>
                    ";
                }
            }
            ?>
        </table>
    </section>
</div>
