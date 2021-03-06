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
									  
										if ( ($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)  ){

									  if($_SESSION['pactareunion']>0){ ?>
									  <li><a href="/ejecucion_acta/{{$id}}">Acta de Reunión</a></li>
									  <?php } 

									  }
										if ( ($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)  ){

									  if($_SESSION['psolcambio']>0){  ?>
									  <li><a href="/ejecucion_solicitudcam/{{$id}}">Solicitud de cambio</a></li>
									  <?php } 

									  }
										if ( ($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)  ){

									  if($_SESSION['pactaacuerdo']>0){ ?>
									  <li><a href="/ejecucion_acuerdo/{{$id}}">Acta de acuerdo</a></li>
									  <?php } 

									  }
										if ( ($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)  ){

									  if($_SESSION['preportho']>0){ ?>
									  <li><a href="/ejecucion_reporte/{{$id}}">Reporte HO/SNC</a></li>
									  <?php } 
									  }
										if ( ($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)  ){

									  if($_SESSION['psolac']>0){ ?>
									  <li><a href="/ejecucion_solicitudac/{{$id}}">Solicitud AC y AP</a></li>
									  <?php }
									  }
										if ( ($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)  ){
									  ?>									  
									  <li class="active"><a href="/ejecucion_modelos/{{$id}}">Modelos</a></li>
									  <?php } ?>
									  
									</ul>
						

							
								</div>
								<div class="col-sm-9" >
									<br>
									<h4 style="text-align: center;">MODELOS</h4>
									<div class="col-sm-12"><br>
										<div class="col-sm-4">Tipo :</div>
										<div class="col-sm-8">
											{!! csrf_field() !!}
											<select class="form-control1" id="idtipo_modelo" name="idtipo_modelo" onchange="SeleccionModeloxTipo()">
											@foreach($TipoModelo as $row)
												<option value="{{$row->idtipo_modelo}}">{{$row->nombre}}</option>
											@endforeach
											</select>
										</div>
									</div>
									<div class="col-sm-12">
									<div class="table-responsive">
									<table class="table" id="TablaModelosTipo">
										<thead>
										  <tr>
											<th>Nº</th>
											<th>Nombre</th>
											<th>Tipo de documento</th>
						
											<th>Opciones</th>
										  </tr>
										</thead>
										<tbody>
										<?php $i=1;?>
										@foreach($modelos as $row)
										  <tr>
											<td>{{$i}}</td>
											<td>{{$row->nombre}}</td>
											<td>{{$row->documento->nombre}}</td>
										
										
											<td>
												 <a href="../documentos/modelos//{{$row->archivo}}" download="{{$row->documento->archivo}}">
												 <button> Descargar</button></a>
									</td>
										  </tr>
										  <?php $i++; ?>
										  @endforeach
										  
										</tbody>
									  </table>

									</div>

									</div>







									<div class="col-sm-12">
									<embed src="pdf.pdf#toolbar=0" width="100%" height="375">
									</div>

									<div class="col-sm-12">

									<br></div>

									

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