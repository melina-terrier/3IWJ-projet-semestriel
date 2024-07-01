
<section>
    
    <h1>Tableau de bord</h1>

    <article class="card">
        <h3>Pages</h3>
        <p><?php echo $elementsCount['pages']; ?></p>
    </article>

    <article class="card">
        <h3>Projets</h3>
        <p><?php echo $elementsCount['projects']; ?></p>
    </article>

    <div id="donutChart"></div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"> </script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js">    </script>
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
    </script>

        <article class="card">
            <h3>Tags</h3>
        </article>



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
    </article>
        
    <article class="card">
        <h3>Médias</h3>
        <button class="view-all">View All</button>
      </a>
      <a href="/dashboard/comments" class="card yellow">
        <div class="title">Médias</div>
        <p><?php echo $elementsCount['medias']; ?></p>
    </article>

    <article class="card">
        <h3>Utilisateurs</h3>
        <button class="view-all">View All</button>
      </a>
      <a href="/dashboard/categories" class="card orange">
        <div class="title">Utilisateurs</div>
        <p><?php echo $elementsCount['users']; ?></p>
    </article>
        <button class="view-all">View All</button>
      </a>

    <article class="card">
        <h3>Admin</h3>
      <a href="/dashboard/categories" class="card blue">
        <div class="title">Admin</div>
        <p><?php echo $elementsCount['admin']; ?></p>
    </article>

    <article class="card">
        <h3>Commentaires</h3>
        <button class="view-all">View All</button>
      </a>
      <a href="/dashboard/categories" class="card green">
        <div class="title">Commentaires</div>
        <p><?php echo $elementsCount['comments']; ?></p>
    </article>

</section>
        <button class="view-all">View All</button>
      </a>
    </section>

<section>
    <h2>Commentaires en attentes de validation</h2>
    <?php ?>
</section>