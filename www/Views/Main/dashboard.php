<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="../styles/dist/main.css">

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body>
    <!-- Header -->
    <header>
        <h1>Tableau de bord</h1>
        <p class="subtitle">Bonjour, <strong><?php echo htmlspecialchars($lastname); ?> <?php echo htmlspecialchars($firstname); ?></strong> !<br>
            Vous êtes connecté en tant que <em><?php echo htmlspecialchars($roles); ?></em>
        </p>
    </header>

    <!-- Navigation -->
    <nav>
        <ul>
            <li><a href="/dashboard/pages">Pages</a></li>
            <li><a href="/dashboard/user">Utilisateurs</a></li>
            <li><a href="/dashboard/medias">Médias</a></li>
            <li><a href="/dashboard/projects">Projets</a></li>
            <li><a href="/dashboard/comments">Commentaires</a></li>
            <!-- Add other navigation links as needed -->
        </ul>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <section class="dashboard-cards">
            <!-- Pages -->
            <a href="/dashboard/pages">
                <div class="block-card-dashboard">
                    <div class="block-card-dashboard-total blue">
                        <img src="/Views/styles/dist/images/pages.png" alt="pages-image">
                        <div class="block-card-dashboard-total-text">
                            <div class="title">Pages</div>
                            <div class="number"><?php echo htmlspecialchars($elementsCount['pages']); ?></div>
                        </div>
                    </div>
                </div>
            </a>
            <!-- Utilisateurs -->
            <a href="/dashboard/user">
                <div class="block-card-dashboard">
                    <div class="block-card-dashboard-total blue">
                        <img src="/Views/styles/dist/images/profil.png" alt="users-image">
                        <div class="block-card-dashboard-total-text">
                            <div class="title">Utilisateurs</div>
                            <div class="number"><?php echo htmlspecialchars($elementsCount['users']); ?></div>
                        </div>
                    </div>
                </div>
            </a>
            <!-- Médias -->
            <a href="/dashboard/medias">
                <div class="block-card-dashboard">
                    <div class="block-card-dashboard-total green">
                        <img src="/Views/styles/dist/images/video.png" alt="video-image">
                        <div class="block-card-dashboard-total-text">
                            <div class="title">Médias</div>
                            <div class="number"><?php echo htmlspecialchars($elementsCount['medias']); ?></div>
                        </div>
                    </div>
                </div>
            </a>
            <!-- Projets -->
            <a href="/dashboard/projects">
                <div class="block-card-dashboard">
                    <div class="block-card-dashboard-total green">
                        <img src="/Views/styles/dist/images/comment.png" alt="comment-image">
                        <div class="block-card-dashboard-total-text">
                            <div class="title">Projets</div>
                            <div class="number"><?php echo htmlspecialchars($elementsCount['projects']); ?></div>
                        </div>
                    </div>
                </div>
            </a>
            <!-- Visiteurs non inscrits -->
            <div class="block-card-dashboard">
                <div class="block-card-dashboard-total red">
                    <img src="/Views/styles/dist/images/visitor.png" alt="visitor-image">
                    <div class="block-card-dashboard-total-text">
                        <div class="title">Visiteurs non inscrits</div>
                        <div class="number"><?php echo htmlspecialchars($elementsCount['visitors']); ?></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="chart-section">
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
                google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ['Catégorie', 'Nombre'],
                        ['Visiteurs', <?php echo $nombreVisiteursNonInscrits; ?>],
                        ['Abonnés', <?php echo $nombreUtilisateursInscrits; ?>],
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

            <div>
                <p>Nombre d'utilisateurs inscrits : <?php echo htmlspecialchars($nombreUtilisateursInscrits); ?></p>
                <p>Nombre de visiteurs non inscrits : <?php echo htmlspecialchars($nombreVisiteursNonInscrits); ?></p>
            </div>
            <div id="chart_div" style="width: 900px; height: 500px;"></div>
        </section>

        <section class="chart-section">
            <div id="donutChart"></div>
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
        </section>

        <section class="summary-cards">
            <article class="card">
                <h3>Pages</h3>
                <p><?= $elementsCount['pages'] ?? 0; ?></p>
            </article>
            <article class="card">
                <h3>Projets</h3>
                <p><?= $elementsCount['projects'] ?? 0; ?></p>
            </article>
            <article class="card">
                <h3>Utilisateurs</h3>
                <p><?= $elementsCount['users'] ?? 0; ?></p>
            </article>
            <article class="card">
                <h3>Commentaires</h3>
                <p><?= $elementsCount['comments'] ?? 0; ?></p>
            </article>
            <div class="card">
                <h3>Médias</h3>
                <p><?= $elementsCount['medias'] ?? 0; ?></p>
            </div>
            <div class="card">
                <h3>Visiteurs non inscrits</h3>
                <p><?= $elementsCount['visitors'] ?? 0; ?></p>
            </div>
        </section>
    </main>

    <script src="path_to_your_js"></script>
</body>
</html>
