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
					{!! csrf_field() !!}

									  <div class="w3l-table-info agile_info_shadow">
									   <h3 class="w3_inner_tittle two">Lista Centro de Costos</h3>
									  
									<label class="col-sm-2 control-label">Filtrar por fase:</label>
									
									<div class="col-sm-2">
										<select name="fase" id="fase" class="form-control1" onchange="listarProyectos();">
											<option value="0">-Seleccione una etapa-</option>
											<option value="1">Inicio y Planificación</option>
											<option value="2">Ejecución</option>
											<option value="3">Cierre</option>
										</select>
									</div>

									<label class="col-sm-1 control-label">Fechas:</label>
									<div class="col-sm-2">
									<?php $año=date('Y')." ";
									$fecha_ini='01-01-'.$año;
									$date=date_create($fecha_ini);
                  					$freu8=$date->format('Y-m-d');
									?>

										<input type="date" class="form-control1" id="fechainicio" onchange="listarProyectos();" value="<?php echo $freu8; ?>">
									</div>
									<div class="col-sm-2">
										<input type="date" class="form-control1" id="fechafin" onchange="listarProyectos();" value="<?php echo date ('Y-m-d',strtotime('+10 day',strtotime (date("Y-m-d")) ) ); ?>">
									</div> 





									 <div id="listaproyectos">
									  

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
											<?php 
											$date=date_create($pro->proyecto->fecha);
                  							$freu=$date->format('d-m-Y');
											?>
											<td>{{$freu}}</td>
											<td>{{$pro->fase->nombre}}</td>
											<td>
												<button id="btncronograma" type="button" class="btn btn-default" data-toggle="modal" data-target="#cronograma" 
												onclick="centrocostos({{$pro->proyecto->idproyecto}})">
												Ver
												</button>

											</td>

										  </tr>
										  <?php $i++;?>
										  @endforeach

										</tbody>
									  </table>
									
									

									  </div>


		<div class="modal fade" id="cronograma" tabindex="-1" role="dialog" aria-labelledby="cronograma">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Centro de costos</h4>
					</div>
					<div class="modal-body">

					<div id="notificar">





					<div class="col-sm-12">
                        <label class="col-sm-3 control-label">Nº Centro Costos</label>

                        <div class="col-sm-9">
                          <input type="text" class="form-control1" name="centrodecosto" id="centrodecosto" >
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <label class="col-sm-3 control-label">Nombre Clave del Proyecto</label>

                        <div class="col-sm-9">
                          <input type="text" class="form-control1" name="nombreclave"  disabled>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="col-sm-3 control-label">Observaciones</label>
                        <div class="col-sm-9">
                          <textarea  name="observacion" id="observacion" cols="0" rows="10" class="form-control1" value=""></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12">
                    <div class="col-xs-12 col-sm-9"></div>
                    <div class="col-xs-12 col-sm-3">
                        <button type="button" class="btn btn-default" Guardar</button> 
                    </div>
                    
                    <br>
                    <br>
                    </div>
                    <div class="col-sm-12">
                        <label class="col-sm-3 control-label">Notificar a:</label>
                        <div class="col-sm-9">
                          <select id="trabajadorcostos" class="form-control1" required >
                                <option value="">-Seleccione un trabajador-</option>
                                
                        </select>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="col-sm-3 control-label">Correo</label>
                        <div id="correo">
                        <div class="col-sm-9">
                          <input type="text" class="form-control1" id="correo" name="correo"  value="" disabled>
                        </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                    <div class="col-xs-12 col-sm-9"></div>
                    <div class="col-xs-12 col-sm-3">
                        <button type="button" class="btn btn-default"   >Agregar</button> 
                    </div>
                    
                    <br>
                    <br>
                </div>
                <div class="col-sm-12">



            
                        <table class="table" id="TablaNotificadoCosto">

                        <thead>
                                            <tr>
                                                <th>Nº</th>
                                                <th>Nombre</th>
                                                <th>Correo</th>                        
                                            </tr>
                                        </thead>

                            
                                        <tbody>
                                            <tr>
                                                <td> </td>
                                                <td> </td>
                                                <td> </td>

                                            </tr>

                                        </tbody>

                        </table>

                        </div>
                <div class="col-sm-12">
                    <div class="col-xs-12 col-sm-9"></div>
                    <div class="col-xs-12 col-sm-3">
                        <button type="button" class="btn btn-default">Notificar</button> 
                    </div>
                    <br>
                </div>






					</div>

					</div>
					<div class="modal-footer">
					</div>
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

@include("footer")



</body>
</html>