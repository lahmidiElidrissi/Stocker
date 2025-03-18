@extends('master')

@section('partialContent')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 d-flex flex-column">
          <div class="row flex-grow">
            <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
              <div class="card card-rounded">
                <div class="card-body">
                  <div class="d-sm-flex justify-content-between align-items-start">
                    <div>
                     <h4 class="card-title card-title-dash">{{ __('Dashbord.Commande-ceSemaine-der-semaine') }}</h4>
                     <h5 class="card-subtitle card-subtitle-dash"><?php echo(date("d/m/Y"))?></h5>
                    </div>
                    <div id="performance-line-legend"></div>
                  </div>
                  <div class="chartjs-wrapper mt-5">
                    <canvas id="performaneLine"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>
@stop



@section("js")
<!-- plugins:js -->
<script src="vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="vendors/chart.js/Chart.min.js"></script>
<script src="vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="vendors/progressbar.js/progressbar.min.js"></script>

<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="js/off-canvas.js"></script>
<script src="js/hoverable-collapse.js"></script>
<script src="js/template.js"></script>
<script src="js/settings.js"></script>
<script src="js/todolist.js"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="js/jquery.cookie.js" type="text/javascript"></script>
<script src="js/Chart.roundedBarCharts.js"></script>
<script>
  (function($) {
  'use strict';
  $(function() {
    $.ajax({
            type:'POST',
            url:"{{ Route('DashbordRapports') }}",
            data: {
             '_token' : "{{csrf_token()}}" ,
            },
            success:function(dataPerformaneLine) {
                if ($("#performaneLine").length) {
                var graphGradient = document.getElementById("performaneLine").getContext('2d');
                var graphGradient2 = document.getElementById("performaneLine").getContext('2d');
                var saleGradientBg = graphGradient.createLinearGradient(5, 0, 5, 100);
                saleGradientBg.addColorStop(0, 'rgba(26, 115, 232, 0.18)');
                saleGradientBg.addColorStop(1, 'rgba(26, 115, 232, 0.02)');
                var saleGradientBg2 = graphGradient2.createLinearGradient(100, 0, 50, 150);
                saleGradientBg2.addColorStop(0, 'rgba(0, 208, 255, 0.19)');
                saleGradientBg2.addColorStop(1, 'rgba(0, 208, 255, 0.03)');
                var salesTopData = {
                    labels: ["{{ __('Dashbord.DIM') }}","{{ __('Dashbord.LUN') }}","{{ __('Dashbord.MAR') }}","{{ __('Dashbord.MER') }}","{{ __('Dashbord.JEU') }}", "{{ __('Dashbord.VEN') }}", "{{ __('Dashbord.SEM') }}"],
                    datasets: [{
                        label: '{{ __("Dashbord.Cette-Semine") }}',
                        data: [dataPerformaneLine[0][0].Total_Quantite, dataPerformaneLine[1][0].Total_Quantite, dataPerformaneLine[2][0].Total_Quantite, dataPerformaneLine[3][0].Total_Quantite, dataPerformaneLine[4][0].Total_Quantite, dataPerformaneLine[5][0].Total_Quantite, dataPerformaneLine[6][0].Total_Quantite],
                        backgroundColor: saleGradientBg,
                        borderColor: [
                            '#1F3BB3',
                        ],
                        borderWidth: 1.5,
                        fill: true, // 3: no fill
                        pointBorderWidth: 1,
                        pointRadius: [4, 4, 4, 4, 4,4, 4],
                        pointHoverRadius: [2, 2, 2, 2, 2,2, 2],
                        pointBackgroundColor: ['#1F3BB3)', '#1F3BB3', '#1F3BB3', '#1F3BB3','#1F3BB3)', '#1F3BB3', '#1F3BB3'],
                        pointBorderColor: ['#fff','#fff','#fff','#fff','#fff','#fff','#fff',],
                    },{
                      label: '{{ __("Dashbord.Derniere-Semine") }}',
                      data: [dataPerformaneLine[7][0].Total_Quantite, dataPerformaneLine[8][0].Total_Quantite, dataPerformaneLine[9][0].Total_Quantite, dataPerformaneLine[10][0].Total_Quantite, dataPerformaneLine[11][0].Total_Quantite, dataPerformaneLine[12][0].Total_Quantite, dataPerformaneLine[13][0].Total_Quantite],
                      backgroundColor: saleGradientBg2,
                      borderColor: [
                          '#52CDFF',
                      ],
                      borderWidth: 1.5,
                      fill: true, // 3: no fill
                      pointBorderWidth: 1,
                      pointRadius: [4, 4, 4, 4, 4,4, 4],
                      pointHoverRadius: [0, 0, 0, 2, 0],
                      pointBackgroundColor: ['#52CDFF)', '#52CDFF', '#52CDFF', '#52CDFF','#52CDFF)', '#52CDFF', '#52CDFF'],
                        pointBorderColor: ['#fff','#fff','#fff','#fff','#fff','#fff','#fff',],
                  }]
                };

                var salesTopOptions = {
                  responsive: true,
                  maintainAspectRatio: false,
                    scales: {
                        yAxes: [{
                            gridLines: {
                                display: true,
                                drawBorder: false,
                                color:"#F0F0F0",
                                zeroLineColor: '#F0F0F0',
                            },
                            ticks: {
                              beginAtZero: false,
                              autoSkip: true,
                              maxTicksLimit: 4,
                              fontSize: 10,
                              color:"#6B778C"
                            }
                        }],
                        xAxes: [{
                          gridLines: {
                              display: false,
                              drawBorder: false,
                          },
                          ticks: {
                            beginAtZero: false,
                            autoSkip: true,
                            maxTicksLimit: 7,
                            fontSize: 10,
                            color:"#6B778C"
                          }
                      }],
                    },
                    legend:false,
                    legendCallback: function (chart) {
                      var text = [];
                      text.push('<div class="chartjs-legend"><ul>');
                      for (var i = 0; i < chart.data.datasets.length; i++) {
                        text.push('<li>');
                        text.push('<span style="background-color:' + chart.data.datasets[i].borderColor + '">' + '</span>');
                        text.push(chart.data.datasets[i].label);
                        text.push('</li>');
                      }
                      text.push('</ul></div>');
                      return text.join("");
                    },

                    elements: {
                        line: {
                            tension: 0.4,
                        }
                    },
                    tooltips: {
                        backgroundColor: 'rgba(31, 59, 179, 1)',
                    }
                }
                var salesTop = new Chart(graphGradient, {
                    type: 'line',
                    data: salesTopData,
                    options: salesTopOptions
                });
                document.getElementById('performance-line-legend').innerHTML = salesTop.generateLegend();
                }
                            }
    });


  });
})(jQuery);

</script>
@stop
