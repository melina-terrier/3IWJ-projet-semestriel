
<section>
    
    <h1>Tableau de bord</h1>

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



  <section>

      <a href="/dashboard/pages" class="card green">
        <div class="title">Page</div>
        <p><?php echo $elementsCount['pages']; ?></p>
      </a>

      <a href="/dashboard/projects" class="card blue">
        <div class="title">Projets</div>
        <p><?php echo $elementsCount['projects']; ?></p>
      </a>

      <a href="/dashboard/tags" class="card orange">
        <div class="title">Tags</div>
        <p><?php echo $elementsCount['tags']; ?></p>
      </a>

      <a href="/dashboard/users" class="card orange">
        <div class="title">Utilisateurs</div>
        <p><?php echo $elementsCount['users']; ?></p>
      </a>

      <a href="/dashboard/users" class="card blue">
        <div class="title">Admin</div>
        <p><?php echo $elementsCount['admin']; ?></p>
      </a>

      <a href="/dashboard/comments" class="card green">
        <div class="title">Commentaires</div>
        <p><?php echo $elementsCount['comments']; ?></p>
      </a>

  </section>


<section class="comments">
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