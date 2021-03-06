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
				<h2 class="w3_inner_tittle">Gestión de Modelos</h2>

				<!--/forms-->
				<div class="forms-main_agileits">

					<div class="graph-form agile_info_shadow" style="overflow: auto;">

						<div class="form-body">
							<form id="formmodelo" action=" method="post" enctype="multipart/form-data">

									{!! csrf_field() !!}

									<input type="hidden" name="opcion" value="1">
									<input type="hidden" name="id" value="">

									<label class="col-sm-3 control-label">Codigo</label>
									<div class="col-sm-9">
										<input  type="text" class="form-control1" name="codigo" id="codigo" placeholder="Ingrese un codigo" maxlength = "11" minlength = "11" required>
									</div>

									<label class="col-sm-3 control-label">Tipo :</label>
									<div class="col-sm-9">
									<select class="form-control1" id="idtipo_modelo" name="idtipo_modelo" onchange="SeleccionModeloxTipo()">
											@foreach($TipoModelo as $row)
												<option value="{{$row->idtipo_modelo}}">{{$row->nombre}}</option>
											@endforeach
											</select>
									</div>
									<label class="col-sm-3 control-label">Archivo</label>
									<div class="col-sm-9">
									<input type="file" class="form-control1"  id="file" name="file">
									</div>


									<div class="col-sm-12"><br>
									<br>
									</div>
									<div class="text">
										<div class="col-xs-12 col-sm-9">
										<div class="col-xs-12 col-sm-4">
										<button type="reset" class="btn btn-default" onclick="">Limpiar</button>
										</div>
										</div>
										<div class="col-xs-12 col-sm-3">

										<button type="button" class="btn btn-default" onclick="insertarModelo()">Guardar</button>
										</div>
										<div>
										<pstyle="visibility: hidden;">&nbsp;</p>
										</div>

									<div id="resultado"></div>

									</div>

								</form>
								<div id="divModelos">
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
