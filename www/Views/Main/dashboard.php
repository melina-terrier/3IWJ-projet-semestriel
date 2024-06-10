<h2>Tableau de bord</h2>
<p class="subtitle">Bonjour, <strong><?php echo htmlspecialchars($lastname); ?> <?php echo htmlspecialchars($firstname); ?> </strong>!
    <br>Vous êtes connecté en tant que <em><?php echo htmlspecialchars($roles); ?></em>

</p>
<section class="dashboard-cards">
    <a href="/dashboard/pages">
		<div class="block-card-dashboard">
			<div class="block-card-dashboard-total blue">
				<img src="/Views/styles/dist/images/pages.png" alt="pages-image">
				<div class="block-card-dashboard-total-text">
					<div class="title">Pages</div>
					<div class="number"><?php echo htmlspecialchars($elementsCount['pages']); ?></div>
				</div>
		</div>
	</a>
	<a href="/dashboard/user">
		<div class="block-card-dashboard-total blue">
			<img src="/Views/styles/dist/images/profil.png" alt="users-image">
			<div class="block-card-dashboard-total-text">
				<div class="title">Utilisateurs</div>
				<div class="number"><?php echo htmlspecialchars($elementsCount['users']); ?></div>
			</div>
		</div>
	</a>
	</div>

    <div class="block-card-dashboard">
	<a href="/dashboard/medias">
		<div class="block-card-dashboard-total green">
			<img src="/Views/styles/dist/images/video.png" alt="video-image">
			<div class="block-card-dashboard-total-text">
				<div class="title">Médias</div>
				<div class="number"><?php echo htmlspecialchars($elementsCount['medias']); ?></div>
			</div>
		</div>
	</a>
    <a href="/dashboard/projects">
        <div class="block-card-dashboard-total green">
            <img src="/Views/styles/dist/images/comment.png" alt="comment-image">
            <div class="block-card-dashboard-total-text">
                <div class="title">Projets</div>
                <div class="number"><?php echo htmlspecialchars($elementsCount['projects']); ?></div>
            </div>
        </div>
    </a>
	</div>
    <div class="block-card-dashboard">
	<a href="/dashboard/comments">
		<div class="block-card-dashboard-total blue">
			<img src="/Views/styles/dist/images/avis.png" alt="avis-image">
			<div class="block-card-dashboard-total-text">
				<div class="title">Commentaires</div>
				<div class="number"><?php echo htmlspecialchars($elementsCount['comments']); ?></div>
			</div>
		</div>
	</a>
	</div>

    <!-- Autres statistiques -->
    <!-- Ajoutez ici d'autres statistiques si nécessaire -->
</div>
</section>

<!DOCTYPE html>

<head>
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
</head>
<body>
    <div>
	<p>Nombre d'utilisateurs inscrits : <?php echo htmlspecialchars($nombreUtilisateursInscrits); ?></p>
<p>Nombre de visiteurs non inscrits : <?php echo htmlspecialchars($nombreVisiteursNonInscrits); ?></p>

    </div>
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
</body>
</html>




<!-- Affichage des utilisateurs et du nombre de projets réalisés -->
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
<!-- Affichage du graphique en du user selon projet -->
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
            <p><?= $elementsCount['pages'] ?? 0; ?></p>
        </div>
        <div class="card">
            <h3>Projets</h3>
            <p><?= $elementsCount['projects'] ?? 0; ?></p>
        </div>
        <div class="card">
            <h3>Utilisateurs</h3>
            <p><?= $elementsCount['users'] ?? 0; ?></p>
        </div>
        <div class="card">
            <h3>Commentaires</h3>
            <p><?= $elementsCount['comments'] ?? 0; ?></p>
        </div>
        <div class="card">
            <h3>Catégories</h3>
            <p><?= $elementsCount['categories'] ?? 0; ?></p>
        </div>
        <div class="card">
            <h3>Médias</h3>
            <p><?= $elementsCount['medias'] ?? 0; ?></p>
        </div>
        <!-- Add other parts of the dashboard -->
    </div>
    <script src="path_to_your_js"></script>


                </section>