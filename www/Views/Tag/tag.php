<section>

        <h1>Ajouter une catégorie</h1>

        <?= $form ?>

        <?php 
        if (!empty($errors)){
            echo '<ul class="errors">'; 
            foreach ($errors as $error){
               echo '<li class="error"><?php echo htmlentities($error); ?></li>';
            }
            echo '</ul>';
        }
        ?>

</section>