<h1>Tableau de bord</h1>

<section>

    <article class="card">
        <h3>Pages</h3>
        <p><?php echo $elementsCount['pages']; ?></p>
    </article>

    <article class="card">
        <h3>Projets</h3>
        <p><?php echo $elementsCount['projects']; ?></p>
    </article>

    <article class="card">
        <h3>Tags</h3>
        <p><?php echo $elementsCount['tags']; ?></p>
    </article>
        
    <article class="card">
        <h3>Médias</h3>
        <p><?php echo $elementsCount['medias']; ?></p>
    </article>

    <article class="card">
        <h3>Utilisateurs</h3>
        <p><?php echo $elementsCount['users']; ?></p>
    </article>

    <article class="card">
        <h3>Admin</h3>
        <p><?php echo $elementsCount['admin']; ?></p>
    </article>

    <article class="card">
        <h3>Commentaires</h3>
        <p><?php echo $elementsCount['comments']; ?></p>
    </article>

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

<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>


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

