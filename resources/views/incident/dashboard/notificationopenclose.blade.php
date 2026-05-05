<style>
    .incident-card {
        background: #fff;
        border-radius: 12px;
        padding: 10px;
    }

    .legend-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 6px;
    }

    .red {
        background: #dc3545;
    }

    .green {
        background: #22c55e;
    }

    .no-data {
        text-align: center;
        color: #dc3545;
        font-weight: bold;
    }
</style>

<div class="incident-card">
    <div class="d-flex align-items-center">

        <!-- Donut Chart -->
        <div id="incident_openClose" style="width: 400px;"></div>

        <!-- Custom Legend -->
        <div class="ms-3 w-100" id="incident_legend"></div>

    </div>
</div>

<script>
    var incidet_loseData = @json($incident);

    var labels = [];
    var series = [];
    var openValue = 0;

    for (var key in incidet_loseData) {
        if (incidet_loseData.hasOwnProperty(key)) {

            labels.push(key);
            series.push(incidet_loseData[key]);

            // center value (OPEN)
            if (key.toLowerCase().includes('open')) {
                openValue = incidet_loseData[key];
            }
        }
    }

    // No data
    if (series.length === 0 || series.every(v => v === 0)) {
        document.getElementById("incident_openClose").innerHTML =
            "<div class='no-data'>No Data Found</div>";
    } else {

        var options = {
            chart: {
                type: 'donut',
                height: 195
            },

            series: series,
            labels: labels,

            colors: ['#0d6efd', '#22c55e'],

            legend: {
                show: false
            },

            dataLabels: {
                enabled: false
            },

            plotOptions: {
                pie: {
                    donut: {
                        size: '70%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Open',
                                formatter: function() {
                                    return openValue;
                                }
                            }
                        }
                    }
                }
            },

            // OPTIONAL CLICK EVENT
            events: {
                dataPointSelection: function(event, chartContext, config) {
                    const label = labels[config.dataPointIndex];
                    console.log("Clicked:", label);
                }
            }
        };

        var chart = new ApexCharts(
            document.querySelector("#incident_openClose"),
            options
        );

        chart.render();

        // Custom Legend
        var legendHtml = '';

        labels.forEach(function(label, i) {

            let colorClass = i === 0 ? 'red' : 'green';

            legendHtml += `
                <div class="d-flex justify-content-between mb-2">
                    <span>
                        <span class="legend-dot ${colorClass}"></span>
                        ${label}
                    </span>
                    <span>${series[i]}</span>
                </div>
            `;
        });

        document.getElementById('incident_legend').innerHTML = legendHtml;
    }
</script>
