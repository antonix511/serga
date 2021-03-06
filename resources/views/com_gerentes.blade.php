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
					<div class="inner_content_w3_agile_info" style="overflow: auto;">
						<div class="col-sm-12" style="border: solid 1px #ddd;
    padding-bottom: 20px;    overflow: auto;">

							<br>
							<h4 style="text-align: center;">Acta de Comité de Gerentes</h4>
							<br><br>
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
												<div class="modal-body" id="hola">

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
																	echo "<td>Acta Comité de Gerentes - ".date('Y',strtotime($row->fecha_registro))." - ".$row->nacta_fake."</td>";
																	echo "<td class='text-center'>
																<button type='button' class='btn btn-primary' data-dismiss='modal' aria-label='Close' onclick=datos_doc_Comite('$row->idcomite','$row->nacta_fake')>Ver más</button>
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
									<button type="button" class="btn btn-default" onclick="AgregarDoc_comite_Gerente({{ $ultimoid->nacta_fake}})">Agregar Doc.</button>
								</div>
								<br>
							<br><br>
							<?php
								if(!empty($ultimoid->nacta)){
								 $_SESSION["nacta"]=$ultimoid->nacta ;
								 }else{
								 	 $_SESSION["nacta"]=1;
								 }
							 	?>
							<div class="col-sm-12">
							<input type="hidden" @if(!empty($create)) value="2" @else value="1" @endif id="accion">
							<form method="post" action="" id="FormComite">
							{!! csrf_field() !!}

									<label class="col-sm-2 control-label">Nº</label>
									<div class="col-sm-3">
										<input type="hidden" class="form-control1" id="idcomite"  placeholder="" @if(!empty($ultimoid)) value="{{$ultimoid->nacta}}" @else value="1" @endif >
										<input type="hidden" class="form-control1" id="idcomite2" name="idcomite2"  placeholder="" @if(!empty($ultimoid)) value="{{$ultimo->idcomite}}" @else 0 @endif >
										<input type="hidden" class="form-control1" id="pvad" disabled="" placeholder="" @if(!empty($ultimoid)) value="{{$ultimoid->nacta}}" @else value="1" @endif >
										<input type="text" class="form-control1" id="nacta_fake" disabled="" placeholder="" @if(!empty($ultimoid)) value="{{$ultimoid->nacta_fake}}" @else value="1" @endif >
									</div>
									<div class="col-sm-1"></div>

									<label class="col-sm-1 control-label">Area/proyecto</label>
									<div class="col-sm-5">
									<select name="idarea" id="idarea" class="form-control1">

												<option>-Seleccione un area-</option>

											@if(!empty($ultimo->idarea))



												@foreach ($areas as $a)
														@if($ultimo->idarea == $a->idarea)
													<option @if(!empty($a)) value="{{$a->idarea}}" @else  @endif selected>
													@else
														<option @if(!empty($a)) value="{{$a->idarea}}" @else  @endif>
													@endif

												{{$a->nombre}}</option>

												@endforeach
												@else

												@foreach ($areas as $a)

														<option @if(!empty($a)) value="{{$a->idarea}}" @else  @endif>

												{{$a->nombre}}</option>

												@endforeach

												@endif



										</select>
									</div>
							</div>
							<div class="col-sm-12">
									<label class="col-sm-2 control-label">Tema de la reunión</label>
									<div class="col-sm-10">
										<input type="text" class="form-control1" id="tema" name="tema"  placeholder="Ingrese el tema de la reunión" @if(!empty($ultimo)) required value="{{$ultimo->tema}}" @else  @endif>
									</div>
							</div>
							<div class="col-sm-12">
									<label class="col-sm-2 control-label">Fecha</label>
									<div class="col-sm-3">
										<input type="date" class="form-control1" id="fecha_hora" name="fecha_hora" @if(!empty($ultimo)) value="{{$ultimo->fecha_hora}}" @else  @endif >
									</div>
									<label class="col-sm-3 control-label"  style="text-align: right;">Hora</label>
									<div class="col-sm-3">
										<input type="time" class="form-control1" id="hora" name="hora" @if(!empty($ultimo)) value="{{$ultimo->hora}}" @else  @endif >
									</div>

							</div>
							<div class="col-sm-12">
									<label class="col-sm-2 control-label">Encargado de Area/Proyecto</label>
									<div class="col-sm-10">
									<select name="idencargado" id="idencargado" class="form-control1" required>

												<option value="0">-Seleccione un Gerente/Jefe-</option>
												@if(!empty($ultimo))
											@foreach ($gerentesYJefes as $gerentesYJefes)

												@if($ultimo->idencargado == $gerentesYJefes->idpersona)

												<option value="{{$gerentesYJefes->idpersona}}" selected="">

												@else
												<option value="{{$gerentesYJefes->idpersona}}">
												@endif
											{{$gerentesYJefes->nombre.' '.$gerentesYJefes->trabajador->apellidos}}
											</option>


											@endforeach

											@else
												@foreach ($gerentesYJefes as $gerentesYJefes)
													<option value="{{$gerentesYJefes->idpersona}}">{{$gerentesYJefes->nombre.' '.$gerentesYJefes->trabajador->apellidos}}
											</option>
											@endforeach

											@endif

										</select>
									</div>
							</div>
							<div class="col-sm-12">
										<br> <div class="col-sm-6">
										<h4>Participantes</h4>
										</div><br><br>
									</div>


							<div class="col-sm-12">
									<label class="col-sm-2 control-label">Nombre</label>
									<div class="col-sm-4">
										<select id="personaacta" name="personaacta" class="form-control1">
						<option>--Seleccione un Trabajador--</option>
						@foreach($trabajadores as $t)
							<option value="<?php  echo $t->idpersona;?>"><?php  echo $t->nombres.' '.$t->apellidos;?></option>
						@endforeach
						</select>
									</div>
									<label class="col-sm-1 control-label">Cargo</label>
									<div class="col-sm-5">
										<div id="cargarcargo">
											<select name="cargo" id="cargo" class="form-control1">
												<option>-Seleccione un cargo-</option>

											</select>
										</div>
									</div>

							</div>
							<div class="col-sm-12"><br></div>
							<div class="col-sm-12">
									<div class="col-xs-12 col-sm-9"></div>

									<div class="col-xs-12 col-sm-3">
									<button type="button" class="btn btn-default" onclick="agregarParticipantesComite()" >Agregar</button>
									</div>
									</div>
									<div class="col-sm-12"><br></div>



								<div class="col-sm-12">
									<div class="table-responsive">
									<table class="table" id="TableComiteGerentes">
										<thead>
                                          <tr>
                                            <th>Nº</th>
                                            <th>Nombre</th>
                                            <th>Cargo</th>
                                            <th>Eliminar</th>
                                          </tr>
                                        </thead>
                                        <tbody><?php $i=1; ?>
                                        <?php if(!empty($participantes)){ ?>
                                        <?php foreach ($participantes as $row) { ?>

                                          <tr>
                                            <td><?=$i;?></td>
                                            <td><?php echo $row->nompa->nombre. " ".$row->apepa->apellidos ?></td>
                                            <td><?=$row->cargo?></td>
                                            <td><a href="#"><i class="fa fa-trash" onclick="EliminarParticipantesComite(<?=$row->idcomite_participantes?>)"></i></a></td>
                                          </tr>
                                        <?php $i++; } ?>
                                        <?php } ?>

                                        </tbody>
									  </table>

									</div>

									</div>


									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Revisiones Pendientes</label>
									<div class="col-sm-9">
										<textarea  name="revision" id="revision" cols="0" rows="10" class="form-control1" style="height: 200px;">@if(!empty($ultimo)) {{$ultimo->revision}} @else   @endif</textarea>
										</div>
									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">AVANCES</label>
									<div class="col-sm-9">
										<textarea  name="avances" id="avances" cols="0" rows="10" class="form-control1" style="height: 400px;">@if(!empty($ultimo)) {{$ultimo->avances}} @else   @endif</textarea>
										</div>
									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">ENCARGOS DEL SIGUIENTE PROYECTO</label>
									<div class="col-sm-9">
										<textarea  name="encargados" id="encargados" cols="0" rows="10" class="form-control1" style="height: 200px;">@if(!empty($ultimo)) {{$ultimo->encargados}} @else   @endif</textarea>
										</div>
									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Fecha Proxima Reunión</label>
									<div class="col-sm-3">
										<input type="date" class="form-control1" id="fecha_prox_reu" name="fecha_prox_reu"
										@if(!empty($ultimo))

										value="{{$ultimo->fecha_prox_reu}}"

										@else
										value="<?php echo date("d-m-Y"); ?>"
										 @endif
										 >
									</div>
									<div class="col-sm-3"></div>
									<div class="col-xs-12 col-sm-3">
									<button type="button" class="btn btn-default" data-toggle="modal" data-target="#firmas">
									Firmas
									</button>






									<div class="modal fade" id="firmas" tabindex="-1" role="dialog" aria-labelledby="firmas">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Firmas</h4>
					</div>
					<div class="modal-body">


				<div class="col-sm-12">
						<label class="col-sm-3 control-label">Nombre:</label>

						<div class="col-sm-9"><select name="personafirmacomite" id="personafirmacomite" class="form-control1">
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
						<div id="cargofirma">
							<select disabled="" class="form-control1">
								<option>Cargo del Trabajador</option>
							</select>
						</div>
					</div>
				</div>



				<div class="col-sm-12">
					<div class="col-xs-12 col-sm-9"></div>

					<div class="col-xs-12 col-sm-3">
						<button type="button" class="btn btn-default"  onclick="agregarfirmaComite()">Agregar</button>
					</div>
				</div>

				<div class="col-sm-12">
					<div class="table-responsive" id="resultadoagregarfirmantescomite">
						<table class="table">
							<thead>
								<tr>
									<th>Nº</th>
					                <th>Gerencia</th>
					                <th>Nombre</th>
					                <th>Cargo</th>
					                <th>Correo</th>
					                <th></th>
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
						                      <td><?php echo $v['area'];?></td>
						                      <td><?php echo $v['nombres'].' '.$v['apellidos'];?></td>
						                      <td><?php echo $v['puesto'];?></td>
						                      <td><?php echo $v['correo'];?></td>
						                      <td> <a href="#"><i class="fa fa-trash"onclick="EliminarFirmaComite(<?=$v["idfirma"]?>)"></i></a></td>
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
						<button type="button" class="btn btn-default" onclick="notificarfirmaComite()" >Notificar</button>
					</div>
				</div>

				<h4>Estado de Firmas</h4>

				<div class="col-sm-12">
					<div class="table-responsive" id="TablaNotificadosComite">
						<table id="myTable2" class="table table-striped table-bordered">
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
			            if(!empty($listano)){
			            foreach ($listano as $v ){
			                ?>
			                <tr>
			                    <td><?php echo $i;?></td>
			                    <td><?php echo $v['area'];?></td>
			                    <td><?php echo $v['nombres'].' '.$v['apellidos'];?></td>
			                    <td><?php echo $v['puesto'];?></td>
			                    <td><?php echo $v['correo'];?></td>
			                    <td><?php echo $v['estado'];?></td>
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




					</div>
					<div class="modal-footer">
					</div>
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
											{{-- <a id="exportar" href="/inicio/com_gerentes/exportar/{{ $_SESSION["idcomite"]}}" target="_blank"> --}}
											<a id="exportar" target="_blank">
												<button type="button" class="btn btn-default" >Visualizar/Descargar</button>
											</a>
										</div>
									</div>

									<div class="col-xs-12 col-sm-3">
									<button type="button" class="btn btn-default" onclick="GuardarComite()">Guardar</button>
									</div>
									</div>
									</form>
						</div>
				    </div>
					<!-- //inner_content_w3_agile_info-->
				</div>
		<!-- //inner_content-->
	</div>
<!-- banner -->
<!--copy rights start here-->
@include("footer")

</body>
</html>
