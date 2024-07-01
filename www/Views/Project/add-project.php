<script>
        tinymce.init({
            selector: '#content',
            width: "100%",
            height: 500,
            resize: false,
            autosave_ask_before_unload: false,
            powerpaste_allow_local_images: true,
            plugins: [
                'advlist', 'anchor', 'autolink', 'codesample', 'fullscreen', 'help',
                'insertimage', 'tinydrive', 'lists', 'link', 'media', 'preview',
                'searchreplace', 'table', 'visualblocks', 'wordcount'
            ],
            toolbar: 'insertfile a11ycheck undo redo | bold italic | forecolor backcolor | codesample | alignleft aligncenter alignright alignjustify | bullist numlist | link image',
            spellchecker_dialog: true,
            spellchecker_ignore_list: ['Ephox', 'Moxiecode'],
            tinydrive_demo_files_url: '../_images/tiny-drive-demo/demo_files.json',
            tinydrive_token_provider: (success, failure) => {
                success({ token: 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJqb2huZG9lIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.Ks_BdfH4CWilyzLNk8S2gDARFhuxIauLa8PwhdEQhEo' });
            },
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
        });
</script>

<section>
    <h1>Ajouter un nouveau projettt</h1>
    <?= $form ?>

    <?php if (isset($seoAdvices) && isset($seoStatus)) {
        echo "<article>
            <h3>Conseil SEO</h3>
            <p>État SEO : ".htmlspecialchars($seoStatus)."</p>
            <ul>";
                foreach ($seoAdvices as $advice) {
                    echo "<li>".htmlspecialchars($advice)."</li>";
                }
            echo "</ul>
        </article>";
    }?>
    
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
    <?php endif; ?>

</section>