<section>
    <article>
        <img src="<?= isset($user['photo']) && !empty($user['photo']) ? $user['photo'] : 'default_profile.jpg' ?>" alt="<?= (isset($media) && is_array($media)) ? $media['description'] : 'Photo de profil' ?>">
        <h1><?= $user['lastname'] ?> <?= $user['firstname'] ?></h1>
        <p><?= $user['occupation'] ?></p>
        <a href="mailto:<?= $user['email'] ?>"><?= $user['email'] ?></a>
        <p><?= $user['city'] ?>, <?= $user['country'] ?></p>
        <a href="/profile/edit">Modifier mon profil</a>
    </article>

    <article>
        <h3>À propos de l'utilisateur</h3>
        <p><?= $user['description'] ?></p>

        <h4>Expérience professionnelle</h4>
        <p><?= $user['experience'] ?></p>

        <h4>Formations</h4>
        <p><?= $user['study'] ?></p>

        <h4>Compétences</h4>
        <p><?= $user['competence'] ?></p>

        <h4>Intérêts</h4>
        <p><?= $user['interest'] ?></p>
    </article>

    <article>
        <h3>Sur le web</h3>
        <a href="<?= $user['website'] ?>">Portfolio</a>

        <?php if (isset($user['link']) && !empty($user['link'])) {
            echo '<a href='.$user['link'].'>Lien</a>';
        } ?>
    </article>

</section>


<section>
    <h2>Projets</h2>

    <?php foreach ($projects as $project) {
        echo '<article>
            <a href="/projects/'.$project['slug'].'">
                <h4>'.$project['title'].'</h4>
                <img href="" alt="">
            </a>
        </article>';
    }
    ?>
</section>
