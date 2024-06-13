<h2>Mes projets</h2>
<section class="section1-status-tab">
    <table class="status-tab">
        <thead>
            <tr class="tab">
                <th class="tab-item active"><a href="#" onclick="globalSections()">Tous</a></th>
                <th class="tab-item"><a href="#" onclick="PublishSections()">Publiés</a></th>
                <th class="tab-item"><a href="#" onclick="draftSections()">Brouillon</a></th>
            </tr>
        </thead>
    </table>
</section>

<section class="all-projects" id="all-projects">



    <table class="status-tab">
            <thead>
            <tr class="tab">
                <th class="tab-item active">Titre</th>
                <th class="tab-item">Contenu</th>
                <th class="tab-item">Date</th>
                <th class="tab-item">Auteur</th>
                <th class="tab-item">Modifier</th>
                <th class="tab-item">Supprimer</th>
            </tr>
            </thead>
            <?php
            if (isset($this->data['projects'])) {
                foreach ($this->data['projects'] as $project) {
                    $projectId = $project->getId();
                    $title = $project->getTitle();
                    $desc = $project->getContent() ?? '';
                    $createdAt = (new DateTime($project->getCreationDate()))->format('Y-m-d');
                    echo "
                    <tr class='tab-page'>
                        <td>$title</td>
                        <td>$desc</td>
                        <td>$createdAt</td>
                        <td>
                            <button class='button button-primary'>
                                <a href='/bo/projects/project?id=$projectId' class='add-content'>Modifier</a>
                            </button>
                        </td>
                        <td>
                            <button class='button button-primary'>
                                <a href='/dashboard/projects?action=delete&id=" . $projectId . "' title='Supprimer' class='link-danger' onclick='return confirm('Êtes-vous sûr de vouloir supprimer le project ?');'>Supprimer</a>
                            </button>
                        </td>
                    </tr>
                    ";
                }
            }
            ?>
        </table>
</section>

<section class="section5-page-add">
    <a href="/dashboard/projects/add-project"><button class="button button-primary">Ajouter un nouveau project</button></a>
</section>