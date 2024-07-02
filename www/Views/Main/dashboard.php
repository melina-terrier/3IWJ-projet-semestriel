
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
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        var data = <?php echo isset($data) ? json_encode($data) : '[]'; ?>;
        var labels = <?php echo isset($labels) ? json_encode($labels) : '[]'; ?>;
        if (data.length > 0 && labels.length > 0) {
            new ApexCharts(document.querySelector("#donutChart"), {
                series: data,
                chart: {
                    height: 300,
                    type: 'donut',
                    toolbar: {
                        show: true
                    }
                },
                labels: labels,
                dataLabels: {
                    enabled: true,
                    formatter: function (val) {
                        return val.toFixed(0);
                    }
                }
            }).render();
        } else {
            document.querySelector("#donutChart").innerText = "Aucune donnée disponible pour afficher le graphique";
        }

        // Zone de recherche
        const searchInput = document.getElementById('searchInput');
        const userList = document.getElementById('userList');
        const userItems = userList.getElementsByTagName('li');
        const originalList = userList.innerHTML;

        searchInput.addEventListener('keyup', function() {
            const filter = searchInput.value.toLowerCase();
            let hasVisibleItems = false;

            if (filter === "") {
                userList.style.display = 'none';
                userList.innerHTML = originalList;
                return;
            }

            for (let i = 0; i < userItems.length; i++) {
                const label = userItems[i].getAttribute('data-label').toLowerCase();
                if (label.includes(filter)) {
                    userItems[i].style.display = '';
                    hasVisibleItems = true;
                } else {
                    userItems[i].style.display = 'none';
                }
            }

            if (hasVisibleItems) {
                userList.style.display = '';
            } else {
                userList.innerHTML = '<li>Aucun utilisateur trouvé</li>';
                userList.style.display = '';
            }
        });
    });
</script>




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
      <a href="/dashboard/categories" class="card orange">
        <div class="title">Utilisateurs</div>
        <p><?php echo $elementsCount['users']; ?></p>
        <button class="view-all">View All</button>
      </a>

      <a href="/dashboard/categories" class="card blue">
        <div class="title">Admin</div>
        <p><?php echo $elementsCount['admin']; ?></p>
        <button class="view-all">View All</button>
      </a>
      <a href="/dashboard/categories" class="card green">
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

<script src="https://cdn.amcharts.com/lib/5/index.js"> </script>
<script src="https://cdn.amcharts.com/lib/5/xy.js">    </script>


<script>

    function displayData($id, $data) {
        var root = am5.Root.new($id);

        var chart = root.container.children.push(
            am5xy.XYChart.new(root, {
                panY: false,
                wheelY: "zoomX",
                layout: root.verticalLayout
            })
        );


        const data = [];
        for (const label in $data) {
            data.push({
                label: label,
                value: $data[label]
            });
        }
        
        let yAxis = chart.yAxes.push(
            am5xy.ValueAxis.new(root, {
                renderer: am5xy.AxisRendererY.new(root, {
                }),
            })
        );

        var xAxis = chart.xAxes.push(
            am5xy.CategoryAxis.new(root, {
                maxDeviation: 0.2,
                renderer: am5xy.AxisRendererX.new(root, {
                }),
                categoryField: "label"
            })
        );
        xAxis.data.setAll(data);

        var series1 = chart.series.push(
            am5xy.ColumnSeries.new(root, {
                name: "Series",
                xAxis: xAxis,
                yAxis: yAxis,
                valueYField: "value",
                categoryXField: "label",
                tooltip: am5.Tooltip.new(root, {})
            })
        );
        series1.data.setAll(data);
    }

</script>


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