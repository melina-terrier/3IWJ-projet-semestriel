<?php
usort($projects, function($a, $b) {
        return strtotime($a['publication_date']) - strtotime($b['publication_date']);
    });
    $projects = array_reverse($projects);
?>
?>

<?=$title ?>
<?=$description;

foreach($projects as $project){
    echo $project['title'];
    echo $project['content'];
}