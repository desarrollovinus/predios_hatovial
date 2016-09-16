<div id="form">
	<?php
		echo form_fieldset('<b>Registro</b>');
		echo form_open('actualizar_controller/actualizar_predio');
		echo form_label('Ficha predial:&nbsp;&nbsp;&nbsp;','ficha');
		
		echo form_input('ficha', $predio->ficha_predial, 'readonly');
		
	?>
	<div class="clear">&nbsp;</div>
	<div id="accordion">
	
	
		<!-- seccion 1 -->
	
	
		<h3><a href="#seccion1">IDENTIFICACI&Oacute;N PREDIO REQUERIDO</a></h3>
		<div>
			<?php echo form_fieldset('<b>DESCRIPCI&Oacute;N DEL PREDIO</b>'); ?>
			<table style="text-align:'left'">
				<tbody>
					<tr>
						<td width="20%"><?php echo form_label('Uso Edificaci&oacute;n','uso_edificacion'); ?></td>
						<td width="30%"><?php echo form_input('uso_edificacion', utf8_decode($descripcion->uso_edificacion), 'readonly');?></td>
						<td width="20%"><?php echo form_label('Estado','estado'); ?></td>
						<td width="30%"><?php echo form_input('estado', utf8_decode($descripcion->estado_pre), 'readonly') ;?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Uso de Terreno','uso_terreno'); ?></td>
						<td width="30%"><?php echo form_input('uso_terreno', utf8_decode($descripcion->uso_terreno), 'readonly');?></td>
						<td width="20%"><?php echo form_label('Tipo de Tenencia','tipo_tenencia'); ?></td>
						<td width="30%"><?php echo form_input('tipo_tenencia', utf8_decode($descripcion->tipo_tenencia), 'readonly'); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Topografia','topografia'); ?></td>
						<td width="30%"><?php echo form_input('topografia', utf8_decode($descripcion->topografia), 'readonly');?></td>
						<td width="20%"><?php echo form_label('Via de Acceso','via_acceso'); ?></td>
						<td width="30%"><?php echo form_input('via_acceso', utf8_decode($descripcion->via_acceso), 'readonly'); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Servicios P&uacute;blicos','servicios_publicos'); ?></td>
						<td width="30%"><?php echo form_input('servicios_publicos', utf8_decode($descripcion->serv_publicos), 'readonly'); ?></td>
						<td width="20%"><?php echo form_label('Nacimiento de Agua','nacimiento_agua'); ?></td>
						<td width="30%"><?php echo form_input('nacimiento_agua', utf8_decode($descripcion->nacimiento_agua), 'readonly'); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('&Aacute;rea Total','area_total'); ?></td>
						<td width="30%"><?php echo form_input('area_total', utf8_decode($descripcion->area_total), 'readonly'); ?>m&sup2;</td>
						<td width="20%"><?php echo form_label('&Aacute;rea Requerida','area_requerida'); ?></td>
						<td width="30%"><?php echo form_input('area_requerida', utf8_decode($descripcion->area_requerida), 'readonly'); ?>m&sup2;</td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('&Aacute;rea Residual','area_residual'); ?></td>
						<td width="30%"><?php echo form_input('area_residual', utf8_decode($descripcion->area_residual), 'readonly'); ?>m&sup2;</td>
						<td width="20%"><?php echo form_label('&Aacute;rea Construida','area_construida'); ?></td>
						<td width="30%"><?php echo form_input('area_construida', utf8_decode($descripcion->area_construida), 'readonly'); ?>m&sup2;</td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('&Aacute;rea Const. Requerida','area_const_requerida'); ?></td>
						<td width="30%"><?php echo form_input('area_const_requerida', utf8_decode($descripcion->area_cons_requerida), 'readonly'); ?>m&sup2;</td>
						<td width="20%"><?php echo form_label('Abscisa Inicial','abscisa_inicial'); ?></td>
						<td width="30%"><?php echo form_input('abscisa_inicial', utf8_decode($descripcion->abscisa_inicial), 'readonly'); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Abscisa Final','abscisa_final'); ?></td>
						<td width="30%"><?php echo form_input('abscisa_final', utf8_decode($descripcion->abscisa_final), 'readonly'); ?></td>
						<td width="20%"><?php echo form_label('Estado del Proceso','estado_proceso'); ?></td>
						<td width="30%"><?php echo form_input('estado_proceso', utf8_decode($identificacion->estado_pro), 'readonly'); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Entregado','entregado'); ?></td>
						<td width="30%"><?php echo form_input('entregado', utf8_decode($identificacion->entregado), 'readonly'); ?></td>
						<td width="20%"><?php echo form_label('Fecha Entregado','fecha_entregado'); ?></td>
						<td width="30%"><?php echo form_input('fecha_entregado', utf8_decode($identificacion->f_entregado), 'readonly'); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Radicado','radicado'); ?></td>
						<td width="30%"><?php echo form_input('radicado', utf8_decode($identificacion->rad_ent), 'readonly'); ?></td>
					</tr>
				</tbody>
			</table>
			<div align="center">
				<?php echo form_label('Observaci&oacute;n','observacion')?><br>
				<?php echo form_textarea('observacion', utf8_decode($descripcion->observacion), 'readonly');?>
			</div>
			<?php echo form_fieldset_close(); ?>
		</div>
		
		
		<!-- seccion 2 -->
		
		
		<h3><a href="#seccion2">IDENTIFICACI&Oacute;N DEL PREDIO ORIGINAL</a></h3>
		<div>
			<?php $id = 0;?>
			<?php foreach ($propietarios as $propietario): ?>
				<?php $id++; ?>
				<?php echo form_fieldset("<b>Identificaci&oacute;n del propietario $id</b>", "id='$id'"); ?>
					<table style="text-align:left">
						<tbody>
							<tr>
								<td width="20%"><?php echo form_label('Tipo documento', "tipo_documento$id"); ?></td>
								<td width="30%"><?php echo form_input("tipo_documento$id", utf8_decode($propietario->tipo_documento), 'readonly'); ?></td>
								<td width="20%"><?php echo form_label('Propietario', "propietario$id"); ?></td>
								<td width="30%"><?php echo form_input("propietario$id", utf8_decode($propietario->nombre), 'readonly'); ?></td>
							</tr>
							<tr>
								<td width="20%"><?php echo form_label('Documento', "documento_propietario$id"); ?></td>
								<td width="30%"><?php echo form_input("documento_propietario$id", utf8_decode($propietario->documento), 'readonly'); ?></td>
								<td width="20%"><?php echo form_label('Tel&eacute;fono', "telefono$id"); ?></td>
								<td width="30%"><?php echo form_input("telefono$id", utf8_decode($propietario->telefono), 'readonly'); ?></td>
							</tr>
							<tr>
								<td width="20%"><?php echo form_label('Participaci&oacute;n', "participacion$id"); ?></td>
								<td width="30%"><?php echo form_input("participacion$id", utf8_decode($propietario->participacion), 'readonly'); ?>%</td>
							</tr>
						</tbody>
					</table>
				<?php echo form_fieldset_close(); ?>
			<?php endforeach;?>
			<div class="clear">&nbsp;</div>
			<?php echo form_fieldset('<b>Identificaci&oacute;n del predio</b>'); ?>
			<table style="text-align:'left'">
				<tbody>
					<tr>
						<td width="20%"><?php echo form_label('Municipio','municipio'); ?></td>
						<td width="30%"><?php echo form_input('municipio', utf8_decode($identificacion->municipio), 'readonly'); ?></td>
						<td width="20%"><?php echo form_label('Vereda o Barrio','vereda_barrio'); ?></td>
						<td width="30%"><?php echo form_input('vereda_barrio', utf8_decode($identificacion->barrio), 'readonly'); ?></td>
					</tr>
					<tr>					
						<td width="30%"><?php echo form_label('Direcci&oacute;n / Nombre','direccion_nombre'); ?></td>
						<td width="20%"><?php echo form_input('direccion_nombre', utf8_decode($identificacion->direccion), 'readonly'); ?></td>
						<td width="30%"><?php echo form_label('Tramo','tramo'); ?></td>
						<td width="20%"><?php echo form_input('tramo', utf8_decode($descripcion->tramo), 'readonly'); ?></td>
					</tr>
				</tbody>
			</table>
			<?php echo form_fieldset_close(); ?>
			<div class="clear">&nbsp;</div>
			<?php echo form_fieldset('<b>Informaci&oacute;n jur&iacute;dica del predio inicial</b>'); ?>
			<table style="text-align:'left'">
				<tbody>
					<tr>
						<td width="20%"><?php echo form_label('N&uacute;mero de matr&iacute;cula','numero_matricula_predio_inicial'); ?></td>
						<td width="30%"><?php echo form_input('numero_matricula_predio_inicial', utf8_decode($identificacion->matricula_orig), 'readonly'); ?></td>
						<td width="20%"><?php echo form_label('Fecha','fecha_predio_inicial'); ?></td>
						<td width="30%"><?php echo form_input('fecha_predio_inicial', utf8_decode($identificacion->fecha_escritura), 'readonly'); ?></td>
					</tr>
					<tr>					
						<td><?php echo form_label('Oficina registro','oficina_registro_predio_inicial'); ?></td>
						<td><?php echo form_input('oficina_registro_predio_inicial', utf8_decode($identificacion->of_registro), 'readonly'); ?></td>
						<td><?php echo form_label('N&uacute;mero de la notar&iacute;a','numero_notaria_predio_inicial'); ?></td>
						<td><?php echo form_input('numero_notaria_predio_inicial', utf8_decode($identificacion->no_notaria), 'readonly'); ?></td>
					</tr>
					<tr>
						<td width="30%"><?php echo form_label('N&uacute;mero de escritura','numero_escritura'); ?></td>
						<td width="20%"><?php echo form_input('numero_escritura', utf8_decode($identificacion->escritura_orig), 'readonly'); ?></td>
						<td width="30%"><?php echo form_label('N&uacute;mero catastral','numero_catastral_predio_inicial'); ?></td>
						<td width="20%"><?php echo form_input('numero_catastral_predio_inicial', utf8_decode($identificacion->no_catastral), 'readonly'); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Ciudad','ciudad_predio_inicial'); ?></td>
						<td><?php echo form_input('ciudad_predio_inicial', utf8_decode($identificacion->ciudad), 'readonly'); ?></td>
					</tr>
				</tbody>
			</table>
			<?php echo form_fieldset_close(); ?>
		</div>
		
		
		<!-- seccion 3 -->
		
		
		<h3><a href="#seccion3">ESTUDIO DE T&Iacute;TULOS</a></h3>
		<div>
			<?php echo form_fieldset('<b>T&iacute;tulos de adquisici&oacute;n</b>'); ?>
			<div align="center"><?php echo form_textarea('titulos_adquisicion', utf8_decode($identificacion->titulos_adq), 'readonly'); ?></div>
			<?php echo form_fieldset_close(); ?>
			<?php echo form_fieldset('<b>Linderos seg&uacute;n t&iacute;tulo</b>'); ?>
			<div align="center"><?php echo form_textarea('linderos_segun_titulo', utf8_decode($identificacion->lind_titulo), 'readonly'); ?></div>
			<?php echo form_fieldset_close(); ?>
			<?php echo form_fieldset('<b>Linderos predio requerido</b>'); ?>
			<div align="center"><?php echo form_textarea('linderos_predio_requerido', utf8_decode($linderos->linderos), 'readonly'); ?></div>
			<?php echo form_fieldset_close(); ?>
			<?php echo form_fieldset('<b>Grav&aacute;menes - Limitaciones</b>'); ?>
			<div align="center"><?php echo form_textarea('gravamenes_limitaciones', utf8_decode($identificacion->gravamenes), 'readonly'); ?></div>
			<?php echo form_fieldset_close(); ?>
			<?php echo form_fieldset('<b>Documentos estudiados</b>'); ?>
			<div align="center"><?php echo form_textarea('documentos_estudiados', utf8_decode($identificacion->doc_estud), 'readonly'); ?></div>
			<?php echo form_fieldset_close(); ?>
			<?php echo form_fieldset('<b>Observaciones estudio de t&iacute;tulos</b>'); ?>
			<div align="center"><?php echo form_textarea('observaciones_estudio_titulos', utf8_decode($identificacion->ob_titu), 'readonly'); ?></div>
			<?php echo form_fieldset_close(); ?>
			<?php echo form_fieldset('<b>Concepto</b>'); ?>
			<div align="center"><?php echo form_textarea('concepto', utf8_decode($identificacion->conc_titu), 'readonly'); ?></div>
			<?php echo form_fieldset_close(); ?>
		</div>
				
		
		<!-- seccion 4 -->
		
		
		<h3><a href="#seccion4">GESTI&Oacute;N PREDIAL</a></h3>
		<div>
			<?php echo form_fieldset('<b>Identificaci&oacute;n</b>')?>
			<table style="text-align:'left'">
				<tbody>
					<tr>
						<td width="30%"><?php echo form_label('Inicio del trabajo f&iacute;sico','inicio_trabajo_fisico'); ?></td>
						<td width="20%"><?php echo form_input('inicio_trabajo_fisico', utf8_decode($identificacion->f_inicio_trab), 'readonly'); ?></td>
						<td width="30%"><?php echo form_label('Encargado gesti&oacute;n predial','encargado_gestion_predial'); ?></td>
						<td width="20%"><?php echo form_input('encargado_gestion_predial', utf8_decode($identificacion->enc_gestion), 'readonly'); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Entrega del plano a interventor&iacute;a','entrega_plano_interventoria'); ?></td>
						<td><?php echo form_input('entrega_plano_interventoria', utf8_decode($identificacion->f_ent_plano_int), 'readonly'); ?></td>
						<td><?php echo form_label('Radicado entrega interventor&iacute;a','radicado_entrega_interventoria'); ?></td>
						<td><?php echo form_input('radicado_entrega_interventoria', utf8_decode($identificacion->rad_int), 'readonly'); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Aprobaci&oacute;n definitiva del plano','aprobacion_definitiva_plano'); ?></td>
						<td><?php echo form_input('aprobacion_definitiva_plano', utf8_decode($identificacion->f_apro_def), 'readonly'); ?></td>
						<td><?php echo form_label('Radicado aprobaci&oacute;n plano','radicado_aprobacion_plano'); ?></td>
						<td><?php echo form_input('radicado_aprobacion_plano', utf8_decode($identificacion->rad_apro_pla), 'readonly'); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Notificaci&oacute;n propietario','notificacion_propietario'); ?></td>
						<td width="30%"><?php echo form_input('notificacion_propietario', utf8_decode($identificacion->f_notificacion_pro), 'readonly'); ?></td>
						<td width="20%"><?php echo form_label('Radicado notificaci&oacute;n propietario','radicado_notificacion_propietario'); ?></td>
						<td width="30%"><?php echo form_input('radicado_notificacion_propietario', utf8_decode($identificacion->rad_no_pro), 'readonly'); ?></td>
					</tr>
				</tbody>
			</table>
			<?php echo form_fieldset_close(); ?>
			<div class="clear">&nbsp;</div>
			<?php echo form_fieldset('<b>Aval&uacute;o</b>'); ?>
			<table style="text-align:'left'">
				<tbody>
					<tr>
						<td width="30%"><?php echo form_label('Total aval&uacute;o','total_avaluo'); ?></td>
						<td width="20%"><?php echo form_input('total_avaluo', utf8_decode($identificacion->total_avaluo), 'readonly'); ?></td>
						<td width="30%"><?php echo form_label('Valor total de mejoras','valor_total_mejoras'); ?></td>
						<td width="20%"><?php echo form_input('valor_total_mejoras', utf8_decode($identificacion->valor_total_mej), 'readonly'); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Valor metro cuadrado','valor_metro_cuadrado'); ?></td>
						<td><?php echo form_input('valor_metro_cuadrado', utf8_decode($identificacion->valor_mtr), 'readonly'); ?></td>
						<td><?php echo form_label('Valor total del terreno','valor_total_terreno'); ?></td>
						<td><?php echo form_input('valor_total_terreno', utf8_decode($identificacion->valor_total_terr), 'readonly'); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Env&iacute;o al avaluador','envio_avaluador'); ?></td>
						<td width="30%"><?php echo form_input('envio_avaluador', utf8_decode($identificacion->f_envio_av), 'readonly'); ?></td>
						<td width="20%"><?php echo form_label('Radicado env&iacute;o avaluador','radicado_envio_avaluador'); ?></td>
						<td width="30%"><?php echo form_input('radicado_envio_avaluador', utf8_decode($identificacion->r_envio_av), 'readonly'); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Fecha del aval&uacute;o','recibo_avaluo'); ?></td>
						<td><?php echo form_input('recibo_avaluo', utf8_decode($identificacion->f_recibo_av), 'readonly'); ?></td>
					</tr>
				</tbody>
			</table>
			<?php echo form_fieldset_close(); ?>
			<div class="clear">&nbsp;</div>
			<?php echo form_fieldset('<b>Jur&iacute;dica</b>'); ?>
			<table style="text-align:'left'">
				<tbody>
					<tr>
						<td width="30%"><?php echo form_label('Env&iacute;o a la interventor&iacute;a','envio_interventoria'); ?></td>
						<td width="20%"><?php echo form_input('envio_interventoria', utf8_decode($identificacion->f_envio_int), 'readonly'); ?></td>
						<td width="30%"><?php echo form_label('Radicado env&iacute;o a interventor&iacute;a','radicado_envio_interventoria'); ?></td>
						<td width="20%"><?php echo form_input('radicado_envio_interventoria', utf8_decode($identificacion->rad_env_int), 'readonly'); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Env&iacute;o a la gerencia para firmar','envio_gerencia_firmar'); ?></td>
						<td width="30%"><?php echo form_input('envio_gerencia_firmar', utf8_decode($identificacion->f_envio_ger), 'readonly'); ?></td>
						<td width="20%"><?php echo form_label('Radicado env&iacute;o a gerencia','radicado_envio_gerencia'); ?></td>
						<td width="30%"><?php echo form_input('radicado_envio_gerencia', utf8_decode($identificacion->rad_env_ger), 'readonly'); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Recibo para la notificaci&oacute;n al propietario','recibo_notificacion_propietario'); ?></td>
						<td><?php echo form_input('recibo_notificacion_propietario', utf8_decode($identificacion->f_recibo_pro), 'readonly'); ?></td>
					</tr>
			</table>
			<?php echo form_fieldset_close(); ?>
			<div class="clear">&nbsp;</div>			
			<?php echo form_fieldset('<b>Enajenaci&oacute;n voluntaria</b>'); ?>
			<table style="text-align:'left'">
				<tbody>
					<tr>
						<td width="30%"><?php echo form_label('Env&iacute;o escritura a notar&iacute;a','envio_escritura_notaria'); ?></td>
						<td width="20%"><?php echo form_input('envio_escritura_notaria', utf8_decode($identificacion->env_esc_not), 'readonly'); ?></td>
						<td width="30%"><?php echo form_label('Ingreso escritura','ingreso_escritura'); ?></td>
						<td width="20%"><?php echo form_input('ingreso_escritura', utf8_decode($identificacion->ing_esc), 'readonly'); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Recibo de registro','recibo_registro_enajenacion'); ?></td>
						<td width="30%"><?php echo form_input('recibo_registro_enajenacion', utf8_decode($identificacion->rec_reg_vol), 'readonly'); ?></td>
					</tr>
				</tbody>
			</table>
			<?php echo form_fieldset_close(); ?>
			<div class="clear">&nbsp;</div>
			<?php echo form_fieldset('<b>Expropiaci&oacute;n</b>'); ?>
			<table style="text-align:'left'">
				<tbody>
					<tr>
						<td width="30%"><?php echo form_label('Notificaci&oacute;n','notificacion'); ?></td>
						<td width="20%"><?php echo form_input('notificacion', utf8_decode($identificacion->notif), 'readonly'); ?></td>
						<td width="30%"><?php echo form_label('Inicio juicio','inicio_juicio'); ?></td>
						<td width="20%"><?php echo form_input('inicio_juicio', utf8_decode($identificacion->ini_juic), 'readonly'); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Inicio Sentencia','inicio_sentencia'); ?></td>
						<td width="30%"><?php echo form_input('inicio_sentencia', utf8_decode($identificacion->ini_sent), 'readonly'); ?></td>
						<td width="20%"><?php echo form_label('Ingreso sentencia registro','ingreso_sentencia_registro'); ?></td>
						<td width="30%"><?php echo form_input('ingreso_sentencia_registro', utf8_decode($identificacion->ing_sent), 'readonly'); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Recibo de registro','recibo_registro_expropiacion'); ?></td>
						<td><?php echo form_input('recibo_registro_expropiacion', utf8_decode($identificacion->rec_reg_exp), 'readonly'); ?></td>
					</tr>
			</table>
			<?php echo form_fieldset_close(); ?>
			<div class="clear">&nbsp;</div>
			<?php echo form_fieldset('<b>Informaci&oacute;n jur&iacute;dica del predio final</b>'); ?>
			<table style="text-align:'left'">
				<tbody>
					<tr>
						<td width="20%"><?php echo form_label('N&uacute;mero de la matr&iacute;cula','numero_matricula_predio_final'); ?></td>
						<td width="30%"><?php echo form_input('numero_matricula_predio_final', utf8_decode($identificacion->num_matricula_f), 'readonly'); ?></td>
						<td width="20%"><?php echo form_label('Fecha','fecha_predio_final'); ?></td>
						<td width="30%"><?php echo form_input('fecha_predio_final', utf8_decode($identificacion->fecha_esc_f), 'readonly'); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Oficina registro','oficina_registro_predio_final'); ?></td>
						<td><?php echo form_input('oficina_registro_predio_final', utf8_decode($identificacion->of_registro_f), 'readonly'); ?></td>
						<td><?php echo form_label('N&uacute;mero de la notar&iacute;a','numero_notaria_predio_final'); ?></td>
						<td><?php echo form_input('numero_notaria_predio_final', utf8_decode($identificacion->num_notaria_f), 'readonly'); ?></td>
					</tr>
					<tr>
						<td width="30%"><?php echo form_label('Escritura o sentencia','escritura_sentencia'); ?></td>
						<td width="20%"><?php echo form_input('escritura_sentencia', utf8_decode($identificacion->num_escritura_f), 'readonly'); ?></td>
						<td width="30%"><?php echo form_label('N&uacute;mero catastral','numero_catastral_predio_final'); ?></td>
						<td width="20%"><?php echo form_input('numero_catastral_predio_final', utf8_decode($identificacion->num_catastral_f), 'readonly'); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Ciudad','ciudad_predio_final'); ?></td>
						<td><?php echo form_input('ciudad_predio_final', utf8_decode($identificacion->ciudad_f), 'readonly'); ?></td>
					</tr>
				</tbody>
			</table>
			<?php echo form_fieldset_close(); ?>
		</div>
	</div>
	<br />
	<div class="clear">&nbsp;</div>
	<?php
	
		echo form_close();
		echo form_fieldset_close();
	?>
</div>
<script type="text/javascript">
	//este script se ejecuta una vez se haya cargado el documento completamente (cuando el documento este ready)
	$(document).ready(function() 
	{	
		//este script unido con jquery es el encargado de dar el estilo css a las secciones del formulario dinamicamente
		$( "#accordion" ).accordion
		({
			autoHeight: false,
			navigation: true
		});
	});
</script>