<!--
author: W3layouts
author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html lang="zxx">
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
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
									   <h3 class="w3_inner_tittle two">Seguimiento de Proyectos</h3>
									  
									<label class="col-sm-2 control-label">Filtrar por fase:</label>
									
									<div class="col-sm-2">
										<select name="fase" id="fase" class="form-control1" onchange="listarProyectos2();">
											<option value="0">-Seleccione una etapa-</option>
											<option value="1">Inicio y Planificación</option>
											<option value="2">Ejecución</option>
											<option value="3">Cierre</option>
										</select>
									</div>

									<label class="col-sm-1 control-label">Fechas:</label>
									<div class="col-sm-2">
										<input type="date" class="form-control1" id="fechainicio" onchange="listarProyectos2();" value="<?php /*echo date ('Y-m-d',strtotime('-10 day',strtotime (date("Y-m-d")) ) );*/ ?>">
									</div>
									<div class="col-sm-2">
										<input type="date" class="form-control1" id="fechafin" onchange="listarProyectos2();" value="<?php /*echo date ('Y-m-d',strtotime('+10 day',strtotime (date("Y-m-d")) ) );*/ ?>">
									</div> 





									 <div id="listaproyectos">
									  

									  <table id="myTable" class="table table-striped table-bordered">
										<thead>
										  <tr>
											<th>Nº</th>
											<th class="col-md-2">Codigo</th>
											<th>Cliente</th>
											<th>Nombre del Proyecto</th>
											<th class="col-xs-1">Tipo de Proyecto</th>
											<th class="col-xs-1">Centro de costos</th>
											<th class="col-md-1">Fecha</th>
											<th>Fase actual del proyecto</th>
											<th>Consultar</th>
										  </tr>
										</thead>
										<tbody>
											

										</tbody>
									  </table>
									
									

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
<script type="text/javascript">
	$(function(){
		listarProyectos2();
	});
</script>


</body>
</html>