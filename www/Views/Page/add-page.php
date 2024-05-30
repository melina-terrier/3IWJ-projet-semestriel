<?php 

if (empty($this->data['page']->getId())) {
    echo "<h2>Nouvelle page</h2>";
} else {
    echo "<h2>Modification de la page</h2>";
}


$status = $this->data['page']->getStatus();


if (!empty($this->data['mandatoryFields'])) {
    $missingFields = implode("<br>", $this->data['mandatoryFields']);
    echo "<div style='color: red'>$missingFields</div>";
}

?>   
    
<script type="text/javascript">

    const imgLists = [<?php
        if (!empty($this->data['mediasList'])) {
            foreach ($this->data['mediasList'] as $media) {
                $title = $media['title'];
                $value = $media['value'];
                echo "{title: '$title', value: '$value'},";
            }
        }
    ?>]

    const useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const isSmallScreen = window.matchMedia('(max-width: 1023.5px)').matches;

    tinymce.init({
    selector: '#content',
    plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons accordion',
    editimage_cors_hosts: ['picsum.photos'],
    menubar: 'file edit view insert format tools table help',
    toolbar: "undo redo | accordion accordionremove | blocks fontfamily fontsize | bold italic underline strikethrough | align numlist bullist | link image | table media | lineheight outdent indent| forecolor backcolor removeformat | charmap emoticons | code fullscreen preview | save print | pagebreak anchor codesample | ltr rtl",
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
        /* Provide file and text for the link dialog */
        if (meta.filetype === 'file') {
        callback('https://www.google.com/logos/google.jpg', { text: 'My text' });
        }

        /* Provide image and alt text for the image dialog */
        if (meta.filetype === 'image') {
        callback('https://www.google.com/logos/google.jpg', { alt: 'My alt text' });
        }

        /* Provide alternative source and posted for the media dialog */
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

    <h2>Créer une page</h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
        
        <input type="number" hidden name="id" value="<?php echo $this->data['page']->getId() ?? '' ?>"/>

        <input name="pageSlug" id="pageName" class="pageName" placeholder="Nom de la page ..." value="<?php echo $this->data['page']->getSlug() ?? '' ?>"><br>

        <label for="title">Titre</label><br>
        <input type="text" required name="title" value="<?php echo $this->data['page']->getTitle() ?? '' ?>"><br>

        <label for="content">Contenu de la page</label><br>
        <textarea id="content" name="content" rows="15" cols="80"><?php echo $this->data['page']->getContent() ?? '' ?></textarea>
        <br />

        <input type="submit" name="save" value="Submit" />
    </form>