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



										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2) ) && isset($doc_validados[13]) && $doc_validados[13] == 1 ){



									  if($_SESSION['pactareunion']>0){ ?>

									  <li class="active"><a href="/ejecucion_acta/{{$id}}">Acta de Reunión</a></li>

									  <?php }



									  }

										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2) ) && isset($doc_validados[7]) && $doc_validados[7] == 1 ){



									  if($_SESSION['psolcambio']>0){  ?>

									  <li><a href="/ejecucion_solicitudcam/{{$id}}">Solicitud de cambio</a></li>

									  <?php }



									  }

										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[8]) && $doc_validados[8] == 1  ){



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

								<div class="col-sm-9" >

								<form method="post" action="" id="formActaReu">

								{!! csrf_field() !!}



								<input type="hidden" name="accion_guardar" id="accion_guardar" @if(!empty($actaacu))  value="2" @else value="1" @endif >

									<br>

									<h4 style="text-align: center;">ACTA DE REUNIÓN</h4>

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

											      <div class="modal-body" id="tabla2">



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

																		<button type='button' class='btn btn-primary' data-dismiss='modal' aria-label='Close' onclick=datos_doc('$row->idacta_reunion')>Ver más</button>

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

											<button type="button" class="btn btn-default" onclick="AgregarDoc()">Agregar Doc.</button>

										</div>

										<br>

									<br><br>



									<div class="col-sm-12">

									<label class="col-sm-3 control-label">N° Acta de Reunión</label>

									<div class="col-sm-3">

										<input type="hidden" class="form-control1" id="nacata"  name="nacata"  placeholder="Ingrese una presupuesto de venta adicional" @if(!empty($nacata)) value="{{$nacata->nacata}}" @else value="{{$numero}}" @endif>



										<input type="hidden" class="form-control1" id="idproyecto" name="idproyecto"  placeholder="Ingrese una presupuesto de venta adicional" value="{{$id}}">



										<input type="hidden" class="form-control1" id="idacta" name="idacta"  placeholder="Ingrese una presupuesto de venta adicional" @if(!empty($actaacu)) value="{{$actaacu->idacta_reunion}}" @else value="" @endif>

										

										<input type="text" class="form-control1" id="pvad"  disabled="" @if(!empty($nacata)) value="{{$nacata->nacata}}" @else value="{{$numero}}" @endif>

									</div>

									</div>



									<div class="col-sm-12">

									<label class="col-sm-3 control-label">Área/Proyecto</label>

									<div class="col-sm-9">

										<input type="text" name="area_proyecto" class="form-control1" disabled="" id="area_proyecto" value="{{$nombrepro->nombre}}">

									</div>

									</div>

									<div class="col-sm-12">

									<label class="col-sm-3 control-label">Tema de la Reunión</label>

									<div class="col-sm-9">

										<input type="text" class="form-control1" id="tema" name="tema"  placeholder="Ingrese el tema de la reunion"  @if(!empty($actaacu->tema)) value="{{$actaacu->tema}}"  @endif  >

									</div>

									</div>



									<div class="col-sm-12">

									<label class="col-sm-3 control-label">Fecha</label>

									<div class="col-sm-3">

										<input type="date" class="form-control1" id="fecha" name="fecha" 

										<?php  ?>

										 @if(!empty($actaacu->fecha))

										  value="{{$actaacu->fecha}}"

										  @else  value="{{date("Y-m-d")}}" @endif>



									</div>

									<label class="col-sm-3 control-label" style="text-align: right;">Hora</label>

									<div class="col-sm-3">

										<input type="time" class="form-control1" id="hora" name="hora" 

										<?php  ?>

										 @if(!empty($actaacu->hora))

										  value="{{$actaacu->hora}}"

										  @else  value="{{date("H:i")}}" @endif>



									</div>

									</div>



									<div class="col-sm-12">

									<label class="col-sm-3 control-label">Encargado de Área/Proyecto</label>

									<div class="col-sm-9">

										<select name="idencargado" id="idencargado" class="form-control1" required>



											@if(empty($actaacu))

												<option value="0">-Seleccione un Gerente/Jefe-</option>

											@endif



											@foreach ($gerentesYJefes as $gerentesYJefes)



											@if(!empty($actaacu))

												@if($actaacu->idencargado==$gerentesYJefes->idpersona)

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

										<textarea  name="temas" style="height: 200px;" id="temas" cols="0" rows="10" class="form-control1 wsg" >@if(!empty($actaacu->temas))  {{$actaacu->temas}} @endif</textarea>

										</div>

									</div>



									<div class="col-sm-12">

									<label class="col-sm-3 control-label">Acciones</label>

									<div class="col-sm-9">

										<textarea  name="acciones"  style="height: 200px;" id="acciones" cols="0" rows="10" class="form-control1 wsg">@if(!empty($actaacu->acciones))  {{$actaacu->acciones}} @endif  </textarea>

										</div>

									</div>



									<div class="col-sm-12">

									<label class="col-sm-3 control-label">Fecha Requerida</label>

									<div class="col-sm-3">

										<input type="date" class="form-control1" id="fecha_requerida" name="fecha_requerida"

										 @if(!empty($actaacu->fecha_requerida))

										  value="{{$actaacu->fecha_requerida}}"

										  @else  value="{{date("Y-m-d")}}" @endif >



									</div>

									<div class="col-sm-3"></div>

									<div class="col-xs-12 col-sm-3">

									<button type="button" class="btn btn-default" data-toggle="modal" data-target="#firmas">Firmas</button></div>







									<div class="modal fade" id="firmas" tabindex="-1" role="dialog" aria-labelledby="firmas">

			<div class="modal-dialog" role="document">

				<div class="modal-content">

					<div class="modal-header">

						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

						<h4 class="modal-title" id="myModalLabel">Firmas</h4>

					</div>

					<div class="modal-body">



					<form id="FormGuardarFirma" method="post" action="">



				<div class="col-sm-12">

						<label class="col-sm-3 control-label">Nombre:</label>



						<div class="col-sm-9">

						<input type="hidden" name="iddocumento" id="iddocumento" value="6">

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

					            	$i=1;

						            	if (!empty($lista)) {

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

					<div id="resupestanotificar">



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





									<br><hr><br>

									<div class="col-sm-12"></div>



									<div class="col-xs-12 col-sm-3">

									<button type="button" class="btn btn-default" onclick="BotonCancelarActas()">Cancelar</button>

									</div>



									<div class="col-xs-12 col-sm-6">

										<div class="col-sm-3"></div>

										<div class="col-sm-6">

											<a href="/actareu/exportaractareu/{{$id}}" target="_blank">

												<button type="button" class="btn btn-default">

													Visualizar /Descargar

												</button>

											</a>

										</div>

										<div class="col-sm-3"></div>

									</div>



									<div class="col-xs-12 col-sm-3">

									<button type="button" class="btn btn-default" onclick="GuardarActaReunion({{$id}})" >Guardar</button>

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

