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
				<h2 class="w3_inner_tittle">Gestión de Privilegios</h2>

				<!--/forms-->
				<div class="forms-main_agileits">

					<div class="graph-form agile_info_shadow" style="overflow: auto;">

						<div class="form-body">
							<form id="formPrivilegio" action="" method="post">
							
									{!! csrf_field() !!}

									<input type="hidden" name="opcion" id="opcion" value="1">
									<input type="hidden" name="id" id="name" value="">
									<input type="hidden" name="idprivilegio" id="idprivilegio" value="">
							
									<label class="col-sm-3 control-label">Nombre</label>
									<div class="col-sm-9">
										<input  type="text" class="form-control1" name="nombre" id="nombre" placeholder="Ingrese el nombre del servicio" required>
									</div>
									@foreach($modulos as $row)

									<input type="checkbox" value=1 name="p{{$row->idmodulo}}" id="p{{$row->idmodulo}}" class="col-sm-2">
									<label class="col-sm-4" for="p{{$row->idmodulo}}">{{$row->nombre}}</label>

									@endforeach

									<div class="col-sm-12"><br>
									<br>
									</div>
									<div class="text">
										<div class="col-xs-12 col-sm-9">
										<div class="col-xs-12 col-sm-4">
											<button type="reset" class="btn btn-default" onclick="LimpiarPrivilegios()" >Limpiar</button>
										</div>
										</div> 
										<div class="col-xs-12 col-sm-3">
											<button type="button" class="btn btn-default" onclick="GuardarPrivilegio()">Guardar</button> 
										</div> 
										<div>
											<pstyle="visibility: hidden;">&nbsp;</p>
										</div>

									<div id="TablaPrivilegios">
										<table id="TablitaPrivilegios" class="table table-striped table-bordered">
										<thead>
											<tr>
												<th>Item</th>
												<th>Nombre</th>
												<th>Consultar</th>
												<th>Eliminar</th>
											</tr>
											</thead>
											@if(!empty($privilegios))
											<?php $i=1; ?>
											<tbody>
											@foreach($privilegios as $fila)
											<tr>
												<td><?=$i?></td>
												<td>{{$fila->nombre}}</td>
												<td>
												<div class="opciones"><a class="fa fa-pencil-square-o" onclick="TraerPrivilegio({{$fila->idprivilegio}})" ></a></div>
												</td>
												<td>
													<div class="opciones"><a class="fa fa-trash" onclick="EliminarPrivilegio({{$fila->idprivilegio}})"></a></div>
												</td>
											</tr>
											<?php $i++; ?>
											@endforeach
											</tbody>
											@endif
										</table>
									</div>

									</div>	

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