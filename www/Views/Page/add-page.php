<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un projet</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<section>

    <div class="aj_projet_container">
        <h1 class="aj_projet_title">Ajouter une Page </h1>

        <form action="process_project_form.php" method="post" enctype="multipart/form-data" class="aj_projet_form">
            <div class="aj_projet_form_group">
                <label for="title">Titre *</label>
                <input type="text" id="title" name="title" required>
            </div>

            <div class="aj_projet_form_group">
                <label for="content">Contenu *</label>
                <textarea id="content" name="content" required></textarea>
            </div>

            <div class="aj_projet_form_group">
                <label for="slug">slug *</label>
                <input type="text" id="slug" name="Slug" required>
            </div>

            <div class="aj_projet_form_group">
                <label for="status">Statut *</label>
                <select id="status" name="status" required>
                    <option value="draft">Brouillon</option>
                    <option value="published">Publié</option>
                </select>
            </div>

            <div class="aj_user_form_button_container">
                <button class="button button--active button--sm" type="submit">Créer la page</button>
            </div>
        </form>

        <?php if (isset($successForm) && !empty($successForm)): ?>
            <div class="aj_projet_message aj_projet_success-message">
                <?php foreach ($successForm as $message): ?>
                    <p><?php echo $message; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($errorsForm) && !empty($errorsForm)): ?>
            <div class="aj_projet_message aj_projet_error-message">
                <?php foreach ($errorsForm as $message): ?>
                    <p><?php echo $message; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

</section>

<script type="text/javascript">
    const imgLists = [<?php
        if (!empty($this->data['mediasList'])) {
            foreach ($this->data['mediasList'] as $media) {
                $title = htmlentities($media['title']);
                $value = $media['value'];
                echo "{title: '$title', value: '$value'},";
            }
        }
    ?>];

    const useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const isSmallScreen = window.matchMedia('(max-width: 1023.5px)').matches;

    tinymce.init({
        selector: '#content',
        plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
        editimage_cors_hosts: ['picsum.photos'],
        menubar: 'file edit view insert format tools table help',
        toolbar: "undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | align numlist bullist | link image | table media | lineheight outdent indent| forecolor backcolor removeformat | charmap emoticons | code fullscreen preview | save print | pagebreak anchor codesample | ltr rtl",
        autosave_ask_before_unload: true,
        autosave_interval: '30s',
        image_list: imgLists,
        autosave_prefix: '{path}{query}-{id}-',
        autosave_restore_when_empty: false,
        autosave_retention: '2m',
        image_advtab: true,
        link_list: [
            { title: 'My page 1', value: 'https://www.tiny.cloud' },
            { title: 'My page 2', value: 'http://www.moxiecode.com' }
        ],
        image_class_list: [
            { title: 'None', value: '' },
            { title: 'Some class', value: 'class-name' }
        ],
        importcss_append: true,
        file_picker_callback: (callback, value, meta) => {
            if (meta.filetype === 'file') {
                callback('https://www.google.com/logos/google.jpg', { text: 'My text' });
            }
            if (meta.filetype === 'image') {
                callback('https://www.google.com/logos/google.jpg', { alt: 'My alt text' });
            }
            if (meta.filetype === 'media') {
                callback('movie.mp4', { source2: 'alt.ogg', poster: 'https://www.google.com/logos/google.jpg' });
            }
        },
        height: 600,
        image_caption: true,
        quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
        noneditable_class: 'mceNonEditable',
        toolbar_mode: 'sliding',
        contextmenu: 'link image table',
        skin: useDarkMode ? 'oxide-dark' : 'oxide',
        content_css: useDarkMode ? 'dark' : 'default',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
    });
</script>

<section>

    <h1>Créer une page</h1>

    <?= $form ?>

    <article>
        <h3>Conseil SEO</h3>
        <p>État SEO : <?= htmlspecialchars($seoStatus) ?></p>
        <ul>
            <?php foreach ($seoAdvices as $advice): ?>
                <li><?= htmlspecialchars($advice) ?></li>
            <?php endforeach; ?>
        </ul>
    </article>
    
    <?php if (!empty($errorsForm)): ?>
        <div>
            <?php foreach ($errorsForm as $error): ?>
                <p class="text"><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($successForm)): ?>
        <div>
            <?php foreach ($successForm as $message): ?>
                <p class="text"><?php echo htmlspecialchars($message); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; 
    
    echo $seoScore; 
    echo $seoSuggestions; 
    ?>

</section>
