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
									<?php if($_SESSION['inicio']>0){ ?>
								  <li><a href="/inicio_resumen/{{$id}}">Inicio y Planificación</a></li>
								  <?php } if($_SESSION['ejecucion']>0){ ?>
								  <li><a href="/ejecucion_resumen/{{$id}}">Ejecución</a></li>
								  <?php } if($_SESSION['cierre']>0){ ?>
								  <li class="active"><a href="#">Cierre</a></li>
								  <?php } ?>
								
								</ul>
								</div>
								<div class="col-sm-12"><br></div>


								
								<div class="col-sm-3" style="border: solid 1px #d6d6d6;padding: 10px;">
								

									<ul class="nav nav-pills nav-stacked">

									<li><a href="/cierre_resumen/{{$id}}">Resumen</a></li>
									  <?php if($_SESSION['pactacierre']>0 && isset($doc_validados[12]) && $doc_validados[12] == 1){ ?>
									  <li class="active"><a href="#">Acta de Cierre</a></li>
									  <?php }  ?>				
									</ul>
						</div>

									<form id="FormActaCierre" method="post" action="">
									<input type="hidden" name="accion_guardar" id="accion_guardar" @if(!empty($acta)) value=2 @else value=1  @endif>
								{!! csrf_field() !!}
								
								<div class="col-sm-9" >
									<br>
									<h4 style="text-align: center;">ACTA DE CIERRE</h4>
									<br><br>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Nº Acta</label>
									<div class="col-sm-9">
										<input type="text" class="form-control1" id="pvad"  placeholder="Ingrese una presupuesto de venta adicional" disabled="" value="{{$numero}}">
									</div>
									</div>

									<div class="col-sm-12">
										<label class="col-sm-3 control-label">Servicio</label>
					
										<div class="col-sm-9">
											<select name="servicio" id="servicio" class="form-control1" disabled="">
											<option>{{$datos->servicio->nombre}}</option>
						
										</select>
									</div>
									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Descripción</label>
									<div class="col-sm-9">
										<textarea  name="descripcion" id="descripcion" cols="0" rows="10" class="form-control1 wsg">@if(!empty($acta)) {{$acta->descripcion}} @endif</textarea>
										</div>
									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Títular del proyecto</label>
									<div class="col-sm-9">
										<input type="text" class="form-control1" id="titular" name="titular"   placeholder="" @if(!empty($acta)) value="{{$acta->titular}}" @endif>
									</div>
									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Nombre del Proyecto</label>
									<div class="col-sm-9">
										<input type="text" class="form-control1" id="pvad" value="{{$datos->nombre}}"  disabled="" placeholder="Se jala">
									</div>
									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Nombre Clave del Proyecto</label>
									<div class="col-sm-9">
										<input type="text" class="form-control1" id="pvad" disabled="" value="{{$datos->nombreclave}}" placeholder="Se jala">
									</div>
									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Centro de Costos</label>
									<div class="col-sm-9">
										<input type="text" class="form-control1" disabled="" value="{{$centrodecosto}}" id="pvad"  placeholder="Centro de costos">
									</div>
									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Nombre de Carpeta del Proyecto</label>
									<div class="col-sm-9">
										<input type="text" class="form-control1" id="pvad" disabled="" placeholder=" NO Se de donde se jala" value="{{$carpeta}}">
									</div>
									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Gerente</label>
									<div class="col-sm-9">
									<input type="hidden" id="gerente" name="gerente" value="{{$gerente}}" >
										<input type="text" disabled="" class="form-control1"   placeholder="Ingrese una presupuesto de venta adicional"  value="{{$gerente}}" >
									</div>
									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Jefe de Proyecto</label>
									<div class="col-sm-9">
									<input type="hidden" id="jefe" name="jefe" value="{{$jefe}}">
										<input type="text" disabled="" class="form-control1"   placeholder="Ingrese una presupuesto de venta adicional" value="{{$jefe}}">
									</div>
									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Fecha de Inicio</label>
									<div class="col-sm-3">
										<input type="date" class="form-control1" id="finicio" @if(!empty($acta)) value="{{$acta->finicio}}" @else value="<?php echo date("Y-m-d");?>"  @endif name="finicio" >
									</div>
									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Fecha de Entrega al Cliente</label>
									<div class="col-sm-3">
										<input type="date" class="form-control1" id="fentrega" @if(!empty($acta)) value="{{$acta->fentrega}}" @else value="<?php echo date("Y-m-d");?>"  @endif name="fentrega">
									</div>
							
									</div>
									
									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Fecha de Cierre del Proyecto</label>
									<div class="col-sm-3">
										<input type="date" class="form-control1" id="fcierre" @if(!empty($acta)) value="{{$acta->fcierre}}" @else value="<?php echo date("Y-m-d");?>"  @endif name="fcierre">
									</div>
							
									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Resultados</label>
									<div class="col-sm-9">
										<textarea  name="resultado" id="resultado" style="height:400px;" cols="0" rows="10" class="form-control1 wsg" placeholder="Ingresar los resultados">@if(!empty($acta)) {{$acta->resultado}} @endif</textarea>
										</div>
									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Observaciones</label>
									<div class="col-sm-9">
										<textarea  name="observaciones" id="observaciones" style="height:100px;" cols="0" rows="10" class="form-control1 wsg" placeholder="Ingresar los resultados">@if(!empty($acta)) {{$acta->observaciones}} @endif</textarea>
										</div>
									</div>
									</form>
									<div class="col-sm-12">


									<div class="col-xs-12 col-sm-4">
									<button type="button" class="btn btn-default" data-toggle="modal" data-target="#entregables" id="Entregables" @if(empty($acta)) disabled=" " @endif >
										Entregables
									</button>

									<div class="modal fade" id="entregables" tabindex="-1" role="dialog" aria-labelledby="entregables">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
													<h4 class="modal-title" id="myModalLabel" id="Entregables">Entregables</h4>
												</div>
												<div class="modal-body">

													

												<div class="col-sm-12">
													<label class="col-sm-3 control-label">Nombre</label>

													<div class="col-sm-9">
													<input type="hidden" name="accion" id="accion" value="0">
											<input type="text" class="form-control1" id="nombreentregable" placeholder="">
										</div>
											</div>

											<div class="col-sm-12">
												<div class="col-xs-12 col-sm-9"></div>

												<div class="col-xs-12 col-sm-3">
													<button type="button" class="btn btn-default" onclick="AgregarEntregableCierre({{$id}})">Agregar/Actualizar</button> 
												</div>
											</div>

											<div class="col-sm-12">
												<div class="table-responsive" id="TablaEntregablesCierre">
													<table class="table" >
														<thead>
															<tr>
																<th>Nº</th>
																<th>Nombre</th>						
																<th>Consultar</th>
																<th>Eliminar</th>
															</tr>
														</thead>
														<tbody>
														@if(!empty($entregables))
															<?php $i=1; ?>
															@foreach($entregables as $row)
															<tr>
																<td>{{$i}}</td>
																<td>{{$row->nombre}}</td>
																<td>
																	<a onclick="consultar_acta_cierre('{{$row->identregable}}')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
																</td>
																<td>
																	<a onclick="eliminar_acta_cierre('{{$row->identregable}}')"><i class="fa fa-trash" aria-hidden="true"></i></a>
																</td>
															</tr>
															<?php $i++; ?>
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










									</div>
									
						

									<div class="col-xs-12 col-sm-4">
									<button type="button" class="btn btn-default" data-toggle="modal" id="LeccionesAprendidas" data-target="#lecciones"  @if(empty($acta)) disabled=" " @endif  id="LeccionesAprendidas">
									Lecciones Aprendidas
									</button>

									<div class="modal fade" id="lecciones" tabindex="-1" role="dialog" aria-labelledby="lecciones">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
													<h4 class="modal-title" id="myModalLabel">Lecciones Aprendidas</h4>
												</div>
												<div class="modal-body">

													
										<div class="col-sm-12">
											<label class="col-sm-3 control-label">Etapa:</label>

											<div class="col-sm-9">
												<input type="text" class="form-control1" id="etapa" placeholder="" @if(!empty($acta)) value="{{$acta->etapa}}" @endif>
											</div>
										</div>


												<div class="col-sm-12">
													<label class="col-sm-3 control-label">Descripción de la situación:</label>

													<div class="col-sm-9">
													<textarea   id="descripcion_leccion" cols="0" rows="10" class="form-control1 wsg" style="height: 80px;"> @if(!empty($acta))  {{$acta->descripcion2}} @endif</textarea>
										</div>
											</div>
											<div class="col-sm-12">
									<label class="col-sm-3 control-label">Consecuencia:</label>
									<div class="col-sm-9">
										<textarea   id="consecuencia_leccion" cols="0" rows="10" class="form-control1 wsg" style="height: 150px;">@if(!empty($acta)) {{$acta->consecuencia}} @endif</textarea></div>
									</div>
									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Accion implementada:</label>
									<div class="col-sm-9">
										<textarea  id="accion_leccion" cols="0" rows="10" class="form-control1 wsg" style="height: 150px;">@if(!empty($acta))  {{$acta->accion}} @endif</textarea>
										</div>
									</div>

									<div class="col-sm-12">
													<label class="col-sm-3 control-label">Concepto de mejora/recomendacion:</label>

													<div class="col-sm-9">
											<textarea class="form-control1 wsg" id="concepto_leccion" placeholder="" style="height: 150px;">@if(!empty($acta)) {{$acta->concepto}} @endif</textarea>
										</div>
											</div>






											<div class="col-sm-12">
												<div class="col-xs-12 col-sm-9"></div>

												<div class="col-xs-12 col-sm-3">
													<button type="button" onclick="AgregarLeccionCierre({{$id}})" class="btn btn-default" >Agregar</button> 
												</div>
											</div>




									<div class="col-xs-12 col-sm-12">
	<br></div>




												</div>
												<div class="modal-footer">
												</div>
											</div>
										</div>

									</div>





									</div>

									<div class="col-xs-12 col-sm-4">
									<button type="button" class="btn btn-default" data-toggle="modal" id="ParticipantesFirmas" data-target="#firmas"  @if(empty($acta)) disabled=" " @endif >
									Participantes y Firmas
									</button>
									</div>



									<div class="modal fade" id="firmas" tabindex="-1" role="dialog" aria-labelledby="firmas">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Firmas</h4>
					</div>
					<div class="modal-body">

					
				<input type="hidden" name="iddocumento" id="iddocumento" value="12">
				<div class="col-sm-12">
						<label class="col-sm-3 control-label">Nombre:</label>

						<div class="col-sm-9">
						<select id="personaacta" name="idtrabajador" class="form-control1">
						<option>Seleccionar Trabajador</option>
						@foreach($trabajadores as $t)
							<option value="<?php  echo $t->idpersona;?>"><?php  echo $t->nombres.' '.$t->apellidos;?></option>
						@endforeach
						</select>
					</div>
				</div>
				<div class="col-sm-12">
						<label class="col-sm-3 control-label">Cargo:</label>

						<div class="col-sm-9">
						<div id="cargarcargo">
						<select name="cargo" id="cargo" class="form-control1">
							<option>Cargo del Trabajador</option>

						</select>
						</div>
					</div>
				</div>



				<div class="col-sm-12">
					<div class="col-xs-12 col-sm-9"></div>

					<div class="col-xs-12 col-sm-3">
						<button type="button" class="btn btn-default" onclick="AgregarFirmasActas({{$id}})">Agregar</button> 
					</div>
				</div>

				<div class="col-sm-12">
					<div class="table-responsive" id="resultadoagregarfirmantes">
						<table class="table">
							<thead>
								<tr>
									<th>Nº</th>
									<th>Nombre</th>	
									<th>Cargo</th>						
									<th>Opciones</th>
								</tr>
							</thead>
							<tbody>
								<?php
					            	$i=1;
						            foreach ($lista as $v ){
						                ?>
						                <tr>
						                    <td><?php echo $i;?></td>
						                    <td><?php echo $v['nombres'].' '.$v['apellidos'];?></td>
						                    <td><?php echo $v['puesto'];?></td>
						                    <td> <a class="fa fa-trash" href="#" onclick="eliminarfirma(<?php echo $v['idfirma'];?>, <?php echo $id;?>);"></a></td>
						                </tr>
						                <?php
						                $i++;
						            }
					            ?>
							</tbody>
						</table>

							</div>

					</div>
					<div class="col-sm-12">
					<div class="col-xs-12 col-sm-9"></div>

					<div class="col-xs-12 col-sm-3">
						<button type="button" class="btn btn-default" onclick="enviarNotificacion({{$id}})">Notificar</button> 
					</div>
				</div>

				<h4>Estado de Firmas</h4>

				<div class="col-sm-12">
					<div class="table-responsive">
						<table class="table" id="FirmasNotificadas">
							<thead>
								<tr>
									<th>Nº</th>
														<th>Nombre</th>	
									<th>Cargo</th>						
									<th>Estado</th>
								</tr>
							</thead>
							<tbody>
							<?php $o=1; ?>
								<?php foreach ($listano as $ve ){ ?>
								        <tr>
						                    <td><?php echo $o;?></td>
						                    <td><?php echo $ve['nombres'].' '.$ve['apellidos'];?></td>
						                    <td><?php echo $ve['puesto'];?></td>
						                    <td> <?=$ve->estado?></td>
						                </tr>
						                <?php
						                $o++;
						            }
						            ?>

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




									</div>





									<hr>

									<div class="col-sm-12"><br></div>
									<div class="col-sm-12">


									<div class="col-xs-12 col-sm-3">
									<button type="button" class="btn btn-default" onclick="BotonCancelarActas()" >Cancelar</button> 
									</div>

										<div class="col-xs-12 col-sm-6">
											<div class="col-xs-12 col-sm-3"></div>
											<div class="col-xs-12 col-sm-6">
											<a href="/cierre/actacierre/{{$id}}" target="_blank">
											<button type="button" class="btn btn-default" @if(empty($acta)) disabled=" " @endif  id="Exportar">Visualizar/Descargar</button>
											</a>
											</div>
											<div class="col-xs-12 col-sm-3"></div>
										</div>
									

									<div class="col-xs-12 col-sm-3">
									<button type="button" class="btn btn-default" onclick="GuardarActaCierre({{$id}})" >Guardar</button> 
									</div>
									</div>

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
@include("footer")


	</body>
	</html>