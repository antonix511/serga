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
									   <h3 class="w3_inner_tittle two">Lista Proyectos</h3>
									   {!! csrf_field() !!}

									 <div id="lista_proyectos">
									  

									  <table id="myTable" class="table table-striped table-bordered">
										<thead>
										  <tr>
											<th>Nº</th>
											<th>Código</th>
											<th>Nombre del Proyecto</th>
											<th>Fecha</th>
											<th>Editar</th>
											<th>Eliminar</th>
										  </tr>
										</thead>
										<tbody>
											<?php $i=count($proyectos);?>
										@foreach ($proyectos as $pro)		

										  <tr>
											<td><?php echo $i;?></td>
											<td>{{$pro->code}}</td>
											<td>{{$pro->nombre}}</td>
											<?php  
                                            $date=date_create($pro->fecha);
                                            $freu=$date->format('d-m-Y');
                                            ?>
											<td>{{$freu}}</td>
											<td><a href="proyecto/editar/{{$pro->idproyecto}}"><button class="course-submit" type="button">Editar</button></a></td>
											<td><button class="course-submit" onclick="EliminarProyecto({{$pro->idproyecto}})" type="button">ELIMINAR</button></td>
										  </tr>
										  <?php $i--;?>
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