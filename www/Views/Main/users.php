<section id="userSection">
    <h1 class="welcome-message">Nos utilisateurs</h1>

    <?php
    foreach($users as $user){
        echo '<article class="user-card">
            <a href="/profiles/'.$user['slug'].'">
                <img src="'.$user['photo'].'" alt="'.$user['photoDescription'].'" class="user-photo">
                <div class="user-info">
                    <h3 class="user-name">'.$user['lastname'].' '.$user['firstname'].'</h3>
                    <p class="user-occupation">'.$user['occupation'].'</p>
                </div>
            </a>
        </article>';
    }
    ?>
</section>
