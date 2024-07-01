<section id="user">

    <h1>Nos utilisateurs</h1>

    <?php
    foreach($users as $user){
        echo '<article class="card">
            <a href="/profiles/'.$user['slug'].'">
                <img src="'.$user['photo'].'" alt="'.htmlentities($user['photoDescription']).'" class="user-photo">
                <div class="user-info">
                    <h3>'.htmlentities($user['lastname']).' '.htmlentities($user['firstname']).'</h3>
                    <p>'.htmlentities($user['occupation']).'</p>
                </div>
            </a>
        </article>';
    }
    ?>
</section>
