<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="path/to/your/styles.css">
</head>
<body>
    <div class="comment-page">
        <header>
            <h1>Le titre de projet est : <?= htmlspecialchars($title) ?></h1>
            <p class="tag"><?= htmlspecialchars($tagName) ?></p>
        </header>
        <article class="content">
            <?= $content ?>
        </article>
        <section class="comments-section">
            <h1>Les Commentaires a ce projet</h1>
            <?php foreach ($comments as $comment): ?>
                <div class="comment">
                    <p class="comment-author">Nom du éditeur : <?= htmlspecialchars($comment["name"]) ?></p>
                    <p class="comment-text">Leur commentaire : <?= htmlspecialchars($comment["comment"]) ?></p>
                </div>
            <?php endforeach; ?>
        </section>
        <section class="comment-form-section">
            <h1>Ecrire un commentaire</h1>
            <?= $form ?>
            <?php if (!empty($errorsForm)): ?>
                <div class="errors">
                    <?php foreach ($errorsForm as $error): ?>
                        <p class="error-text"><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($successForm)): ?>
                <div class="success">
                    <?php foreach ($successForm as $message): ?>
                        <p class="success-text"><?php echo htmlspecialchars($message); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </div>
</body>
</html>
