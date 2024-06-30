<section id="apropos_userProfile" class="apropos-section">
    <div class="card apropos-user-details">
        <img src="<?= isset($user['photo']) && !empty($user['photo']) ? $user['photo'] : 'default_profile.jpg' ?>" alt="<?= (isset($media) && is_array($media)) ? $media['description'] : 'Photo de profil' ?>" class="card-img-top apropos-user-photo">
        <div class="card-body">
            <h2 class="card-title apropos-user-name"><?= $user['lastname'] ?> <?= $user['firstname'] ?></h2>
            <p class="card-text apropos-user-occupation"><?= $user['occupation'] ?></p>
            <a href="mailto:<?= $user['email'] ?>" class="card-link apropos-user-email"><?= $user['email'] ?></a>
            <p class="card-text apropos-user-location"><?= $user['city'] ?>, <?= $user['country'] ?></p>
            <!-- <a href="/profile/edit" class="btn btn-primary apropos-edit-profile">Modifier mon profil</a> -->
        </div>
    </div>

    <div class="card apropos-user-about">
        <div class="card-body">
            <h3 class="card-title">À propos de l'utilisateur</h3>
            <p class="card-text apropos-user-description"><?= $user['description'] ?></p>

            <h4 class="card-title">Expérience professionnelle</h4>
            <p class="card-text apropos-user-experience"><?= $user['experience'] ?></p>

            <h4 class="card-title">Formations</h4>
            <p class="card-text apropos-user-study"><?= $user['study'] ?></p>

            <h4 class="card-title">Compétences</h4>
            <p class="card-text apropos-user-competence"><?= $user['competence'] ?></p>

            <h4 class="card-title">Intérêts</h4>
            <p class="card-text apropos-user-interest"><?= $user['interest'] ?></p>
        </div>
    </div>

    <div class="card apropos-user-web">
        <div class="card-body">
            <h3 class="card-title">Sur le web</h3>
            <a href="<?= $user['website'] ?>" class="card-link apropos-website">Portfolio</a>

            <?php if (isset($user['link']) && !empty($user['link'])) : ?>
                <a href="<?= $user['link'] ?>" class="card-link apropos-web-link">Lien</a>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- <section id="apropos_userProjects" class="apropos-section">
    <h2 class="apropos-section-title">Projets</h2>

    <div class="card-deck apropos-project-cards">
        <?php foreach ($projects as $project) : ?>
            <div class="card apropos-project-card">
                <img src="<?= $project['image'] ?>" class="card-img-top apropos-project-image" alt="<?= $project['title'] ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $project['title'] ?></h5>
                    <a href="/projects/<?= $project['slug'] ?>" class="btn btn-primary">Voir le projet</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section> -->
