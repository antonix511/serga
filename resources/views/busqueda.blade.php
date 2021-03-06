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
				   <h3 class="w3_inner_tittle two">Búsqueda de Proyectos</h3>

				  <div class="col-sm-12">
				  	<label class="col-sm-2 control-label">Buscar:</label>
				  	<div class="col-sm-2">
				  		<select id="busquedaCombo" class="form-control1" onchange="MetododeBusca()">
				  			<option value="1">Proyectos</option>
				  			<option value="2">Documentos</option>
				  		</select>
				  	</div>
				  </div>
				<div id="MetodoBusca">

				<label class="control-label col-sm-2">Cliente :</label>	

				<div class="col-sm-2">
						<select name="idcliente" id="idcliente" class="form-control1" required onchange="BusquedaProyectos()">
											<option value="0">-Seleccione un cliente-</option>
											@foreach ($cli as $cliente)
											<option value="{{$cliente->idpersona}}">{{$cliente->nombre}}</option>
											@endforeach
						
						</select>
				</div>
				<label class="control-label col-sm-2">Ubicacion :</label>	

				<div class="col-sm-2">
						<select name="iddepartamento" id="iddepartamento" class="form-control1" required onchange="BusquedaProyectos()">
											<option value="0">-Seleccione un Departamento-</option>
											@foreach ($depa as $depa)
											<option value="{{$depa->iddepartamento}}">{{$depa->nombre}}</option>
											@endforeach
										
						</select>
				</div>
				<div class="col-sm-2" id="provincia">
						<select name="idprovincia" id="idprovincia" class="form-control1" required>
							<option value="0">-Seleccione una Provincia-</option>

						</select>
				</div>
				<div class="col-sm-2" id="distrito">
						<select name="iddistrito" id="iddistrito" class="form-control1" required>
							<option value="0">-Seleccione un Distrito-</option>				
						</select>
				</div>

					<label class="col-sm-2 control-label">Filtrar por fase:</label>
					
					<div class="col-sm-2">
						<select name="fase" id="fase" class="form-control1" onchange="BusquedaProyectos()">
							<option value="0">-Seleccione una etapa-</option>
							<option value="1">Inicio y Planificación</option>
							<option value="2">Ejecución</option>
							<option value="3">Cierre</option>
						</select>
					</div>

					<label class="col-sm-1 control-label">Fechas:</label>
					<div class="col-sm-2">
						<input type="date" class="form-control1" id="fechainicio" onchange="BusquedaProyectos()">
					</div>
					<div class="col-sm-2">
						<input type="date" class="form-control1" id="fechafin"   onchange="BusquedaProyectos()" >
					</div>
				</div>

									 <div id="listaproyectos2">
									  

									  <table id="myTable" class="table table-striped table-bordered">
										<thead>
										  <tr>
											<th>Nº</th>
											<th>Código</th>
											<th>Nombre del Proyecto</th>
											<th>Fecha</th>
											<th>Fase actual del proyecto</th>
											<th>Consultar</th>
										  </tr>
										</thead>
										<tbody>
											<?php $i=1;?>
											@foreach ($proyectos as $pro)		

										  <tr>
											<td><?php echo $i;?></td>
											<td>{{$pro->proyecto->nombreclave}}</td>
											<td>{{$pro->proyecto->nombre}}</td>
											<td>{{$pro->proyecto->fecha}}</td>
											<td>{{$pro->fase->nombre}}</td>
											<td><button class="course-submit" onClick="" type="button"><a href="/proyectos">CONSULTAR</a></button></td>
										  </tr>
										  <?php $i++;?>
										  @endforeach

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



</body>
</html>