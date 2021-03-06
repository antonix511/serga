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
									  <li><a href="/ejecucion_acta/{{$id}}">Acta de Reunión</a></li>
									  <?php }

									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2) ) && isset($doc_validados[7]) && $doc_validados[7] == 1 ){

									  if($_SESSION['psolcambio']>0){  ?>
									  <li><a href="/ejecucion_solicitudcam/{{$id}}">Solicitud de cambio</a></li>
									  <?php }

									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2) ) && isset($doc_validados[8]) && $doc_validados[8] == 1 ){

									  if($_SESSION['pactaacuerdo']>0){ ?>
									  <li><a href="/ejecucion_acuerdo/{{$id}}">Acta de acuerdo</a></li>
									  <?php }

									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2) ) && isset($doc_validados[9]) && $doc_validados[9] == 1 ){

									  if($_SESSION['preportho']>0){ ?>
									  <li><a href="/ejecucion_reporte/{{$id}}">Reporte HO/SNC</a></li>
									  <?php }
									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2) ) && isset($doc_validados[10]) && $doc_validados[10] == 1 ){

									  if($_SESSION['psolac']>0){ ?>
									  <li class="active"><a href="/ejecucion_solicitudac/{{$id}}">Solicitud AC y AP</a></li>
									  <?php }
									  }
										if ( ($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)  ){
									  ?>
									  <li><a href="/ejecucion_modelos/{{$id}}">Modelos</a></li>
									  <?php } ?>

									</ul>



								</div>
								<div class="col-sm-9" >
									<br>
									<h4 style="text-align: center;">SOLICITUD DE ACCIÓN CORRECTIVA /PREVENTIVA</h4>
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
														<div class="modal-body">

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
																			echo "<td>$row->nombre</td>";
																			echo "<td class='text-center'>
																		<button type='button' class='btn btn-primary' data-dismiss='modal' aria-label='Close' onclick=datos_doc_sa('$row->idsolicitudac')>Ver más</button>
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
										<div class="col-md-2" >
											<button type="button" class="btn btn-default" onclick="AgregarDocHo()">Agregar Doc.</button>
										</div>
										<br>
										<br>
										<br>
										<br>

									<div class="col-sm-12">

									<div class="col-sm-5">
										  <input type="file" class="form-control1"  id="file" name="file">
										  <input type="hidden"  id="op" name="op" value="1">
										  <input type="hidden"  id="accion" name="accion" value="{{$accion}}">
										  <input type="hidden"  id="idproyecto" name="idproyecto" value="{{$id}}">
											<input type="hidden" id="idsolicitudac" name="idsolicitudac" value="{{$idsolicitudac}}">
											{!! csrf_field() !!}
									</div>
									<div class="col-sm-4"></div>

									<div class="col-sm-3">
									<button type="button" class="btn btn-default" onclick="guardarReportesa();" >Guardar</button>
									</div>

									</div>
									<h4 class="text-center" id="titulo_documento">{{$nombreArchivo}}</h4>
									<br>
									<div class="col-sm-12" id="resultado">
									<embed src="../documentos/solicitudac/{{$archivo}}" width="100%" height="600">
									</div>

									<div class="col-sm-12">

									<br></div>

									<div class="col-xs-12 col-sm-9"></div>

									<div class="col-xs-12 col-sm-3">
									<button type="button" class="btn btn-default" onclick="eliminarReportesa({{$id}});" >Eliminar</button>
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
	<!--copy rights start here-->
	@include("footer")
	</body>
	</html>
