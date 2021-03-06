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
									   <h3 class="w3_inner_tittle two">Firmas</h3>


									 <div id="firmascentrocostos">


									  <table id="myTable" class="table table-striped table-bordered">
										<thead>
										  <tr>
											<th>Nº</th>
											<th>Proyecto</th>
											<th>Documento</th>
											<th>Aprobar</th>
											<th>Desaprobar</th>
										  </tr>
										</thead>
										<tbody>
											<?php $i=1;?>
											@if(!empty($firmas))
											@foreach($firmas as $fila)
										  <tr>
											<td><?php echo $i;?></td>
											{{-- <td>{{$fila->proyecto_firma->nombre}}</td> --}}
											<td>{{isset($fila->proyecto_firma->nombre) ? $fila->proyecto_firma->nombre : ''}}</td>
											<td>
												<div class="row">
													<div class="col-md-7">
														{{$fila->documento_firma->nombre}}
													</div>
													<div class="col-md-5">
														@if($fila->idproyecto != 0)
															<a href="/firmas_actainicio/{{$fila->idproyecto}}">
															<button type="button" class="btn">
																Ver
															</button>
															</a>
														@endif
													</div>
												</div>
											</td>
											<td>
												@if (in_array($fila->idestadofirma, array(2,4)))
													<button id="btncronograma" type="button" class="btn btn-default"
													onclick="AprobarFirma({{$fila->idfirma}})">
													Aprobar
												</button>
												@endif
											</td>
											<td>
												@if (in_array($fila->idestadofirma, array(2,4)))
													<button id="btncronograma" type="button" class="btn btn-default"
													onclick="DesaprobarFirma({{$fila->idfirma}})">
													Desaprobar
												</button>
												@endif
											</td>


										  </tr>
										  <?php $i++;?>
										  @endforeach
										  @endif


										  @if(!empty($firmasreu))
											@foreach($firmasreu as $filar)
										  <tr>
											<td><?php echo $i;?></td>
											<td>{{$filar->area}}</td>
											<td>Acta Reunion
											<a href="/firmas_actareunion/{{$filar->idacta}}"><button type="button" class="btn">Ver
												</button></a></td>
											<td>
												<button id="btncronograma" type="button" class="btn btn-default"
												onclick="AprobarFirma({{$filar->idfirma}})">
												Aprobar
												</button>

											</td>
											<td>
												<button id="btncronograma" type="button" class="btn btn-default"
												onclick="DesaprobarFirma({{$filar->idfirma}})">
												Desaprobar
												</button>
											</td>


										  </tr>
										  <?php $i++;?>
										  @endforeach
										  @endif


										  @if(!empty($firmascom))
										  @foreach($firmascom as $filac)
										  <tr>
											<td><?php echo $i;?></td>
											<td>{{$filac->area}}</td>
											<td>Acta Comite de Gerentes <a href="/firmas_actacomite/{{$filac->idcomite}}"><button type="button" class="btn">Ver
												</button></a> </td>
											<td>
												<button id="btncronograma" type="button" class="btn btn-default"
												onclick="AprobarFirma_comite({{$filac->idfirma}})">
												Aprobar
												</button>

											</td>
											<td>
												<button id="btncronograma" type="button" class="btn btn-default"
												onclick="DesaprobarFirma_comite({{$filac->idfirma}})">
												Desaprobar
												</button>
											</td>


										  </tr>
										  <?php $i++;?>
										  @endforeach
										  @endif
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
