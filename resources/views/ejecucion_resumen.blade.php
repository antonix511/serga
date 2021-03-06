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

										<li class="active"><a href="#">Resumen</a></li>
									  <?php 
									  
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2) ) && isset($doc_validados[13]) && $doc_validados[13] == 1 ){

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
									  <li><a href="/ejecucion_acuerdo/{{$id}}">Acta de acuerdo</a></li>
									  <?php } 

									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2) ) && isset($doc_validados[9]) && $doc_validados[9] == 1 ){

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
									<br>
									<h4>En la fase de EJECUCIÓN del PROYECTO {{$nombreclave}} los documentos registrados son los siguientes:</h4>
									<br><br>

									<?php 

										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[13]) && $doc_validados[13] == 1  ){
									if($_SESSION['pactareunion']>0){ ?>

									  <div class="checkbox-inline1"><label><input type="checkbox" disabled="" @if ($actareunion == 1) {{'checked'}} @endif> Acta de Reunión</label></div>

									  <?php } 


									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2) ) && isset($doc_validados[7]) && $doc_validados[7] == 1 ){

									  if($_SESSION['psolcambio']>0){  ?>

									  <div class="checkbox-inline1"><label><input type="checkbox" disabled="" @if ($solcambio == 1) {{'checked'}} @endif> Solicitud de cambio</label></div>

									  <?php } 

									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[8]) && $doc_validados[8] == 1  ){

									  if($_SESSION['pactaacuerdo']>0){ ?>

									  <div class="checkbox-inline1"><label><input type="checkbox" disabled="" @if ($actaacuerdo == 1) {{'checked'}} @endif> Acta de Acuerdo</label></div>

									  <?php } 

									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2) ) && isset($doc_validados[9]) && $doc_validados[9] == 1 ){

									  if($_SESSION['preportho']>0){ ?>

									  <div class="checkbox-inline1"><label><input type="checkbox" disabled="" @if ($reportho == 1) {{'checked'}} @endif> Reporte HO/SNC</label></div>

									  <?php } 

									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2) ) && isset($doc_validados[10]) && $doc_validados[10] == 1 ){


									  if($_SESSION['psolac']>0){ ?>

									  <div class="checkbox-inline1"><label><input type="checkbox" disabled="" @if ($solac == 1) {{'checked'}} @endif> Solicitud AC y AP</label></div>

									  <?php }

									  }
										if ( ($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)  ){
									  ?>			
									  <div class="checkbox-inline1"><label><input type="checkbox" disabled="" checked="" > Modelos</label></div>
									  <?php } ?>


									
										
										
										
										

											


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
	<!--copy rights start here-->
	@include("footer")



	</body>
	</html>