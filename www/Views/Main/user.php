<?php 
usort($projects, function($a, $b) {
    return strtotime($a['publication_date']) - strtotime($b['publication_date']);
});
$projects = array_reverse($projects);
?>

?>

<section class="profile">

    <article class="card">
        <img src="<?= isset($user['photo']) && !empty($user['photo']) ? $user['photo'] : '' ?>" alt="<?= (isset($media) && is_array($media)) ? $media['description'] : 'Photo de profil' ?>" class="user-photo">
        <div class="user-info">
            <h2><?= $user['lastname'] ?> <?= $user['firstname'] ?></h2>
            <p><?= $user['occupation'] ?></p>
            <a href="mailto:<?= $user['email'] ?>"><?= $user['email'] ?></a>
            <p><?= $user['city'] ?>, <?= $user['country'] ?></p>
        </div>
    </article>


<section class="profile">

    <article class="card">
        <img src="<?= isset($user['photo']) && !empty($user['photo']) ? htmlentities($user['photo']) : '' ?>" alt="<?= (isset($media) && is_array($media)) ? htmlentities($media['description']) : 'Photo de profil' ?>" class="user-photo">
        <div class="user-info">
            <h2><?= htmlentities($user['lastname']) ?> <?= htmlentities($user['firstname']) ?></h2>
            <p><?= htmlentities($user['occupation']) ?></p>
            <a href="mailto:<?= htmlentities($user['email']) ?>"><?= htmlentities($user['email']) ?></a>
            <p><?= htmlentities($user['city']) ?>, <?= htmlentities($user['country']) ?></p>
        </div>
    </article>

    <div class="card">
        <div class="card-body">
            <h3 class="card-title">À propos de l'utilisateur</h3>
            <p class="card-text"><?= htmlentities($user['description']) ?></p>

            <h4 class="card-title">Expérience professionnelle</h4>
            <p class="card-text"><?=htmlentities($user['experience']) ?></p>

            <h4 class="card-title">Formations</h4>
            <p class="card-text"><?= htmlentities($user['study']) ?></p>

            <h4 class="card-title">Compétences</h4>
            <p class="card-text"><?= htmlentities($user['competence']) ?></p>

            <h4 class="card-title">Intérêts</h4>
            <p class="card-text"><?= htmlentities($user['interest']) ?></p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Sur le web</h3>
            <a href="<?= htmlentities($user['website']) ?>" class="card-link">Portfolio</a>

            <?php if (isset($user['link']) && !empty($user['link'])) : ?>
                <a href="<?= htmlentities($user['link']) ?>" class="card-link">Linkedin</a>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="projects">
    <h2 class="">Projets</h2>

    <div class="card">
        <?php foreach ($projects as $project) : ?>
            <div class="card">
                <img src="<?= $project['featured_image'] ?>" class="project-image" alt="<?= htmlentities($project['imageDescription']) ?>">
                <div class="card-body">
                    <h3 class="card-title"><?= htmlentities($project['title']) ?></h3>
                    <?php
                        if (isset($project['tag_name']) && $project['tag_name']) {
                            foreach($project['tag_name'] as $tag) {
                                echo '<p class="tag">' . $tag . '</p>';
                            }
                        } ?>
                    <a href="/projects/<?= htmlentities($project['slug']) ?>" class="primary-button">Voir le projet</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
