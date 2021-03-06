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
		</div>
		<div class="clearfix"></div>
		<div class="inner_content">

			<div class="inner_content_w3_agile_info two_in">


				<div class="w3l-table-info agile_info_shadow">
					{{-- <h3 class="w3_inner_tittle two"><a href="/resumen_proyecto/{{$id}}">{{$nombreclave}}</a></h3> --}}
					<h3 class="w3_inner_tittle two"><a href="/resumen_proyecto/{{$id}}">{{$nomcla}}</a></h3>

					<div class="col-sm-12">

						<div class="col-sm-12" style="border: solid 1px #d6d6d6;padding: 10px;">
							<ul class="nav nav-pills">
								<li><a href="/inicio_ventas/{{$id}}">Ventas</a></li>
								  <?php  if($_SESSION['inicio']>0){ ?>
								  <li class="active"><a href="#">Inicio y Planificación</a></li>
								  <?php } if($_SESSION['ejecucion']>0){ ?>
								  <li><a href="/ejecucion_resumen/{{$id}}">Ejecución</a></li>
								  <?php } if($_SESSION['cierre']>0){ ?>
								  <li><a href="/cierre_resumen/{{$id}}">Cierre</a></li>
								  <?php } ?>

							</ul>
						</div>
						<div class="col-sm-12"><br></div>



						<div class="col-sm-3" style="border: solid 1px #d6d6d6;padding: 10px;">


							<ul class="nav nav-pills nav-stacked">
									  <li ><a href="/inicio_resumen/{{$id}}">Resumen</a></li>
									  <?php


										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2) || ($_SESSION['tipoproy']==3)) && isset($doc_validados[1]) && $doc_validados[1] == 1 ){

									  if($_SESSION['pactainicio']>0){ ?>
									  <li class="active"><a href="/inicio_actainicio/{{$id}}">Acta de Inicio</a></li>
									  <?php }


									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[2]) && $doc_validados[2] == 1  ){

									  if($_SESSION['pmatrizcomu']>0){  ?>
									  <li><a href="/inicio_matrizcomu/{{$id}}">Matriz de Comunicación</a></li>
									  <?php }

									  }
										if ( ($_SESSION['tipoproy']==1) ){


									  if($_SESSION['pmatrizrol']>0 && isset($doc_validados[3]) && $doc_validados[3] == 1){ ?>
									  <li><a href="/inicio_matrizrol/{{$id}}">Matriz de Roles</a></li>
									  <?php }


									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[15]) && $doc_validados[15] == 1  ){


									  if($_SESSION['pmatrizries']>0){ ?>
									  <li><a href="/inicio_matrizriesgos/{{$id}}">Matriz de Riesgos</a></li>
									  <?php }


									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[4]) && $doc_validados[4] == 1  ){

									  if($_SESSION['preqlogist']>0){ ?>
									  <li ><a href="/inicio_reqlogisti/{{$id}}">Req. Logistica</a></li>
									  <?php }


									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[5]) && $doc_validados[5] == 1  ){


									  if($_SESSION['preqcart']>0){ ?>
									  <li><a href="/inicio_reqcartog/{{$id}}">Req. Cartografía</a></li>
									  <?php }}
									  if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[6]) && $doc_validados[6] == 1  ){
									   ?>
									  <li><a href="/cierre_actar/{{$id}}">Acta de Reunión</a></li>
									  <?php } ?>
							</ul>



						</div>

						<form id="fromacta_inicio" action="/inicio/actainicio/guardar" method="post">
							{!! csrf_field() !!}
							 <input name="_token" hidden value="{!! csrf_token() !!}" />
						<div class="col-sm-9" >
							<br>
							<h4 style="text-align: center;">ACTA DE INICIO DEL PROYECTO</h4>
							<br><br>

							<input type="hidden"  id="idproyecto" name="idproyecto" value="{{$id}}">


							<div id="guardado">
							<input type="hidden" name="idacta" id="idacta" value="{{$idacta}}">
							<input type="hidden" id="accion" value="{{$accion}}">

							<div class="col-sm-12">
								<label class="col-sm-3 control-label">Nº Acta</label>
								<div class="col-sm-9">
									<input type="text" class="form-control1" name="numero" disabled="" placeholder="Por Generar" value="{{$nombreclave}}">
								</div>
							</div>
							</div>



							<div class="col-sm-12">

								<label class="col-sm-3 control-label">Servicio</label>

								<div class="col-sm-9">

									<select  class="form-control1" required disabled>
											<option value="">{{$serv}}</option>
											</select>
							</div>
						</div>

						<div class="col-sm-12">
							<label class="col-sm-3 control-label">Descripción</label>
							<div class="col-sm-9">
								<textarea  name="descripcion" cols="0" rows="10" class="form-control1 wsg" value="" style="height: 40px;">{{$descripcion}}</textarea>
							</div>
						</div>


						<div class="col-sm-12">
							<label class="col-sm-3 control-label">Cliente</label>

							<div class="col-sm-9"><select class="form-control1" disabled>
								<option>{{$cli}}</option>

							</select>
						</div>
					</div>
					<div class="col-sm-12">
						<label class="col-sm-3 control-label">Titular del Proyecto</label>
						<div class="col-sm-9">
							<input type="text" class="form-control1"  name="titular" placeholder="" value="{{$titular}}">
						</div>
					</div>
					<div class="col-sm-12">
						<label class="col-sm-3 control-label">Nombre del Proyecto</label>
						<div class="col-sm-9">
							<input type="text" class="form-control1" disabled="" value="{{$nom}}">
						</div>
					</div>

					<div class="col-sm-12">
						<label class="col-sm-3 control-label">Nombre Clave del Proyecto</label>
						<div class="col-sm-9">
							<input type="text" class="form-control1"  disabled="" value="{{$nomcla}}">
						</div>
					</div>

					<div class="col-sm-12">

						<label class="col-sm-3 control-label">Centro de Costos</label>

						<div class="col-sm-9">
							<select name="centrocostos" class="form-control1" disabled>
							<option>{{$centrodecosto}}</option>

						</select>
					</div>
				</div>

				<div class="col-sm-12">
					<label class="col-sm-3 control-label">Nombre de Carpeta del Proyecto</label>
					<div class="col-sm-9">
						<input type="hidden" class="form-control1" name="carpeta"   value="{{$carpeta}}">
						<input type="text" class="form-control1" name="carpeta1" disabled=""  value="{{$carpeta}}">
					</div>
				</div>

				<div class="col-sm-12">

					<label class="col-sm-3 control-label">Gerente</label>

					<div class="col-sm-9"><select  class="form-control1" disabled>
						<option>{{$gerente}}</option>
							</select>
				</div>
			</div>

			<div class="col-sm-12">

				<label class="col-sm-3 control-label">Jefe de Proyecto</label>

				<div class="col-sm-9"><select class="form-control1" disabled>
					<option>{{$jefe}}</option>
				</select>
			</div>
		</div>

		<div class="col-sm-12">
			<label class="col-sm-3 control-label">Fecha de Inicio</label>
			<div class="col-sm-3">
				<input type="date" class="form-control1" name="finicio" value="{{$finicio}}">
			</div>

		</div>

		<div class="col-sm-12">
			<label class="col-sm-3 control-label">Fecha de Entrega al Cliente</label>
			<div class="col-sm-3">
				<input type="date" class="form-control1" name="fentrega" value="{{$fentrega}}">
			</div>

		</div>

		<div class="col-sm-12">
			<label class="col-sm-3 control-label">Fecha de Cierre del Proyecto</label>
			<div class="col-sm-3">
				<input type="date" class="form-control1" name="fcierre" value="{{$fcierre}}">
			</div>

		</div>

		<div class="col-sm-12">
			<label class="col-sm-3 control-label">Sujeto a Bono</label>
			<div class="col-sm-4">
			<?php if($bono == "0") { ?>
					<select class="form-control1" name="bono" id="bono">
						<option value="NO">NO</option>
						<option value="SI">SI</option>
						<option value="OTROS">OTROS</option>
					</select>
			<?php } else{?>
				<select class="form-control1" name="bono" id="bono">
					<?php if ($bono=="SI"){ ?>
						<option value="{{$bono}}" selected="">{{$bono}}</option>
						<option value="NO">NO</option>
						<option value="OTROS">OTROS</option>
					<?php }elseif($bono=="NO"){ ?>
						<option value="{{$bono}}" selected="">{{$bono}}</option>
						<option value="SI" >SI</option>
						<option value="OTROS">OTROS</option>

					<?php }else{?>
						<option value="{{$bono}}" selected="">{{$bono}}</option>
						<option value="SI" >SI</option>
						<option value="NO">NO</option>
					<?php } ?>
					</select>

			<?php }?>
			</div>
			<?php if($bono == "0") { ?>
			<div class="col-sm-4" id="opsujbono" >

			</div>
			<?php } elseif($bono=="SI"){?>
			<div class="col-sm-4" id="opsujbono" >
				<select class="form-control1" name="bono2" id="bono2">
						<?php if ($bono2 == "Hito"): ?>
							<option value="{{$bono2}}" selected>Por {{$bono2}}</option>
							<option value="Mensual" >Mensual</option>
						<?php else: ?>
							<option value="{{$bono2}}" selected>{{$bono2}}</option>
							<option value="Hito" >Por Hito</option>
						<?php endif ?>

				</select>
			</div>

			<?php }?>
			<?php if($bono=="OTROS"){ ?>
			<div class="col-sm-4" id="opsujbono" >
					<input type="text" name="bono2" class="form-control1" id="bono2" value="{{$bono2}}">
			</div>
					<?php } ?>

		</div>

		<div class="col-sm-12">
			<label class="col-sm-3 control-label">Ambito del Proyecto</label>
			<div class="col-sm-9">
				<textarea   name="ambito" cols="0" rows="10" class="form-control1 wsg" style="height: 200px;">{{$ambito}}</textarea>
			</div>
		</div>
		<div class="col-sm-12">
			<label class="col-sm-3 control-label">Alcance del Servicio</label>
			<div class="col-sm-9">
				<textarea  name="alcance"  cols="0" rows="10" class="form-control1 wsg" style="height: 200px;">{{$alcance}}</textarea>
			</div>
		</div>
		<div class="col-sm-12">
			<label class="col-sm-3 control-label">Metodología para la ejecución del servicio</label>
			<div class="col-sm-9">
				<textarea  name="metodologia" cols="0" rows="10" class="form-control1 wsg" style="height: 200px;">{{$metodologia}}</textarea>
			</div>
		</div>
		<div class="col-sm-12">
						<label class="col-sm-3 control-label">Calidad</label>

						<div class="col-sm-9">
							<textarea  name="calidad" cols="0" rows="10" class="form-control1 wsg" style="height: 200px;">{{$calidad}}</textarea>
						</div>
				</div>
		<div class="col-sm-12"><br></div>
		<div class="col-xs-12 col-sm-3">
			<button id="btnequipo" type="button" class="btn btn-default" data-toggle="modal" data-target="#equipo" @if ($accion == 1) {{'disabled'}} @endif>
				Equipo de Trabajo
			</button>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="equipo" tabindex="-1" role="dialog" aria-labelledby="equipo">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" >
							<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Equipo de Trabajo</h4>
					</div>
					<div class="modal-body">

						<div class="col-sm-12">
							<label class="col-sm-3 control-label">Nombres y Apellidos</label>

							<div class="col-sm-9">
								<select name="equipotrabajo" id="equipotrabajo" class="form-control1" required>
								<option value="0">-Seleccione un trabajador-</option>
								@foreach ($traba as $traba)
								<option value="{{$traba->idpersona}}">{{$traba->nombre.' '.$traba->trabajador->apellidos}}</option>
								@endforeach

								</select>
						</div>
					</div>

					<div class="col-sm-12">
						<label class="col-sm-3 control-label">Puesto de equipo</label>

						<div id="cargarpuesto">
						<div class="col-sm-9">
						<select name="puesto" id="puesto" class="form-control1" disabled>
							<option value="0">Puesto de equipo</option>
						</select>
						</div>
						</div>

				</div>


				<div class="col-sm-12">
					<div class="col-xs-12 col-sm-9"></div>

					<div class="col-xs-12 col-sm-3">
						<button type="button" onclick="registrarEquipo();" class="btn btn-default" >Agregar</button>
					</div>
				</div>
				<div class="col-sm-12">
					<br>
				</div>

				<div id="resultadoequipo">
				<div class="col-sm-12 table-responsive" style="overflow: scroll; height: 300px;">


						<table >
							<thead>
								<tr>
									<th>Nº</th>
									<th>Nombres y Apellidos</th>
									<th>Puesto</th>
									<th>Eliminar</th>
								</tr>
							</thead>
							<tbody>

							@if (count($equipo)==0)
							@elseif(count($equipo)!=0)

							<?php $i=1;?>
						 	@foreach ($equipo as $eq)
								<tr>
									<td><?php echo $i;?></td>
									<td>{{$eq->persona.' '.$eq->apellidos}}</td>
									<td>{{$eq->puesto}}</td>
									<td> <a class="fa fa-trash" onclick="eliminarequipo({{$eq->idequipo}});"></a></td>


							</tr>
							<?php $i++;?>
							@endforeach

							@endif



							</tbody>
						</table>
						</div>


						</div>

					</div>
					<div class="modal-footer">
					</div>
				</div>
			</div>
		</div>

<!-- Modal -->
		<div class="modal fade" id="ImgCro" tabindex="-1" role="dialog" aria-labelledby="ImgCro">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" >
							<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Imagen Cronograma</h4>
					</div>
					<div class="modal-body">

						<label class="col-sm-3 control-label">Imagen Cronograma</label>
						<input type="file" id="imgcronograma" name="imgcronograma" />




				<div class="col-sm-12">
					<br>
				</div>

				</div>
				<div class="modal-footer">
				<div class="col-sm-12">
					<div class="col-xs-12 col-sm-9"></div>

					<div class="col-xs-12 col-sm-3">
						<button type="button"  class="btn btn-default"  data-dismiss="modal" >Aceptar</button>
					</div>
				</div>
				</div>
				</div>
			</div>
		</div>



<div class="col-xs-12 col-sm-3">
	<button id="btnentregables" type="button" class="btn btn-default" data-toggle="modal" data-target="#entregables" @if ($accion == 1) {{'disabled'}} @endif>
				Entregables
			</button>
</div>


	<div class="modal fade" id="entregables" tabindex="-1" role="dialog" aria-labelledby="entregables">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Entregables</h4>
					</div>
					<div class="modal-body">
					<p>Escribir 1 o más documentos hacer entregados en el proyecto:</p>
					<br>



					<div class="col-sm-12">
						<label class="col-sm-3 control-label">Entregable</label>

						<div class="col-sm-9">
						<textarea  name="nombreentregable" id="nombreentregable" cols="0" rows="10" class="form-control1 wsg"></textarea>
			</div>
				</div>

				<div class="col-sm-12">
					<div class="col-xs-12 col-sm-3">

					</div>
					<div class="col-xs-12 col-sm-3">

					</div>
					<div class="col-xs-12 col-sm-3">
					<button type="button" onclick="limpiarEntregable();" class="btn btn-default" >Limpiar</button>
					</div>
					<div class="col-xs-12 col-sm-3">
						<button type="button" onclick="registroEntregable();" class="btn btn-default" >Agregar</button>
					</div>
				</div>
				<div class="col-xs-12">
				<br>
				</div>

				<div class="col-sm-12">
					<div id="resultadoentregables">
						<div class="col-sm-12 table-responsive" style="overflow: scroll; height: 300px;">
						<table>
							<thead>
								<tr>
									<th>Nº</th>
									<th>Nombre</th>
									<th>Eliminar</th>
								</tr>
							</thead>
							<tbody>

							@if (count($entregables)==0)
							@elseif(count($entregables)!=0)

							<?php $i=1;?>
						 	@foreach ($entregables as $eq)
								<tr>
									<td><?php echo $i;?></td>
									<td>{{$eq->nombre}}</td>
									<td> <a class="fa fa-trash" onclick="eliminarEntregable({{$eq->identregable}});" ></a></td>
							</tr>
							<?php $i++;?>
							@endforeach

							@endif

							</tbody>
						</table>
						</div>

							</div>

						</div>

					</div>
					<div class="modal-footer">
					</div>
				</div>
			</div>
		</div>

		<div class="col-xs-12 col-sm-3">
			<button id="btncronograma" type="button" class="btn btn-default" data-toggle="modal" data-target="#cronograma" @if ($accion == 1) {{'disabled'}} @endif>
				Cronograma
			</button>
		</div>
		<div class="modal fade" id="cronograma" tabindex="-1" role="dialog" aria-labelledby="cronograma">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Cronograma</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-12">
								<label class="col-sm-3 control-label">Versión</label>
								<div class="col-sm-9">
									<input type="text" class="form-control1"  id="version" name="version" >
								</div>
							</div>
							<div class="col-sm-12">
								<label class="col-sm-3 control-label">Descripción</label>
								<div class="col-sm-9">
									<input type="text" class="form-control1"  id="desccrono" name="desccrono" >
								</div>
							</div>
							<div class="col-sm-12">
								<label class="col-sm-3 control-label">Nº de Intervalos</label>
								<div class="col-sm-3">
									<input type="number" class="form-control1" id="nroIntervalos" name="nroIntervalos">
								</div>
								<div class="col-sm-1"></div>
								<label class="col-sm-2 control-label">Nº de Tareas</label>
								<div class="col-sm-3">
									<input type="number" class="form-control1" id="nroTareas" name="nroTareas">
								</div>
							</div>
							<div class="col-sm-12">
								<label class="col-sm-3 control-label">Nº de Días de Seguimiento</label>
								<div class="col-sm-3">
									<input type="number" class="form-control1" id="nroDias" name="nroDias">
								</div>
							</div>
							<div class="col-sm-12">
								<label class="col-sm-3 control-label">Subir VP</label>
								<div class="col-sm-9">
									<input type="file" class="form-control1" id="vpFile" name="vpFile">
								</div>
							</div>
							<div class="col-sm-12">
								<label class="col-sm-3 control-label">Subir</label>
								<div class="col-sm-9">
									<input type="hidden"  id="op" name="op" value="6">
									<input type="file" class="form-control1" id="file" name="file">
								</div>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="col-xs-12 col-sm-9"></div>
							<div class="col-xs-12 col-sm-3">
								<button type="button" class="btn btn-default" onclick="guardarCronograma();">Guardar</button>
							</div>
							<br>
							<br>
						</div>
				<div id="resultadocrono">
					<div class="col-sm-12 table-responsive" style="overflow: scroll; height: 300px;">
						<table>
							<thead>
								<tr>
									<th>Versión</th>
									<th>Nombre</th>
									<th>fecha</th>
									<th>Descargar</th>
									<th>Descargar VP</th>
									<th>Eliminar</th>
								</tr>
							</thead>
							<tbody>
							@if (count($cronograma)==0)
							@elseif(count($cronograma)!=0)
								<?php $i=1;?>
								@foreach ($cronograma as $eq)
									<tr>
										<td>{{$eq->version}}</td>
										<td>{{$eq->nombre}}</td>
										<td>{{$eq->fecha_registro}}</td>
										<td><a class="fa fa-download" href="../documentos/cronogramas/{{$eq->archivo}}" download="{{$eq->archivo}}">{{$eq->archivo}}</a></td>
										<td><a class="fa fa-download" href="../documentos/cronogramas/{{$eq->vp_archivo}}" download="{{$eq->vp_archivo}}">{{$eq->vp_archivo}}</a></td>
										<td> <a class="fa fa-trash" onclick="eliminarCronograma({{$eq->idcronograma}});" ></a></td>
									</tr>
									<?php $i++;?>
								@endforeach
							@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer"></div>
			</div>
		</div>
	</div>



<div class="col-xs-12 col-sm-3">
	<button id="btnfirmas" type="button" class="btn btn-default" data-toggle="modal" data-target="#firmas" @if ($accion == 1) {{'disabled'}} @endif>
				Firmas
	</button>
</div>


	<div class="modal fade" id="firmas" tabindex="-1" role="dialog" aria-labelledby="firmas">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Firmas - Acta de Inicio</h4>
					</div>
					<div class="modal-body">
					<input type="hidden" name="iddocumento" id="iddocumento" value="1">

					<div class="col-sm-12">
						<label class="col-sm-3 control-label">Gerencia /Area:</label>

						<div class="col-sm-9"><select name="area" id="area" class="form-control1">
							<option>-Seleccione un area-</option>
							@foreach ($areas as $a)
							<option value="{{$a->idarea}}">{{$a->nombre}}</option>
							@endforeach

						</select>
					</div>
				</div>
				<div class="col-sm-12">
						<label class="col-sm-3 control-label">Persona:</label>

						<div class="col-sm-9">
						<div id="cargarpersona">
						<select name="personaacta" id="personaacta" class="form-control1">
						<option>-Seleccione una persona-</option>
						</select>
						</div>


					</div>
				</div>
				<div class="col-sm-12">
						<label class="col-sm-3 control-label">Cargo de la Persona:</label>

						<div class="col-sm-9">
						<div id="cargarcargo">
						<select name="cargo" id="cargo" class="form-control1">
							<option>-Seleccione un cargo-</option>

						</select>
						</div>

					</div>
				</div>



				<div class="col-sm-12">
					<div class="col-xs-12 col-sm-9"></div>

					<div class="col-xs-12 col-sm-3">
						<button type="button" onclick="agregarFirmantes();" class="btn btn-default" >Agregar</button>
					</div>

				</div>
				<div class="col-xs-12"><br></div>


				<div class="col-sm-12">
					<div id="resultadoagregarfirmantes">
						<table id="myTable2" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>Nº</th>
									<th>Gerencia</th>
									<th>Nombre</th>
									<th>Cargo</th>
									<th>Correo</th>


								</tr>
							</thead>
							<tbody>


							</tbody>
						</table>

							</div>

					</div>




					<div class="col-sm-12">
					<div class="col-xs-12 col-sm-9"></div>

					<div class="col-xs-12 col-sm-3">
						<button type="button" class="btn btn-default"  onclick="enviarCorreos();">Notificar</button>
					</div>
					<div id="resupestanotificar">

					</div>

				</div>

				<h4>Estado de Firmas</h4>
				<br><br>
				<div class="col-sm-12">
					<div class="table-responsive">
						<table id="myTable3" class="table table-striped table-bordered">

							<thead>
								<tr>
									<th>Nº</th>
									<th>Gerencia</th>
									<th>Nombre</th>
									<th>Cargo</th>
									<th>Correo</th>
									<th>Estado</th>
								</tr>
							</thead>
							<tbody>
							@if (count($firmas)==0)
							@elseif(count($firmas)!=0)

							<?php $i=1;?>
						 	@foreach ($firmas as $eq)
								<tr>
									<td><?php echo $i;?></td>
									<td>{{$eq->area}}</td>
									<td>{{$eq->nombres.' '.$eq->apellidos}}</td>
									<td>{{$eq->puesto}}</td>
									<td>{{$eq->correo}}</td>
									<td>{{$eq->estado}}</td>

							</tr>
							<?php $i++;?>
							@endforeach

							@endif

							</tbody>
						</table>

							</div>

					</div>




					</div>
					<div class="modal-footer">
					</div>
				</div>
			</div>
	</div>




<div class="col-xs-12 col-sm-12">
	<br></div>

	<div class="col-xs-12 col-sm-3">
		<button type="button" class="btn btn-default" value="Cancelar" onclick="BotonCancelarActas()">Cancelar</button>
	</div>

		<div class="col-xs-12 col-sm-3">
			<button id="btnImgCro" type="button" class="btn btn-default" data-toggle="modal" data-target="#ImgCro" @if ($accion == 1) {{'disabled'}} @endif>
						Imagen Cronograma
					</button>
		</div>
		<div class="col-xs-12 col-sm-3">
		<button type="button" class="btn btn-default" @if ($accion == 1) {{'disabled'}} @endif >
		<a href="/inicio/actainicio/exportar/{{$id}}" target="_blank" style="color: #fff">Visualizar/Descargar</a></button>
		</div>



	<div class="col-xs-12 col-sm-3">
		<button type="button" class="btn btn-default" onclick="GuardarActaInicioForm();">Guardar</button>
	</div>


</form>







</div>

</div>



</div>





</div>
<!-- //tables -->

<!-- /social_media-->

<!-- //social_media-->
</div>
<!-- //inner_content_w3_agile_info-->
</div>
<!-- //inner_content-->
<!--copy rights start here-->

@include("footer")

</body>
</html>
