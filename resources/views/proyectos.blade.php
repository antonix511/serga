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
	<!-- custom-theme -->
@include("cabeza2")

<script type="text/javascript">
$(document).ready(function() {
	$("#idtrabajador").removeAttr("required");
	$('#idtrabajador2').prop("required", false);
});
</script>
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
				<h2 class="w3_inner_tittle">Gestión de Proyectos</h2>

				<!--/forms-->
				<div class="forms-main_agileits">

					<div class="graph-form agile_info_shadow">
						<h3 class="w3_inner_tittle two">Información del proyecto </h3>
						<div class="form-body">
							<form id="formproyectos" action="" method="post">
									{!! csrf_field() !!}

									<div class="col-sm-12">
										<label class="col-sm-3 control-label">CODE</label>
										<div class="col-sm-4">
											<input  disabled="" type="text" class="form-control1" name="code" placeholder="Por Generar" >
										</div>
										<label class="col-sm-2 control-label">Fecha</label>
										<div class="col-sm-2">
											<input type="date" class="form-control1" name="fecha" value="<?php echo date("Y-m-d");?>">
										</div>
									</div>
									<div class="col-sm-12">
										<label class="col-sm-3 control-label">Nombre Clave del Proyecto</label>
										<div class="col-sx-2 col-sm-2">
											<input  id="abreviatura_campo" disabled="" type="text" class="form-control1" name="c1" placeholder="Abrev. Cliente">
										</div>
										<div class="col-sx-2 col-sm-2">
											<input  disabled="" type="text" class="form-control1" name="c2" value="<?php echo date("Y");?>">
										</div>
										<div class="col-sx-2 col-sm-2">
											<input id="abreviaturaservicio"  disabled="" type="text" class="form-control1" name="c3" placeholder="Abrev. Tipo">
										</div>
										<div class="col-sx-2 col-sm-2">
											<input  disabled="" type="text" class="form-control1" name="c4" placeholder="Por generar">
										</div>
										<div class="col-sx-2 col-sm-4"> </div>
									</div>

									<div class="col-sm-12">
										<label class="col-sm-3 control-label">Cliente</label>
										<div class="col-sm-9">
											<select name="idcliente" id="idcliente" class="form-control1" required>
												<option value="">-Seleccione un Cliente-</option>
												@foreach ($cliente as $cliente)
													<option value="{{$cliente->idpersona}}">{{$cliente->nombre}}</option>
												@endforeach
											</select>
										</div>
									</div>

									<div class="col-sm-12">
										<label class="col-sm-3 control-label">Contacto con el cliente(Facturación)</label>
										<div id="contacto">
											<div class="col-sm-9">
												<input type="text" class="form-control1" name="contacto" placeholder="El contacto carga al seleccionar un cliente">
											</div>
										</div>
									</div>

									<div class="col-sm-12">
										<label class="col-sm-3 control-label">Nombre del Proyecto</label>
										<div class="col-sm-9">
											<input type="text" class="form-control1" name="nombre" placeholder="Ingrese un Nombre para el Proyecto" required>
										</div>
									</div>

									<div class="col-sm-12">
										<label class="col-sm-3 control-label">Servicio</label>
										<div class="col-sm-9">
											<select name="idservicio" id="idservicio" class="form-control1" required>
												<option value="">-Seleccione un Servicio-</option>
												@foreach ($servicio as $servicio)
													<option value="{{$servicio->idservicio}}">{{$servicio->nombre}}</option>
												@endforeach
											</select>
										</div>
									</div>

									<div class="col-sm-12">
										<label class="col-sm-3 control-label">Descripción</label>
										<div class="col-sm-9">
											<textarea  name="descripcion" cols="0" rows="10" class="form-control1" style="height:70px;"></textarea>
										</div>
									</div>

									<div class="col-sm-12">
										<label class="col-sm-3 control-label">Ubicación</label>
										<div class="col-sm-3">
											<select name="iddepartamento" id="iddepartamento" class="form-control1" required>
												<option value="">-Seleccione un Departamento-</option>
												@foreach ($depa as $depa)
													<option value="{{$depa->iddepartamento}}">{{$depa->nombre}}</option>
												@endforeach
											</select>
										</div>
										<div class="col-sm-3" id="provincia">
											<select name="idprovincia" id="idprovincia" class="form-control1" required>
												<option value="">-Seleccione una Provincia-</option>
											</select>
										</div>
										<div class="col-sm-3" id="distrito">
											<select name="iddistrito" class="form-control1" required>
												<option value="">-Seleccione un Distrito-</option>
											</select>
										</div>
									</div>

									<div class="col-sm-12">
										<label class="col-sm-3 control-label">Gerente</label>
										<div class="col-sm-9">
											<select name="gerente" class="form-control1" required>
												<option value="">-Seleccione un Gerente-</option>
												@foreach ($gerente as $gerente)
													<option value="{{$gerente->idpersona}}">{{$gerente->nombre.' '.$gerente->trabajador->apellidos}}</option>
												@endforeach
											</select>
										</div>
									</div>

									<div class="col-sm-12">
										<label class="col-sm-3 control-label">Jefe de Proyecto</label>
										<div class="col-sm-9">
											<select name="jefe" class="form-control1" required>
												<option value="">-Seleccione un Jefe de Proyecto-</option>
												@foreach ($jefe as $jefe)
													<option value="{{$jefe->idpersona}}">{{$jefe->nombre.' '.$jefe->trabajador->apellidos}}</option>
												@endforeach
											</select>
										</div>
									</div>

									<div class="col-sm-12">
										<label class="col-sm-3 control-label">Presupuesto de venta</label>
										<div class="col-sm-6">
											<input type="text" class="form-control1" name="presupuesto"  placeholder="Ingrese un presupuesto" onkeypress="return numeros(event)" required>
										</div>
										<div class="col-sm-3">
											<select name="idmoneda" id="idmoneda"  class="form-control1" required>
												@foreach ($moneda as $moneda)
													<option value="{{$moneda->idmoneda}}">{{$moneda->nombre}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-sm-12">
										<label class="col-sm-3 control-label">Tipo de Proyecto</label>
										<div class="col-sm-3">
											<select name="idtipoproyecto" id="idtipoproyecto"  class="form-control1" required>
												<option value="">-Seleccione el tipo de Proyecto-</option>
												@foreach ($tipoproyecto as $tipoproyecto)
													<option value="{{$tipoproyecto->idtipoproyecto}}">{{$tipoproyecto->nombre}}</option>
												@endforeach
											</select>
										</div>

										<label class="col-sm-3 control-label">Tipo de Contrato</label>
										<div class="col-sm-3">
											<select name="idtipocontrato" class="form-control1" required>
												<option value="">-Seleccione el tipo de Contrato-</option>
												@foreach ($tipocontrato as $tipocontrato)
													<option value="{{$tipocontrato->idtipocontrato}}">{{$tipocontrato->nombre}}</option>
												@endforeach
											</select>
										</div>
									</div>

									<div class="col-sm-12">
										<label class="col-sm-3 control-label">Fecha de Aceptación de la propuesta</label>
										<div class="col-sm-2">
											<input type="date" class="form-control1" name="faceptacion" value="<?php echo date("Y-m-d");?>" required>
										</div>
									</div>

									<div class="col-sm-12">
										<label class="col-sm-3 control-label">Fecha de Inicio del proyecto</label>
										<div class="col-sm-2">
											<input type="date" class="form-control1" name="finicio" value="<?php echo date("Y-m-d");?>" required>
										</div>
									</div>

									<div class="col-sm-12">
										<label class="col-sm-3 control-label">Fecha fin del proyecto</label>
										<div class="col-sm-2">
											<input type="date" class="form-control1" name="fentrega" value="<?php echo date("Y-m-d");?>" required>
										</div>
									</div>

									<!--
									<div class="col-sm-12">
										<div class="col-sm-2 col-xs-12">
											<button type="button" class="btn btn-default" data-toggle="modal" data-target="#cronograma">Registrar Acta de Inicio</button>
										</div>
									</div>
									-->

									<div class="col-sm-12">
										<br>
											<h4 class="w3_inner_tittle two" style="text-align: center;">CAMPO LLENADO SOLO PARA ADENDAS/ADICIONALES</h4>
										<br>
									</div>

									<div class="col-sm-12" style="border: solid 2px #e6e6e6;padding: 10px;padding-top: 30px;">
										<div class="col-sm-12">
											<label class="col-sm-3 control-label">N° Centro de Costo</label>
											<div class="col-sm-9">
												<input type="text" class="form-control1" name="centrodecosto"  placeholder="Ingrese el N° Centro de Costo" disabled="" >
											</div>
										</div>
										<div class="col-sm-12">
											<label class="col-sm-3 control-label">Presupuesto de Venta Adicional</label>
											<div class="col-sm-9">
												<input type="text" class="form-control1" name="presupuestoadicional"  placeholder="Ingrese una presupuesto de venta adicional" disabled="" >
											</div>
										</div>
										<div class="col-sm-12">
											<label class="col-sm-3 control-label">Observaciones</label>
											<div class="col-sm-9">
												{{-- <textarea   name="observacion" cols="0" rows="10" class="form-control1" disabled="" ></textarea> --}}
												<textarea name="observacion" cols="0" rows="10" class="form-control1" ></textarea>
											</div>
										</div>
									</div>

									<div class="col-sm-12">
										<br>
											<h4 class="w3_inner_tittle two" >Notificar Información del Proyecto </h4>
										<br>
									</div>
									<div class="col-sm-12">
										<label class="col-sm-2 control-label">Nombre</label>
										<div class="col-sm-4">
												<select name="idtrabajador" id="idtrabajador" class="form-control1">
													<option value="">-Seleccione un destino de notificación-</option>
													@foreach ($trabajador as $trabajador)
														<option value="{{$trabajador->idpersona}}">{{$trabajador->nombre.' '.$trabajador->trabajador->apellidos}}</option>
													@endforeach
											</select>
										</div>
										<label class="col-sm-2 control-label">Nombre</label>
										<div class="col-sm-4">
											<select name="idtrabajador2" id="idtrabajador2" class="form-control1" >
												<option value="">-Seleccione un destino de notificación-</option>
												@foreach ($trabajador2 as $trabajador2)
													<option value="{{$trabajador2->idpersona}}">{{$trabajador2->nombre.' '.$trabajador2->trabajador->apellidos}}</option>
												@endforeach
											</select>
										</div>
									</div>

									<div class="col-sm-12">
										<label class="col-sm-2 control-label">Correo Electrónico</label>
										<div class="col-sm-4">
											<input  id="correonotifica" type="email" class="form-control1" name="correo" placeholder="Correo destino" >
										</div>
										<label class="col-sm-2 control-label">Correo Electrónico</label>
										<div class="col-sm-4">
											<input  id="correonotifica2" type="email" class="form-control1" name="correo2" placeholder="Correo destino" >
										</div>
									</div>

									<div class="col-sm-12">
										<label class="col-sm-2 control-label">Celular</label>
										<div class="col-sm-4">
											<input  id="celnotifica" type="text" class="form-control1" name="celular" placeholder="Celular destino" maxlength="9">
										</div>
										<label class="col-sm-2 control-label">Celular</label>
										<div class="col-sm-4">
											<input  id="celnotifica2" type="text" class="form-control1" name="celular2" placeholder="Celular destino" maxlength="9">
										</div>
									</div>

									<div class="col-sm-12"><br>
										<br>
									</div>

									<div class="text">
										<div class="col-xs-12 col-sm-2">
											<button type="button" class="btn btn-default">Cancelar</button>
										</div>
										<div class="col-xs-12 col-sm-6"></div>
										<div class="col-xs-12 col-sm-2">
											<div class="checkbox-inline1">
												<label><input type="checkbox" name="notificar" value="1" checked> Notificar por Correo</label><br>
												<label><input type="checkbox" name="notificar2" value="1" checked> Notificar por SMS</label>
											</div>
										</div>
										<div class="col-xs-12 col-sm-2">
											<button type="submit" class="btn btn-default" >Guardar</button>
										</div>
										<div>
											<pstyle="visibility: hidden;">&nbsp;</p>
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
	<!-- CRONOGRAMA - Modal -->
	<div class="modal fade" id="cronograma" tabindex="-1" role="dialog" aria-labelledby="cronogramaTitulo" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="cronogramaTitulo">Cronograma</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-body">
						<form id="form-cronograma" action="" method="post">
							<div class="row">
								<div class="col-sm-12">
									<div class="col-xs-12 col-sm-3">
										<label class="control-label">Versión</label>
									</div>
									<div class="col-xs-12 col-sm-9">
										<input type="text" class="form-control1" name="cronograma-version" placeholder="Ingrese nombre de versión">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="col-xs-12 col-sm-3">
										<label class="control-label">Descripción</label>
									</div>
									<div class="col-xs-12 col-sm-9">
										<textarea class="form-control1" name="cronograma-descripcion" id="" cols="30" rows="2" placeholder="Ingrese descripción"></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="col-xs-12 col-sm-3">
										<label class="control-label">N° de Intervalos</label>
									</div>
									<div class="col-xs-12 col-sm-3">
										<input type="number" class="form-control1" name="cronograma-intervalos" placeholder="Ingrese Nro. de intervalos">
									</div>
									<div class="col-sm-1"></div>
									<div class="col-xs-12 col-sm-2">
										<label class="control-label">N° de Tareas</label>
									</div>
									<div class="col-xs-12 col-sm-3">
										<input type="number" class="form-control1" name="cronograma-tareas" placeholder="Ingrese Nro. de tareas">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="col-xs-12 col-sm-3">
										<label class="control-label">N° de Días de Seguimiento</label>
									</div>
									<div class="col-xs-12 col-sm-3">
										<input type="number" class="form-control1" name="cronograma-dias" placeholder="Ingrese Nro. de dias">
									</div>
									<div class="col-sm-6"></div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="col-xs-12 col-sm-3">
										<label class="control-label">Subir VP</label>
									</div>
									<div class="col-xs-12 col-sm-6">
										<input type="file" class="form-control1" name="cronograma-vp">
									</div>
									<div class="col-sm-3"></div>
								</div>
								<div class="col-sm-12">
									<div class="col-xs-12 col-sm-3">
										<label class="control-label">Subir</label>
									</div>
									<div class="col-xs-12 col-sm-6">
										<input type="file" class="form-control1" name="cronograma-upload">
									</div>
									<div class="col-sm-3"></div>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="modal-footer">
					<div class="col-sm-12">
						<div class="col-sm-2 col-xs-12">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
						</div>
						<div class="col-sm-8"></div>
						<div class="col-sm-2 col-xs-12">
							<button type="button" class="btn btn-default" id="saveCronograma">Guardar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- FIN CRONOGRAMA - Modal -->
</div>
<!-- banner -->
<!--copy rights start here-->
@include("footer")
</body>
</html>
