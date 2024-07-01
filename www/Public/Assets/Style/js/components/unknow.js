<script>
window.addEventListener("scroll", function () {
    console.log(window.scrollY);
    const header = document.getElementById("header");
    if (window.scrollY > 0) {
        header.classList.add("sticky");
    } else {
        header.classList.remove("sticky");
    }
});
</script>

<script>
        window.addEventListener("scroll", function () {
            console.log(window.scrollY);
            const header = document.getElementById("header");
            if (window.scrollY > 0) {
                header.classList.add("sticky");
            } else {
                header.classList.remove("sticky");
            }
        });
    </script>


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

<script src="https://cdn.amcharts.com/lib/5/index.js"> </script>
<script src="https://cdn.amcharts.com/lib/5/xy.js">    </script>

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