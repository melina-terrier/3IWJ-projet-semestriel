<?php

usort($projects, function($a, $b) {
  return strtotime($a['publication_date']) - strtotime($b['publication_date']);
});
$projects = array_reverse($projects);

echo '<section>';

    if (isset($title) && isset($description)){
        echo '<h1>'.$title.'</h1>
        <p>'.$description.'</p>';
    } else {
        echo '<h1>Les projets</h1>';
    }

    foreach ($projects as $project) {
    echo '<article>
        <a href="/projects/' . $project['slug'] . '">
        <img src="' . $project['featured_image'] . '" alt="">
        <h4>' . $project['title'] . '</h4>';
        if ($project['category_name']) {
            echo '<p>' . $project['category_name'] . '</p>';
        }
    echo '</a>
        <a href="/profiles/' . $project['userSlug'] . '"><img src="'.$project['profile_photo'].'">' . $project['username'] . '</img></a>
    </article>';
    }

echo '</section>';