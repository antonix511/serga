<!--
author: W3layouts
author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
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
				<h2 class="w3_inner_tittle">Gestión de Clientes</h2>

				<!--/forms-->
				<div class="forms-main_agileits">

					<div class="graph-form agile_info_shadow" style="overflow: auto;">

						<div class="form-body">
							<form id="formcliente" action="/cliente/controller" method="post">

									{!! csrf_field() !!}

									<input type="hidden" name="opcion" value="1">
									<input type="hidden" name="id" value="">

									<label class="col-sm-3 control-label">RUC</label>
									<div class="col-sm-9">
										<input  type="number" class="form-control1" name="ruc" id="ruc" placeholder="Ingrese un RUC" maxlength="11" minlength = "11" required>
									</div>

									<label class="col-sm-3 control-label">Nombre</label>
									<div class="col-sm-9">
										<input  type="text" class="form-control1" name="nombre" placeholder="Ingrese un nombre" maxlength = "100"  required>
									</div>

									<label class="col-sm-3 control-label">Abreviatura</label>
									<div class="col-sm-9">
										<input  type="text" class="form-control1" name="abreviatura" placeholder="Ingrese una abreviatura" maxlength = "5"  required>
									</div>
									<label class="col-sm-3 control-label">Contacto</label>
									<div class="col-sm-9">
										<input  type="text" class="form-control1" name="contacto" placeholder="Ingrese un contacto" maxlength = "100"  required>
									</div>

									<label class="col-sm-3 control-label">Correo</label>
									<div class="col-sm-9">
										<input  type="email" class="form-control1" name="correo" placeholder="Ingrese un correo" maxlength = "100"  required>
									</div>

									<label class="col-sm-3 control-label">Telefono</label>
									<div class="col-sm-9">
										<input  type="text" class="form-control1" name="telefono" placeholder="Ingrese telefono" maxlength = "15" >
									</div>

									<label class="col-sm-3 control-label">Dirección</label>
									<div class="col-sm-9">
										<input  type="text" class="form-control1" name="direccion" placeholder="Ingrese dirección" maxlength = "100" >
									</div>


									<div class="col-sm-12"><br>
									<br>
									</div>
									<div class="text">
										<div class="col-xs-12 col-sm-9">
										<div class="col-xs-12 col-sm-4">
										<button type="reset" class="btn btn-default" onclick="limpiar_Campos_clientes()">Limpiar</button>
										</div>
										</div>
										<div class="col-xs-12 col-sm-3">

										<button type="submit" class="btn btn-default">Guardar</button>
										</div>
										<div>
										<pstyle="visibility: hidden;">&nbsp;</p>
										</div>

									<div id="resultado"></div>

									</div>

								</form>

						<table id="myTable" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>Nº</th>
									<th>Nombre</th>
									<th>Contacto</th>
									<th>Correo</th>
									<th>Abreviatura</th>
									<th>Opciones</th>
								</tr>
							</thead>
							<tbody>
							<?php	$i=1; ?>
							@foreach ($clientes as $cliente)
								<tr>
									<td>{{$i}}</td>
									<td>{{$cliente->persona->nombre}}</td>
									<td>{{$cliente->contacto}}</td>
									<td>{{$cliente->persona->correo}}</td>
									<td>{{$cliente->abreviatura}} </td>
									<td><div class="opciones"><a class="fa fa-pencil-square-o" onclick="traer_Datos_clientes('{{$cliente->idcliente}}')" ></a></div>
									<div class="opciones"><a class="fa fa-trash" onclick="eliminar_Datos_clientes('{{$cliente->persona->idpersona}}')"></a></div></td>
							</tr>
							<?php	$i++; ?>
							@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<!-- //inner_content_w3_agile_info-->
	</div>
	<!-- //inner_content-->
</div>
@include("footer")
</body>
</html>
