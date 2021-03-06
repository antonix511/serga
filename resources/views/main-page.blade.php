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
					<div class="inner_content_w3_agile_info">
					<!-- /agile_top_w3_grids-->
					   <div class="agile_top_w3_grids">
					          <ul class="ca-menu">
									<li>
										<a href="/proyectos">

											<i class="fa fa-building-o" aria-hidden="true"></i>
											<div class="ca-content">
												<h4 class="ca-main">Nuevo Proyecto</h4>
												<h3 class="ca-sub"></h3>
											</div>


										</a>
									</li>
									<li>
										<a href="/seguimiento">
										  <i class="fa fa-user" aria-hidden="true"></i>
											<div class="ca-content">
												<h4 class="ca-main one">Proyectos</h4>
												<h3 class="ca-sub one"></h3>
											</div>
										</a>
									</li>
									<li>
										<a href="/pdf/total" target="_blank">
											<i class="fa fa-database" aria-hidden="true"></i>
											<div class="ca-content">
											<h4 class="ca-main two">Reportes</h4>
												<h3 class="ca-sub two"></h3>
											</div>
										</a>
									</li>
									<li>
										<a href="/busqueda">
											<i class="fa fa-tasks" aria-hidden="true"></i>
											<div class="ca-content">
												<h4 class="ca-main one">Búsqueda</h4>
												<h3 class="ca-sub three"></h3>
											</div>
										</a>
									</li>
									<li id="btnequipo" data-toggle="modal" data-target="#equipo">
										<a href="#">
											<i class="fa fa-clone" aria-hidden="true"></i>
											<div class="ca-content">
												<h4 class="ca-main four">Acta de Comité de Gerentes- Acta de Reunión</h4>
												<h3 class="ca-sub four"></h3>
											</div>
										</a>
									</li>
									<li>
										<a href="/code">
										  <i class="glyphicon glyphicon-list-alt" aria-hidden="true"></i>
											<div class="ca-content">
												<h4 class="ca-main one">CODE</h4>
												<h3 class="ca-sub one"></h3>
											</div>
										</a>
									</li>
								  	<li>
										<a href="/seguimiento-proyectos">
											<i class="glyphicon glyphicon-zoom-in" aria-hidden="true"></i>
											<div class="ca-content">
												<h4 class="ca-main four">Seguimiento de Proyectos</h4>
												<h3 class="ca-sub four"></h3>
											</div>
										</a>
									</li>
									<div class="clearfix"></div>
								</ul>
					   </div>

					   <!-- Modal -->
		<div class="modal fade" id="equipo" tabindex="-1" role="dialog" aria-labelledby="equipo">
			<div class="modal-dialog" role="document" style="width: 30%;">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" >
							<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Escoger Acta</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="col-sm-6">
									<a href="/comit/gerentes"><button class="btn btn-primary">Comite Gerentes</button></a>
								</div>

								<div class="col-sm-6">
									<a href="/acta/gerentes"><button class="btn btn-warning">Acta Reunión</button></a>
								</div>


							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>
					 <!-- //agile_top_w3_grids-->
						<!-- /agile_top_w3_post_sections   -->


						<!-- //agile_top_w3_post_sections-->
							<!-- /w3ls_agile_circle_progress-->

						<!-- /w3ls_agile_circle_progress-->
						<!-- /chart_agile-->

						  <!-- /w3ls_agile_circle_progress-->

						<!-- /w3ls_agile_circle_progress-->
						 <!--/prograc-blocks_agileits-->


							  <!--//prograc-blocks_agileits-->
						<!-- /bottom_agileits_grids-->

						<!-- //bottom_agileits_grids-->
												<!-- /weather_w3_agile_info-->

						<!-- //weather_w3_agile_info-->
						<!-- /social_media-->
						  <div class="social_media_w3ls">




							  <div class="clearfix"></div>

						</div>
						<!-- //social_media-->
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
