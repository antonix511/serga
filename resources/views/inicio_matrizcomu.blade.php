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
										<li ><a href="/inicio_resumen/{{$id}}">Resumen</a></li>
									  <?php 

									  
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2) || ($_SESSION['tipoproy']==3)) && isset($doc_validados[1]) && $doc_validados[1] == 1 ){

									  if($_SESSION['pactainicio']>0){ ?>
									  <li><a href="/inicio_actainicio/{{$id}}">Acta de Inicio</a></li>
									  <?php } 


									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[2]) && $doc_validados[2] == 1  ){

									  if($_SESSION['pmatrizcomu']>0){  ?>
									  <li class="active"><a href="/inicio_matrizcomu/{{$id}}">Matriz de Comunicación</a></li>
									  <?php } 

									  }
										if ( ($_SESSION['tipoproy']==1) && isset($doc_validados[3]) && $doc_validados[3] == 1 ){


									  if($_SESSION['pmatrizrol']>0){ ?>
									  <li><a href="/inicio_matrizrol/{{$id}}">Matriz de Roles</a></li>
									  <?php } 


									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2) ) && isset($doc_validados[15]) && $doc_validados[15] == 1 ){


									  if($_SESSION['pmatrizries']>0){ ?>
									  <li><a href="/inicio_matrizriesgos/{{$id}}">Matriz de Riesgos</a></li>
									  <?php } 


									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[4]) && $doc_validados[4] == 1  ){

									  if($_SESSION['preqlogist']>0){ ?>
									  <li ><a href="/inicio_reqlogisti/{{$id}}">Req. Logistica</a></li>
									  <?php } 


									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[5]) && $doc_validados[5] == 1  ){


									  if($_SESSION['preqcart']>0){ ?>
									  <li><a href="/inicio_reqcartog/{{$id}}">Req. Cartografía</a></li>
									  <?php }}
									  if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[6]) && $doc_validados[6] == 1  ){		  
									   ?>
									  <li><a href="/cierre_actar/{{$id}}">Acta de Reunión</a></li>
									  <?php } ?>
									</ul>
						

							
								</div>
								
								<form id="" action="/inicio/matrizrol" method="post">

									<input type="hidden" name="idmatriz" id="idmatriz" value="{{$idmatriz}}">		
									<input type="hidden"  id="idproyecto" name="idproyecto" value="{{$id}}">
									<input type="hidden"  id="accion" name="accion" value="{{$accion}}">
								

								<div class="col-sm-9" >
									<br>
									<h4 style="text-align: center;">MATRIZ DE COMUNICACIÓN</h4>
									<br><br>

									<input type="hidden"  id="op" name="op" value="1">	
									


									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Nombre del Proyecto</label>
									<div class="col-sm-9">
										<input type="text" class="form-control1" disabled="" value="{{$nom}}"></div>
									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Nombre Clave del Proyecto</label>
									<div class="col-sm-9">
										<input type="text" class="form-control1"  disabled="" value="{{$nomcla}}">
									</div>
									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Fecha</label>
									<div class="col-sm-3">
										<input type="date" class="form-control1" id="fecha" name="fecha" value="{{$fecha}}">
									</div>
									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Descripción</label>
									<div class="col-sm-9">
										<textarea   name="descripcion" id="descripcion" cols="0" rows="10" class="form-control1 wsg" value="{{$descripcion}}" >{{$descripcion}}</textarea>
									</div>
									</div>

									<div class="col-sm-12">
										<label class="col-sm-3 control-label">Archivo</label>
									<div class="col-sm-9">
										  <input type="file" class="form-control1"  id="file" name="file">
									</div>
									
									</div>
									<div class="col-sm-12">
									<div class="col-sm-3"></div>
										<label class="col-sm-9 control-label">{{$docuemnto}}</label>
									
									</div>
									<div class="col-sm-12"><br></div>

									<div id="resultadomatrizcomu">

									<div class="col-xs-12 col-sm-3">
									<a  @if ($accion == 1) {{'disabled'}} @endif href="../documentos/matriz_comunicacion/{{$archivo}}" download="{{$doc}}"><button type="button" class="btn btn-default"  @if ($accion == 1) {{'disabled'}} @endif>Descargar</button> </a>
									</div>

									</div>
									
									<div class="col-xs-12 col-sm-6"></div>

									<div class="col-xs-12 col-sm-3">
									<button type="button" class="btn btn-default" onclick="guadarMatrizComu();">Guardar</button> 
									</div>

								</div>


							</form>

								</div>
			


							 </div>
									  


								
							
						</div>
							<!-- //tables -->
					
							<!-- /social_media-->
						
						<!-- //social_media-->
				    </div>
					<!-- //inner_content_w3_agile_info-->
				</div>
@include("footer")
	</body>
	</html>