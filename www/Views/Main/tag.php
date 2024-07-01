<?=$title ?>
<?=$description;

foreach($projects as $project){
    echo $project['title'];
    echo $project['content'];
}