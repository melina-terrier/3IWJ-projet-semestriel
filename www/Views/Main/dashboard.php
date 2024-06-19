<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="../styles/dist/main.css">

</head>
<body>
<main>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Catégorie', 'Nombre'],
                ['Visiteurs', <?php echo $nombreVisiteursNonInscrits; ?>],
                ['Abonnés', <?php echo $nombreUtilisateursInscrits; ?>],
                ['Auteurs', 0 ] 
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

    <div class="dashboard">
        <h2>Tableau de bord</h2>
        <p class="subtitle">Bonjour, <strong><?php echo htmlspecialchars($lastname); ?> <?php echo htmlspecialchars($firstname); ?></strong>!
            <br>Vous êtes connecté en tant que <em><?php echo htmlspecialchars($roles); ?></em>
        </p>

        <section class="dashboard-cards">
        <a href="/dashboard/pages" class="dashboard-card green">
        <article class="card">
                    <div class="text">
                        <div class="title">Page</div>
                        <div class="number"><?php echo htmlspecialchars($elementsCount['pages']); ?></div>
                    </div>
                    <button class="view-all">View All</button>
             </article>
            </a>
            <a href="/dashboard/projects" class="dashboard-card purple">
            <article class="card">
                    <div class="text">
                        <div class="title">Projets</div>
                        <div class="number"><?php echo htmlspecialchars($elementsCount['projects']); ?></div>
                    </div>
                    <button class="view-all">View All</button>
             </article>
            </a>
            <a href="/dashboard/user" class="dashboard-card dark">
            <article class="card">
                    <div class="text">
                        <div class="title">Utulisateurs</div>
                        <div class="number"><?php echo htmlspecialchars($elementsCount['users']); ?></div>
                    </div>
                    <button class="view-all">View All</button>
             </article>
            </a>
            <a href="/dashboard/comments" class="dashboard-card blue">
            <article class="card">
                    <div class="text">
                        <div class="title">Commentaires</div>
                        <div class="number"><?php echo htmlspecialchars($elementsCount['comments']); ?></div>
                    </div>
                    <button class="view-all">View All</button>
            </article>
            
            
        </section>
    </div>
        <div>
            <p>Nombre d'utilisateurs inscrits : <?php echo htmlspecialchars($nombreUtilisateursInscrits); ?></p>
            <p>Nombre de visiteurs non inscrits : <?php echo htmlspecialchars($nombreVisiteursNonInscrits); ?></p>
        </div>
        <div id="chart_div" style="width: 900px; height: 500px;"></div>

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

        <section>
            <div class="card">
                <h3>Pages</h3>
                <p><?= htmlspecialchars($elementsCount['pages'] ?? 0); ?></p>
            </div>
            <div class="card">
                <h3>Projets</h3>
                <p><?= htmlspecialchars($elementsCount['projects'] ?? 0); ?></p>
            </div>
            <div class="card">
                <h3>Utilisateurs</h3>
                <p><?= htmlspecialchars($elementsCount['users'] ?? 0); ?></p>
            </div>
            <div class="card">
                <h3>Commentaires</h3>
                <p><?= htmlspecialchars($elementsCount['comments'] ?? 0); ?></p>
            </div>
            <div class="card">
                <h3>Catégories</h3>
                <p><?= htmlspecialchars($elementsCount['categories'] ?? 0); ?></p>
            </div>
            <div class="card">
                <h3>Médias</h3>
                <p><?= htmlspecialchars($elementsCount['medias'] ?? 0); ?></p>
            </div>
        </section>
    </div>
        </main>
</body>
</html>
