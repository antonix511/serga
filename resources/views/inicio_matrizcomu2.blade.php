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
								<h3 class="w3_inner_tittle two"><a href="/resumen_proyecto/{{$id}}">Proyecto CL-2016-MA-0001</a></h3>
									  


								<div class="col-sm-12">

								<div class="col-sm-12" style="border: solid 1px #d6d6d6;padding: 10px;">
								<ul class="nav nav-pills">
								  <li class="active"><a href="#">Inicio y Planificación</a></li>
								  <li><a href="/ejecucion_resumen/{{$id}}">Ejecución</a></li>
								  <li><a href="/cierre_resumen/{{$id}}">Cierre</a></li>
								
								</ul>
								</div>
								<div class="col-sm-12"><br></div>


								
								<div class="col-sm-3" style="border: solid 1px #d6d6d6;padding: 10px;">
								

									<ul class="nav nav-pills nav-stacked">
									  <li ><a href="/inicio_resumen/{{$id}}">Resumen</a></li>
									  <li><a href="/inicio_actainicio/{{$id}}">Acta de Inicio</a></li>
									  <li class="active"><a href="#">Matriz de Comunicación</a></li>
									  <li><a href="/inicio_matrizrol/{{$id}}">Matriz de Roles</a></li>
									  <li><a href="/inicio_reqlogisti/{{$id}}">Req. Logistica</a></li>
									  <li><a href="/inicio_reqcartog/{{$id}}">Req. Cartografía</a></li>
									</ul>
						

							
								</div>

								<form id="formmatrizcomu">
									{!! csrf_field() !!}
								<div class="col-sm-9" >
									<input type="hidden" name="idmatriz" id="idmatriz" value="{{$idmatrizcomu}}">		
									<input type="hidden"  id="idproyecto" name="idproyecto" value="{{$id}}">
									<input type="hidden"  id="accion" name="accion" value="{{$accion}}">
									<br>
									<h4 style="text-align: center;">Matriz de comunicaciones</h4>
									<br><br>
									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Nombre del proyecto</label>
									<div class="col-sm-9">
										<input type="text" class="form-control1" disabled="" value="{{$nom}}">
									</div>
									</div>

									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Nombre clave del proyecto</label>
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
									<label class="col-sm-3 control-label">Interesado</label>
									<div class="col-sm-9">
										<select name="interesado" id="interesado" class="form-control1" required>
										<option value="0">-Seleccione un trabajador-</option>
										@foreach ($traba as $traba)
										<option value="{{$traba->idpersona}}">{{$traba->nombre.' '.$traba->trabajador->apellidos}}</option>
										@endforeach
										</select>
									</div>
									</div>
									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Cargo</label>
						
										<div id="cargarpuesto">
										<div class="col-sm-9"><select name="puesto" id="puesto" class="form-control1" disabled>
											<option>-Seleccione un trabajador-</option>
										</select>
										</div>
										</div>	
								
									</div>
									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Responsable a Distribuir la información</label>
									<div class="col-sm-9">
										<select name="responsable" id="responsable" class="form-control1" required>
										<option value="0">-Seleccione un responsable-</option>
										@foreach ($traba2 as $t)
										<option value="{{$t->idpersona}}">{{$t->nombre.' '.$t->trabajador->apellidos}}</option>
										@endforeach
										</select>
									</div>
									</div>
									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Información a comunicar</label>
									<div class="col-sm-9">
										<input type="text" class="form-control1" id="informacion" name="informacion" placeholder="">
									</div>
									</div>
									<div class="col-sm-12">
				
									<label class="col-sm-3 control-label">Importancia de la comunicación</label>
					
										<div class="col-sm-9">
											<select name="importancia" id="importancia" class="form-control1">
											<option value="1">ALTA</option>
											<option value="2">MEDIA</option>
											<option value="3">BAJA</option>
						
										</select>
									</div>
									</div>
									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Frecuencia de la comunicación</label>
									<div class="col-sm-9">
										<input type="text" class="form-control1" id="frecuencia" name="frecuencia" placeholder="">
									</div>
									</div>
									<div class="col-sm-12">
									<label class="col-sm-3 control-label">Medio de comunicación a utilizar</label>
									<div class="col-sm-9">
										<input type="text" class="form-control1" id="medio" name="medio"  placeholder="">
									</div>
									</div>

									<div class="col-xs-12 col-sm-9"></div>

									<div class="col-xs-12 col-sm-3">
									<button type="button" class="btn btn-default" onclick="agregarmatrizcomu();" >Agregar</button> 
									</div>
									<div class="col-sm-12">

									<br><br></div>


									<div class="col-sm-12">
									<div id="resultadomatriztabla">
									<table id="myTable" class="table table-striped table-bordered">
										<thead>
										  <tr>
											<th>Nº</th>
											<th>Interesado</th>
											<th>Cargo</th>
											<th>Responsable de distribuir la información</th>
											<th>Información a comunicar</th>
											<th>Importancia de la comunicación</th>
											<th>Frecuencia de la comunicación</th>
											<th>Medio de comunicación a utilizar</th>
											<th></th>
											<th></th>
										  </tr>
										</thead>
										<tbody>
										  @if (count($lista)==0) 
											@elseif(count($lista)!=0) 

											<?php $i=1;?>
										 	@foreach ($lista as $eq)	
												<tr>
													<td><?php echo $i;?></td>
													<td>{{$eq->int_nom.' '.$eq->int_ape}}</td>
													<td>{{$eq->puesto}}</td>
													<td>{{$eq->resp_nom.' '.$eq->resp_ape}}</td>
													<td>{{$eq->informacion}}</td>
													<td>{{$eq->importancia}}</td>
													<td>{{$eq->frecuencia}}</td>
													<td>{{$eq->medio}}</td>

													<td> <a class="fa fa-search" href="#"></a></td>
													<td> <a class="fa fa-trash" href="#"></a></td>


											</tr>
											<?php $i++;?>
											@endforeach

											@endif
														  
										</tbody>
									  </table>

									</div>

									</div>

									<div class="col-xs-12 col-sm-3">
									<button type="button" class="btn btn-default" >Cancelar</button> 
									</div>
									
									<div class="col-xs-12 col-sm-6"></div>

									<div class="col-xs-12 col-sm-3">
									<button type="button" class="btn btn-default" onclick="guardarMatrizcomu();" >Guardar</button> 
									</div>
									<div id="resultadoguardarmatrizcomu">
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
		<!-- //inner_content-->
	<!--copy rights start here-->
@include("footer")

	</body>
	</html>