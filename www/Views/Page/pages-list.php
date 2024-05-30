<h2>Mes pages</h2>

<div class="page">
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
                <th class="tab-item">Auteur</th>
                <th class="tab-item">Date</th>
                <th class="tab-item">Status</th>
                <th class="tab-item">Modifier</th>
            </tr>
            </thead>
            <?php
            if (isset($this->data['pages'])) {
                foreach ($this->data['pages'] as $page) {
                    $pageId = $page->getId();
                    $title = $page->getTitle();
                    // $username = $page->getUserUsername();
                    $creationDate = (new DateTime($page->getCreationDate()))->format('Y-m-d');
                    $status = $page->getStatus() ? 'Publié' : "Non publié";
                    echo "
                    <tr class='tab-page'>
                        <td>$title</td>
                        <td>$creationDate</td>
                        <td>$status</td>
                        <td>
                            <a href='/dashboard/pages/page?id=$pageId' class='link-primary'><i class='fa fa-pencil' aria-hidden='true'></i></a>
                        </td>
                    </tr>
                    ";
                }
            }
            ?>
        </table>
    </section>
    <section class="section4-add">
        <a href="/dashboard/add-page" class="add-content">
            <button class="button button-primary">Ajouter</button>
        </a>
    </section>
</div>