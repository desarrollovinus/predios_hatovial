<!DOCTYPE html>
<html>
	<head>
		<meta charset="<?php echo config_item('charset');?>" />
		<title><?php echo $titulo_pagina; ?></title>
		
		<!-- estilos -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/estilo.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/cupertino/jquery-ui-1.8.16.custom.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/demos.css" type="text/css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/fancydropdown.css" type="text/css">
		
		<!-- icono -->
		<link rel="shortcut icon" href="<?php echo base_url(); ?>img/favicon.ico" type="image/x-icon">
		<link rel="icon" href="<?php echo base_url(); ?>img/favicon.ico" type="image/x-icon">
		
		<!-- scripts -->
		<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.form.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.ui.core.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.ui.widget.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.ui.button.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.ui.accordion.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.ui.datepicker.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.ui.mouse.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.ui.draggable.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.ui.position.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.ui.dialog.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.ui.resizable.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.effects.core.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.bgiframe-2.1.2.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/fancydropdown.js"></script>
		<style>
		<!--
		 /* Font Definitions */
			@font-face
				{font-family:"Cambria Math";
				panose-1:2 4 5 3 5 4 6 3 2 4;}
			@font-face
				{font-family:"Trebuchet MS";
				panose-1:2 11 6 3 2 2 2 2 2 4;}
			 /* Style Definitions */
			 p.MsoNormal, li.MsoNormal, div.MsoNormal
				{margin:0cm;
				margin-bottom:.0001pt;
				font-size:12.0pt;
				font-family:"Times New Roman","serif";}
			.MsoPapDefault
				{margin-bottom:10.0pt;
				line-height:115%;}
			@page WordSection1
				{size:612.0pt 792.0pt;
				margin:70.85pt 3.0cm 70.85pt 3.0cm;}
			div.WordSection1
				{page:WordSection1;}
		-->
		</style>
	</head>
	<body>
		<div id="principal">
			<div id="encabezado">
				<div id="nombre_aplicacion"></div>
				<div id="logo"></div>
			</div>
			<div id="contenido">
				<div id="form">
					<div id="accordion">
						<!-- seccion 0 -->
						<div align="center"><h1><a href="#seccion0">ESTUDIO DE T&Iacute;TULOS</a></h1></div>
						<table>
							<tr>
								<td width="20%"><?php echo form_label('<b>Ficha predial: </b>', "ficha"); ?></td>
								<td width="30%"><?php echo $predio->ficha_predial; ?></td>
							</tr>
							<tr>
								<td width="30%"><?php echo form_label('<b>Proyecto:</b>', "proyecto"); ?></td>
								<td width="20%">Desarrollo VIAL del ABURR&Aacute; NORTE</td>
							</tr>
							<tr>
								<td><?php echo form_label('<b>Sector:</b>', "sector"); ?></td>
								<td>Norte del &Aacute;rea Metropolitana</td>
							</tr>
							<tr>
								<td><?php echo form_label('<b>Para:</b>', "para"); ?></td>
								<td>Departamento de Antioquia y el &Aacute;rea Metropolitana del Valle de Aburr&aacute;</td>
							</tr>
							<tr>
								<?php
									$meses['January'] = 'Enero';
									$meses['February'] = 'Febrero';
									$meses['March'] = 'Marzo';
									$meses['April'] = 'Abril';
									$meses['May'] = 'Mayo';
									$meses['June'] = 'Junio';
									$meses['July'] = 'Julio';
									$meses['August'] = 'Agosto';
									$meses['September'] = 'Septiembre';
									$meses['October'] = 'Octubre';
									$meses['November'] = 'Noviembre';
									$meses['December'] = 'Diciembre'; 
									
									$timestamp = time();
								?>
								<td><?php echo form_label('<b>Fecha:</b>', "fecha_documento"); ?></td>
								<td><?php echo strftime("%d-".$meses[strftime("%B", $timestamp)]." de %Y", $timestamp); ?></td>
							</tr>
							<tr>
								<td><?php echo form_label('<b>Clase de Aval&uacute;o:</b>', "clase_avaluo"); ?></td>
								<td></td>
							</tr>
						</table>

						<h3><a href="#seccion2">IDENTIFICACI&Oacute;N PROPIETARIO(S)</a></h3>
						<div>
							<?php $id = 0;?>
							<?php foreach ($propietarios as $propietario): ?>
								<?php $id++; ?>
								<?php echo form_fieldset("<b>Propietario $id</b>"); ?>
									<table style="text-align:left">
										<tbody>
											<tr>
												<td width="20%"><?php echo form_label('<b>Nombre:</b>', "propietario$id"); ?></td>
												<td width="30%"><?php echo utf8_decode($propietario->nombre); ?></td>
											</tr>
											<tr>
												<td width="30%"><?php echo form_label('<b>'.utf8_decode($propietario->tipo_documento).':</b>', "documento_propietario$id"); ?></td>
												<td width="20%"><?php echo utf8_decode($propietario->documento); ?></td>
											</tr>
											<tr>
												<td><?php echo form_label('<b>Tel&eacute;fono:</b>', "telefono$id"); ?></td>
												<td><?php echo utf8_decode($propietario->telefono); ?></td>
											</tr>
											<tr>
												<td><?php echo form_label('<b>Participaci&oacute;n:</b>', "participacion$id"); ?></td>
												<td><?php echo utf8_decode($propietario->participacion); ?>%</td>
											</tr>
										</tbody>
									</table>
								<?php echo form_fieldset_close(); ?>
							<?php endforeach;?>
							<div class="clear">&nbsp;</div>
						</div>
						<!-- seccion 1 -->
						<h3><a href="#seccion1">IDENTIFICACI&Oacute;N PREDIO</a></h3>
						<div>
							<?php echo form_fieldset(); ?>
								<table style="text-align:'left'">
									<tbody>
										<tr>
											<td width="20%"><?php echo form_label('<b>Municipio:</b>','municipio'); ?></td>
											<td width="30%"><?php echo utf8_decode($identificacion->municipio); ?></td>
										</tr>
										<tr>
											<td width="30%"><?php echo form_label('<b>Vereda o Barrio:</b>','vereda_barrio'); ?></td>
											<td width="20%"><?php echo utf8_decode($identificacion->barrio); ?></td>
										</tr>
										<tr>					
											<td><?php echo form_label('<b>Direcci&oacute;n / Nombre:</b>','direccion_nombre'); ?></td>
											<td><?php echo utf8_decode($identificacion->direccion); ?></td>
										</tr>
										<tr>
											<td><?php echo form_label('<b>Tramo:</b>','tramo'); ?></td>
											<td><?php echo utf8_decode($descripcion->tramo); ?></td>
										</tr>
									</tbody>
								</table>
							<?php echo form_fieldset_close(); ?>
							<div class="clear">&nbsp;</div>
						</div>
						<!-- seccion 2 -->
						<h3><a href="#seccion2">INFORMACI&Oacute;N JUR&Iacute;DICA DEL PREDIO</a></h3>
						<div>
							<?php echo form_fieldset(); ?>
								<table style="text-align:'left'">
									<tbody>
										<tr>
											<td width="20%"><?php echo form_label('<b>Direcci&oacute;n / Nombre:</b>','direccion_nombre'); ?></td>
											<td width="30%"><?php echo utf8_decode($identificacion->matricula_orig); ?></td>
										</tr>
										<tr>
											<td width="30%"><?php echo form_label('<b>Escritura No: </b>','numero_escritura'); ?></td>
											<td width="20%"><?php echo utf8_decode($identificacion->escritura_orig); ?></td>
										</tr>
										<tr>
											<td><?php echo form_label('<b>Fecha: </b>', 'fecha_escritura'); ?></td>
											<td><?php echo utf8_decode($identificacion->fecha_escritura); ?></td>
										</tr>
										<tr>
											<td><?php echo form_label('<b>Notar&iacute;a No: </b>', 'numero_notaria'); ?></td>
											<td><?php echo utf8_decode($identificacion->no_notaria); ?></td>
										</tr>
										<tr>
											<td><?php echo form_label('<b>Of. Registro: </b>', 'oficina_registro'); ?></td>
											<td><?php echo utf8_decode($identificacion->of_registro); ?></td>
										</tr>
										<tr>
											<td><?php echo form_label('<b>Ciudad: </b>', 'ciudad'); ?></td>
											<td><?php echo utf8_decode($identificacion->ciudad); ?></td>
										</tr>
										<tr>
											<td><?php echo form_label('<b>No Catastral: </b>', 'numero_catastral'); ?></td>
											<td><?php echo utf8_decode($identificacion->no_catastral); ?></td>
										</tr>
									</tbody>
								</table>
							<?php echo form_fieldset_close(); ?>
							<div class="clear">&nbsp;</div>
						</div>						
						<!-- seccion 3 -->
						<h3><a href="#seccion3">IDENTIFICACI&Oacute;N PREDIO REQUERIDO</a></h3>
						<div>
							<?php echo form_fieldset('<b>DESCRIPCI&Oacute;N DEL PREDIO</b>'); ?>
								<table style="text-align:'left'">
									<tbody>
										<tr>
											<td width="20%"><?php echo form_label('<b>Uso Edificaci&oacute;n:</b>','uso_edificacion'); ?></td>
											<td width="30%"><?php echo utf8_decode($descripcion->uso_edificacion);?></td>
										</tr>
										<tr>
											<td width="30%"><?php echo form_label('<b>Servicios P&uacute;blicos:</b>','servicios_publicos'); ?></td>
											<td width="20%"><?php echo utf8_decode($descripcion->serv_publicos); ?></td>
										</tr>
										<tr>
											<td><?php echo form_label('<b>&Aacute;rea Const. Requerida:</b>','area_const_requerida'); ?></td>
											<td><?php echo utf8_decode($descripcion->area_cons_requerida); ?>m&sup2;</td>
										</tr>
										<tr>
											<td><?php echo form_label('<b>Estado:</b>','estado'); ?></td>
											<td><?php echo utf8_decode($descripcion->estado_pre) ;?></td>
										</tr>
										<tr>
											<td><?php echo form_label('<b>Nacimiento de Agua:</b>','nacimiento_agua'); ?></td>
											<td><?php echo utf8_decode($descripcion->nacimiento_agua); ?></td>
										</tr>
										<tr>
											<td><?php echo form_label('<b>Abscisa Inicial:</b>','abscisa_inicial'); ?></td>
											<td><?php echo utf8_decode($descripcion->abscisa_inicial); ?></td>
										</tr>
										<tr>
											<td><?php echo form_label('<b>Uso de Terreno:</b>','uso_terreno'); ?></td>
											<td><?php echo utf8_decode($descripcion->uso_terreno);?></td>
										</tr>
										<tr>
											<td><?php echo form_label('<b>&Aacute;rea Total:</b>','area_total'); ?></td>
											<td><?php echo utf8_decode($descripcion->area_total); ?>m&sup2;</td>
										</tr>
										<tr>
											<td><?php echo form_label('<b>Abscisa Final:</b>','abscisa_final'); ?></td>
											<td><?php echo utf8_decode($descripcion->abscisa_final); ?></td>
										</tr>
										<tr>
											<td><?php echo form_label('<b>Tipo de Tenencia:</b>','tipo_tenencia'); ?></td>
											<td><?php echo utf8_decode($descripcion->tipo_tenencia); ?></td>
										</tr>
										<tr>
											<td><?php echo form_label('<b>&Aacute;rea Requerida:</b>','area_requerida'); ?></td>
											<td><?php echo utf8_decode($descripcion->area_requerida); ?>m&sup2;</td>
										</tr>
										<tr>
											<td><?php echo form_label('<b>Topografia:</b>','topografia'); ?></td>
											<td><?php echo utf8_decode($descripcion->topografia);?></td>
										</tr>
										<tr>
											<td><?php echo form_label('<b>&Aacute;rea Residual:</b>','area_residual'); ?></td>
											<td><?php echo utf8_decode($descripcion->area_residual); ?>m&sup2;</td>
										</tr>
										<tr>
											<td><?php echo form_label('<b>Via de Acceso:</b>','via_acceso'); ?></td>
											<td><?php echo utf8_decode($descripcion->via_acceso); ?></td>
										</tr>
										<tr>
											<td><?php echo form_label('<b>&Aacute;rea Construida:</b>','area_construida'); ?></td>
											<td><?php echo utf8_decode($descripcion->area_construida); ?>m&sup2;</td>
										</tr>
									</tbody>
								</table>
								<p><?php echo "<b>Observaci&oacute;n: </b>".utf8_decode($descripcion->observacion); ?></p>
								<br>
							<?php echo form_fieldset_close(); ?>
						</div>
						<!-- seccion 4 -->
						<h3><a href="#seccion4">ESTUDIO DE T&Iacute;TULOS</a></h3>
						<div>
							<?php echo form_fieldset('<b>T&iacute;tulos de adquisici&oacute;n:</b>'); ?>
								<?php 
									$identificacion->titulos_adq = str_replace("“", "\"", $identificacion->titulos_adq);
									$identificacion->titulos_adq = str_replace("�", "\"", $identificacion->titulos_adq);
									$identificacion->titulos_adq = str_replace("\n", "<br>", $identificacion->titulos_adq);
									echo '<p>'.utf8_decode($identificacion->titulos_adq).'</p>'; 
								?>
							<?php echo form_fieldset_close(); ?>
							<div class="clear"></div><br>
							<?php echo form_fieldset('<b>Linderos seg&uacute;n t&iacute;tulo:</b>'); ?>
								<?php 
									$identificacion->lind_titulo = str_replace("“", "\"", $identificacion->lind_titulo);
									$identificacion->lind_titulo = str_replace("�", "\"", $identificacion->lind_titulo);
									$identificacion->lind_titulo = str_replace("\n", "<br>", $identificacion->lind_titulo);
									echo '<p>'.utf8_decode($identificacion->lind_titulo).'</p>'; 
								?>
							<?php echo form_fieldset_close(); ?>
							<div class="clear"></div><br>
							<?php echo form_fieldset('<b>Linderos predio requerido:</b>'); ?>
								<?php 
									$linderos->linderos = str_replace("“", "\"", $linderos->linderos);
									$linderos->linderos = str_replace("�", "\"", $linderos->linderos);
									$linderos->linderos = str_replace("\n", "<br>", $linderos->linderos);
									echo '<p>'.utf8_decode($linderos->linderos).'</p>'; 
								?>
							<?php echo form_fieldset_close(); ?>
							<div class="clear"></div><br>
							<?php echo form_fieldset('<b>Grav&aacute;menes - Limitaciones:</b>'); ?>
								<?php 
									$identificacion->gravamenes = str_replace("“", "\"", $identificacion->gravamenes);
									$identificacion->gravamenes = str_replace("�", "\"", $identificacion->gravamenes);
									$identificacion->gravamenes = str_replace("\n", "<br>", $identificacion->gravamenes);
									echo '<p>'.utf8_decode($identificacion->gravamenes).'</p>'; 
								?>
							<?php echo form_fieldset_close(); ?>
							<div class="clear"></div><br>
							<?php echo form_fieldset('<b>Documentos estudiados:</b>'); ?>
								<?php if($identificacion->doc_estud != '') echo "<ol>"; ?>
								<?php 
									$identificacion->doc_estud = str_replace("“", "\"", $identificacion->doc_estud);
									$identificacion->doc_estud = str_replace("�", "\"", $identificacion->doc_estud);
									$identificacion->doc_estud = str_replace("\n", "</li><li>", $identificacion->doc_estud);
									echo '<li>'.utf8_decode($identificacion->doc_estud).'</li>'; 
								?>
								<?php if($identificacion->doc_estud != '') echo "</ol>"; ?>
							<?php echo form_fieldset_close(); ?>
							<div class="clear"></div><br>
							<?php echo form_fieldset('<b>Observaciones estudio de t&iacute;tulos:</b>'); ?>
								<?php 
									$identificacion->ob_titu = str_replace("“", "\"", $identificacion->ob_titu);
									$identificacion->ob_titu = str_replace("�", "\"", $identificacion->ob_titu);
									$identificacion->ob_titu = str_replace("\n", "<br>", $identificacion->ob_titu);
									echo '<p>'.utf8_decode($identificacion->ob_titu).'</p>';
								?>
							<?php echo form_fieldset_close(); ?>
							<div class="clear"></div><br>
							<?php echo form_fieldset('<b>Concepto:</b>'); ?>
								<?php 
									$identificacion->conc_titu = str_replace("“", "\"", $identificacion->conc_titu);
									$identificacion->conc_titu = str_replace("�", "\"", $identificacion->conc_titu);
									$identificacion->conc_titu = str_replace("\n", "<br>", $identificacion->conc_titu);
									echo '<p>'.utf8_decode($identificacion->conc_titu).'</p>'; 
								?>
							<?php echo form_fieldset_close(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>