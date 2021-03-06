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
								  <li class="active"><a href="#">Inicio y Planificación</a></li>
								  <?php } if($_SESSION['ejecucion']>0){ ?>
								  <li><a href="/ejecucion_resumen/{{$id}}">Ejecución</a></li>
								  <?php } if($_SESSION['cierre']>0){ ?>
								  <li><a href="/cierre_resumen/{{$id}}">Cierre</a></li>
								  <?php } ?>
								
								</ul>
								</div>
								<div class="col-sm-12"><br></div>


								
								<div class="col-sm-3" style="border: solid 1px #d6d6d6;padding: 10px;">
								

									<ul class="nav nav-pills nav-stacked">
									  <li class="active"><a href="">Resumen</a></li>
									  <?php  

									  
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2) || ($_SESSION['tipoproy']==3)) && isset($doc_validados[1]) && $doc_validados[1] == 1   ){

									  if($_SESSION['pactainicio']>0){ ?>
									  <li><a href="/inicio_actainicio/{{$id}}">Acta de Inicio</a></li>
									  <?php } 

									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2) ) && isset($doc_validados[2]) && $doc_validados[2] == 1  ){

									  if(($_SESSION['pmatrizcomu']>0) ){  ?>
									  <li><a href="/inicio_matrizcomu/{{$id}}">Matriz de Comunicación</a></li>
									  <?php } 

									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2) ) && isset($doc_validados[3]) && $doc_validados[3] == 1  ){

									  if($_SESSION['pmatrizrol']>0){ ?>
									  <li><a href="/inicio_matrizrol/{{$id}}">Matriz de Roles</a></li>
									  <?php } 

									  }
										if ( ($_SESSION['tipoproy']==1) && isset($doc_validados[15]) && $doc_validados[15] == 1 ){

									  if($_SESSION['pmatrizries']>0){ ?>
									  <li><a href="/inicio_matrizriesgos/{{$id}}">Matriz de Riesgos</a></li>
									  <?php } 

									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[4]) && $doc_validados[4] == 1   ){

									  if($_SESSION['preqlogist']>0){ ?>
									  <li><a href="/inicio_reqlogisti/{{$id}}">Req. Logistica</a></li>
									  <?php } 

									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[5]) && $doc_validados[5] == 1   ){
									  if($_SESSION['preqcart']>0){ ?>
									  <li><a href="/inicio_reqcartog/{{$id}}">Req. Cartografía</a></li>
									  <?php } 

									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[6]) && $doc_validados[6] == 1   ){
									  ?>
									  <li><a href="/cierre_actar/{{$id}}">Acta de Reunión</a></li>
									  <?php } ?>
									</ul>
						

							
								</div>
								<div class="col-sm-9" >
									<br>
									<h4>En la fase de INICIO Y PLANIFICACIÓN del PROYECTO {{$nombreclave}} los documentos registrados son los siguientes:</h4>
									<br><br>
										<?php  

										
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2) || ($_SESSION['tipoproy']==3)) && isset($doc_validados[1]) && $doc_validados[1] == 1  ){

										if($_SESSION['pactainicio']>0){ ?>

										<div class="checkbox-inline1"><label><input type="checkbox" disabled="" @if ($actainicio == 1) {{'checked'}} @endif> Acta de inicio</label></div>

										<?php } 

										}
										
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[2]) && $doc_validados[2] == 1   ){

										if($_SESSION['pmatrizcomu']>0){  ?>

										<div class="checkbox-inline1"><label><input type="checkbox" disabled="" @if ($matrizcomu == 1) {{'checked'}} @endif> Matriz de comunicación</label></div>

										<?php } 


										}
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[3]) && $doc_validados[3] == 1   ){

										if($_SESSION['pmatrizrol']>0){ ?>

										<div class="checkbox-inline1"><label><input type="checkbox" disabled="" @if ($matrizrol == 1) {{'checked'}} @endif> Matriz de roles</label></div>
										
										<?php } 


										}
										if ( ($_SESSION['tipoproy']==1) ){

										if(($_SESSION['pmatrizries']>0) && isset($doc_validados[15]) && $doc_validados[15] == 1 ){ ?>

										<div class="checkbox-inline1"><label><input type="checkbox" disabled="" @if ($matrizrol == 1) {{'checked'}} @endif> Matriz de Riesgos</label></div>
										
										<?php } 


										}
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[4]) && $doc_validados[4] == 1   ){

										if($_SESSION['preqlogist']>0){ ?>

										<div class="checkbox-inline1"><label><input type="checkbox" disabled="" @if ($reqlogist == 1) {{'checked'}} @endif> Requerimientos de Logistica</label></div>
										
										<?php } 


										}
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[5]) && $doc_validados[5] == 1   ){

										if($_SESSION['preqcart']>0){ ?>

										<div class="checkbox-inline1"><label><input type="checkbox" disabled="" @if ($reqcart == 1) {{'checked'}} @endif> Requerimientos de Cartografía</label></div>
										
										<?php } ?>
										<?php  

										}
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[6]) && $doc_validados[6] == 1   ){

										if($_SESSION['pactareuc']>0){ ?>
										<div class="checkbox-inline1"><label><input type="checkbox" disabled="" @if ($actareuc == 1) {{'checked'}} @endif> Acta de Reunión</label></div>


									  <?php }
									  } ?>
											


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