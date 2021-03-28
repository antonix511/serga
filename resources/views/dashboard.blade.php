<?php session_start(); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SERGA</title>

    @include("cabeza2")
</head>
<body>
    <div class="wthree_agile_admin_info">
        <div class="w3_agileits_top_nav">
            <ul class="gn-menu-main" id="gn-menu">
                @include('menu')
                @include('cabecera')
            </ul>
        </div>
        <div class="clearfix">
            <div class="inner_content">
                <div class="inner_content_w3_agile_info two_in">
                    <div class="w3l-table-info agile_info_shadow">
                        <ol class="breadcrumb">
                            <li><a href="/inicio">Home</a></li>
                            <li><a href="/seguimiento-proyectos">Seguimiento de Proyectos</a></li>
                            <li><a href="/seguimiento-proyectos/{{ $nro_seguimiento }}">{{ $code_proyecto }}</a></li>
                            <li class="active">Dashboard</li>
                        </ol>
                        <h3 class="w3_inner_tittle two">Dashboard - {{ $code_proyecto }}</h3>
                        <div class="row">
                            <div class="col-sm-2 col-md-2 col-xs-6">
                                <label class="control-label">Intervalo de Seguimiento</label>
                            </div>
                            <div class="col-sm-1 col-md-1 col-xs-3">
                                <select name="selectIntervalos" id="selectIntervalos" class="form-control" onchange="updateData(this.value)" style="padding: 0px !important;">
                                    @for($i = 1; $i <= $nro_iteracion; $i++)
                                        <option value="{{ $i }}" {{ ($i == 4) ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-sm-9 col-xs-3"></div>
                        </div>
                        <div class="row" style="padding: 1%;"></div>
                        <h3 class="w3_inner_tittle two">Indicadores</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-sm-3 col-md-3 col-xs-6">
                                        <label class="control-label">Variación del Costo (S/.)</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-xs-6">
                                        <input type="number" class="form-control1" id="vc" value="{{ $vc }}" data-placement="right" data-toggle="tooltip" title="" disabled>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-xs-6">
                                        <label class="control-label">Índice Desempeño Costo</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-xs-6">
                                        <input type="number" class="form-control1" id="idc" value="{{ $idc }}" data-placement="right" data-toggle="tooltip" title="" disabled>
                                    </div>
                                    <div class="col-md-2 col-sm-2"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3 col-md-3 col-xs-6">
                                        <label class="control-label">% Variación del Costo</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-xs-6">
                                        <input type="number" class="form-control1" id="p_vc" value="{{ $p_vc }}" disabled>
                                    </div>
                                </div>
                                <div class="row" style="padding: 2%;"></div>
                                <div class="row">
                                    <div class="col-sm-3 col-md-3 col-xs-6">
                                        <label class="control-label">Variación del Cronograma</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-xs-6">
                                        <input type="number" class="form-control1" id="vs" value="{{ $vs }}" data-placement="right" data-toggle="tooltip" title="" disabled>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-xs-6">
                                        <label class="control-label">Índice de Desempeño Cronograma</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-xs-6">
                                        <input type="number" class="form-control1" id="ids" value="{{ $ids }}" data-placement="right" data-toggle="tooltip" title="" disabled>
                                    </div>
                                    <div class="col-sm-2 col-md-2"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3 col-md-3 col-xs-6">
                                        <label class="control-label">% Variación del Cronograma</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-xs-6">
                                        <input type="number" class="form-control1" id="p_vs" value="{{ $p_vs }}" disabled>
                                    </div>
                                    <div class="col-sm-7 col-md-7"></div>
                                </div>
                                <div style="display: none;">
                                    <input type="text" id="ac" value="{{ $array_ac }}">
                                    <input type="text" id="ev" value="{{ $array_ev }}">
                                    <input type="text" id="pv" value="{{ $array_pv }}">
                                    <input type="number" id="intervalos" value="{{ $intervalos }}">
                                    <input type="number" id="nroSeguimiento" value="{{ $nro_seguimiento }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                        <h3 class="w3_inner_tittle two">Proyecciones</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-2 col-sm-3">
                                        <label class="control-label">En el mejor de los casos</label>
                                    </div>
                                    <div class="col-md-2 col-sm-3">
                                        <input type="number" class="form-control1" value="{{ $mejor_caso }}" disabled>
                                    </div>
                                    <div class="col-md-4 col-sm-3">
                                        <label class="control-label">{{ $tt_mejor_caso }}</label>
                                    </div>
                                    <div class="col-md-4 col-sm-3"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 col-sm-3">
                                        <label class="control-label">Variación hasta la conclusión</label>
                                    </div>
                                    <div class="col-md-2 col-sm-3">
                                        <input type="number" class="form-control1" value="{{ $var_mejor }}" disabled>
                                    </div>
                                    <div class="col-md-4 col-sm-3">
                                        <label class="control-label">{{ $tt_var_mejor }}</label>
                                    </div>
                                    <div class="col-md-4 col-sm-3"></div>
                                </div>
                                <div class="row" style="padding: 2%;"></div>
                                <div class="row">
                                    <div class="col-md-2 col-sm-3">
                                        <label class="control-label">En el peor de los casos</label>
                                    </div>
                                    <div class="col-md-2 col-sm-3">
                                        <input type="number" class="form-control1" value="{{ $peor_caso }}" disabled>
                                    </div>
                                    <div class="col-md-4 col-sm-3">
                                        <label class="control-label">{{ $tt_peor_caso }}</label>
                                    </div>
                                    <div class="col-md-4 col-sm-3"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 col-sm-3">
                                        <label class="control-label">Variación hasta la conclusión</label>
                                    </div>
                                    <div class="col-md-2 col-sm-3">
                                        <input type="number" class="form-control1" value="{{ $var_peor }}" disabled>
                                    </div>
                                    <div class="col-md-4 col-sm-3">
                                        <label class="control-label">{{ $tt_var_peor }}</label>
                                    </div>
                                    <div class="col-md-4 col-sm-3"></div>
                                </div>
                                <div class="row" style="padding: 2%;"></div>
                                <div class="row">
                                    <div class="col-md-2 col-sm-3">
                                        <label class="control-label">En el mejor de los escenarios</label>
                                    </div>
                                    <div class="col-md-2 col-sm-3">
                                        <input type="number" class="form-control1" value="{{ $mejor_esc }}" disabled>
                                    </div>
                                    <div class="col-md-4 col-sm-3">
                                        <label class="control-label">{{ $tt_mejor_esc }}</label>
                                    </div>
                                    <div class="col-sm-4 col-md-3"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 col-sm-3">
                                        <label class="control-label">En el peor de los escenarios</label>
                                    </div>
                                    <div class="col-md-2 col-sm-3">
                                        <input type="number" class="form-control1" value="{{ $peor_esc }}" disabled>
                                    </div>
                                    <div class="col-md-4 col-sm-3">
                                        <label class="control-label">{{ $tt_peor_esc }}</label>
                                    </div>
                                    <div class="col-md-4 col-sm-3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

    <script>
        function updateData(value) {
            var nroSeguimiento = document.getElementById("nroSeguimiento").value;
            var intervaloSelect = document.getElementById("selectIntervalos").value;
            $.ajax({
                type: "GET",
                url: "/ajax/data-dashboard/" + nroSeguimiento + "/" + value,
                success: function (response) {
                    $("#vs").val(response.data.vs);
                    $("#vc").val(response.data.vc);
                    $("#p_vc").val(response.data.p_vc);
                    $("#p_vs").val(response.data.p_vs);
                    $("#idc").val(response.data.idc);
                    $("#ids").val(response.data.ids);

                    document.getElementById("vs").setAttribute("title", response.data.tt_vs);
                    document.getElementById("vc").setAttribute("title", response.data.tt_vc);
                    document.getElementById("idc").setAttribute("title", response.data.tt_idc);
                    document.getElementById("ids").setAttribute("title", response.data.tt_ids);

                    var array_ac = document.getElementById("ac").value.split(",").slice(0, intervaloSelect);
                    var array_ev = document.getElementById("ev").value.split(",").slice(0, intervaloSelect);
                    var array_pv = document.getElementById("pv").value.split(",").slice(0, intervaloSelect);
                    var intervalos = document.getElementById("intervalos").value;
                    var ctx = document.getElementById('myChart');

                    var labels = [];
                    for (var i = 0; i <= intervalos; i++) {
                        labels.push(i);
                    }

                    const firstElement = 0;

                    var myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'EV Acumulado',
                                    data: [firstElement].concat(array_ev),
                                    backgroundColor: [
                                        'rgba(255, 255, 255, 0)'
                                    ],
                                    borderColor: [
                                        'rgba(255, 99, 132, 1)'
                                    ],
                                    borderWidth: 2
                                },
                                {
                                    label: 'PV Acumulado',
                                    data: [firstElement].concat(array_pv),
                                    backgroundColor: [
                                        'rgba(255, 255, 255, 0)'
                                    ],
                                    borderColor: [
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 206, 86, 1)',
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(153, 102, 255, 1)',
                                        'rgba(255, 159, 64, 1)'
                                    ],
                                    borderWidth: 2
                                },
                                {
                                    label: 'AC Acumulado',
                                    data: [firstElement].concat(array_ac),
                                    backgroundColor: [
                                        'rgba(255, 255, 255, 0)'
                                    ],
                                    borderColor: [
                                        'rgba(255, 159, 64, 1)'
                                    ],
                                    borderWidth: 2
                                }
                            ]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                    },
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Dinero (S/.)',
                                        lineHeight: 1.4,
                                        fontSize: 14
                                    }
                                }],
                                xAxes: [{
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Nro. de Iteraciones',
                                        lineHeight: 1.4,
                                        fontSize: 14
                                    }
                                }]
                            }
                        }
                    });
                },
                error: function () {
                    swal('Error', 'error', 'error');
                }
            });
        }
    </script>
    <script>

        var array_ac = document.getElementById("ac").value.split(",");
        var array_ev = document.getElementById("ev").value.split(",");
        var array_pv = document.getElementById("pv").value.split(",");
        var intervalos = document.getElementById("intervalos").value;
        var ctx = document.getElementById('myChart');

        var labels = [];
        for (var i = 0; i <= intervalos; i++) {
            labels.push(i);
        }

        const firstElement = 0;

        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'EV Acumulado',
                        data: [firstElement].concat(array_ev),
                        backgroundColor: [
                            'rgba(255, 255, 255, 0)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 2
                    },
                    {
                        label: 'PV Acumulado',
                        data: [firstElement].concat(array_pv),
                        backgroundColor: [
                            'rgba(255, 255, 255, 0)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 2
                    },
                    {
                        label: 'AC Acumulado',
                        data: [firstElement].concat(array_ac),
                        backgroundColor: [
                            'rgba(255, 255, 255, 0)'
                        ],
                        borderColor: [
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 2
                    }
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Dinero (S/.)',
                            lineHeight: 1.4,
                            fontSize: 14
                        }
                    }],
                    xAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Nro. de Iteraciones',
                            lineHeight: 1.4,
                            fontSize: 14
                        }
                    }]
                }
            }
        });
    </script>
</body>
</html>
