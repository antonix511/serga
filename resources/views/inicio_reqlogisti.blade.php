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

					<!-- breadcrumbs -->

					<!-- //breadcrumbs -->






					<div class="inner_content_w3_agile_info two_in">
{!! csrf_field() !!}

						<div class="w3l-table-info agile_info_shadow">
								<h3 class="w3_inner_tittle two"><a href="/resumen_proyecto/{{$id}}">{{$nombreclave}}</a></h3>



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
									  <li><a href="/inicio_actainicio/{{$id}}">Acta de Inicio</a></li>
									  <?php }


									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[2]) && $doc_validados[2] == 1  ){

									  if($_SESSION['pmatrizcomu']>0){  ?>
									  <li><a href="/inicio_matrizcomu/{{$id}}">Matriz de Comunicación</a></li>
									  <?php }

									  }
										if ( ($_SESSION['tipoproy']==1) && isset($doc_validados[3]) && $doc_validados[3] == 1 ){


									  if($_SESSION['pmatrizrol']>0){ ?>
									  <li><a href="/inicio_matrizrol/{{$id}}">Matriz de Roles</a></li>
									  <?php }


									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2) ) && isset($doc_validados[15]) && $doc_validados[15] == 1 ){


									  if($_SESSION['pmatrizries']>0){ ?>
									  <li><a href="/inicio_matrizriesgos/{{$id}}">Matriz de Riesgos</a></li>
									  <?php }


									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2) ) && isset($doc_validados[4]) && $doc_validados[4] == 1 ){

									  if($_SESSION['preqlogist']>0){ ?>
									  <li class="active"><a href="/inicio_reqlogisti/{{$id}}">Req. Logistica</a></li>
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
								<div class="col-sm-9" >
								<form id="formreqlogi" method="post" action="/reqlog/controller">
						{!! csrf_field() !!}
									<br>
									<h4 style="text-align: center;">REQUERIMIENTOS DE LOGÍSTICA</h4>
									<br><br>
									<div class="col-md-7"></div>
									<div class="col-md-3">
											<button type="button" class="btn btn-default"  data-toggle="modal" data-target="#registro">Ver Doc. Registrados</button>

											<div class="modal fade" id="registro" tabindex="-1" role="dialog">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header text-left">
															<h4 class="modal-title" id="exampleModalLabel">Documentos Registrados</h4>
														</div>
														<div class="modal-body" id="tabla_req_logistica">

															<table id="myTable" class="table">
															<thead>
																<tr>
																<th>N°</th>
																<th>Código del Documento</th>
																<th>Ver</th>
																</tr>
															</thead>
															<tbody>
																<?php
																	if(!empty($listadoc)){
																		$contador = 1;
																		foreach ($listadoc as $row) {
																			echo "<tr><td>$contador</td>";
																			echo "<td>$row->nrequerimiento</td>";
																			echo "<td class='text-center'>
																			<button type='button' class='btn btn-primary' data-dismiss='modal' aria-label='Close' onclick=datos_doc_req_Logistica('$row->idreqlogis')>Ver más</button>
																			</td></tr>";
																			$contador+=1;
																		}
																	}
																?>
															</tbody>

														</table>

														</div>
													</div>
												</div>
											</div>

										</div>
										<div class="col-md-2">
											<button type="button" class="btn btn-default" onclick="AgregarDoc_Reque_Logistica({{$id}})">Agregar Doc.</button>
										</div>
										<br>
									<br><br>
									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Nº Requerimiento</label>
									<div class="col-sm-4">
									<input  name="idproyecto" id="idproyecto" type="hidden" class="form-control1" value="{{$id}}">

									<input  name="accion" id="accion" type="hidden" class="form-control1" @if(empty($reqlogis)) value="1" @else value="2" @endif>

									<input  name="nrequerimiento" id="nrequerimiento" type="hidden" class="form-control1" @if(empty($reqlogis)) value="{{$numero}}" @else value="{{$reqlogis->nrequerimiento}}" @endif>
										<input id="nrequerimiento_2" disabled=""  type="text" class="form-control1" @if(empty($reqlogis)) value="{{$numero}}" @else value="{{$reqlogis->nrequerimiento}}" @endif>
									</div>


									<label class="col-sm-2 control-label">Fecha</label>
									<div class="col-sm-3">
										<input type="date" class="form-control1" id="fecha" name="fecha"
										<input type="hidden" name="idreqlogis" @if(empty($reqlogis)) value="<?php echo date("Y-m-d");?>" @endif @if(!empty($reqlogis)) value="{{$reqlogis->fecha}}" @endif  id="idreqlogis">

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
									<label class="col-sm-3 control-label">Cliente</label>
									<div class="col-sm-9">
										<select class="form-control1" disabled>
											<option>{{$cli}}</option>
										</select>
									</div>
									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Nombre del Proyecto</label>
									<div class="col-sm-9">
										<input type="text" id="nombre_proyecto"  class="form-control1" disabled="" value="{{$nom}}">
									</div>
									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Nombre Clave del Proyecto</label>
									<div class="col-sm-9">
										<input type="text" id="nomclaveproyecto" class="form-control1"  disabled="" value="{{$nomcla}}">
									</div>
									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Centro de Costos</label>
									<div class="col-sm-9">
										<input type="text" class="form-control1"  disabled="" value="{{$centrodecosto}}">
									</div>
									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Gerente /Jefe del Proyecto</label>
									<div class="col-sm-9">
										<select name="idjefegerente" id="idjefegerente" class="form-control1" required>

											@if(empty($reqlogis))
												<option value="0">-Seleccione un Gerente/Jefe-</option>
											@endif

											@foreach ($gerentesYJefes as $gerentesYJefes)

											@if(!empty($reqlogis))
												@if($reqlogis->idjefegerente==$gerentesYJefes->idpersona)
													<option value="{{$gerentesYJefes->idpersona}}" selected="">
												@else
													<option value="{{$gerentesYJefes->idpersona}}">
												@endif
											@else
												<option value="{{$gerentesYJefes->idpersona}}">
											@endif

											{{$gerentesYJefes->nombre.' '.$gerentesYJefes->trabajador->apellidos}}
											</option>


											@endforeach

										</select>
									</div>
									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Solicitante</label>
									<div class="col-sm-9">
										<select name="idsolicitante" id="idsolicitante" class="form-control1" required>

										@if(empty($reqlogis))
												<option value="0">-Seleccione un Trabajador-</option>
											@endif

											@foreach ($traba as $traba)

											@if(!empty($reqlogis))
												@if($reqlogis->idsolicitante==$traba->idpersona)
													<option value="{{$traba->idpersona}}" selected="">
												@else
													<option value="{{$traba->idpersona}}">
												@endif
											@else
												<option value="{{$traba->idpersona}}">
											@endif

											{{$traba->nombre.' '.$traba->trabajador->apellidos}}
											</option>


											@endforeach


										</select>

									</div>
									</div>

									<div class="col-sm-12">
										<br> <div class="col-sm-6">
										<h4>Ubicación del proyecto</h4>
										</div><br><br>
									</div>


									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Departamento</label>

										<div class="col-sm-3">
										<input  disabled="" type="text" class="form-control1" id="depa" value="{{$depa}}">
									</div>

									<label class="col-sm-3 control-label">Provincia</label>

										<div class="col-sm-3">
										<input  disabled="" type="text" class="form-control1" id="prov" value="{{$prov}}">


									</div>


									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Fecha de Entrega</label>
									<div class="col-sm-3">
										<input type="date" class="form-control1" id="fecha_entrega" name="fecha_entrega" @if(empty($reqlogis)) value="<?php echo date("Y-m-d");?>" @endif @if(!empty($reqlogis)) value="{{$reqlogis->fecha_entrega}}" @endif>
									</div>
									<label class="col-sm-3 control-label">Distrito</label>

										<div class="col-sm-3">
										<input  disabled="" type="text" class="form-control1" id="dis" value="{{$dis}}">



									   </div>
									</div>



									</div>





									<div class="col-sm-12">
									<br>
									<hr>
									<br>
									<form id="formreqarea" method="post" action="/reqlog/controller">
									<input type="hidden" name="opcion" id="opcion" value="0">
									<input type="hidden" name="idreqlogis" @if(empty($reqlogis)) value="" @endif @if(!empty($reqlogis)) value="{{$reqlogis->idreqlogis}}" @endif  id="idreqlogis">

										{!! csrf_field() !!}
										<label class="col-sm-3 control-label">Área de Logística y Mantenimiento</label>

										<div class="col-sm-9">
											<select name="idlogistica" id="idlogistica" class="form-control1" required @if(empty($reqlogis)) disabled="" @endif>
										<option value="0">-Seleccione una Opción-</option>
										@foreach ($logistica as $logistica)
										<option value="{{$logistica->idlogistica}}">{{$logistica->nombre}}</option>
										@endforeach

										</select>
									</div>
									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Cantidad</label>
									<div class="col-sm-9">
										<input type="text" class="form-control1" id="cantidad" name="cantidad"  placeholder="Ingrese cantidad" @if(empty($reqlogis)) disabled="" @endif>
									</div>
									</div>

									<div class="col-sm-12">
										<label class="col-sm-3 control-label">Unidades de medida</label>

										<div class="col-sm-9">
											<select name="idunidad" id="idunidad" class="form-control1" required @if(empty($reqlogis)) disabled="" @endif>
										<option value="0">-Seleccione una Opción-</option>
										@foreach ($unidades as $unidades)
										<option value="{{$unidades->idunidad}}">{{$unidades->nombre}}</option>
										@endforeach

										</select>
									</div>
									</div>
									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Descripción</label>
									<div class="col-sm-9">
										<textarea  name="descripcion" id="descripcion" cols="0" rows="10" class="form-control1 " @if(empty($reqlogis)) disabled="" @endif></textarea>
										</div>
									</div>
									<div class="col-sm-12">
										<label class="col-sm-3 control-label">Personal Asignado</label>

										<div class="col-sm-9">
											<select name="idpersona" id="idpersona" class="form-control1" @if(empty($reqlogis)) disabled="" @endif required>
										<option value="0">-Seleccione un Trabajador-</option>
										@foreach ($traba2 as $traba2)
										<option value="{{$traba2->idpersona}}">{{$traba2->nombre.' '.$traba2->trabajador->apellidos}}</option>
										@endforeach

										</select>
									</div>
									</div>
									<div class="col-xs-12 col-sm-9"></div>

									<div class="col-xs-12 col-sm-3">
									<button type="button" id="btnAgregar" class="btn btn-default" @if(empty($reqlogis)) disabled="" @endif onclick="agregarArea({{$id}})" >Agregar/Actualizar</button>
									</div>

									</form>

									<div class="col-sm-12">

									<br><br></div>

									<div class="col-sm-12">
									<div class="table-responsive" >
									<table class="table" id="tablelogisti">

										<thead>
										  <tr>
											<th>Área de Logistica y Mantenimiento</th>
											<th>Cantidad</th>
											<th>Unidad</th>
											<th>Descripción</th>
											<th>Personal Asignado</th>
											<th>Consultar</th>
											<th>Eliminar</th>
										  </tr>
										</thead>
										@if(!empty($resultado))
										@foreach($resultado as $row)
										<tbody>
										  <tr>
											<td>{{isset($row->logistica->nombre) ? $row->logistica->nombre: ''}}</td>
											<td>{{$row->cantidad}}</td>
											<td>{{isset($row->unidad->nombre) ? $row->unidad->nombre: ''}}</td>
											<td>{{$row->descripcion}}</td>
											<td>{{isset($row->persona->nombre) ? $row->persona->nombre : ''}} {{isset($row->trabajador->apellidos) ? $row->trabajador->apellidos : ''}}</td>
											<td><a href="#"><i class="fa fa-pencil-square-o" aria-hidden="true" onclick="ConsultarEquipLogistica({{$row->idreqlogisdeta}})"></i></a></td>
											<td><a href="#"><i class="fa fa-trash" onclick="EliminarEquipLogistica({{$row->idreqlogisdeta}})"></i></a></td>
										  </tr>

										</tbody>
										@endforeach
										@endif
									  </table>

									</div>

									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Observación</label>
									<div class="col-sm-9">
										<textarea   name="observacion" id="observacion" cols="0" rows="10" class="form-control1 wsg" >@if(!empty($reqlogis)) {{$reqlogis->observacion}} @endif
										</textarea>
										</div>
									</div>


									<div class="col-xs-12 col-sm-3">
									<button type="button" class="btn btn-default" onclick="BotonCancelarActas()" >Cancelar</button>
									</div>

									<div class="col-xs-12 col-sm-3">
									<a href="/reqlogis/exportareq/{{$id}}" target="_blank"><button type="button" class="btn btn-default" id="ExportarReqLogis" @if(empty($reqlogis)) disabled="" @endif >Visualizar/Descargar</button></a>
									</div>
									<div class="col-xs-12 col-sm-3">

									</div>



									<div class="col-xs-12 col-sm-3">
									<button type="button" class="btn btn-default" onclick="guardarReqLogis({{$id}})">Guardar</button>
									</div>



									</form>




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
