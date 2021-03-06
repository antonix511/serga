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
	<meta name="csrf-token" content="{{ csrf_token() }}">
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
				<h2 class="w3_inner_tittle">Gestión de Trabajadores</h2>

				<!--/forms-->
				<div class="forms-main_agileits">

					<div class="graph-form agile_info_shadow" style="overflow: auto;">

						<div class="form-body">
							<form id="formtrabajador" action="/trabajador/controller" method="post">

							<div class="modal fade" id="privi" tabindex="-1" role="dialog" aria-labelledby="privi">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Privilegios</h4>
					</div>
					<div class="modal-body">
		
					@foreach($modulos as $row)

						<input type="checkbox" value=1 name="p{{$row->idmodulo}}" id="p{{$row->idmodulo}}" class="col-sm-2">
						<label class="col-sm-4" for="p{{$row->idmodulo}}">{{$row->nombre}}</label>

					@endforeach
					
				</div>
				<div class="modal-footer">
				<div  class="col-sm-4"></div>
					<div class="col-sm-4">
					<button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Aceptar</span></button></div>
				</div>
			</div>
	</div>
</div>

									{!! csrf_field() !!}
									<input type="hidden" name="opcion" value="1">
									<input type="hidden" name="id" value="">


									<div class="col-sm-8">
									<label class="col-sm-3 control-label">DNI</label>
									<div class="col-sm-9">
										<input  type="text" class="form-control1" name="dni" placeholder="Ingrese el dni" maxlength = "8" minlength = "8" required>
									</div>


									<label class="col-sm-3 control-label">Nombres</label>
									<div class="col-sm-9">
										<input  type="text" class="form-control1" name="nombre" placeholder="Ingrese nombres" maxlength = "100"  required>
									</div>


									<label class="col-sm-3 control-label">Apellidos</label>
									<div class="col-sm-9">
										<input  type="text" class="form-control1" name="apellidos" placeholder="Ingrese Apellidos" maxlength = "100"  required>
									</div>

									<label class="col-sm-3 control-label">Abreviatura</label>
									<div class="col-sm-9">
										<input  type="text" class="form-control1" name="abreviatura" placeholder="Ingrese Abreviatura" maxlength = "100"  required>
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



									<label class="col-sm-3 control-label">Area</label>

										<div class="col-sm-9">
											<select name="idarea" class="form-control1" id="idarea"required>
											<option value="">-Seleccione un Área-</option>
											@foreach ($areas as $area)
											<option value="{{$area->idarea}}">{{$area->nombre}}</option>
											@endforeach
											</select>
									</div>



									<label class="col-sm-3 control-label">Puesto</label>

										<div class="col-sm-9">

											<select  name="idpuesto" class="form-control1" required>
											<option value="">-Seleccione un Puesto-</option>
											@foreach ($puestos as $puesto)
											<option value="{{$puesto->idpuesto}}">{{$puesto->nombre}}</option>
											@endforeach
											</select>
									</div>

									<label class="col-sm-3 control-label">Usuario</label>
									<div class="col-sm-9">
										<input  type="text" class="form-control1" name="usuario" placeholder="Ingrese un usuario"  required>
									</div>

									<label class="col-sm-3 control-label">Clave</label>
									<div class="col-sm-9">
										<input  type="password" class="form-control1" name="clave" placeholder="*******"  maxlength = "100" required>
									</div>

									<div class="col-sm-12">
											<input type="hidden" name="idprivilegio" id="idprivilegio" value="{{$idprivilegio}}">
									</div>



									</div>
									<div class="col-sm-4">
										<p>Foto</p>
										<div id="list" class="col-sm-12" style="border: solid 1px #000;height: 200px;">

										</div>
										<input type="file" id="files" name="foto" />



										<div class="col-sm-12"><br>
										<br>
										</div>
										<p>Firma</p>
										<div id="list2" class="col-sm-12" style="border: solid 1px #000;height: 200px;">
										</div>
										<input type="file" id="files2" name="firma" />


									</div>

									<div class="col-sm-12"><br>
									<br>
									</div>
									<div class="text">
										<div class="col-xs-12 col-sm-3">
										<button type="reset" class="btn btn-default" onclick="limpiar_Campos_trabajador()">Limpiar</button>
										</div>
										<div class="col-xs-12 col-sm-2">
										</div>
										<div class="col-xs-12 col-sm-2">
										<button id="btnprivi" type="button" class="btn btn-default" data-toggle="modal" data-target="#privi">
											Privilegios
										</button>
										</div>
										<div class="col-xs-12 col-sm-2">
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
						<div class="col-sm-12"><br>
									</div>
						<div id="divtrabajadores">
						<table id="tabletrabajadores" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>Nº</th>
									<th>Nombre</th>
									<th>Apellido</th>
									<th>Correo</th>
									<th>Telefono</th>
									<th>Area</th>
									<th>Puesto</th>
									<th>Opciones</th>
								</tr>
							</thead>
							<tbody>
							<?php	$i=1; ?>
							@foreach ($trabajadores as $trabajador)
								<tr>
									<td>{{$i}}</td>
									<td>{{$trabajador->persona->nombre}}</td>
									<td>{{$trabajador->apellidos}}</td>
									<td>{{$trabajador->persona->correo}}</td>
									<td>{{$trabajador->persona->telefono}}</td>
									<td>{{$trabajador->area->nombre}}</td>
									<td>{{$trabajador->puesto->nombre}}</td>
									<td><div class="opciones"><a class="fa fa-pencil-square-o" onclick="traer_Datos_trabajador('{{$trabajador->idtrabajador}}')" ></a></div>
									<div class="opciones"><a class="fa fa-trash" onclick="eliminar_Datos_trabajador('{{$trabajador->idtrabajador}}')"></a></div>
								</td>
							</tr>
							<?php	$i++; ?>
							@endforeach
							</tbody>
						</table>
						</div>

						

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
