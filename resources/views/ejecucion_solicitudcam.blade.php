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
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2) ) && isset($doc_validados[7]) && $doc_validados[7] == 1 ){

									  if($_SESSION['psolcambio']>0){  ?>
									  <li class="active"><a href="/ejecucion_solicitudcam/{{$id}}">Solicitud de cambio</a></li>
									  <?php }

									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2) ) && isset($doc_validados[8]) && $doc_validados[8] == 1 ){

									  if($_SESSION['pactaacuerdo']>0){ ?>
									  <li><a href="/ejecucion_acuerdo/{{$id}}">Acta de acuerdo</a></li>
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

								</div>

								<form method="post" id="formSolicitudCambio" nombre="ella">
								{!! csrf_field() !!}
							<input type="hidden" name="accion_guardar" id="accion_guardar" @if(!empty($solcam))  value="2" @else value="1" @endif >
							<input type="hidden" name="idacta" id="idacta" @if(!empty($solcam))  value="{{$solcam->idsolicitud}}"@else value="1" @endif  >
							<input type="hidden" class="form-control1" id="nacata" name="nacata" @if(!empty($solcam)) value="{{$solcam->idsolicitud}}" @else value="" @endif>

							<input type="hidden" name="idproyecto" id="idproyecto" value="{{$id}}">
								<div class="col-sm-9" >
									<br>
									<h4 style="text-align: center;">SOLICITUD DE CAMBIO</h4>
									<br><br>
									<div class="text-right col-md-12">
										<div class="col-md-7"></div>
										<div class="col-md-3">
											<button type="button" class="btn btn-default"  data-toggle="modal" data-target="#registro">Ver Doc. Registrados</button>

											<div class="modal fade" id="registro" tabindex="-1" role="dialog">
											  <div class="modal-dialog" role="document">
											    <div class="modal-content">
											      <div class="modal-header text-left">
											        <h4 class="modal-title" id="exampleModalLabel">Documentos Registrados</h4>
											      </div>
											      <div class="modal-body" id="tabla_solicitud">

											       	<table class="table">
											    		<thead>
											    			<tr>
											    			<th>N°</th>
												    		<th>Medio de Aprobación - fecha</th>
												    		<th>Ver</th>
												    		</tr>
											    		</thead>
											    		<tbody>
											    			<?php
													     		if(!empty($listadoc)){
													     			$contador = 1;
													     			foreach ($listadoc as $row) {
													     				$date =  $row->fecha;
													     				$fecha=date("d-m-Y",strtotime($date));
													     				echo "<tr><td>$contador</td>";
													     				echo "<td>$row->medio $fecha</td>";
													     				echo "<td class='text-center'>
																		<button type='button' class='btn btn-primary' data-dismiss='modal' aria-label='Close' onclick=datos_doc_solicitud_cambio('$row->idsolicitud')>Ver más</button>
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
											<button type="button" class="btn btn-default" onclick="AgregarDoc2()">Agregar Doc.</button>
										</div>
									</div>
									<br>
									<br>
									<br>
									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Fecha</label>
									<div class="col-sm-3">
										<input type="date" class="form-control1" id="fecha" name="fecha" @if(!empty($solcam)) value="{{$solcam->fecha}}" @else value="<?php echo date("Y-m-d");?>" @endif >
									</div>

									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Motivo de Cambio</label>

									<div class="col-sm-6">
									<div class="checkbox-inline1">
									<label>
									<input type="checkbox" id="input" name="motivo_tiempo" value=1 @if(!empty($solcam)) @if($solcam->motivo_tiempo==1) checked="" @endif  @endif > Tiempo
									</label>
									</div>
									<div class="checkbox-inline1"><label>
									<input type="checkbox" id="input1"  value=1 name="motivo_costo" @if(!empty($solcam)) @if($solcam->motivo_costo==1) checked="" @endif  @endif   >
									Costo
									</label></div>
									<div class="checkbox-inline1"><label>
									<input type="checkbox" id="input2" value=1 name="motivo_alcance" @if(!empty($solcam)) @if($solcam->motivo_alcance==1) checked="" @endif  @endif    >
									Alcance</label></div>
									<div class="checkbox-inline1"><label>
									<input type="checkbox" id="input3" value=1 name="motivo_sgc" @if(!empty($solcam)) @if($solcam->motivo_sgc==1) checked="" @endif  @endif    >
									SGC</label></div>
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
										<input type="text" class="form-control1"  disabled="" value="{{$centrodecosto}}">
									</div>
									</div>
									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Cliente</label>
									<div class="col-sm-9">
										<input type="text" class="form-control1"  disabled="" value="{{$cli}}">
									</div>
									</div>
									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Contacto (Cliente)</label>
									<div class="col-sm-9">
										<input type="text" class="form-control1"  disabled="" value="{{$contacto}}">
									</div>
									</div>
									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Medio de Aprobación</label>
									<div class="col-sm-9">
										<input type="text" class="form-control1"  name="medio" id="medio" @if(!empty($solcam)) value="{{$solcam->medio}}"  @endif  >
									</div>
									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Descripción</label>
									<div class="col-sm-9">
										<textarea  name="descripcion" id="descripcion" cols="0" rows="10" class="form-control1 wsg" style="height: 200px"> @if(!empty($solcam)) {{$solcam->descripcion}}  @endif </textarea>
										</div>
									</div>

									<div class="col-sm-12">
										<label class="col-sm-3 control-label">Fecha de entrega</label>
										<div class="col-sm-3">
											<input type="date" class="form-control1" id="fecha_entrega" name="fecha_entrega"
												@if(!empty($solcam)) value="{{$solcam->fecha_entrega}}"
												@else value="<?php echo date("Y-m-d");?>" @endif >
											</div>
									</div>

									<br><hr><br>

									<div class="col-sm-12">
										<br> <div class="col-sm-6">
										<h4>Aprobación</h4>
										</div><br><br>
									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Nombre</label>
									<div class="col-sm-9">
										<input type="text" class="form-control1" id="nombre" name="nombre"  placeholder="Nombre "  @if(!empty($solcam)) value="{{$solcam->nombre}}"  @endif  >
									</div>
									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Cargo</label>
									<div class="col-sm-9">
										<input type="text" class="form-control1" id="acta_cargo" name="acta_cargo"  placeholder="Cargo"  @if(!empty($solcam)) value="{{$solcam->cargo}}"  @endif  >
									</div>
									</div>

									<div class="col-sm-12">

									<div class="col-xs-12 col-sm-3">
									<button type="button" class="btn btn-default" data-toggle="modal" data-target="#firmas">
									Firmas
									</button>

									<div class="modal fade" id="firmas" tabindex="-1" role="dialog" aria-labelledby="firmas">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Paricipantes y Firmas</h4>
					</div>
					<div class="modal-body">
					<form id="FormGuardarFirma" method="post" action="">

					<input type="hidden" name="iddocumento" id="iddocumento" value="7">
				<div class="col-sm-12">
						<label class="col-sm-3 control-label">Nombre:</label>

						<div class="col-sm-9">
						<select id="personaacta" name="idtrabajador" class="form-control1">
						<option>Cardo del Trabajador</option>
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
							<option>-Seleccione un cargo-</option>

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
				<input name="_token" hidden value="{!! csrf_token() !!}" />
				</form>

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
										if(!empty($lista)){
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
										}else{

										}

						            ?>
								</tbody>
							</table>

								</div>

					</div>
					<div class="col-sm-12">
					<div class="col-xs-12 col-sm-9"></div>

					<div class="col-xs-12 col-sm-3">
						<button type="button" class="btn btn-default" onclick="enviarNotificacion({{$id}});" >Notificar</button>
					</div>
				</div>

				<h4>Estado de Firmas</h4>

				<div class="col-sm-12">
					<div class="table-responsive">
						<table class="table"  id="FirmasNotificadas">
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
                            <?php

                             $i=1;
                            foreach ($firmas as $eq) {  ?>
                                <tr>
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $eq->area;?></td>
                                    <td><?php echo $eq->nombres.' '.$eq->apellidos;?></td>
                                    <td><?php echo $eq->puesto;?></td>
                                    <td><?php echo $eq->correo;?></td>
                                    <td><?php echo $eq->estado;?></td>

                            </tr>
                            <?php $i++;
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

									<div class="col-xs-12 col-sm-9"></div>

									</div>



									<div class="col-sm-12"><br></div>
									<div class="col-sm-12">


									<div class="col-xs-12 col-sm-3">
									<button type="button" class="btn btn-default" onclick="BotonCancelarActas()" >Cancelar</button>
									</div>

									<div class="col-xs-12 col-sm-6">
										<div class="col-sm-3"></div>
										<div class="col-sm-6">
											<a href="/solcam/exportarsolcam/{{$id}}" target="_blank">
												<button @if(empty($solcam)) disabled="" @endif type="button" id="ExportarSolCam" class="btn btn-default">
													Visualizar/Descargar
												</button>
											</a>
										</div>
										<div class="col-sm-3"></div>
									</div>

									<div class="col-xs-12 col-sm-3">
									<button type="button" class="btn btn-default" onclick="AgregarSolicitudCambio({{$id}})" >Guardar</button>
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

	<!--copy rights end here-->
	@include("footer")
	</body>
	</html>
