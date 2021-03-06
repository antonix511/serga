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

					<form method="post" id="formInfo">




					<div class="inner_content_w3_agile_info two_in">


						<div class="w3l-table-info agile_info_shadow">
								<h3 class="w3_inner_tittle two"><a href="/resumen_proyecto/{{$id}}">{{$nombreclave}}</a></h3>



								<div class="col-sm-12">

								<div class="col-sm-12" style="border: solid 1px #d6d6d6;padding: 10px;">
								<ul class="nav nav-pills">
								<li class="active"><a href="/inicio_ventas/{{$id}}">Ventas</a></li>
								  <?php  if($_SESSION['inicio']>0){ ?>
								  <li><a href="/inicio_resumen/{{$id}}">Inicio y Planificación</a></li>
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
									  <li class="active"><a href="#">Información del proyecto</a></li>

									</ul>



								</div>


								<div class="col-sm-9" >

							<div class="forms-main_agileits">

							<div class="graph-form agile_info_shadow">
								<div class="form-body">
											{!! csrf_field() !!}

											<div class="col-sm-12">
											<label class="col-sm-3 control-label">CODE</label>
											<div class="col-sm-4">
												<input  readonly type="text" class="form-control1" id="code" name="code" value="{{$proyecto->code}}" >
											</div>


											<label class="col-sm-2 control-label">Fecha</label>
											<div class="col-sm-2">
												<input type="date"  disabled="" class="form-control1" name="fecha" value="{{$proyecto->fecha}}">

											</div>
											</div>

											<div class="col-sm-12">

											<label class="col-sm-3 control-label">Nombre Clave del Proyecto</label>


											<div class="col-sx-2 col-sm-9">
												<input  id="abreviatura_campo" readonly type="text" class="form-control1" name="c1" value="{{$proyecto->nombreclave}}">
											</div>


											</div>
											<div class="col-sm-12">
											<label class="col-sm-3 control-label">Cliente</label>

												<div class="col-sm-9">
												<select name="idcliente" id="icliente" class="form-control1" required>

													@foreach ($clientes as $cliente)
													@if($proyecto->idcliente==$cliente->idpersona)
														<option value="{{$cliente->idpersona}}" selected="">
													@else
														<option value="{{$cliente->idpersona}}">
													@endif
														{{$cliente->nombre}}</option>
													@endforeach

												</select>
											</div>
											</div>

											<div class="col-sm-12">
											<label class="col-sm-3 control-label">Contacto con el cliente(Facturación)</label>
											<div id="contacto">
											<div class="col-sm-9">
												<input  @if($editar==0) disabled="" @endif type="text" class="form-control1" name="contacto" value="{{$proyecto->contacto}}">
											</div>
											</div>

											</div>

											<div class="col-sm-12">
											<label class="col-sm-3 control-label">Nombre del Proyecto</label>
											<div class="col-sm-9">
												<input type="text" @if($editar==0) disabled="" @endif class="form-control1" name="nombre" value="{{$proyecto->nombre}}" required>
											</div>
											</div>

											<div class="col-sm-12">
											<label class="col-sm-3 control-label">Servicio</label>

												<div class="col-sm-9">
													<select name="idservicio" id="idservicio" class="form-control1" required>
													@foreach ($servicios as $servicio)
														@if($proyecto->idservicio==$servicio->idservicio)
														<option value="{{$servicio->idservicio}}" selected="">
														@else
														<option value="{{$servicio->idservicio}}" >
														@endif
														{{$servicio->nombre}}</option>
													@endforeach

													</select>
											</div>
											</div>

											<div class="col-sm-12">
											<label class="col-sm-3 control-label">Descripción</label>
											<div class="col-sm-9">
												<textarea name="descripcion" cols="0" rows="10" class="form-control1">{{$proyecto->descripcion}}</textarea>
												</div>
											</div>

											<div class="col-sm-12">
											<label class="col-sm-3 control-label">Ubicación</label>

												<div class="col-sm-3">
													<select name="iddepartamento" id="iddepartamento" class="form-control1" required>
													@foreach($departamento as $fila)

													@if($fila->iddepartamento == $proyecto->iddepartamento)
														<option  value="{{$fila->iddepartamento}}" selected="">{{$fila->nombre}}</option>
													@else
														<option  value="{{$fila->iddepartamento}}">{{$fila->nombre}}</option>
													@endif

													@endforeach
													</select>


												</div>
												<div class="col-sm-3" id="provincia">

													<select name="idprovincia" id="idprovincia" class="form-control1" required>

													@foreach($provincia as $fila)

													@if($fila->idprovincia == $proyecto->idprovincia)
														<option  value="{{$proyecto->idprovincia}}" selected="">{{$proyecto->provincia->nombre}}</option>
													@else
														<option  value="{{$fila->idprovincia}}">{{$fila->nombre}}</option>
													@endif

													@endforeach

													</select>


												</div>

												<div class="col-sm-3" id="distrito">
													<select name="iddistrito" class="form-control1" required>

													@foreach($distrito as $fila)

													@if($fila->iddistrito == $proyecto->iddistrito)
														<option  value="{{$proyecto->iddistrito}}" selected="">{{$proyecto->provincia->nombre}}</option>
													@else
														<option  value="{{$fila->iddistrito}}">{{$fila->nombre}}</option>
													@endif

													@endforeach

													</select>


												</div>

											</div>

											<div class="col-sm-12">
											<label class="col-sm-3 control-label">Gerente</label>

												<div class="col-sm-9">
													<select name="gerente" class="form-control1" required>
													@foreach ($gerente as $gerente)
													@if($proyecto->gerente==$gerente->idpersona)
													<option value="{{$gerente->idpersona}}" selected=""> {{$gerente->nombre.' '.$gerente->trabajador->apellidos}}</option>
													@else
													<option value="{{$gerente->idpersona}}"> {{$gerente->nombre.' '.$gerente->trabajador->apellidos}}</option>
													@endif

													@endforeach


												</select>
											</div>
											</div>

											<div class="col-sm-12">
											<label class="col-sm-3 control-label">Jefe de Proyecto</label>

												<div class="col-sm-9">
													<select name="jefe" class="form-control1" required>
													@foreach ($jefes as $jefe)
													@if($proyecto->jefe==$jefe->idpersona)
													<option value="{{$jefe->idpersona}}" selected=""> {{$jefe->nombre.' '.$jefe->trabajador->apellidos}}</option>
													@else
													<option value="{{$jefe->idpersona}}"> {{$jefe->nombre.' '.$jefe->trabajador->apellidos}}</option>
													@endif

													@endforeach

												</select>
											</div>
											</div>

											@if (in_array(Auth::user()->usuario, array('svera', 'jaleon', 'yvera', 'admin')))
												<div class="col-sm-12">
													<label class="col-sm-3 control-label">Presupuesto</label>
													<div class="col-sm-6">
														<input type="text"
														@if($editar==0 || !in_array(Auth::user()->usuario, array('yvera', 'admin')))
																disabled=""
															@endif
															class="form-control1" name="presupuesto" value="{{$proyecto->presupuesto}}" required>
													</div>
													<div class="col-sm-3">
														<select name="idmoneda" class="form-control1" required
															@if($editar==0 || !in_array(Auth::user()->usuario, array('yvera', 'admin')))
																disabled=""
															@endif
														>
															@if($proyecto->idmoneda==1)
																<option value="1" selected="">Soles</option>
																<option value="" >Dolares</option>
															@else
																<option value="" selected="">Dolares</option>
																<option value="1" >Soles</option>
															@endif
														</select>
													</div>
												</div>
											@endif

											<div class="col-sm-12">
											<label class="col-sm-3 control-label">Tipo de Proyecto</label>

												<div class="col-sm-3">
													<select name="idtipoproyecto" id="idtipoproyecto"  class="form-control1" required>
													@foreach ($tipoproyecto as $tipoproyecto)
													@if($proyecto->idtipoproyecto==$tipoproyecto->idtipoproyecto)
													<option value="{{$tipoproyecto->idtipoproyecto}}" selected="">
													@else
													<option value="{{$tipoproyecto->idtipoproyecto}}">
													@endif
													{{$tipoproyecto->nombre}}</option>
													@endforeach


												</select>
											</div>

											<label class="col-sm-3 control-label">Tipo de Contrato</label>

												<div class="col-sm-3">
													<select name="idtipocontrato" class="form-control1" required>
													@foreach($tipo_con as $row)
													@if($row->nombre == $proyecto->retornar_tipContrato->nombre)
													<option value="{{$row->idtipocontrato}}" selected>{{$proyecto->retornar_tipContrato->nombre}}</option>
													@else
													<option value="{{$row->idtipocontrato}}">{{$row->nombre}}</option>
													@endif
													@endforeach

												</select>
											</div>
											</div>

											<div class="col-sm-12">
											<label class="col-sm-3 control-label">Fecha de aceptación de la propuesta</label>
											<?php
		                                            $date=date_create($proyecto->faceptacion);
		                                            $freu=$date->format('d-m-Y');
		                                            ?>
											<div class="col-sm-3">
												<input  type="date" class="form-control1" name="faceptacion" value="{{$proyecto->faceptacion}}" required>
											</div>

											</div>
											<?php
		                                            $date=date_create($proyecto->finicio);
		                                            $freu=$date->format('d-m-Y');
		                                            ?>
											<div class="col-sm-12">
											<label class="col-sm-3 control-label">Fecha de inicio del proyecto</label>
											<div class="col-sm-3">
												<input @if($editar==0) disabled="" @endif type="date" class="form-control1" name="finicio" value="{{date('Y-m-d', strtotime($freu))}}" required>
											</div>

											</div>
											<?php
		                                            $date=date_create($proyecto->fentrega);
		                                            $freu=$date->format('d-m-Y');
		                                            ?>
											<div class="col-sm-12">
											<label class="col-sm-3 control-label">Fecha de entrega del proyecto</label>
											<div class="col-sm-3">

												<input @if($editar==0) disabled="" @endif type="date" class="form-control1" name="fentrega" value="{{date('Y-m-d', strtotime($freu))}}" required>
												{{-- <input @if($editar==0) disabled="" @endif type="date" class="form-control1" name="fentrega" value="{{$freu}}" required> --}}
											</div>

											</div>

											<div class="col-sm-12">
											<br>
											<h4 class="w3_inner_tittle two" style="text-align: center;">Campo llenado solo para Adendas/Adicionales </h4>
											<br>
											</div>


												<div class="col-sm-12" style="border: solid 2px #e6e6e6;padding: 10px;padding-top: 30px;">

													<div class="col-sm-12">
											<label class="col-sm-3 control-label">Nº centro de costo:</label>
											<div class="col-sm-9">
												{{-- <input type="text" class="form-control1" name="centrodecosto"  placeholder="Ingrese el centro de costo" disabled="" value="{{$proyecto->centrodecosto}}" > --}}
												<input type="text" class="form-control1" name="centrodecosto"  placeholder="Ingrese el centro de costo" value="{{$proyecto->centrodecosto}}" maxlength="100">
											</div>

												</div>
												<div class="col-sm-12">
											<label class="col-sm-3 control-label">Presupuesto de venta Adicional</label>
											<div class="col-sm-9">
												{{-- <input type="text" class="form-control1" name="presupuestoadicional"  placeholder="Ingrese una presupuesto de venta adicional"  disabled=""  value="{{$proyecto->presupuestoadicional}}"> --}}
												<input type="text" class="form-control1" name="presupuestoadicional"  placeholder="Ingrese una presupuesto de venta adicional"  value="{{$proyecto->presupuestoadicional}}">
											</div>
											</div>



											<div class="col-sm-12">
											<label class="col-sm-3 control-label">Observaciones</label>
											<div class="col-sm-9">
												{{-- <textarea   name="observacion" cols="0" rows="10" class="form-control1" disabled="" >{{$proyecto->observacion}}</textarea> --}}
												<textarea   name="observacion" cols="0" rows="10" class="form-control1" maxlength="500" >{{$proyecto->observacion}}</textarea>
												</div>
											</div>
											</div>

											<div class="col-sm-12">
											<br>
											<h4 class="w3_inner_tittle two" >Personas Notificadas Centro de costos </h4>
											<br>
											</div>
											<div class="col-sm-12">
											<label class="col-sm-2 control-label">Nombre</label>

											<div class="col-sm-4">
													<select name="idtrabajador" id="idtrabajador" class="form-control1" required>
													<?php if(empty($proyecto->notificado1->nombre)) { ?>
													<option>--Seleccione --</option>
													<?php } ?>
													@foreach($trabajadores as $row)
													<?php if(!empty($proyecto->notificado1->nombre)) { ?>
													@if($row->idpersona==$proyecto->idtrabajador)
													<option value="{{$row->idpersona}}" selected="">{{$row->nombre.' '.$row->trabajador->apellidos}}</option>
													@else
													<option value="{{$row->idpersona}}">{{$row->nombre.' '.$row->trabajador->apellidos}}</option>
													@endif
													<?php }else{ ?>
													<option value="{{$row->idpersona}}">{{$row->nombre.' '.$row->trabajador->apellidos}}</option>
													<?php } ?>
													@endforeach


												</select>
											</div>


											<label class="col-sm-2 control-label">Nombre</label>

											<div class="col-sm-4">
													<select name="idtrabajador2" id="idtrabajador2" class="form-control1" required>
														<?php if(empty($proyecto->notificado2->nombre)) { ?>
													<option>--Seleccione --</option>
													<?php } ?>

													@foreach($trabajadores as $row)
													<?php if(!empty($proyecto->notificado2->nombre)) { ?>
													@if($row->idpersona==$proyecto->idtrabajador2)
													<option value="{{$row->idpersona}}" selected="">{{$row->nombre.' '.$row->trabajador->apellidos}}</option>
													@else
													<option value="{{$row->idpersona}}">{{$row->nombre.' '.$row->trabajador->apellidos}}</option>
													@endif
													<?php }else{ ?>

													<option value="{{$row->idpersona}}">{{$row->nombre.' '.$row->trabajador->apellidos}}</option>
													<?php } ?>
													@endforeach
												</select>
											</div>




											</div>
											<div class="col-sm-12">
											<label class="col-sm-2 control-label">Correo electrónico</label>
											<div class="col-sm-4">
												<input  id="correonotifica" disabled="" type="email" class="form-control1" name="correo" placeholder="Correo destino" required value="{{$proyecto->correo}}">
											</div>

											<label class="col-sm-2 control-label">Correo electrónico</label>
											<div class="col-sm-4">
											<?php if(!empty($proyecto->notificado2->nombre)) { ?>
												<input  id="correonotifica2" disabled="" type="email" class="form-control1" name="correo2" placeholder="Correo destino" required value="{{$proyecto->correo2}}">
												<?php } ?>
											</div>




											</div>


											<div class="col-sm-12"><br>
											<br>
											</div>
											<div class="col-xs-12 col-sm-12">
											<div class="col-xs-12 col-sm-3"></div>
											<div class="col-xs-12 col-sm-3">

											</div>
											@if($editar==0)

											@else
											<div class="col-xs-12 col-sm-3">
											<a href="/info/infoproyecto/{{$id}}">
											<button type="button" class="btn btn-default"  id="Exportar">Exportar</button>
											</a></div>

											<div class="col-xs-12 col-sm-3">
											<button type="button" class="btn btn-default" onclick="editarInfoProyecto({{$id}})"  id="Editar">Editar</button>
											</div>
											@endif
										</div>


											<div class="text">
												<div class="col-xs-12 col-sm-2">

												</div>
												<div class="col-xs-12 col-sm-6"></div>
												<div class="col-xs-12 col-sm-2">

												</div>
												<div class="col-xs-12 col-sm-2">

												</div>
												<div>
												<pstyle="visibility: hidden;">&nbsp;</p>
												</div>
												</div>
							</div>

						</div>
</div>




								</div>

</form>

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
