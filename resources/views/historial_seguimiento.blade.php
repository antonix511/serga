<?php session_start(); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SERGA</title>
    @include('cabeza2')
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
                            <li class="active">{{ $project_code }}</li>
                        </ol>
                        <h3 class="w3_inner_tittle two">Código del Proyecto: {{ $project_code }}</h3>
                        <div class="row">
                            <div class="col-sm-2 col-xs-12">
                                <label class="control-label">Presupuesto</label>
                            </div>
                            <div class="col-sm-2 col-xs-12">
                                <input type="number" class="form-control1" name="presupuesto" value="{{ $project_presupuesto }}" disabled>
                            </div>
                            <div class="col-sm-8"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 col-xs-12">
                                <label class="control-label">N° de Intervalos</label>
                            </div>
                            <div class="col-sm-2 col-xs-12">
                                <input type="number" class="form-control1" name="nro_intervalos" value="{{ $project_intervalos }}" disabled>
                            </div>
                            <div class="col-sm-1"></div>
                            <div class="col-sm-2 col-xs-12">
                                <label class="control-label">N° de Tareas</label>
                            </div>
                            <div class="col-sm-2 col-xs-12">
                                <input type="number" class="form-control1" name="nro_tareas" value="{{ $project_nro_tareas }}" disabled>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 col-xs-12">
                                <label class="control-label">Fecha de Inicio:</label>
                            </div>
                            <div class="col-sm-2 col-xs-12">
                                <input type="date" class="form-control1" name="fecha_ini" value="{{ $project_fecha_inicio }}" disabled>
                            </div>
                            <div class="col-sm-1"></div>
                            <div class="col-sm-2 col-xs-12">
                                <label class="control-label">Fecha Fin</label>
                            </div>
                            <div class="col-sm-2 col-xs-12">
                                <input type="date" class="form-control1" name="fecha_fin" value="{{ $project_fecha_fin }}" disabled>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>
                        <div class="row" style="margin-top: 1%;">
                            <div class="col-sm-10"></div>
                            <div class="col-sm-2 col-xs-12 ">
                                @if($ult_int == 0)
                                    <button class="btn btn-dark pull-right" disabled>Ver Dashboard</button>
                                @else
                                    <a href="/historial-seguimiento/{{ $id }}/dashboard" class="btn btn-dark pull-right" role="button">Ver Dashboard</a>
                                @endif
                            </div>
                        </div>
                        <div class="row" style="margin-top: 1%;">
                            <div class="col-sm-12 col-xs-12">
                                <table id="historialSeguimiento" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>N°</th>
                                            <th class="text-center">Fecha Seguimiento</th>
                                            <th class="text-center">Costo Real y % de Avance</th>
                                            <th class="text-center">VC</th>
                                            <th class="text-center">IDC</th>
                                            <th class="text-center">VS</th>
                                            <th class="text-center">IDS</th>
                                            <th class="text-center">Estado Seguimiento</th>
                                            <th class="text-center">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php $i = 1; ?>
                                    @foreach ($project_historial as $historial)
                                        <tr class="trID_{{ $historial->id }} trNRO_{{ $i }}">
                                            <!-- <td>{{ $historial->id }}</td> -->
                                            <td><?php echo $i; ?></td>
                                            <td class="text-center">{{ $historial->fecha_seguimiento }}</td>
                                            <td class="text-center">
                                                @if (!empty($historial->costo_avance))
                                                <a href="../documentos/historiales/{{ $historial->seguimiento->proyecto->nombreclave }}/{{ $historial->costo_avance }}" download="{{ $historial->costo_avance }}">
                                                    <i class="fa fa-download"></i> {{ $historial->costo_avance }}
                                                </a>
                                                @endif
                                            </td>
                                            @if (!empty($historial->vc))
                                                <td class="text-center">{{ ($historial->vc >= 0) ? '+' : '-' }}</td>
                                            @else
                                                <td class="text-center"></td>
                                            @endif

                                            @if (!empty(floatval($historial->idc)))
                                                @if ($historial->idc != 99.99)
                                                    <td class="text-center">{{ ($historial->idc > 1) ? '>1' : '<1' }}</td>
                                                @else
                                                    <td class="text-center">NC</td>
                                                @endif
                                            @else
                                                <td class="text-center"></td>
                                            @endif

                                            @if (!empty($historial->vs))
                                                <td class="text-center">{{ ($historial->vs >= 0) ? '+' : '-' }}</td>
                                            @else
                                                <td class="text-center"></td>
                                            @endif

                                            @if (!empty(floatval($historial->ids)))
                                                @if ($historial->ids != 99.99)
                                                   <td class="text-center">{{ ($historial->ids > 1) ? '>1' : '<1' }}</td>
                                                @else
                                                    <td class="text-center">NC</td>
                                                @endif
                                            @else
                                                <td class="text-center"></td>
                                            @endif
                                            <td class="text-center">{{ empty($historial->estado) ? 'Pendiente' : $historial->estado }}</td>
                                            <td class="text-center">
                                                @if (empty($historial->estado))
                                                    <button id="btnCrearSeguimiento{{ $i }}" class="td_btn btn btndefault" type="button" data-toggle="modal" data-target="#crearSeguimiento"><i class="fa fa-clipboard"></i></button>
                                                @else
                                                    <button id="btnCrearSeguimiento{{ $i }}" class="td_btn btn btndefault" type="button" data-toggle="modal" data-target="#crearSeguimiento" disabled><i class="fa fa-clipboard"></i></button>
                                                @endif
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL -->
    <div class="modal fade" id="crearSeguimiento" tabindex="-1" role="dialog" aria-labelledby="crearSeguimientoTitulo" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearSeguimientoTitulo">Editar Seguimiento</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-body">
                        <form action="" id="form-crear-seguimiento" method="post">
                            <div class="row">
                                <div class="col-sm-3 col-xs-12">
                                    <label class="control-label">Subir Costos Real y % Avance Real</label>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <input type="file" class="form-control1" name="seguimiento-costos" id="seguimientoCostos">
                                </div>
                                <div class="col-sm-3"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 col-xs-12">
                                    <label class="control-label">Comentario</label>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <textarea name="seguimiento-comentario" cols="88" rows="3" id="seguimientoComentario"></textarea>
                                </div>
                                <div class="col-sm-3"></div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-sm-12">
                        <div class="col-sm-2 col-xs-12">
                            <button class="btn btn-default" type="button" data-dismiss="modal">Cerrar</button>
                        </div>
                        <div class="col-sm-8"></div>
                        <div class="col-sm-2 col-xs-12">
                            <input type="hidden" id="seguimiento-historia-id" name="seguimiento-historia-id">
                            <input type="hidden" id="seguimiento-historia-it" name="seguimiento-historia-it">
                            <button class="btn btn-default" type="button" onclick="guardarSeguimiento();">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL - FIN -->
    @include('footer')
    <script type="text/javascript">
        $('.td_btn').click(function () {
            var $row = $(this).closest('tr');
            var $tmp = $row.attr('class').split(' ');
            var rowID = $tmp[0].split('_')[1];
            var rowIT = $tmp[1].split('_')[1];
            $('#seguimiento-historia-id').val(rowID);
            $('#seguimiento-historia-it').val(rowIT);
            $.ajax({
                type: "GET",
                url: "/ajax/cargar-detalle-historial/" + rowID,
                success: function (response) {
                    $("#seguimientoComentario").val(response.data.comentario);
                },
                error: function () {
                    swal('Error', 'error', 'error');
                }
            });
        });
    </script>
</body>
</html>
