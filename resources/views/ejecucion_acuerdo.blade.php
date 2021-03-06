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


						<div class="w3l-table-info agile_info_shadow">
								<h3 class="w3_inner_tittle two"><a href="/resumen_proyecto/{{$id}}">{{$nombreclave}}</a></h3>



								<div class="col-sm-12">

								<div class="col-sm-12" style="border: solid 1px #d6d6d6;padding: 10px;">
								<ul class="nav nav-pills">
								  <li><a href="/inicio_ventas/{{$id}}">Ventas</a></li>
									<?php  if($_SESSION['inicio']>0){ ?>
									<li><a href="/inicio_resumen/{{$id}}">Inicio y Planificación</a></li>
									<?php } if($_SESSION['ejecucion']>0){ ?>
									<li class="active"><a href="#">Ejecución</a></li>
									<?php } if($_SESSION['cierre']>0){ ?>
									<li><a href="/cierre_resumen/{{$id}}">Cierre</a></li>
									<?php } ?>

								</ul>
								</div>
								<div class="col-sm-12"><br></div>



								<div class="col-sm-3" style="border: solid 1px #d6d6d6;padding: 10px;">


									<ul class="nav nav-pills nav-stacked">

										<li><a href="/ejecucion_resumen/{{$id}}">Resumen</a></li>
									  <?php

										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[13]) && $doc_validados[13] == 1  ){

									  if($_SESSION['pactareunion']>0){ ?>
									  <li><a href="/ejecucion_acta/{{$id}}">Acta de Reunión</a></li>
									  <?php }

									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[7]) && $doc_validados[7] == 1  ){

									  if($_SESSION['psolcambio']>0){  ?>
									  <li><a href="/ejecucion_solicitudcam/{{$id}}">Solicitud de cambio</a></li>
									  <?php }

									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[8]) && $doc_validados[8] == 1  ){

									  if($_SESSION['pactaacuerdo']>0){ ?>
									  <li class="active"><a href="/ejecucion_acuerdo/{{$id}}">Acta de acuerdo</a></li>
									  <?php }

									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[9]) && $doc_validados[9] == 1  ){

									  if($_SESSION['preportho']>0){ ?>
									  <li><a href="/ejecucion_reporte/{{$id}}">Reporte HO/SNC</a></li>
									  <?php }
									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[10]) && $doc_validados[10] == 1  ){

									  if($_SESSION['psolac']>0){ ?>
									  <li><a href="/ejecucion_solicitudac/{{$id}}">Solicitud AC y AP</a></li>
									  <?php }
									  }
										if ( ($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)  ){
									  ?>
									  <li><a href="/ejecucion_modelos/{{$id}}">Modelos</a></li>
									  <?php } ?>


									</ul>


							<form id="formactaAcuerdo" method="post" action="">
							{!! csrf_field() !!}
							<input type="hidden" name="accion_guardar" id="accion_guardar" @if(!empty($acta)) value=2 @else value=1  @endif >
								</div>
								<div class="col-sm-9" >
									<br>
									<h4 style="text-align: center;">ACTA DE ACUERDO</h4>
									<br>
									<div class="col-md-7"></div>
									<div class="col-md-3">
											<button type="button" class="btn btn-default"  data-toggle="modal" data-target="#registro">Ver Doc. Registrados</button>

											<div class="modal fade" id="registro" tabindex="-1" role="dialog">
											  <div class="modal-dialog" role="document">
											    <div class="modal-content">
											      <div class="modal-header text-left">
											        <h4 class="modal-title" id="exampleModalLabel">Documentos Registrados</h4>
											      </div>
											      <div class="modal-body" id="tabla_acuerdo">

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
													     				echo "<td>$row->numero_acta</td>";
													     				echo "<td class='text-center'>
																				<button type='button' class='btn btn-primary' data-dismiss='modal' aria-label='Close' onclick=datos_doc_acta_acuerdo('$row->idacta_acuerdo')>Ver más</button>
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
											<button type="button" class="btn btn-default" onclick="AgregarDoc1()">Agregar Doc.</button>
										</div>
										<br>
									<br><br>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Nº Acta</label>
									<div class="col-sm-3">
										<input type="text" class="form-control1" id="cliente" placeholder="Numero de Acta" disabled="" @if(!empty($acta))  value="{{$acta->numero_acta}}" @else value="{{$numero}}" @endif>
										<input type="hidden" class="form-control1" name="numero_acta" id="numero_acta" placeholder="Numero de Acta" @if(!empty($acta)) value="{{$acta->numero_acta}}" @else value="{{$numero}}" @endif>
										<input type="hidden" class="form-control1" name="idacta_acuerdo" id="idacta_acuerdo" placeholder="Numero de Acta" @if(!empty($acta)) value="{{$acta->idacta_acuerdo}}" @else value="" @endif>
									</div>
									</div>
									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Fecha</label>
									<div class="col-sm-3">
										<input type="date" class="form-control1" id="fecha_hora_fecha" name="fecha_hora_fecha" 
										<?php  ?>
										 @if(!empty($acta->fecha_hora))
										  value="{{$acta->fecha_hora}}"
										  @else  value="{{date("Y-m-d")}}" @endif>

									</div>
									<label class="col-sm-3 control-label" style="text-align: right;">Hora</label>
									<div class="col-sm-3">
										<input type="time" class="form-control1" id="hora" name="hora" 
										<?php  ?>
										 @if(!empty($acta->hora))
										  value="{{$acta->hora}}"
										  @else  value="{{date("H:i")}}" @endif>

									</div>

									</div>
									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Tema de la Reunión</label>
									<div class="col-sm-9">
										<input type="text" class="form-control1" placeholder="Ingrese el tema de la Reunión" name="tema" id="tema" @if(!empty($acta)) value="{{$acta->tema}}" @endif >
									</div>
									</div>
									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Cliente</label>
									<div class="col-sm-9">
										<input type="text" class="form-control1" disabled="" value="{{$cli}}">
									</div>
									</div>
									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Proyecto</label>
									<div class="col-sm-9">
										<input type="text" class="form-control1" disabled="" value="{{$nom}}">
									</div>
									</div>
									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Revisión de Avances</label>
									<div class="col-sm-9">
										<textarea  name="revision" id="revision" cols="0" rows="10" class="form-control1 wsg" style="height: 200px;">@if(!empty($acta)) {{$acta->revision}} @endif </textarea>
										</div>
									</div>
									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Acuerdos</label>
									<div class="col-sm-9">
										<textarea  name="acuerdos" id="acuerdos" cols="0" rows="10" class="form-control1 wsg" style="height: 200px;" >@if(!empty($acta)) {{$acta->acuerdos}} @endif </textarea>
										</div>
									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Titulo de Cronograma</label>
									<div class="col-sm-9">
										<input type="text" class="form-control1" id="cronograma" name="cronograma" @if(!empty($acta))  value="{{$acta->cronograma}}" @endif>
										</div>
									</div>

									<form method="post" id="formAgregarProgramacion" action="">

										{!! csrf_field() !!}
										<input type="hidden" name="idprogra" id="idprogra" value="0">
									<div class="col-sm-12">
										<br> <div class="col-sm-6">
										<h4>Programación de la Semana</h4>
										</div><br><br>
									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Fecha</label>
									<div class="col-sm-3">
										<input type="date" class="form-control1" @if(!empty($idacta)) disabled="" @endif id="fecha" name="fecha" value="<?php echo date("Y-m-d");?>">
									</div>

									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Actividad</label>
									<div class="col-sm-9">
										<textarea  name="actividad" id="actividad" @if(empty($acta)) disabled=""@endif  cols="0" rows="10" class="form-control1 wsg" style="height: 200px;"></textarea>
										</div>
									</div>
									<input type="hidden" name="idacta_acuerdo" id="idacta_acuerdo" @if(!empty($acta))  value="{{$acta->idacta_acuerdo}}" @endif>

									<div class="col-sm-12">
									<div class="col-xs-12 col-sm-9"></div>

									<div class="col-xs-12 col-sm-3">
									<button type="button" @if(empty($acta)) disabled=""@endif class="btn btn-default" onclick="AgregarProgramacion({{$id}})" id="AgregarProgramacionAcuerdo" >Agregar/Actualizar</button>
									</div>
									</div>

									</form>

									<div class="col-sm-12">
									<div class="table-responsive">
									<table class="table" id="TableAgregaProgramacion">
										<thead>
										  <tr>
											<th>Nº</th>
											<th>Fecha</th>
											<th>Actividad</th>
											<th>Consultar</th>
											<th>Eliminar</th>
										  </tr>
										</thead>
										<tbody>
										@if(!empty($resultado))
										<?php $i=1;?>
										@foreach($resultado as $row)
										  <tr>
											<td>{{$i}}</td>
											<?php  
                                            $date=date_create($row->fecha);
                                            $freu=$date->format('d-m-Y');
                                            ?>
											<td>{{$freu}}</td>
											<td>{{$row->actividad}}</td>
											<td><a href="#"><i class="fa fa-pencil-square-o" aria-hidden="true" onclick="ConsultarProgramacionAcuerdo({{$row->idactaacuerdodet}})"></i></a></td>
											<td><a href="#"><i class="fa fa-trash" aria-hidden="true" onclick="EliminarProgramacionAcuerdo({{$row->idactaacuerdodet}})"></i></a></td>
										  </tr>
										  <?php $i++;?>
										  @endforeach
										  @else
										  <tr>
											<td>-</td>
											<td>-</td>
											<td>-</td>
											<td>
												<select>
													<option>-Opciones-</option>
													<option>Consultar</option>
													<option>Eliminar</option>
												</select>
											</td>
										  </tr>
										  @endif
										</tbody>
									  </table>

									</div>

									</div>


									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Fecha prox. reunión</label>
									<div class="col-sm-3">
										<input type="date" class="form-control1" id="fecha_prox_reu" name="fecha_prox_reu" @if(!empty($acta)) value="{{$acta->fecha_prox_reu}}" @else  value="<?php echo date("Y-m-d");?>" @endif>
									</div>

									</div>


									<div class="col-sm-12"><br></div>
									<div class="col-sm-12">


									<div class="col-xs-12 col-sm-3">
									<button type="button" class="btn btn-default" onclick="BotonCancelarActas()" >Cancelar</button>
									</div>

									<div class="col-xs-12 col-sm-6">
										<div class="col-sm-3"></div>
										<div class="col-sm-6">
											<a href="/actaacu/exportaractaacu/{{$id}}" target="_blank">
												<button  @if(empty($acta)) disabled=""@endif id="ExportarAcuerdo"  type="button" class="btn btn-default">
													Visualizar/Descargar
												</button>
											</a>
										</div>
									</div>

									<div class="col-xs-12 col-sm-3">
									<input type="hidden" name="idproyecto" id="idproyecto" value="{{$id}}">
									<button type="button" class="btn btn-default" onclick="GuardarActaAcuerdo({{$id}})">Guardar</button>
									</div>
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
@include("footer");

	</body>
	</html>
