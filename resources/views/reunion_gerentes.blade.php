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




					<form id="FormActaReuCierre" method="post" action="" >
						{!! csrf_field() !!}
						<input type="hidden" name="accion_guardar" id="accion_guardar" @if(!empty($acta)) value=2 @else value=1  @endif>
						<input type="hidden" class="form-control1" id="nacata" name="nacata" @if(!empty($acta)) value="{{$acta->idacta_reunion}}" @else value="" @endif>
					<div class="inner_content_w3_agile_info two_in">


						<div class="w3l-table-info agile_info_shadow">




								<div class="col-sm-12" >
									<br>
									<h4 style="text-align: center;">Acta de Reunión</h4>
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
											      <div class="modal-body" id="tabla_documentos">

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
													     				echo "<td>$row->nacata</td>";
													     				echo "<td class='text-center'>
																		<button type='button' class='btn btn-primary' data-dismiss='modal' aria-label='Close' onclick=datos_doc_menu('$row->idacta_reunion')>Ver más</button>
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
											<button type="button" class="btn btn-default" onclick="AgregarDocActa()">Agregar Doc.</button>
										</div>
									</div>
									<br>
									<br>
									<br>
									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Nº de acta</label>
									<div class="col-sm-3">
											<input type="hidden" class="form-control1" id="nacata"  name="nacata"  placeholder="Ingrese una presupuesto de venta adicional" @if(!empty($acta)) value="{{$acta->nacata}}" @else  value="{{$numero}}" @endif>

										<input type="hidden" class="form-control1" id="idproyecto" name="idproyecto"  placeholder="Ingrese una presupuesto de venta adicional" value="{{$id}}">

										<input type="hidden" class="form-control1" id="idacta" name="idacta" id="idacta"  placeholder="Ingrese una presupuesto de venta adicional" @if(!empty($acta)) value="{{$acta->idacta_reunion}}" @else value="{{ $idacta }}" @endif>
										<input type="hidden" id="idnuevaacta" value="{{ $idacta }}">

										<input type="text" class="form-control1" id="pvad"  placeholder="Ingrese una presupuesto de venta adicional" disabled=""  @if(!empty($acta)) value="{{$acta->nacata}}" @else  value="{{$numero}}" @endif>

									</div>
									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Área/Proyecto</label>
									<div class="col-sm-9">
										<select name="area_proyecto" id="area_proyecto" class="form-control1">

										@if(empty($acta))
												<option>-Seleccione un area-</option>
											@endif

											@foreach ($areas as $a)

											@if(!empty($acta))
												@if($acta->area_proyecto==$a->idarea)
													<option value="{{$a->idarea}}" selected="">
												@else
													<option value="{{$a->idarea}}">
												@endif
											@else
												<option value="{{$a->idarea}}">
											@endif

											{{$a->nombre}}</option>


											@endforeach


										</select>
									</div>
									</div>
									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Tema de la Reunión</label>
									<div class="col-sm-9">
										<input type="text" class="form-control1" id="tema" name="tema"  placeholder="Ingrese el tema de la reunion" @if(!empty($acta)) value="{{$acta->tema}}" @endif >
									</div>
									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Fecha</label>
									<div class="col-sm-3">
										<input type="date" class="form-control1" id="fecha" name="fecha"  @if(!empty($acta)) value="{{$acta->fecha}}" @else  value="<?php echo date("Y-m-d");?>" @endif>

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
									<label class="col-sm-3 control-label">Encargado de Área/Proyecto</label>
									<div class="col-sm-9">
										<select name="idencargado" id="idencargado" class="form-control1" required>

											@if(empty($acta))
												<option value="0">-Seleccione un Gerente/Jefe-</option>
											@endif

											@foreach ($gerentesYJefes as $gerentesYJefes)

											@if(!empty($acta))
												@if($acta->idencargado==$gerentesYJefes->idpersona)
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
									<label class="col-sm-3 control-label">Temas Tratados</label>
									<div class="col-sm-9">
										<textarea style="height: 200px;"  name="temas" id="temas" cols="0" rows="10" class="form-control1">@if(!empty($acta)) {{$acta->temas}} @endif</textarea>
										</div>
									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Acciones</label>
									<div class="col-sm-9">
										<textarea style="height: 200px;"  name="acciones" id="acciones" cols="0" rows="10" class="form-control1">@if(!empty($acta)) {{$acta->acciones}} @endif</textarea>
										</div>
									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Fecha Requerida</label>
									<div class="col-sm-3">
										<input type="date" class="form-control1" id="fecha_requerida" name="fecha_requerida" @if(!empty($acta)) value="{{$acta->fecha_requerida}}" @else  value="<?php echo date("Y-m-d");?>" @endif>

									</div>
									</form>
									<div class="col-xs-12 col-sm-2"></div>

									<div class="col-xs-12 col-sm-4">
									<button type="button" class="btn btn-default" data-toggle="modal" data-target="#firmas">
									Participantes y firmas
									</button>

									<div class="modal fade" id="firmas" tabindex="-1" role="dialog" aria-labelledby="firmas">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Firmas</h4>
					</div>
					<div class="modal-body">
				<input type="hidden" name="iddocumento" id="iddocumento" value="13">
				<div class="col-sm-12">
						<label class="col-sm-3 control-label">Nombre:</label>

						<div class="col-sm-9">
						<select id="personaacta" name="idtrabajador" class="form-control1">
						<option>--Seleccione un Trabajador--</option>
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
						                    <td> <a class="fa fa-trash" href="#" onclick="eliminarfirma(<?php echo $v['idfirma'];?>,
						                    <?php echo $id;?>);"></a></td>
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
						<button type="button" id="notificar_reu_menu" class="btn btn-default"
						@if(!empty($acta))
						onclick="enviarNotificacion_menu({{$acta->idacta_reunion}})"
						@else
						onclick="enviarNotificacion_menu({{$idacta}})"
						@endif
						>Notificar</button>
					</div>
				</div>

				<h4>Estado de Firmas</h4>

				<div class="col-sm-12">
					<div class="table-responsive">
						<table class="table" id="FirmasNotificadas">
							<thead>
								<tr>
									<th>Nº</th>
									<th>Area</th>
									<th>Nombre</th>
									<th>Cargo</th>
									<th>Correo</th>
									<th>Estado</th>
								</tr>
							</thead>
							<tbody>
							<?php

							if(!empty($listano)){
									$i=1;
		                            foreach ($listano as $eq) {  ?>
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



									</div>


									<div class="col-sm-12"><br></div>
									<div class="col-sm-12">


									<div class="col-xs-12 col-sm-3">
									<button type="button" class="btn btn-default" onclick="BotonCancelarActas()" >Cancelar</button>
									</div>

									<div class="col-xs-12 col-sm-6">
										<div class="col-sm-3"></div>
										<div class="col-sm-6">
										{{-- @if(!empty($acta)) --}}
											{{-- <a href="/actareumenu/exportaractareu/{{$acta->idacta_reunion}}" id="exportar_reunion_menu" target="_blank"> --}}
											<a id="exportar_reunion_menu" target="_blank">
												<button type="button" class="btn btn-default">Visualizar/Descargar</button>
											</a>
										{{-- @else --}}
										{{-- <a href="/actareumenu/exportaractareu/{{$idacta}}" id="exportar_reunion_menu">
												<button type="button" class="btn btn-default">Visualizar/Descargar</button>
											</a>
										@endif --}}
										</div>
										<div class="col-sm-3"></div>
									</div>

									<div class="col-xs-12 col-sm-3">
									<button type="button" class="btn btn-default" onclick="GuardarActaReunionCierre({{$id}})" >Guardar</button>
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
