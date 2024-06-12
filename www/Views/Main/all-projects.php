<?php

foreach($projects as $project){
    echo $project['title'];
    echo $project['content'];
    if ($project['category_name']){
        echo $project['category_name'];
    }
}
?>