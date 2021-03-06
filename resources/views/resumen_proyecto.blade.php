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
							<?php if($permiso_config_docs == 1){ ?>
								<div class="pull-right"><button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#mdlConfigDoc"><i class="fa fa-cogs"></i></button></div>
							<?php } ?>
								<h3 class="w3_inner_tittle two">{{$nombreclave}}</h3>
									  
								<h4>Bienvenido, el proyecto contiene los siguientes documentos registrados</h4>

					
								<div class="text" id="dv-resumen" style="display: none;">
								<br>
								<?php  
								$inicio=0;
								$ejecucion=0;
								$cierre=0;
								 ?>
									<div class="col-xs-6">
										<?php if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2) || ($_SESSION['tipoproy']==3)) && isset($doc_validados[1]) && $doc_validados[1] == 1 ){  ?>

										<?php  if($_SESSION['pactainicio']>0){  $inicio++;?>

										<div class="checkbox-inline1"><label><input type="checkbox" disabled="" @if ($actainicio == 1) {{'checked'}} @endif> Acta de inicio</label></div>

										<?php } 
												}
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[2]) && $doc_validados[2] == 1  ){

										if($_SESSION['pmatrizcomu']>0){  $inicio++;?>

										<div class="checkbox-inline1"><label><input type="checkbox" disabled="" @if ($matrizcomu == 1) {{'checked'}} @endif> Matriz de comunicación</label></div>

										<?php } 

										}
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[3]) && $doc_validados[3] == 1 ){

										if($_SESSION['pmatrizrol']>0){ $inicio++;?>

										<div class="checkbox-inline1"><label><input type="checkbox" disabled="" @if ($matrizrol == 1) {{'checked'}} @endif> Matriz de roles</label></div>
										
										<?php } 

										}
										if ( (($_SESSION['tipoproy']==1) && isset($doc_validados[15]) && $doc_validados[15] == 1)){

										if($_SESSION['pmatrizries']>0){ $inicio++;?>

										<div class="checkbox-inline1"><label><input type="checkbox" disabled="" @if ($matrizrol == 1) {{'checked'}} @endif> Matriz de Riesgos</label></div>
										
										<?php } 


										}
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[4]) && $doc_validados[4] == 1 ){

										if($_SESSION['preqlogist']>0){ $inicio++;?>

										<div class="checkbox-inline1"><label><input type="checkbox" disabled="" @if ($reqlogist == 1) {{'checked'}} @endif> Requerimientos de Logistica</label></div>
										
										<?php } 


											}
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[5]) && $doc_validados[5] == 1 ){


										if($_SESSION['preqcart']>0){ $inicio++;?>

										<div class="checkbox-inline1"><label><input type="checkbox" disabled="" @if ($reqcart == 1) {{'checked'}} @endif> Requerimientos de Cartografía</label></div>
										
										<?php } 

										}
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[6]) && $doc_validados[6] == 1){
										?>

										<div class="checkbox-inline1"><label><input type="checkbox" disabled="" @if ($actareuc == 1) {{'checked'}} @endif> Acta de Reunión</label></div>
											<?php } ?>
														

									</div>
									<?php $_SESSION['inicio']=$inicio; ?>
									<?php if ($inicio>0) { ?>
									<div class="col-xs-6">
										<a href="/inicio_resumen/{{$id}}"><div class="button">
													<p class="btnText">Fase de Inicio y Planificación</p>
													<div class="btnTwo">
													  <p class="btnText2">Ingresar</p>
													</div>
												 </div>

												 </a>


									</div>
									<?php } ?>

									<div class="col-xs-12"><br><hr></div>

									<div class="col-xs-6">

										<?php 


										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[13]) && $doc_validados[13] == 1  ){


										if($_SESSION['pactareunion']>0){ $ejecucion=1; ?>

									  <div class="checkbox-inline1"><label><input type="checkbox" disabled="" @if ($actareunion == 1) {{'checked'}} @endif> Acta de Reunión</label></div>

									  <?php } 


									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[7]) && $doc_validados[7] == 1 ){


									  if($_SESSION['psolcambio']>0){  $ejecucion=1;?>

									  <div class="checkbox-inline1"><label><input type="checkbox" disabled="" @if ($solcambio == 1) {{'checked'}} @endif> Solicitud de cambio</label></div>

									  <?php } 

									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[8]) && $doc_validados[8] == 1  ){


									  if($_SESSION['pactaacuerdo']>0){ $ejecucion=1;?>

									  <div class="checkbox-inline1"><label><input type="checkbox" disabled="" @if ($actaacuerdo == 1) {{'checked'}} @endif> Acta de Acuerdo</label></div>

									  <?php } 


									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[9]) && $doc_validados[9] == 1 ){

									  if($_SESSION['preportho']>0){ $ejecucion=1;?>

									  <div class="checkbox-inline1"><label><input type="checkbox" disabled="" @if ($reportho == 1) {{'checked'}} @endif> Reporte HO/SNC</label></div>

									  <?php } 

									  }
										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2)) && isset($doc_validados[10]) && $doc_validados[10] == 1  ){


									  if($_SESSION['psolac']>0){ $ejecucion=1;?>

									  <div class="checkbox-inline1"><label><input type="checkbox" disabled="" @if ($solac == 1) {{'checked'}} @endif> Solicitud AC y AP</label></div>

									  <?php }

									  }?>
														

									</div>
									<?php $_SESSION['ejecucion']=$ejecucion; ?>
									<?php if ($ejecucion>0) {?>
										
									<div class="col-xs-6">
										<a href="/ejecucion_resumen/{{$id}}"><div class="button">
													<p class="btnText">Fase de Ejecución</p>
													<div class="btnTwo">
													  <p class="btnText2">Ingresar</p>
													</div>
												 </div>
												</a>


									</div>
									<?php } ?>

									<div class="col-xs-12"><br><hr></div>
									<div class="col-xs-6">

										<?php 


										if ( (($_SESSION['tipoproy']==1) || ($_SESSION['tipoproy']==2) || ($_SESSION['tipoproy']==3)) && isset($doc_validados[12]) && $doc_validados[12] == 1 ){

										if($_SESSION['pactacierre']>0){ $cierre=1; ?>


									  <div class="checkbox-inline1"><label><input type="checkbox" disabled="" @if ($actacierre == 1) {{'checked'}} @endif> Acta de Cierre</label></div>


									  <?php }  }
									   ?>

														

									</div>
									<?php $_SESSION['cierre']=$cierre; ?>
									<?php if ($cierre>0) { ?>
									<div class="col-xs-6">
										<a href="/cierre_resumen/{{$id}}"><div class="button">
													<p class="btnText">Fase Cierre</p>
													<div class="btnTwo">
													  <p class="btnText2">Ingresar</p>
													</div>
												 </div>
												</a>


									</div>

									<?php } ?>






								</div>
								<?php if ( ($inicio==0) && ($ejecucion==0) && ($cierre==0) ) { ?>
								<div class="col-md-12"><hr>Este proyecto no requiere de los formatos establecidos para la gestión de proyectos.</div>
								<?php } ?>
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
<?php if($permiso_config_docs == 1){ ?>
<div class="modal fade" id="mdlConfigDoc" tabindex="-1" role="dialog" aria-labelledby="mdlConfigDoc">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" >
					<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Configuración de documentos</h4>
			</div>
			<div class="modal-body">

				<form method="post" id="frmConfigDoc">
					<input type="hidden" name="id" value="{{$id}}">
					<div class="col-md-4">
						<label><strong>F. Inicio</strong></label>
					<?php if(isset($doc_validados[1])){ ?><div class="checkbox-inline1"><label><input name="cnf_doc[1]" type="checkbox" @if ($doc_validados[1] == 1) {{'checked'}} @endif value="1"> Acta de inicio</label></div><?php } ?>
					<?php if(isset($doc_validados[2])){ ?><div class="checkbox-inline1"><label><input name="cnf_doc[2]" type="checkbox" @if ($doc_validados[2] == 1) {{'checked'}} @endif value="1"> Matriz de comunicación</label></div><?php } ?>
					<?php if(isset($doc_validados[3])){ ?><div class="checkbox-inline1"><label><input name="cnf_doc[3]" type="checkbox" @if ($doc_validados[3] == 1) {{'checked'}} @endif value="1"> Matriz de roles</label></div><?php } ?>
					<?php if(isset($doc_validados[15])){ ?><div class="checkbox-inline1"><label><input name="cnf_doc[15]" type="checkbox" @if ($doc_validados[15] == 1) {{'checked'}} @endif value="1"> Matriz de Riesgos</label></div><?php } ?>
					<?php if(isset($doc_validados[4])){ ?><div class="checkbox-inline1"><label><input name="cnf_doc[4]" type="checkbox" @if ($doc_validados[4] == 1) {{'checked'}} @endif value="1"> Requerimientos de Logistica</label></div><?php } ?>
					<?php if(isset($doc_validados[5])){ ?><div class="checkbox-inline1"><label><input name="cnf_doc[5]" type="checkbox" @if ($doc_validados[5] == 1) {{'checked'}} @endif value="1"> Requerimientos de Cartografía</label></div><?php } ?>
					<?php if(isset($doc_validados[6])){ ?><div class="checkbox-inline1"><label><input name="cnf_doc[6]" type="checkbox" @if ($doc_validados[6] == 1) {{'checked'}} @endif value="1"> Acta de Reunión</label></div><?php } ?>
					</div>

					<div class="col-md-4">
						<label><strong>F. Ejecución</strong></label>
					<?php if(isset($doc_validados[13])){ ?><div class="checkbox-inline1"><label><input name="cnf_doc[13]" type="checkbox" @if ($doc_validados[13] == 1) {{'checked'}} @endif value="1"> Acta de Reunión</label></div><?php } ?>
					<?php if(isset($doc_validados[7])){ ?><div class="checkbox-inline1"><label><input name="cnf_doc[7]" type="checkbox" @if ($doc_validados[7] == 1) {{'checked'}} @endif value="1"> Solicitud de cambio</label></div><?php } ?>
					<?php if(isset($doc_validados[8])){ ?><div class="checkbox-inline1"><label><input name="cnf_doc[8]" type="checkbox" @if ($doc_validados[8] == 1) {{'checked'}} @endif value="1"> Acta de Acuerdo</label></div><?php } ?>
					<?php if(isset($doc_validados[9])){ ?><div class="checkbox-inline1"><label><input name="cnf_doc[9]" type="checkbox" @if ($doc_validados[9] == 1) {{'checked'}} @endif value="1"> Reporte HO/SNC</label></div><?php } ?>
					<?php if(isset($doc_validados[10])){ ?><div class="checkbox-inline1"><label><input name="cnf_doc[10]" type="checkbox" @if ($doc_validados[10] == 1) {{'checked'}} @endif value="1"> Solicitud AC y AP</label></div><?php } ?>
					</div>

					<div class="col-md-4">
						<label><strong>F. Cierre</strong></label>
					<?php if(isset($doc_validados[12])){ ?><div class="checkbox-inline1"><label><input name="cnf_doc[12]" type="checkbox" @if ($doc_validados[12] == 1) {{'checked'}} @endif value="1"> Acta de Cierre</label></div><?php } ?>
					</div>
					{!! csrf_field() !!}

					<div class="clear"></div>
				</form>

			</div>
			<div class="modal-footer">
					<div class="col-xs-12 col-sm-3">
						<button type="button"  data-dismiss="modal" class="btn btn-default">Cancelar</button>
					</div>

					<div class="col-xs-12 col-sm-3 col-sm-offset-6">
						<button id="btnConfigDoc" type="button" class="btn btn-default">Guardar</button>
					</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<script>
$(function(){
	$('#btnConfigDoc').click(function(ev){
		ev.preventDefault();
		$('#btnConfigDoc').prop('disabled', true).html('Guardando...');
		$.post('/proyecto_doc_valida',$('#frmConfigDoc').serialize(),function(resp){
			if(resp.status == 'success'){
				swal("Éxito!", resp.msg, "success");
				setTimeout(function(){
					document.location.reload();
				},1000);
			}else{
				swal("Error!", resp.msg, "error");
				$('#btnConfigDoc').prop('disabled', false).html('Guardar');
			}
		}).fail(function(err){
			swal("Error!", "Ocurrió un error", "error");
			$('#btnConfigDoc').prop('disabled', false).html('Guardar');
		}, 'json');
	});


	if($.trim($('#dv-resumen').text()) != ""){
		$('#dv-resumen').show();
	}
});
</script>


@include("footer")

	</body>
	</html>