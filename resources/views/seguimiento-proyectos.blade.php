<?php session_start(); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=gb18030">
    <title>SERGA</title>
    @include('cabeza2')
</head>
<body>
    <div class="wthree_agile_admin_info">
        <div class="w3_agileits_top_nav">
            <ul class="gn-menu-main" id="gn-menu">
                @include("menu")
                @include("cabecera")
            </ul>
        </div>
        <div class="clearfix">
            <div class="inner_content">
                <div class="inner_content_w3_agile_info two_in">
                    <div class="w3l-table-info agile_info_shadow">
                        <h3 class="w3_inner_tittle two">Seguimiento de Proyectos</h3>
                        <div class="row">
                            <label class="col-sm-2 control-label">Filtrar por fase:</label>
                            <div class="col-sm-2">
                                <select name="fase" id="fase" class="form-control1" onchange="listarProyectos2();">
                                    <option value="0">-Seleccione una etapa-</option>
                                    <option value="1">Inicio y Planificación</option>
                                    <option value="2">Ejecución</option>
                                    <option value="3">Cierre</option>
                                </select>
                            </div>
                            <label class="col-sm-1 control-label">Fechas:</label>
                            <div class="col-sm-2">
                                <input type="date" class="form-control1" id="fechainicio" onchange="listarProyectos2();" value="<?php /*echo date ('Y-m-d',strtotime('-10 day',strtotime (date("Y-m-d")) ) );*/ ?>">
                            </div>
                            <div class="col-sm-2">
                                <input type="date" class="form-control1" id="fechafin" onchange="listarProyectos2();" value="<?php /*echo date ('Y-m-d',strtotime('+10 day',strtotime (date("Y-m-d")) ) );*/ ?>">
                            </div>
                            <div class="col-sm-2"></div>
                            <div class="col-sm-1">
                                <button class="btn btn-default" id="filterBtn">Filtrar</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                <label class="control-label">Filtrar por VC</label>
                            </div>
                            <div class="col-sm-2">
                                <select name="vc" id="vc" class="form-control1">
                                    <option value="0">Positivo (+)</option>
                                    <option value="1">Negativo (-)</option>
                                    <option value="2">Todos</option>
                                </select>
                            </div>
                            <div class="col-sm-1"></div>
                            <div class="col-sm-2">
                                <label class="control-label">Filtrar por VS</label>
                            </div>
                            <div class="col-sm-2">
                                <select name="vs" id="vs" class="form-control1">
                                    <option value="0">Positivo (+)</option>
                                    <option value="1">Negativo (-)</option>
                                    <option value="2">Todos</option>
                                </select>
                            </div>
                            <div class="col-sm-2"></div>
                            <div class="col-sm-1">
                                <button class="btn btn-default" id="cleanFilter">Limpiar tabla</button>
                            </div>
                        </div>
                        <div id="listSeguimientoProyecto">
                            <table id="seguimientoTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="col-xs-2">Código</th>
                                        <th class="col-xs-1">Fecha de Inicio</th>
                                        <th class="col-xs-1">Fecha Fin</th>
                                        <th class="col-xs-3">Nombre del Proyecto</th>
                                        <th class="col-xs-1">Fecha Último Seguimiento</th>
                                        <th>VC</th>
                                        <th>IDC</th>
                                        <th>VS</th>
                                        <th>IDS</th>
                                        <th>Estado</th>
                                        <th>Opción</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@include('footer')
<script type="text/javascript">
    $(function () {
        listarSeguimientos();
    });

    $("#cleanFilter").click(function () {
        listarSeguimientos();
    });

    $("#filterBtn").click(function () {
        listarSeguimientosFilter();
    });
</script>

</body>
</html>