
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style/src/css/main.css">

</head>

<body >
  

<div id="usersProjects">
    <h2>Utilisateurs et nombre de projets réalisés</h2>
    <input type="text" id="searchInput" placeholder="Rechercher un utilisateur">
    <ul id="userList" style="display: none;">
        <?php if (isset($labels) && is_array($labels) && isset($data) && is_array($data)) : ?>
            <?php foreach ($labels as $index => $label) : ?>
                <li data-label="<?php echo htmlspecialchars($label); ?>">
                    <?php echo htmlspecialchars($label . ' : ' . $data[$index] . ' projets réalisés'); ?>
                </li>
            <?php endforeach; ?>
        <?php else : ?>
            <li>Aucune donnée disponible</li>
        <?php endif; ?>
    </ul>
</div>
<div id="donutChart"></div>
  <div class="main-content">
    
    <section class="dashboard-cards">
      <a href="/dashboard/pages" class="card green">
        <div class="title">Page</div>
        <p><?php echo $elementsCount['pages']; ?></p>
        <button class="view-all ">View All</button>
      </a>
      <a href="/dashboard/projects" class="card blue">
        <div class="title">Projets</div>
        <p><?php echo $elementsCount['projects']; ?></p>
        <button class="view-all">View All</button>
      </a>
      <a href="/dashboard/users" class="card orange">
        <div class="title">Tags</div>
        <p><?php echo $elementsCount['tags']; ?></p>
        <button class="view-all">View All</button>
      </a>
      <a href="/dashboard/comments" class="card yellow">
        <div class="title">Médias</div>
        <p><?php echo $elementsCount['medias']; ?></p>
        <button class="view-all">View All</button>
      </a>
      <a href="/dashboard/users" class="card orange">
        <div class="title">Utilisateurs</div>
        <p><?php echo $elementsCount['users']; ?></p>
        <button class="view-all">View All</button>
      </a>

      <a href="/dashboard/users" class="card blue">
        <div class="title">Admin</div>
        <p><?php echo $elementsCount['admin']; ?></p>
        <button class="view-all">View All</button>
      </a>
      <a href="/dashboard/tags" class="card green">
        <div class="title">Commentaires</div>
        <p><?php echo $elementsCount['comments']; ?></p>
        <button class="view-all">View All</button>
      </a>
    </section>

<section>
    <h2>Commentaires en attentes de validation</h2>
    <?php 
        foreach ($comments as $comment) {
            if($comment['status'] == 0){
                echo '<article>
                    <p>'.$comment["name"].'</p>
                    <p>'.$comment["comment"].'<p>
                </article>';
            }
        }
    ?>
</section>


<?php 
    foreach ($elementsCount['userByMonth'] as $year => $monthsData) {
        foreach($monthsData as $month => $days){
            setlocale(LC_TIME, 'fr_FR');
            $monthName = strftime("%B", mktime(0, 0, 0, $month, 1, date('Y')));
            echo "<h2>Nouveaux comptes créés en $monthName $year </h2>";
            echo "<div id='usersByDay-$year-$month' style='width: 100%; height: 500px;'></div>";?>
            <script>
                displayData('usersByDay-<?php echo $year . '-' . $month; ?>', <?php echo json_encode($days); ?>);
            </script>
    <?php } 
    }
?>

<?php 
    foreach ($elementsCount['userByYear'] as $year => $monthsData) {
        echo "<h2>Nouveaux comptes créés en $year</h2>";
        echo "<div id='usersByMonth-$year' style='width: 100%; height: 500px;'></div>";?>
        <script>
            displayData('usersByMonth-<?php echo $year; ?>', <?php echo json_encode($monthsData); ?>);
        </script>
    <?php 
    }
?>

<?php 
    foreach ($elementsCount['projectByMonth'] as $year => $monthsData) {
        foreach($monthsData as $month => $days){
            $monthName = date('F', $month); 
            echo "<h2>Projets publiés en $monthName $year </h2>";
            echo "<div id='projectsByDay-$year-$month' style='width: 100%; height: 500px;'></div>";?>
            <script>
                displayData('projectsByDay-<?php echo $year . '-' . $month; ?>', <?php echo json_encode($days); ?>);
            </script>
    <?php } 
    }
?>

<?php 
    foreach ($elementsCount['projectByYear'] as $year => $monthsData) {
        echo "<h2>Projets publiés en $year</h2>";
        echo "<div id='projectsByMonth-$year' style='width: 100%; height: 500px;'></div>";?>
        <script>
            displayData('projectsByMonth-<?php echo $year; ?>', <?php echo json_encode($monthsData); ?>);
        </script>
    <?php 
    }
?>

<h2>Nombre de projets publiés par utilisateur</h2>
<div id="projectsByUser" style="width: 100%; height: 500px;"></div>
<script>
    displayData('projectsByUser', <?php echo json_encode($elementsCount['projectByUser']); ?>);
</script>

  </body>