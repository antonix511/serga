<style type="text/css">
	ul.dropdown-menu{max-height: 500px;
		overflow-y: scroll;}
</style>
<?php $proyectos=$_SESSION['proyectos']; $foto=$_SESSION['foto']; ?>
<?php if (empty($foto)) {
	$foto="perfil-foto.jpg";
} ?>
@if(!empty($proyectos))
<?php $i=0; ?>
	@foreach($proyectos as $row)
		<?php $i++; ?>	
	@endforeach
@endif
<li class="second logo" style="text-align: left;"><h1><a href="/inicio"><i class="fa fa-graduation-cap" aria-hidden="true"></i>SERGA
<p style="margin-top: -15%;color: white;font-weight: bold;"><small>Seguimiento de Resultados y Gestion de Avance</small></p></a></h1>
</li>
			 <li class="second admin-pic">
				       <ul class="top_dp_agile">
									<li class="dropdown profile_details_drop">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
											<div class="profile_img">	
												<span class="prfil-img"><img style="width: 40px; height: 40px;"  src="/documentos/trabajador/<?=$foto?>"  alt=""> </span> 
											</div>	
										</a>
										<ul class="dropdown-menu drp-mnu">
									
											<li> <a href="{{Route('cerrarsesion')}}"><i class="fa fa-sign-out"></i> Salir</a> </li>
										</ul>
									</li>
									
						</ul>
			</li>

			
				<li class="second top_bell_nav">
				@if(!empty($proyectos))
				   <ul class="top_dp_agile ">
									<li class="dropdown head-dpdn">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-bell-o" aria-hidden="true"></i> <span class="badge blue"><?= $i; ?></span></a>
										<ul class="dropdown-menu">
											<li>
												<div class="notification_header">
													<h3>Tus Notificaciones</h3>
												</div>
											</li>
											
											
											

											@foreach($proyectos as $row)
											<li><a href="/resumen_proyecto/{{$row->idproyecto}}">
												<div class="user_img"><img width="70" height="150" src="/documentos/trabajador/perfil-foto.jpg" alt=""></div>
											   <div class="notification_desc">
											     <h6>{{$row->nombre}}</h6>
												<p>Faltan terminar los documentos</p>
												<p><span>fecha entrega 3 dias</span></p>
												</div>
											  <div class="clearfix"></div>	
											 </a></li>
											 @endforeach
											 

										</ul>
									</li>
									
						</ul>
						@endif
				</li>

				<li >
					
				</li>