<!--
author: W3layouts
author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="zxx">
<head>
	<title>SERGA</title>
	@include("cabeza2")
</head>
<body>
	<!-- banner -->
	<div class="wthree_agile_admin_info">
		<!-- /w3_agileits_top_nav-->
		<!-- /nav-->
		<div class="w3_agileits_top_nav">
			<ul id="gn-menu" class="gn-menu-main">
				<!-- /nav_agile_w3l -->

				@include("menu")
				@include("cabecera")

			</ul>
			<!-- //nav -->

		</div>
		<div class="clearfix"></div>
		<!-- //w3_agileits_top_nav-->

		<!-- /inner_content-->
		<div class="inner_content">
			<!-- /inner_content_w3_agile_info-->



			<div class="inner_content_w3_agile_info two_in">
				<h2 class="w3_inner_tittle">CODE</h2>

				<!--/forms-->
				<div class="forms-main_agileits">

					<div class="graph-form agile_info_shadow" style="overflow: auto;">

						<div class="form-body">
							<form id="formcode" action="" method="post">

									{!! csrf_field() !!}

									<input type="hidden" name="opcion" id="opcion" value="1">
									<input type="hidden" name="id" id="id" value="">
									<input type="hidden" name="correlativo" id="correlativo" value="">
									<input type="hidden" name="idtrabajador_registro" value="{{ Auth::id() }}">

									<label class="col-sm-3 control-label">Elegir Cliente</label>

									<div class="col-sm-3">
										<select name="cliente" id="cliente" onchange="ProyectoCliente()" class="form-control1">
											<option value="0">Seleccione un Cliente</option>
											@foreach($clientes as $row)
												<option value="{{$row->abreviatura}}">{{$row->persona->nombre}}</option>
											@endforeach
										</select>
									</div>

									<label class="col-sm-3 control-label">Elegir Proyecto</label>
									<div class="col-sm-3">
										<select name="proyecto" id="proyecto" class="form-control1" onchange="ProyectoxProyecto()">
										<option value="0"> Seleccion un Proyecto</option>

										</select>
									</div>

									<label class="col-sm-3 control-label">Elegir Tipo Documento</label>
									<div class="col-sm-3">
										<select name="documento" id="documento" class="form-control1" onchange="ProyectoxDocumento()" >
										<option value="0">Seleccione un Documento</option>
											@foreach($documentos as $row)
												<option value="{{$row->abreviatura}}">{{$row->nombre}}</option>
											@endforeach
										</select>
									</div>
									<label class="col-sm-3 control-label">Expediente</label>
									<div class="col-sm-3">
										<input  type="text" class="form-control1" name="codigo" id="codigo"  maxlength = "100"  required>
									</div>


									<label class="col-sm-3 control-label">Descripcion</label>
									<div class="col-sm-9">
										<input type="text" class="form-control1" name="descripcion" id="descripcion" placeholder="Ingrese una descripcion" min="10" maxlength = "100"  required>
									</div>


									<div class="col-sm-12"><br>
									<br>
									</div>
									<div class="text">
										<div class="col-xs-12 col-sm-9">
										<div class="col-xs-12 col-sm-4">
										<button type="button" onclick="LimpiarCode()" class="btn btn-default" >Limpiar</button>
										</div>
										</div>
										<div class="col-xs-12 col-sm-3">

										<button type="button" class="btn btn-default" onclick="GuardarCode()">Guardar</button>
										</div>
										<div>
										<pstyle="visibility: hidden;">&nbsp;</p>
										</div>

									<div id="resultado">
										<table id="tablaCode" class="table table-striped table-bordered">
											<thead>
												<tr>
													<th>Numero</th>
													<th>CODE</th>
													<th>descripcion</th>
													<th>Usuario de creación</th>
													<th>Fecha</th>
													<th>Consultar</th>
													<th>Eliminar</th>
													<th style="display: none;">Expediente</th>
												</tr>
											</thead>
											<tbody>
											@if(!empty($codes))
												<?php $i=1?>
												@foreach($codes as $row)
												<tr>

													<td><?=$i?></td>
													<td>{{$row->nombre}}</td>
													<td>{{$row->descripcion}}</td>
													<td>{{$row->trabajador ? $row->trabajador->usuario : ''}}</td>
													<td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $row->fecha_registro)->format('Y-m-d') }}</td>
													<td>
													<div class="opciones">
														<a class="fa fa-pencil-square-o" onclick="TraerCode({{$row->idcode}})" ></a>
													</div>
													</td>
													<td>
													<div class="opciones">
														<a class="fa fa-trash" onclick="EliminarCode({{$row->idcode}})"></a>
													</div>
													</td>
													<td style="display: none;">{{$row->codigo}}</td>
												</tr>
												<?php $i++; ?>
												@endforeach
											@endif
											</tbody>
										</table>
									</div>

									</div>

								</form>

					</div>
				</div>
			</div>
		</div>
		<!-- //inner_content_w3_agile_info-->
	</div>
	<!-- //inner_content-->
</div>
@include("footer")

<script type="text/javascript">
	function ProyectoCliente() {
		var idcliente=$("#cliente").val();
		var formData= new FormData();//se crea el formato de datos, para enio de archivos y datos
  		formData.append('idcliente',idcliente);
    var token = $('input[name=_token]').val();
    console.log(token);
    $.ajax({
      url: "/cliente_proyecto/traer",//url
      type: "post",//tipo post
      dataType: "html",
      data:formData,
      cache: false,
      headers: {'X-CSRF-TOKEN':token},
      contentType: false,
      processData: false,
      success:function(data){
        //$("#tablelogisti").empty();
        $("#proyecto").html(data);
      },
      error:function (data){
            swal("Error", "Error.", "error");
      }

    });

    $.ajax({
      url: "/cliente_proyecto/proyecto_tablas",//url
      type: "post",//tipo post
      dataType: "html",
      data:formData,
      cache: false,
      headers: {'X-CSRF-TOKEN':token},
      contentType: false,
      processData: false,
      success:function(data){
        //$("#tablelogisti").empty();
        $('#myTable').DataTable().destroy();
        $('#resultado').html(data);
        $('#tablaCode').DataTable();
      },
      error:function (data){
            swal("Error", "Error.", "error");
      }

    });
	}

	function ProyectoxProyecto() {
		var proyecto=$("#proyecto").val();
		var idcliente=$("#cliente").val();
		var formData= new FormData();//se crea el formato de datos, para enio de archivos y datos
		var token = $('input[name=_token]').val();
  		formData.append('proyecto',proyecto);
  		formData.append('idcliente',idcliente);
		$.ajax({
      url: "/proyecto_proyecto/proyecto_tablas",//url
      type: "post",//tipo post
      dataType: "html",
      data:formData,
      cache: false,
      headers: {'X-CSRF-TOKEN':token},
      contentType: false,
      processData: false,
      success:function(data){
        //$("#tablelogisti").empty();
        $('#myTable').DataTable().destroy();
        $('#resultado').html(data);
        $('#tablaCode').DataTable();
      },
      error:function (data){
            swal("Error", "Error.", "error");
      }

    });
	}

	function ProyectoxDocumento() {
		var proyecto=$("#proyecto").val();
		var idcliente=$("#cliente").val();
		var documento=$("#documento").val();
		var formData= new FormData();//se crea el formato de datos, para enio de archivos y datos
		var token = $('input[name=_token]').val();
  		formData.append('proyecto',proyecto);
  		formData.append('idcliente',idcliente);
  		formData.append('documento',documento);
		$.ajax({
      url: "/documento_proyecto/proyecto_tablas",//url
      type: "post",//tipo post
      dataType: "html",
      data:formData,
      cache: false,
      headers: {'X-CSRF-TOKEN':token},
      contentType: false,
      processData: false,
      success:function(data){
        //$("#tablelogisti").empty();
        $('#myTable').DataTable().destroy();
        $('#resultado').html(data);
        $('#tablaCode').DataTable();
      },
      error:function (data){
            swal("Error", "Error.", "error");
      }

    });
	}
</script>
</body>
</html>
