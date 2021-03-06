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
					<form id="formreqcartografia" method="post" action="/reqcarto/controller">

						{!! csrf_field() !!}
					<div class="inner_content_w3_agile_info two_in">


						<div class="w3l-table-info agile_info_shadow">
								<h3 class="w3_inner_tittle two"><a href="/resumen_proyecto/{{$id}}">{{$nombreclave}}</a></h3>


								<input  name="idproyecto" id="idproyecto" type="hidden" class="form-control1" value="{{$id}}">
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
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[15]) && $doc_validados[15] == 1  ){


									  if($_SESSION['pmatrizries']>0){ ?>
									  <li><a href="/inicio_matrizriesgos/{{$id}}">Matriz de Riesgos</a></li>
									  <?php }


									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[4]) && $doc_validados[4] == 1  ){

									  if($_SESSION['preqlogist']>0){ ?>
									  <li><a href="/inicio_reqlogisti/{{$id}}">Req. Logistica</a></li>
									  <?php }


									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2) ) && isset($doc_validados[5]) && $doc_validados[5] == 1 ){


									  if($_SESSION['preqcart']>0){ ?>
									  <li class="active"><a href="/inicio_reqcartog/{{$id}}">Req. Cartografía</a></li>
									  <?php }}
									  if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2) ) && isset($doc_validados[6]) && $doc_validados[6] == 1 ){
									   ?>
									  <li><a href="/cierre_actar/{{$id}}">Acta de Reunión</a></li>
									  <?php } ?>
									</ul>



								</div>
								<div class="col-sm-9" >
									<br>
									<h4 style="text-align: center;">REQUERIMIENTOS DE CARTOGRAFÍA</h4>
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
											      <div class="modal-body" id="tabla_cartografia">

											       	<table class="table">
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
													     				echo "<td>$row->numero_requerimiento</td>";
													     				echo "<td class='text-center'>
																			<button type='button' class='btn btn-primary' data-dismiss='modal' aria-label='Close' onclick=datos_doc_req_Cartografia('$row->idreqcartografia')>Ver más</button>
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
											<button type="button" class="btn btn-default" onclick="AgregarDoc_Reque_Cartografia({{$id}})">Agregar Doc.</button>
										</div>
										<br>
									<br><br>
									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Nº Requerimiento</label>
									<div class="col-sm-3">
										<input type="hidden" name="numero_requerimiento" id="numero_requerimiento" @if(!empty($reqcarto)) value="{{$reqcarto->numero_requerimiento}}" @else value="{{$numero}}" @endif>
										<input  disabled="" type="text" class="form-control1" id="ndocumento" placeholder="0001"  @if(!empty($reqcarto)) value="{{$reqcarto->numero_requerimiento}}" @else value="{{$numero}}" @endif>
										<input  name="accion" id="accion" type="hidden" class="form-control1" @if(empty($reqcarto)) value="1" @else value="2" @endif>
									</div>


									<label class="col-sm-3 control-label" style="text-align: right;">Fecha</label>
									<div class="col-sm-3">
										<input type="date" class="form-control1" id="fecha" name="fecha" @if(empty($reqcarto)) value="<?php echo date("Y-m-d");?>" @endif @if(!empty($reqcarto)) value="{{$reqcarto->fecha}}"  @endif>

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
									<label class="col-sm-3 control-label">Gerente /Jefe del Proyecto</label>
									<div class="col-sm-9">
										<select name="idjefegerente" id="idjefegerente" class="form-control1" required>

											@if(empty($reqcarto))
											<option value="">-Seleccione un Gerente/Jefe-</option>
											@endif

											@foreach ($gerentesYJefes as $gerentesYJefes)
											@if(!empty($reqcarto))
											@if($reqcarto->idjefegerente==$gerentesYJefes->idpersona)
											<option value="{{$gerentesYJefes->idpersona}}" selected>
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
										<select name="idsolicitante" id="solicitante" class="form-control1" required>
										@if(empty($reqcarto))
										<option value="0">-Seleccione un Trabajador-</option>
										@endif

										@foreach ($traba as $traba)

										@if(!empty($reqcarto))
											@if($reqcarto->idsolicitante==$traba->idpersona)
											<option selected="" value="{{$traba->idpersona}}">
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
									<label class="col-sm-3 control-label">Colaborador designado</label>
									<div class="col-sm-9">
										<select name="colaborador" id="colaborador" class="form-control1" required>
										@if(empty($reqcarto))
										<option value="0">-Seleccione un Colaborador-</option>
										@endif

										@foreach ($cola as $traba)

										@if(!empty($reqcarto))
											@if($reqcarto->colaborador==$traba->idpersona)
											<option selected="" value="{{$traba->idpersona}}">
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
									<label class="col-sm-3 control-label">Fecha de Entrega</label>
									<div class="col-sm-3">
										<input type="date" class="form-control1" id="fecha_entrega" name="fecha_entrega"  @if(empty($reqcarto)) value="<?php echo date("Y-m-d");?>" @endif @if(!empty($reqcarto)) value="{{$reqcarto->fecha_entrega}}" @endif>
									</div>


									<br>
									<hr>
									<br>

									<div class="col-sm-12">
										<br> <div class="col-sm-6">
										<h4>Equipo de Cartografía</h4>
										</div><br><br>
									</div>

									<form id="formreqcartoequipo" method="post" action="/reqcarto_detalle/controller">

									<input type="hidden" name="idreqcartografia" @if(empty($reqcarto)) value="0" @endif @if(!empty($reqcarto)) value="{{$reqcarto->idreqcartografia}}" @endif  id="idreqcartografia">
									<input type="hidden" name="detalle_carto" id="detalle_carto" value="0">

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Cantidad</label>
									<div class="col-sm-3">
										<input type="number" class="form-control1" id="cantidad" name="cantidad" placeholder="" @if(empty($reqcarto)) disabled="" @endif>
									</div>
									<div class="col-sm-1"></div>

									<label class="col-sm-2 control-label">Fecha de Devolución</label>
									<div class="col-sm-3">
										<input type="date" class="form-control1" id="fecha_devolucion" name="fecha_devolucion" @if(empty($reqcarto)) disabled="" @endif value="<?php echo date("Y-m-d");?>">

									</div>
									</div>


									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Descripción</label>

										<div class="col-sm-9">
											<select name="idequipo" id="idequipo" class="form-control1" required @if(empty($reqcarto)) disabled="" @endif >
										<option value="0">-Seleccione un Producto-</option>
										@foreach ($equipo as $equipo)
										<option value="{{$equipo->idequipo}}">{{$equipo->nombre}}</option>
										@endforeach

										</select>
									</div>

									<div class="col-sm-6"></div>


									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Observación</label>
									<div class="col-sm-9">
										<textarea  @if(empty($reqcarto)) disabled="" @endif name="observaciones" id="observaciones" cols="0" rows="10" class="form-control1 wsg"></textarea>
										</div>
									</div>

									<div class="col-xs-12 col-sm-9">
										<div class="col-xs-12 col-sm-4">
											<button type="button" id=""  class="btn btn-default" onclick="LimpiarCarto()">Limpiar</button>
										</div>
									</div>

									<div class="col-xs-12 col-sm-3">
									<button type="button" id="btnAgregarEquip" @if(empty($reqcarto)) disabled="" @endif class="btn btn-default" onclick="agregarEquipoCarto({{$id}})">Agregar / Actualizar</button>
									</div>
									</form>
									<div class="col-sm-12">

									<br><br></div>


									<div class="col-sm-12">
									<div class="table-responsive">
									<table class="table" id="tablecartografiaequipo">
										<thead>
										  <tr>
											<th>N</th>
											<th>Cantidad</th>
											<th>Descripción</th>
											<th>Fecha de devolución</th>
											<th>Observación</th>
											<th>Consultar</th>
											<th>Eliminar</th>
										  </tr>
										</thead>
										<tbody>
										@if(!empty($resultado)) <?php $i=1;?>
										@foreach($resultado as $row)


											  <tr>
											  	<td>{{$i}}</td>
												<td>{{$row->cantidad}}</td>
												<td><?php if(!empty($row->equipo->nombre)){ ?> {{$row->equipo->nombre}} <?php } ?> </td>
												<?php
		                                            $date=date_create($row->fecha_devolucion);
		                                            $freu=$date->format('d-m-Y');
		                                            ?>
												<td>{{$freu}}</td>
												<td>{{$row->observaciones}}</td>


												<td><a href="#"><i class="fa fa-pencil-square-o" aria-hidden="true" onclick="ConsultarEquipCartografia({{$row->idreqcartodeta}})"></i></a></td>
												<td><a href="#"><i class="fa fa-trash" onclick="EliminarEquipCartografia({{$row->idreqcartodeta}})"></i></a></td>

											  </tr>

											<?php $i++;?>
										@endforeach
										</tbody>
										@else
											<tbody>
											  <tr>
												<td>-</td>
												<td>-</td>
												<td>-</td>
												<td>-</td>
												<td>-</td>
												<td>
													<a href="#"><i class="fa fa-trash"></i></a></td>
												<td><a href="#"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
												</td>
											  </tr>

											</tbody>
										@endif
									  </table>

									</div>

									</div>




									<div class="col-xs-12 col-sm-3">
									<button type="button" class="btn btn-default" onclick="BotonCancelarActas()" >Cancelar</button>
									</div>

									<div class="col-xs-12 col-sm-3">
									<a href="/reqcarto/exportareq/{{$id}}" target="_blank">

									<button type="button" id="ExportarReqCarto" class="btn btn-default" @if(empty($reqcarto)) disabled="" @endif >Visualizar/Descargar</button> </a>

									</div>
									<div class="col-xs-12 col-sm-3">

									</div>



									<div class="col-xs-12 col-sm-3">
									<button type="button" class="btn btn-default" onclick="guardarReqCarto({{$id}})">Guardar</button>
									</div>




								</div>
								</div>

							 </div>

							 </form>



						</div>
							<!-- //tables -->

							<!-- /social_media-->

						<!-- //social_media-->
				    </div>
					<!-- //inner_content_w3_agile_info-->
				</div>
		<!-- //inner_content-->
	@include("footer")


	</body>
	</html>
