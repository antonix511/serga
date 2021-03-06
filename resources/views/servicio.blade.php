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



			<div class="inner_content_w3_agile_info two_in">
				<h2 class="w3_inner_tittle">Gestión de Servicios</h2>

				<!--/forms-->
				<div class="forms-main_agileits">

					<div class="graph-form agile_info_shadow" style="overflow: auto;">

						<div class="form-body">
							<form id="formservicio" action="/servicio/controller" method="post">
							
									{!! csrf_field() !!}

									<input type="hidden" name="opcion" value="1">
									<input type="hidden" name="id" value="">
							
									<label class="col-sm-3 control-label">Nombre</label>
									<div class="col-sm-9">
										<input  type="text" class="form-control1" name="nombre" placeholder="Ingrese el nombre del servicio" required >
									</div>

									<label class="col-sm-3 control-label">Abreviatura</label>
									<div class="col-sm-9">
										<input  type="text" class="form-control1" name="abreviatura" placeholder="Ingrese abreviatura del servicio" required maxlength = "5"  >
									</div>


									<div class="col-sm-12"><br>
									<br>
									</div>
									<div class="text">
										<div class="col-xs-12 col-sm-9">
										<div class="col-xs-12 col-sm-4">
										<button type="reset" class="btn btn-default" onclick="limpiar_Campos_servicio()">Limpiar</button>
										</div>
										</div> 
										<div class="col-xs-12 col-sm-3">
										<button type="submit" class="btn btn-default">Guardar</button> 
										</div> 
										<div>
										<pstyle="visibility: hidden;">&nbsp;</p>
										</div>

									<div id="resultado"></div>

									</div>	


		
						<table id="tableservicios" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>Nº</th>		
									<th>Nombre</th>
									<th>Abreviatura</th>		
									<th>Opciones</th>
								</tr>
							</thead>
							<tbody>

						

							<?php $i=1;?>
						
								@foreach ($servicios as $servicio)
								<tr>
									<td>{{$i}}</td>
									<td>{{$servicio->nombre}}</td>
									<td>{{$servicio->abreviatura}}</td>
									<td>

									<div class="opciones">
									<a class="fa fa-pencil-square-o" onclick="traer_Datos_servicio('{{$servicio->idservicio}}')" ></a>
									</div>

									<div class="opciones">
									<a class="fa fa-trash" onclick="eliminar_Datos_servicio('{{$servicio->idservicio}}')"></a>
									</div>

									</td>
							</tr>
							<?php	$i++; ?>
							@endforeach
				

							</tbody>
						</table>
					



								
						</form> 




					</div>

				</div>
			</div> 
		</div>
		<!-- //inner_content_w3_agile_info-->
	</div>
	<!-- //inner_content-->
</div>
@include("footer")


</body>
</html>