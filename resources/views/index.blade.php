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
<!-- custom-theme -->
@include("cabeza2")
</head>
<body>
<!-- banner -->
<div class="wthree_agile_admin_info">
		  <!-- /w3_agileits_top_nav-->
		  <!-- /nav-->
		  <div class="w3_agileits_top_nav">
			<ul id="gn-menu" class="gn-menu-main">

				
				
                <li class="second logo admin" style="text-align: left;"><h1><a href="#"><i class="fa fa-graduation-cap" aria-hidden="true"></i>SERGA
<p style="margin-top: -15%;color: white;font-weight: bold;"><small>Seguimiento de Resultados y Gestion de Avance</small></p></a></h1></li>
				

				
				<li >
					
				</li>

			</ul>
			<!-- //nav -->
			
		</div>
		<div class="clearfix"></div>
		<!-- //w3_agileits_top_nav-->
		
		<!-- /inner_content-->
				<div class="inner_content">

				
				    <!-- /inner_content_w3_agile_info-->
					<div class="inner_content_w3_agile_info">
				<div class="col-sm-3" style="text-align: center;"><br><br><br><br><br><img src="logo.png" style="width: 100%;"/></div>	
				 <div class="col-sm-3"  style="text-align: center;float: right;"> <br><br><br><br><br><img src="images/ISO_2015.png" style="width: 75%;"/></div>
				


							<div class="registration admin_agile">
								
												<div class="signin-form profile admin">
													<h2>Bienvenido al Sistema de Gestión de Proyectos</h2>
													<div class="login-form">
														<form action="/" method="post">
															{!! csrf_field() !!}

															<input type="text" name="usuario" placeholder="Usuario" required="">
															<input type="password" name="clave" placeholder="Clave" required="">
															<div class="tp">
																<input type="submit" value="Ingresar">
															</div>
															@if(isset($errorusuario))
															<label class="">{{$errorusuario}}</label>
															@endif
															@if(isset($errorcontraseña))
															<label class="">{{$errorcontraseña}}</label>
															@endif
															
														</form>
														<br>

														
													</div>
												

													 
												</div>

					

				    </div>

				   
					<!-- //inner_content_w3_agile_info-->
				</div>
		<!-- //inner_content-->
	</div>
<!-- banner -->
<!--copy rights start here-->
@include("footer")

</body>
</html>