

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

    <?php if (!empty($seoAdvices) && !empty($seoStatus)) {
        echo '<article class="card">
            <h3>Conseil SEO</h3>
            <p>État SEO : '.htmlentities($seoStatus).'</p>
        <ul>';
            foreach ($seoAdvices as $advice){
                echo '<li>'.htmlentities($advice).'</li>';
            }
        echo '</ul>
        </article>';
    } ?>
    
    <?php if (!empty($errorsForm)): ?>
        <ul>
            <?php foreach ($errorsForm as $error): ?>
                <li class="error"><?php echo htmlentities($error); ?></li>
            <?php endforeach; ?>
            </ul>
    <?php endif; ?>

    <?php if (!empty($successForm)): ?>
        <div>
            <?php foreach ($successForm as $message): ?>
                <p class="text"><?php echo htmlspecialchars($message); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; 

    ?>

</section>
