@extends('master')
@section('partialContent')
<div class="content-wrapper" >
    <section class="row">
      <div class="col-sm-12">
        <div class="home-tab">
          <div class="tab-content tab-content-basic">
            <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
              <div class="row">
                <div class="col-sm-12 col-lg-6 col-md-6">
                  <div class="statistics-details d-flex align-items-center" style="text-align: center;" id="statistics">
                    <div>
                      <h3 style="color:#8D8D8D;" class="p-3">{{ __('Dashbord.produits-en-stock') }}</h3>
                      <h3>0</h3>
                    </div>
                    <div>
                      <h3 style="color:#8D8D8D;" class="p-3">{{ __('Dashbord.produits-vente') }}</h3>
                      <h3>0</h3>
                    </div>
                    <div>
                      <h3 style="color:#8D8D8D;" class="p-3">{{ __('Dashbord.valeur-global') }}</h3>
                      <h3 >0</h3>

                    </div>
                  </div>
                </div>
                <div class="col-sm-12 col-lg-6 col-md-6 grid-margin stretch-card">
                  <div class="card card-rounded">
                    <div class="card-body" id="forPC">

                      <div class="row">
                        <div class="col-md-6 col-sm-12">
                          <div class="d-flex justify-content-between align-items-center mb-2 mb-sm-0" id="B1">
                            <div class="circle-progress-width">
                              <div id="totalVisitors" class="progressbar-js-circle pr-2"></div>
                            </div>
                            <div class="group-text" id="textdashbord">
                              <p class="for-pc">{{ __('Dashbord.lesCommandeParRapportStock') }}</p>
                              <h4 class="mb-0 fw-bold for-pc" id="pourcentage1"></h4>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6 col-sm-12">
                          <div class="d-flex justify-content-between align-items-center mb-2 mb-sm-0" id="B1">
                            <div class="circle-progress-width">
                              <div id="visitperday" class="progressbar-js-circle pr-2"></div>
                            </div>
                            <div class="group-text" id="textdashbord">
                              <p class="for-pc">{{ __('Dashbord.Commande-de-ce-mois') }}</p>
                              <h4 class="mb-0 fw-bold for-pc">{{ $data[0]->Total_Quantite }}</h4>
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
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
              <div class="row">
                <div class="col-lg-8 d-flex flex-column">
                  <div class="row flex-grow">
                    <div class="col-12 grid-margin stretch-card">
                      <div class="card card-rounded">
                        <div class="card-body">
                          <div class="d-sm-flex justify-content-between align-items-start">
                            <div>
                              <h4 class="card-title card-title-dash">{{ __('Dashbord.revenu') }}</h4>
                             <p class="card-subtitle card-subtitle-dash">{{ __('Dashbord.rapport-par-jour') }} </p>
                            </div>
                            <div>
                            </div>
                          </div>
                          <div class="d-sm-flex align-items-center mt-1 justify-content-between">
                            <div class="d-sm-flex align-items-center mt-4 justify-content-between"><h2 class="me-2 fw-bold" id="totelDh">0</h2><h4 class="me-2">DH</h4><h4 class="text-success"></h4></div>
                            <div class="me-3"><div id="marketing-overview-legend"></div></div>
                          </div>
                          <div class="chartjs-bar-wrapper mt-3">
                            <canvas id="marketingOverview"></canvas>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row flex-grow">
                    <div class="col-12 grid-margin stretch-card">
                      <div class="card card-rounded">
                        <div class="card-body">
                          <div class="d-sm-flex justify-content-between align-items-start">
                            <div>
                              <h4 class="card-title card-title-dash">{{ __('Dashbord.credits-client') }}</h4>
                             <p class="card-subtitle card-subtitle-dash"><?php echo(date("d/m/Y"))?></p>
                            </div>
                          </div>
                          <div class="table-responsive  mt-1">
                            <table class="table select-table">
                              <thead>
                                <tr>
                                  <th>
                                    <div class="form-check form-check-flat mt-0">
                                      <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" aria-checked="false"><i class="input-helper"></i></label>
                                    </div>
                                  </th>
                                  <th>{{ __('Dashbord.client') }}</th>
                                  <th>{{ __('Dashbord.Total-credits') }}</th>
                                  <th>{{ __('Dashbord.credit') }}</th>
                                  <th>{{ __('Dashbord.date') }}</th>
                                </tr>
                              </thead>
                              <script>
                                var duC ;
                                var totalC ;
                                var pourcentageC;
                              </script>
                              <tbody>
                                @foreach($commandes as $commande)
                                <tr>
                                    <td>
                                      <div class="form-check form-check-flat mt-0">
                                        <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" aria-checked="false"><i class="input-helper"></i></label>
                                      </div>
                                    </td>
                                    <td>
                                      <div class="d-flex ">
                                        <img src="<?php echo $commande->image;?>" alt="">
                                        <div>
                                          <h6> <?php echo $commande->client_nom;?></h6>
                                          <p>{{ __('Dashbord.client') }}</p>
                                        </div>
                                      </div>
                                    </td>
                                    <td>
                                        <h6><?php echo $commande->du." Dh";?></h6>
                                      </td>
                                    <td>
                                      <div>
                                        <div class="d-flex justify-content-between align-items-center mb-1 max-width-progress-wrap">
                                          <p class="text-success"><b><?php echo $commande->pourcentage." %";?></b></p>
                                        </div>
                                        <div class="progress progress-md">
                                          <div class="progress-bar bg-<?php echo $commande->className." %";?>" role="progressbar" style="width: <?php echo $commande->pourcentage."%";?>" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                      </div>
                                    </td>
                                    <td><div class="badge badge-opacity-<?php echo $commande->className." %";?>"><?php echo $commande->commande_date;?></div></td>
                                  </tr>
                                @endforeach
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row flex-grow">
                  </div>
                </div>
                <div class="col-lg-4 d-flex flex-column">
                  <div class="row flex-grow">
                    <div class="col-12 grid-margin stretch-card">
                      <div class="card card-rounded">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-lg-12">
                              <div class="d-flex justify-content-between align-items-center">
                                <h4 class="card-title card-title-dash">{{ __('Dashbord.les-dernieres-commandes') }}</h4>
                                <div class="add-items d-flex mb-0">
                                  <!-- <input type="text" class="form-control todo-list-input" placeholder="What do you need to do today?"> -->
                                  <button class="add btn btn-icons btn-rounded btn-primary todo-list-add-btn text-white me-0 pl-12p" onclick="toGestionDeCommande()"><i class="mdi mdi-plus"></i></button>
                                  <script>function toGestionDeCommande(){
                                 location.href = "/commandes";
                                  }</script>
                                </div>
                              </div>
                              <div class="list-wrapper">
                                <ul class="todo-list todo-list-rounded">
                                @foreach($commandes as $commande)
                                  <li class="d-block">
                                    <div class="form-check w-100">
                                      <label class="form-check-label">
                                        <input class="checkbox" type="checkbox"> {{ $commande->client_nom }}	 <i class="input-helper rounded"></i>
                                      </label>
                                      <div class="d-flex mt-2">
                                        <div class="ps-4 text-small me-3">{{ $commande->commande_date }}</div>
                                        <div class="badge badge-opacity-success me-3">{{ __('Dashbord.complete') }}</div>
                                      </div>
                                    </div>
                                  </li>
                                  @endforeach
                                </ul>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row flex-grow">
                    <div class="col-12 grid-margin stretch-card">
                      <div class="card card-rounded">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-lg-12">
                              <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                  <h4 class="card-title card-title-dash">{{ __('Dashbord.achats-raports') }}</h4>
                                </div>
                              </div>
                              <div class="mt-3">
                                <canvas id="leaveReport"></canvas>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@stop


@section('js')
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
                console.log(dataPerformaneLine);
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


    $.ajax({
       type:'POST',
       url:"{{ Route('DashbordRapportsStock') }}",
       data: {
        '_token' : "{{csrf_token()}}" ,
       },
       success:function(data) {
        var elementsH3 = document.querySelectorAll("h3");
        elementsH3[5].innerHTML = data[0][0].GlobalStock;
        elementsH3[3].innerHTML = data[1][0].ProduitsVente;
        elementsH3[1].innerHTML = data[2];
        if ($('#totalVisitors').length) {
      var bar = new ProgressBar.Circle(totalVisitors, {
        color: '#fff',
        // This has to be the same size as the maximum width to
        // prevent clipping
        strokeWidth: 15,
        trailWidth: 15,
        easing: 'easeInOut',
        duration: 1400,
        text: {
          autoStyleContainer: false
        },
        from: {
          color: '#52CDFF',
          width: 15
        },
        to: {
          color: '#677ae4',
          width: 15
        },
        // Set default step function for all animate calls
        step: function(state, circle) {
          circle.path.setAttribute('stroke', state.color);
          circle.path.setAttribute('stroke-width', state.width);
          var value = Math.round(circle.value() * 100);
          if (value === 0) {
            circle.setText('');
          } else {
            circle.setText(value);
          }

        }
      });
      var elementsH3 = document.querySelectorAll("h3");
      var XDash = parseInt(elementsH3['3'].innerHTML);
      var YDash = parseInt(elementsH3['1'].innerHTML);
      var pourcentage = XDash*1 / YDash;
      var Realpourcentage = Math.round(XDash*100 / YDash).toFixed(2);;
      bar.text.style.fontSize = '0rem';
      bar.animate(pourcentage); // Number from 0.0 to 1.0
      $("#pourcentage1").text(Realpourcentage + " %");
    }
       }
    });

    if ($('#visitperday').length) {
      var bar = new ProgressBar.Circle(visitperday, {
        color: '#fff',
        // This has to be the same size as the maximum width to
        // prevent clipping
        strokeWidth: 15,
        trailWidth: 15,
        easing: 'easeInOut',
        duration: 1400,
        text: {
          autoStyleContainer: false
        },
        from: {
          color: '#34B1AA',
          width: 15
        },
        to: {
          color: '#677ae4',
          width: 15
        },
        // Set default step function for all animate calls
        step: function(state, circle) {
          circle.path.setAttribute('stroke', state.color);
          circle.path.setAttribute('stroke-width', state.width);

          var value = Math.round(circle.value() * 100);
          if (value === 0) {
            circle.setText('');
          } else {
            circle.setText(value);
          }

        }
      });

      bar.text.style.fontSize = '0rem';
      bar.animate(.34); // Number from 0.0 to 1.0
    }

    $.ajax({
            type:'POST',
            url:"{{ Route('DashbordRapports2') }}",
            data: {
             '_token' : "{{csrf_token()}}" ,
            },
            success:function(dataPerformaneLine) {
                var all = dataPerformaneLine[0][0].Total_Quantite+dataPerformaneLine[1][0].Total_Quantite+dataPerformaneLine[2][0].Total_Quantite+dataPerformaneLine[3][0].Total_Quantite+dataPerformaneLine[4][0].Total_Quantite+dataPerformaneLine[5][0].Total_Quantite+dataPerformaneLine[6][0].Total_Quantite+dataPerformaneLine[7][0].Total_Quantite+dataPerformaneLine[8][0].Total_Quantite+dataPerformaneLine[9][0].Total_Quantite+dataPerformaneLine[10][0].Total_Quantite+dataPerformaneLine[11][0].Total_Quantite+dataPerformaneLine[12][0].Total_Quantite;
                $("#totelDh").text(all);

    if ($("#marketingOverview").length) {
      var marketingOverviewChart = document.getElementById("marketingOverview").getContext('2d');
      var marketingOverviewData = {
          labels:  ["{{ __('Dashbord.Dim') }}","{{ __('Dashbord.Lun') }}","{{ __('Dashbord.Mar') }}","{{ __('Dashbord.Mer') }}","{{ __('Dashbord.Jeu') }}", "{{ __('Dashbord.Ven') }}", "{{ __('Dashbord.Sem') }}","{{ __('Dashbord.DIM') }}","{{ __('Dashbord.LUN') }}","{{ __('Dashbord.MAR') }}","{{ __('Dashbord.MER') }}","{{ __('Dashbord.JEU') }}", "{{ __('Dashbord.VEN') }}", "{{ __('Dashbord.SEM') }}"],
          datasets: [{
            label: '{{ __("Dashbord.Cette-Semine") }}',
              data: [0,0,0,0,0,0,0,dataPerformaneLine[7][0].Total_Quantite, dataPerformaneLine[8][0].Total_Quantite, dataPerformaneLine[9][0].Total_Quantite, dataPerformaneLine[10][0].Total_Quantite, dataPerformaneLine[11][0].Total_Quantite, dataPerformaneLine[12][0].Total_Quantite, dataPerformaneLine[13][0].Total_Quantite],
              backgroundColor: "#1F3BB3",
              borderColor: [
                  '#1F3BB3',
              ],
              borderWidth: 0,
              fill: true, // 3: no fill
          },{
            label: '{{ __("Dashbord.Derniere-Semine") }}',
            data: [dataPerformaneLine[0][0].Total_Quantite, dataPerformaneLine[1][0].Total_Quantite, dataPerformaneLine[2][0].Total_Quantite, dataPerformaneLine[3][0].Total_Quantite, dataPerformaneLine[4][0].Total_Quantite, dataPerformaneLine[5][0].Total_Quantite, dataPerformaneLine[6][0].Total_Quantite,0,0,0,0,0,0,0],
            backgroundColor: "#52CDFF",
            borderColor: [
                '#52CDFF',
            ],
            borderWidth: 0,
            fill: true, // 3: no fill
        }]
      };

      var marketingOverviewOptions = {
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
                    beginAtZero: true,
                    autoSkip: true,
                    maxTicksLimit: 5,
                    fontSize: 10,
                    color:"#6B778C"
                  }
              }],
              xAxes: [{
                stacked: true,
                barPercentage: 0.35,
                gridLines: {
                    display: false,
                    drawBorder: false,
                },
                ticks: {
                  beginAtZero: false,
                  autoSkip: true,
                  maxTicksLimit: 14,
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
              text.push('<li class="text-muted text-small">');
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
      var marketingOverview = new Chart(marketingOverviewChart, {
          type: 'bar',
          data: marketingOverviewData,
          options: marketingOverviewOptions
      });
      document.getElementById('marketing-overview-legend').innerHTML = marketingOverview.generateLegend();
    }
            }
        });


    if ($("#leaveReport").length) {
      var leaveReportChart = document.getElementById("leaveReport").getContext('2d');
      var leaveReportData = {
          labels: ["Jan","Feb", "Mar", "Apr", "May"],
          datasets: [{
              label: 'Last week',
              data: [18, 25, 39, 11, 24],
              backgroundColor: "#52CDFF",
              borderColor: [
                  '#52CDFF',
              ],
              borderWidth: 0,
              fill: true, // 3: no fill

          }]
      };

      var leaveReportOptions = {
        responsive: true,
        maintainAspectRatio: false,
          scales: {
              yAxes: [{
                  gridLines: {
                      display: true,
                      drawBorder: false,
                      color:"rgba(255,255,255,.05)",
                      zeroLineColor: "rgba(255,255,255,.05)",
                  },
                  ticks: {
                    beginAtZero: true,
                    autoSkip: true,
                    maxTicksLimit: 5,
                    fontSize: 10,
                    color:"#6B778C"
                  }
              }],
              xAxes: [{
                barPercentage: 0.5,
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

          elements: {
              line: {
                  tension: 0.4,
              }
          },
          tooltips: {
              backgroundColor: 'rgba(31, 59, 179, 1)',
          }
      }
      var leaveReport = new Chart(leaveReportChart, {
          type: 'bar',
          data: leaveReportData,
          options: leaveReportOptions
      });
    }

  });
})(jQuery);
</script>

@stop
