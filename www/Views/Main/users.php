<section>
    <h1>Nos utilisateurs</h1>

    <?php
    foreach($users as $user){
        echo '<article>
            <a href="/profiles/'.$user['slug'].'">
                <h3>'.$user['lastname'].' '.$user['firstname'].'</h3>
                <p>'.$user['occupation'].'</p>
                <img src="'.$user['photo'].'" alt="'.$user['photoDescription'].'">
            </a>
        </article>';
    }
    ?>

</section>