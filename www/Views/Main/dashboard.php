<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Catégorie', 'Nombre'],
            ['Visiteurs', <?php echo $nombreVisiteursNonInscrits; ?>],
            ['Abonnés', <?php echo $elementsCount['users']; ?>],
            ['Auteurs', 0 ] // Remplacez par votre valeur
        ]);

        var options = {
            title: 'Statistiques',
            chartArea: {width: '50%'},
            hAxis: {
                title: 'Nombre total',
                minValue: 0
            },
            vAxis: {
                title: 'Catégorie'
            }
        };

        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>


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

<section>
	<p>Nombre d'utilisateurs inscrits : <?php echo htmlspecialchars($elementsCount['users']); ?></p>

    <p>Nombre d'utilisateurs inscrits par jour : <?php echo htmlspecialchars($elementsCount['userByDay']); ?></p>
    <p>Nombre d'utilisateurs inscrits par Mois : <?php echo htmlspecialchars($elementsCount['userByMonth']); ?></p>
    <p>Nombre d'utilisateurs inscrits par Ans : <?php echo htmlspecialchars($elementsCount['userByYear']); ?></p>

    <p>Nombre de projets créées par jour : <?php echo htmlspecialchars($elementsCount['projectByDay']); ?></p>
    <p>Nombre de projets créées par Mois : <?php echo htmlspecialchars($elementsCount['projectByMonth']); ?></p>
    <p>Nombre de projets créées par Ans : <?php echo htmlspecialchars($elementsCount['projectByYear']); ?></p>

    <p>Nombre de projets créées par utilisateur : <?php echo htmlspecialchars($elementsCount['projectByUser']); ?></p>

    <p>Nombre de visiteurs non inscrits : <?php echo htmlspecialchars($nombreVisiteursNonInscrits); ?></p>

    <div id="chart_div" style="width: 900px; height: 500px;"></div>
</section>

<div id="usersProjects">
    <h2>Utilisateurs et nombre de projets réalisés</h2>
    <ul>
        <?php if (isset($labels) && is_array($labels) && isset($data) && is_array($data)) : ?>
            <?php foreach ($labels as $index => $label) : ?>
                <li><?php echo htmlspecialchars($label . ' : ' . $data[$index] . ' projets réalisés'); ?></li>
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
                height: 350,
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
});
</script>