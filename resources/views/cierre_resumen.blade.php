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
								  <li><a href="/ejecucion_resumen/{{$id}}">Ejecución</a></li>
								  <?php } if($_SESSION['cierre']>0){ ?>
								  <li class="active"><a href="#">Cierre</a></li>
								  <?php } ?>

								
								</ul>
								</div>
								<div class="col-sm-12"><br></div>


								
								<div class="col-sm-3" style="border: solid 1px #d6d6d6;padding: 10px;">
								

									<ul class="nav nav-pills nav-stacked">

										<li class="active"><a href="#">Resumen</a></li>
									  <?php if($_SESSION['pactacierre']>0 && isset($doc_validados[12]) && $doc_validados[12] == 1){ ?>
									  <li><a href="/cierre_actac/{{$id}}">Acta de Cierre</a></li>
									  <?php } if($_SESSION['pactareuc']>0){  ?>
									  
									  <?php } ?>

				
									</ul>
						

							
								</div>
								<div class="col-sm-9" >
									<br>
									<h4>En la fase de CIERRE del PROYECTO {{$nombreclave}} los documentos registrados son los siguientes:</h4>
									<br><br>
									<?php if($_SESSION['pactacierre']>0 && isset($doc_validados[12]) && $doc_validados[12] == 1){ ?>


									  <div class="checkbox-inline1"><label><input type="checkbox" disabled="" @if ($actacierre == 1) {{'checked'}} @endif> Acta de Cierre</label></div>


									  <?php }  ?>

									
										
										

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