<div id="form">
	<?php
		echo form_fieldset('<b>Registro</b>');
		echo form_open('registro_controller/registrar_predio');
		
		echo form_hidden($this->security->get_csrf_token_name(),$this->security->get_csrf_hash());
		echo form_label('Ficha predial:&nbsp;&nbsp;&nbsp;','ficha');
		
		echo form_input('ficha');
		/*
		$verificar_ficha = array(
			'type' => 'button',
			'name' => 'verificar_ficha',
			'id' => 'verificar_ficha',
			'value' => 'Verificar Ficha'
		); 
		echo form_input($verificar_ficha);*/
		
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
						<td width="30%"><?php echo form_input('uso_edificacion');?></td>
						<td width="20%"><?php echo form_label('Estado','estado'); ?></td>
						<td width="30%"><?php echo form_input('estado') ;?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Uso de Terreno','uso_terreno'); ?></td>
						<td width="30%"><?php echo form_input('uso_terreno');?></td>
						<td width="20%"><?php echo form_label('Tipo de Tenencia','tipo_tenencia'); ?></td>
						<td width="30%"><?php echo form_input('tipo_tenencia'); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Topografia','topografia'); ?></td>
						<td width="30%"><?php echo form_input('topografia');?></td>
						<td width="20%"><?php echo form_label('Via de Acceso','via_acceso'); ?></td>
						<td width="30%"><?php echo form_input('via_acceso'); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Servicios P&uacute;blicos','servicios_publicos'); ?></td>
						<td width="30%"><?php echo form_dropdown('servicios_publicos', array(' ' => ' ', 'Si' => 'S&iacute;','No' => 'No')); ?></td>
						<td width="20%"><?php echo form_label('Nacimiento de Agua','nacimiento_agua'); ?></td>
						<td width="30%"><?php echo form_dropdown('nacimiento_agua', array(' ' => ' ', 'Si' => 'S&iacute;','No' => 'No')); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('&Aacute;rea Total','area_total'); ?></td>
						<td width="30%"><?php echo form_input('area_total'); ?>m&sup2;</td>
						<td width="20%"><?php echo form_label('&Aacute;rea Requerida','area_requerida'); ?></td>
						<td width="30%"><?php echo form_input('area_requerida'); ?>m&sup2;</td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('&Aacute;rea Residual','area_residual'); ?></td>
						<td width="30%"><?php echo form_input('area_residual'); ?>m&sup2;</td>
						<td width="20%"><?php echo form_label('&Aacute;rea Construida','area_construida'); ?></td>
						<td width="30%"><?php echo form_input('area_construida'); ?>m&sup2;</td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('&Aacute;rea Const. Requerida','area_const_requerida'); ?></td>
						<td width="30%"><?php echo form_input('area_const_requerida'); ?>m&sup2;</td>
						<td width="20%"><?php echo form_label('Abscisa Inicial','abscisa_inicial'); ?></td>
						<td width="30%"><?php echo form_input('abscisa_inicial'); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Abscisa Final','abscisa_final'); ?></td>
						<td width="30%"><?php echo form_input('abscisa_final'); ?></td>
						<td width="20%"><?php echo form_label('Estado del Proceso','estado_proceso'); ?></td>
						<?php 
							$estado_proceso = array(' ' => ' ');
							foreach($estados as $estado):
								$estado_proceso[$estado->estado] = $estado->estado;
							endforeach; 
						?>
						<td width="30%"><?php echo form_dropdown('estado_proceso', $estado_proceso); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Entregado','entregado'); ?></td>
						<td width="30%"><?php echo form_dropdown('entregado', array(' ' => ' ', 'SI' => 'S&iacute;','NO' => 'No')); ?></td>
						<td width="20%"><?php echo form_label('Fecha Entregado','fecha_entregado'); ?></td>
						<td width="30%"><?php echo form_input('fecha_entregado'); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Radicado','radicado'); ?></td>
						<td width="30%"><?php echo form_input('radicado'); ?></td>
						<td width="20%"><?php echo form_label('Requerido','requerido'); ?></td>
						<td width="30%"><?php echo form_dropdown('requerido', array(1 => 'S&iacute;', 0 => 'No')); ?></td>
					</tr>
				</tbody>
			</table>
			<div align="center">
				<?php echo form_label('Observaci&oacute;n','observacion')?><br>
				<?php echo form_textarea('observacion');?>
			</div>
			<?php echo form_fieldset_close(); ?>
		</div>
		
		
		<!-- seccion 2 -->
		
		
		<h3><a href="#seccion2">IDENTIFICACI&Oacute;N DEL PREDIO ORIGINAL</a></h3>
		<div>
			<input type="hidden" name="propietarios_hidden" id="propietarios_hidden" value="0" />
			<?php echo form_label('No. de propietarios:', 'agregar')?>
			<?php echo form_input('agregar'); ?>
			<?php
				$boton_agregar = array(
					'type' => 'button',
					'name' => 'boton_agregar',
					'id' => 'boton_agregar',
					'value' => 'Agregar'
				); 
				echo form_input($boton_agregar);
			?>
			<div class="clear">&nbsp;</div>
			<?php echo form_fieldset('<b>Identificaci&oacute;n del predio</b>'); ?>
			<table style="text-align:'left'">
				<tbody>
					<tr>
						<td width="20%"><?php echo form_label('Municipio','municipio'); ?></td>
						<td width="30%"><?php echo form_input('municipio'); ?></td>
						<td width="20%"><?php echo form_label('Vereda o Barrio','vereda_barrio'); ?></td>
						<td width="30%"><?php echo form_input('vereda_barrio'); ?></td>
					</tr>
					<tr>					
						<td width="30%"><?php echo form_label('Direcci&oacute;n / Nombre','direccion_nombre'); ?></td>
						<td width="20%"><?php echo form_input('direccion_nombre'); ?></td>
						<td width="30%"><?php echo form_label('Tramo','tramo'); ?></td>
						<?php
							$_tramos = array(' ' => ' ');
							foreach($tramos as $tramo):
								$_tramos[$tramo->tramo] = $tramo->tramo;
							endforeach;
						?>
						<td width="20%"><?php echo form_dropdown('tramo', $_tramos)?></td>
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
						<td width="30%"><?php echo form_input('numero_matricula_predio_inicial'); ?></td>
						<td width="20%"><?php echo form_label('Fecha','fecha_predio_inicial'); ?></td>
						<td width="30%"><?php echo form_input('fecha_predio_inicial'); ?></td>
					</tr>
					<tr>					
						<td><?php echo form_label('Oficina registro','oficina_registro_predio_inicial'); ?></td>
						<td><?php echo form_input('oficina_registro_predio_inicial'); ?></td>
						<td><?php echo form_label('N&uacute;mero de la notar&iacute;a','numero_notaria_predio_inicial'); ?></td>
						<td><?php echo form_input('numero_notaria_predio_inicial')?></td>
					</tr>
					<tr>
						<td width="30%"><?php echo form_label('N&uacute;mero de escritura','numero_escritura'); ?></td>
						<td width="20%"><?php echo form_input('numero_escritura'); ?></td>
						<td width="30%"><?php echo form_label('N&uacute;mero catastral','numero_catastral_predio_inicial'); ?></td>
						<td width="20%"><?php echo form_input('numero_catastral_predio_inicial'); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Ciudad','ciudad_predio_inicial'); ?></td>
						<td><?php echo form_input('ciudad_predio_inicial'); ?></td>
					</tr>
				</tbody>
			</table>
			<?php echo form_fieldset_close(); ?>
		</div>
		
		
		<!-- seccion 3 -->
		
		
		<h3><a href="#seccion3">ESTUDIO DE T&Iacute;TULOS</a></h3>
		<div>
			<?php echo form_fieldset('<b>T&iacute;tulos de adquisici&oacute;n</b>'); ?>
			<div align="center"><?php echo form_textarea('titulos_adquisicion'); ?></div>
			<?php echo form_fieldset_close(); ?>
			<?php echo form_fieldset('<b>Linderos seg&uacute;n t&iacute;tulo</b>'); ?>
			<div align="center"><?php echo form_textarea('linderos_segun_titulo'); ?></div>
			<?php echo form_fieldset_close(); ?>
			<?php echo form_fieldset('<b>Linderos predio requerido</b>'); ?>
			<div align="center"><?php echo form_textarea('linderos_predio_requerido'); ?></div>
			<?php echo form_fieldset_close(); ?>
			<?php echo form_fieldset('<b>Grav&aacute;menes - Limitaciones</b>'); ?>
			<div align="center"><?php echo form_textarea('gravamenes_limitaciones'); ?></div>
			<?php echo form_fieldset_close(); ?>
			<?php echo form_fieldset('<b>Documentos estudiados</b>'); ?>
			<div align="center"><?php echo form_textarea('documentos_estudiados'); ?></div>
			<?php echo form_fieldset_close(); ?>
			<?php echo form_fieldset('<b>Observaciones estudio de t&iacute;tulos</b>'); ?>
			<div align="center"><?php echo form_textarea('observaciones_estudio_titulos'); ?></div>
			<?php echo form_fieldset_close(); ?>
			<?php echo form_fieldset('<b>Concepto</b>'); ?>
			<div align="center"><?php echo form_textarea('concepto'); ?></div>
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
						<td width="20%"><?php echo form_input('inicio_trabajo_fisico'); ?></td>
						<?php
							$_contratistas = array(' ' => ' ');
							foreach($contratistas as $contratista):
								$_contratistas[$contratista->id_cont] = $contratista->nombre;
							endforeach; 
						?>
						<td width="30%"><?php echo form_label('Encargado gesti&oacute;n predial','encargado_gestion_predial'); ?></td>
						<td width="20%"><?php echo form_dropdown('encargado_gestion_predial',$_contratistas); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Entrega del plano a interventor&iacute;a','entrega_plano_interventoria'); ?></td>
						<td><?php echo form_input('entrega_plano_interventoria'); ?></td>
						<td><?php echo form_label('Radicado entrega interventor&iacute;a','radicado_entrega_interventoria'); ?></td>
						<td><?php echo form_input('radicado_entrega_interventoria'); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Aprobaci&oacute;n definitiva del plano','aprobacion_definitiva_plano'); ?></td>
						<td><?php echo form_input('aprobacion_definitiva_plano'); ?></td>
						<td><?php echo form_label('Radicado aprobaci&oacute;n plano','radicado_aprobacion_plano'); ?></td>
						<td><?php echo form_input('radicado_aprobacion_plano'); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Notificaci&oacute;n propietario','notificacion_propietario'); ?></td>
						<td width="30%"><?php echo form_input('notificacion_propietario'); ?></td>
						<td width="20%"><?php echo form_label('Radicado notificaci&oacute;n propietario','radicado_notificacion_propietario'); ?></td>
						<td width="30%"><?php echo form_input('radicado_notificacion_propietario'); ?></td>
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
						<td width="20%"><?php echo form_input('total_avaluo'); ?></td>
						<td width="30%"><?php echo form_label('Valor total de mejoras','valor_total_mejoras'); ?></td>
						<td width="20%"><?php echo form_input('valor_total_mejoras'); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Valor metro cuadrado','valor_metro_cuadrado'); ?></td>
						<td><?php echo form_input('valor_metro_cuadrado'); ?></td>
						<td><?php echo form_label('Valor total del terreno','valor_total_terreno'); ?></td>
						<td><?php echo form_input('valor_total_terreno'); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Env&iacute;o al avaluador','envio_avaluador'); ?></td>
						<td width="30%"><?php echo form_input('envio_avaluador'); ?></td>
						<td width="20%"><?php echo form_label('Radicado env&iacute;o avaluador','radicado_envio_avaluador'); ?></td>
						<td width="30%"><?php echo form_input('radicado_envio_avaluador'); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Fecha del aval&uacute;o','recibo_avaluo'); ?></td>
						<td><?php echo form_input('recibo_avaluo'); ?></td>
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
						<td width="20%"><?php echo form_input('envio_interventoria'); ?></td>
						<td width="30%"><?php echo form_label('Radicado env&iacute;o a interventor&iacute;a','radicado_envio_interventoria'); ?></td>
						<td width="20%"><?php echo form_input('radicado_envio_interventoria'); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Env&iacute;o a la gerencia para firmar','envio_gerencia_firmar'); ?></td>
						<td width="30%"><?php echo form_input('envio_gerencia_firmar'); ?></td>
						<td width="20%"><?php echo form_label('Radicado env&iacute;o a gerencia','radicado_envio_gerencia'); ?></td>
						<td width="30%"><?php echo form_input('radicado_envio_gerencia'); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Recibo para la notificaci&oacute;n al propietario','recibo_notificacion_propietario'); ?></td>
						<td><?php echo form_input('recibo_notificacion_propietario'); ?></td>
					</tr>
			</table>
			<?php echo form_fieldset_close(); ?>
			<div class="clear">&nbsp;</div>			
			<?php echo form_fieldset('<b>Enajenaci&oacute;n voluntaria</b>'); ?>
			<table style="text-align:'left'">
				<tbody>
					<tr>
						<td width="30%"><?php echo form_label('Env&iacute;o escritura a notar&iacute;a','envio_escritura_notaria'); ?></td>
						<td width="20%"><?php echo form_input('envio_escritura_notaria'); ?></td>
						<td width="30%"><?php echo form_label('Ingreso escritura','ingreso_escritura'); ?></td>
						<td width="20%"><?php echo form_input('ingreso_escritura'); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Recibo de registro','recibo_registro_enajenacion'); ?></td>
						<td width="30%"><?php echo form_input('recibo_registro_enajenacion'); ?></td>
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
						<td width="20%"><?php echo form_input('notificacion'); ?></td>
						<td width="30%"><?php echo form_label('Inicio juicio','inicio_juicio'); ?></td>
						<td width="20%"><?php echo form_input('inicio_juicio'); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Inicio Sentencia','inicio_sentencia'); ?></td>
						<td width="30%"><?php echo form_input('inicio_sentencia'); ?></td>
						<td width="20%"><?php echo form_label('Ingreso sentencia registro','ingreso_sentencia_registro'); ?></td>
						<td width="30%"><?php echo form_input('ingreso_sentencia_registro'); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Recibo de registro','recibo_registro_expropiacion'); ?></td>
						<td><?php echo form_input('recibo_registro_expropiacion'); ?></td>
					</tr>
			</table>
			<?php echo form_fieldset_close(); ?>
			<div class="clear">&nbsp;</div>
			<?php echo form_fieldset('<b>Informaci&oacute;n jur&iacute;dica del predio final</b>'); ?>
			<table style="text-align:'left'">
				<tbody>
					<tr>
						<td width="20%"><?php echo form_label('N&uacute;mero de la matr&iacute;cula','numero_matricula_predio_final'); ?></td>
						<td width="30%"><?php echo form_input('numero_matricula_predio_final'); ?></td>
						<td width="20%"><?php echo form_label('Fecha','fecha_predio_final'); ?></td>
						<td width="30%"><?php echo form_input('fecha_predio_final'); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Oficina registro','oficina_registro_predio_final'); ?></td>
						<td><?php echo form_input('oficina_registro_predio_final'); ?></td>
						<td><?php echo form_label('N&uacute;mero de la notar&iacute;a','numero_notaria_predio_final'); ?></td>
						<td><?php echo form_input('numero_notaria_predio_final'); ?></td>
					</tr>
					<tr>
						<td width="30%"><?php echo form_label('Escritura o sentencia','escritura_sentencia'); ?></td>
						<td width="20%"><?php echo form_input('escritura_sentencia'); ?></td>
						<td width="30%"><?php echo form_label('N&uacute;mero catastral','numero_catastral_predio_final'); ?></td>
						<td width="20%"><?php echo form_input('numero_catastral_predio_final'); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Ciudad','ciudad_predio_final'); ?></td>
						<td><?php echo form_input('ciudad_predio_final'); ?></td>
					</tr>
				</tbody>
			</table>
			<?php echo form_fieldset_close(); ?>
		</div>
	</div>
	<br /><input type="hidden" id="errores" />
	<div class="clear">&nbsp;</div>
	<input type="hidden" id="boton_hidden" name="boton_hidden" value="" />
	<?php 		
		$guardar = array(
			'type' => 'button',
			'name' => 'guardar',
			'id' => 'guardar',
			'value' => 'Guardar y salir'
		);
		echo form_input($guardar);
		
		$salir = array(
			'type' => 'button',
			'name' => 'salir',
			'id' => 'salir',
			'value' => 'Cancelar y volver'
		);
		echo form_input($salir);
	
		echo form_close();
		echo form_fieldset_close();
	?>
	
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	//este script se ejecuta una vez se haya cargado el documento completamente (cuando el documento este ready)
	$(document).ready(function() 
	{
		//esta funcion determina si hay un punto en una tira de caracteres
		function hay_punto(string)
		{
			//si no esta vacio
			if(string.length > 0)
			{
				//se obtiene un array de caracteres
				array = string.split('');
				//se examina cada caracter
				for(var i = 0; i < array.length; i++)
				{
					//si es un punto
					if(array[i] == '.')
					{
						return true;
					}
				}
			}
			return false;
		}

		//esta funcion verifica si todos los documentos de los propietarios estan diligenciados
		function hay_documentos_propietarios_vacios()
		{
			('#form input[name^=documento_propietario]').each(function(){
				if($(this).val() == '')
				{
					return true;
				}
			});
			return false;
		}

		//esta funcion saca la ventana de confirmacion jquery
		function abrir_ventana_dialogo(titulo, mensaje, funcion)
		{
			//en el template hay un div con id="cargando", despues de ese div se agrega otro con id="dialog-confirm"
			$('#cargando').append('<div id="dialog-confirm"></div>');
			//al div que se acaba de crear se le agrega el atributo title="�Desea borrar este propietario?"
			$('#dialog-confirm').attr('title', titulo);
			//tambien se le agrega el siguiente codigo html entre sus tags de inicio y final
			$('#dialog-confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>' + mensaje + '</p>');
			//se le da formato con la libreria de jquery y se muestra con las opciones siguientes
			$( "#dialog-confirm" ).dialog({
				resizable: false,
				height:200,
				width:420,
				modal: true,
				buttons: {
					Si: function() {
						funcion();
						//se destruye el elemento dialog
						$( "#dialog:ui-dialog" ).dialog( "destroy" );
						//se remueve el div con id="dialog-confirm" del documento html
						$('#dialog-confirm').remove();
						//se cierra el elemento flotante
						$( this ).dialog( "close" );
					},
					No: function() {
						//se destruye el elemento dialog
						$( "#dialog:ui-dialog" ).dialog( "destroy" );
						//se remueve el div con id="dialog-confirm" del documento html
						$('#dialog-confirm').remove();
						//se cierra el elemento flotante
						$( this ).dialog( "close" );
					}
				}
			});
		}

		//esta funcion saca la ventana de alerta jquery
		function abrir_ventana_alerta(titulo, mensaje, funcion)
		{
			//en el template hay un div con id="cargando", despues de ese div se agrega otro con id="dialog-confirm"
			$('#cargando').append('<div id="dialog-message"></div>');
			//al div que se acaba de crear se le agrega el atributo title="�Desea borrar este propietario?"
			$('#dialog-message').attr('title', titulo);
			//tambien se le agrega el siguiente codigo html entre sus tags de inicio y final
			$('#dialog-message').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>' + mensaje + '</p>');
			//se le da formato con la libreria de jquery y se muestra con las opciones siguientes
			$( "#dialog-message" ).dialog({
				resizable: false,
				height:200,
				width:420,
				modal: true,
				buttons: {
					Ok: function() {
						//se destruye el elemento dialog
						$( "#dialog:ui-dialog" ).dialog( "destroy" );
						//se remueve el div con id="dialog-confirm" del documento html
						$('#dialog-message').remove();
						//se cierra el elemento flotante
						$( this ).dialog( "close" );
						//se ejecuta la funcion pasada por parametro
						funcion();
					}
				}
			});
		}
		
		//este script unido con jquery es el encargado de dar el estilo css a las secciones del formulario dinamicamente
		$( "#accordion" ).accordion
		({
			autoHeight: false,
			navigation: true
		});

		//este script unido con jquery es el encargado de dar el estilo css a la tabla de pagos
		oTable = $('#form table[id=pagos]').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers"
		});
		
		//este script se encarga de verificar que estos campos sean de tipo double
		$('#form input[name^=area], #form input[name^=total], #form input[name^=valor]').keypress(function(event){
			//48 es el codigo del caracter 0
			//57 es el codigo del caracter 9
			//46 es el codigo del caracter .
			//8  es el codigo del backspace
			//0  es el codigo de los caracteres no alfanum�ricos y de puntuacion

			//si es un caracter no numerico
			if (event.which != 0 && event.which != 8 && (event.which < 48 || event.which > 57)) {
				//si es un punto
				if(event.which == 46){
					//si hay punto en lo que se ha ingresado hasta ahora
					if (hay_punto($(this).val()))
					{
						//se cancela el evento
						event.preventDefault();
					}
				}
				//si no es un punto se cancela el evento
				else
				{
					event.preventDefault();
				}
			}
		});
		
		//este script se encarga de desplegar el calendario en cada uno de los elementos especificados
		$('#form input[name^=fecha], #form input[name=inicio_trabajo_fisico], ' +
				'#form input[name=entrega_plano_interventoria], #form input[name=aprobacion_definitiva_plano], ' +
				'#form input[name=notificacion_propietario], #form input[name=envio_avaluador], #form input[name=recibo_avaluo], ' +
				'#form input[name=envio_interventoria], #form input[name=envio_gerencia_firmar], #form input[name=recibo_notificacion_propietario], ' +
				'#form input[name=envio_escritura_notaria], #form input[name=ingreso_escritura], #form input[name^=recibo_registro], ' +
				'#form input[name=notificacion], #form input[name=inicio_juicio], #form input[name=inicio_sentencia], ' +
				'#form input[name=ingreso_sentencia_registro]').datepicker();
		
		//este script se encarga de validar la entrada de un numero entero para la adicion de propietarios
		$('#form input[name=agregar]').keypress(function(event){
			//48 es el codigo del caracter 0
			//57 es el codigo del caracter 9
			//8  es el codigo del backspace
			//0  es el codigo de los caracteres no alfanum�ricos y de puntuacion

			//si es un caracter no numerico
			if (event.which != 0 && event.which != 8 && (event.which < 48 || event.which > 57)) {
				//se cancela el evento
				event.preventDefault();
			}
		});
		
		//se encarga de adicionar los propietarios
		$('#boton_agregar').click(function(){
			//obtengo la cantidad de propietarios a insertar
			var propietarios_nuevos = parseInt($('#form input[name=agregar]').val());
			//obtengo la cantidad de propietarios que ya se insertaron
			var propietarios_existentes = parseInt($('#form input[name=propietarios_hidden]').val());
			//si no se ingreso nada o se ingreso un 0
			if(propietarios_nuevos == "" || propietarios_nuevos == 0)
			{
				//no haga nada
				return false;
			}
			//esta forma de realizar el ciclo es para garantizar ids independientes para luego poder borrarlas mas facil
			for(var i = propietarios_existentes + 1; i <= propietarios_existentes + propietarios_nuevos; i++)
			{
				//creo la tabla correspondiente a ese propietario
				var propietario = '<fieldset id="' + i + '"><legend><b>Identificaci&oacute;n del propietario ' + i + '</b></legend><table style="text-align:left"><tbody><tr><td width="20%"><label for="tipo_documento' + i + '">Tipo documento</label></td><td width="30%"><select name="tipo_documento' + i + '"><option value=""></option><option value="Cedula">CC</option><option value="Nit">Nit</option></select></td><td width="20%"><label for="propietario' + i + '">Propietario</label></td><td width="30%"><input type="text" value="" name="propietario' + i + '"></td></tr><tr><td width="20%"><label for="documento_propietario' + i + '">Documento</label></td><td width="30%"><input type="text" value="" name="documento_propietario' + i + '"></td><td width="20%"><label for="telefono' + i + '">Tel&eacute;fono</label></td><td width="30%"><input type="text" value="" name="telefono' + i + '"></td></tr><tr><td width="20%"><label for="participacion' + i + '">Participaci&oacute;n</label></td><td width="30%"><input type="text" value="" name="participacion' + i + '">%</td><td><input type="button" name="boton_eliminar' + i + '" value="Eliminar propietario" id="boton_eliminar' + i + '"></td></tr></tbody></table></fieldset>';
				//la inserto antes del input propietarios_hidden
				$('#form input[name=propietarios_hidden]').before(propietario);
				//actualizo el valor de propietarios_hidden
				$('#form input[name=propietarios_hidden]').val(parseInt($('#form input[name=propietarios_hidden]').val()) + 1);
			}
			//le pongo estilo a los botones de eliminacion. name^=boton_eliminar quiere decir: todos los input que su nombre empiece con boton_eliminar
			$('#form input[name^=boton_eliminar]').button();
		});

		//este script se encarga de agregar el evento clic a cada boton creado dinamicamente - en vivo (live)
		$('#form input[name^=boton_eliminar]').live('click', function(event){
			//se obtiene la id del elemento DOM que genera el evento
			var idDOM = event.target.id;
			//se crea un array de palabras usando como token la palabra: boton_eliminar ej: boton_eliminar3--> array[ , 3]
			var arrayLetras = idDOM.split('boton_eliminar');
			//se saca aparte la posicion donde se encuentra la id del fieldset que contiene todos los datos del propietario
			var propietario = arrayLetras[1];
			//se invoca la ventana de dialogo jquery y se le pasa la funcion que debe ejecutar en caso de que el usuario acepte
			abrir_ventana_dialogo(
				'�Desea borrar este propietario?', 
				'Los datos del propietario ' + propietario + ' ser&aacute;n borrados definitivamente. �Desea confirmar esta acci&oacute;n?', 
				function(){
					//se borra el fieldset seleccionado dando un efecto animado de desaparicion en medio segundo
					$('#form fieldset[id=' + propietario + ']').delay(500).fadeOut('slow',function(){
						//se remueve el fieldset del formulario con todos sus campos
						$('#form fieldset[id=' + propietario + ']').remove();
					});
				}
			);
		});

		//este script se encarga de agregar el evento keypress a cada input creado dinamicamente - en vivo (live)
		$('#form input[name^=documento_propietario]').live('keypress',function(event){
			//48 es el codigo del caracter 0
			//57 es el codigo del caracter 9
			//46 es el codigo del caracter .
			
			//si es un caracter no numerico y distinto del punto
			if((event.which < 48 || event.which > 57) && event.which != 46)
			{
				event.preventDefault();
			}
		});

		//este script se encarga de verificar que estos campos generados dinamicamente sean de tipo double
		$('#form input[name^=participacion]').live('keypress',function(event){
			//48 es el codigo del caracter 0
			//57 es el codigo del caracter 9
			//46 es el codigo del caracter .
			//8  es el codigo del backspace
			//0  es el codigo de los caracteres no alfanum�ricos y de puntuacion

			//si es un caracter no numerico
			if (event.which != 0 && event.which != 8 && (event.which < 48 || event.which > 57)) {
				//si es un punto
				if(event.which == 46){
					//si hay punto en lo que se ha ingresado hasta ahora
					if (hay_punto($(this).val()))
					{
						//se cancela el evento
						event.preventDefault();
					}
				}
				//si no es un punto se cancela el evento
				else
				{
					event.preventDefault();
				}
			}
		});

		//este script genera el evento clic del boton Guardar y Salir
		$('#form input[name=guardar], #form input[name=bitacora]').click(function(){
			$('#form input[name=boton_hidden]').val($(this).attr('id'));
			//se verifica que la ficha se haya ingresado
			if($('#form input[name=ficha]').val() == "")
			{
				abrir_ventana_alerta(
					'Ficha predial',
					'No ha ingresado la ficha predial.', 
					function(){
						$('#form input[name=ficha]').scrollTo('slow');
					}
				);
				return false;
			}

			//se verifica que se haya seleccionado un estado del proceso
			if($('#form select[name=estado_proceso]').val() == " ")
			{
				abrir_ventana_alerta(
					'Estado del proceso',
					'Indique el estado actual del proceso.', 
					function(){
						$('#form a[href=#seccion1]').click();
						$('#form select[name=estado_proceso]').scrollTo('slow');
					}
				);
				return false;
			}

			//se obtiene la cantidad de propietarios adicionados
			var nro_propietarios = $('#form input[name=propietarios_hidden]').val();
			//se recorren los controles de los propietarios
			for(var i = 1; i <= nro_propietarios; i++)
			{
				//se verifica que el contro asociado existe
				if($('#form input[name=documento_propietario' + i + ']').length > 0)
				{
					//se verifica que se haya ingresado el documento del propietario
					if($('#form input[name=documento_propietario' + i + ']').val() == "")
					{
						abrir_ventana_alerta(
							'Documento del propietario',
							'Ingrese el documento del propietario ' + i + '.', 
							function(){
								$('#form a[href=#seccion2]').click();
								$('#form input[name=documento_propietario' + i + ']').scrollTo('slow');
							}
						);
						return false;
					}
				}
			}

			//se envia el formulario, previa pregunta del deseo de hacerlo
			abrir_ventana_dialogo(
					'Confirmar registro', 
					'Desea confirmar el ingreso de este registro?', 
					function(){
						$('#form form').submit();
					}
				);
		});

		//si dan clic en el boton salir sin guardar
		$('#form input[name=salir]').click(function(){
			history.back();
		});

		//como los datos a enviar son demasiados, se opta por usar una libreria de jquery que se encarga
		//de serializar todos los campos y los manda por POST via ajax
		var opciones = {
                beforeSubmit: function()
                {
					$('#cargando').html('Enviando la informaci&oacute;n Por favor espere');
					$('#cargando').removeClass('error');
		            $("div#alerta").remove();
		            $("span.error").remove();
					$('#cargando').show();
                },
                success: function(msg)
                {
                	if(msg == "correcto")
					{
						$('#cargando').html('Los datos se guardaron correctamente. Redireccionando...');
                        $('#cargando').addClass('correcto');
                        location.href = '<?php echo base_url(); ?>';
					}
					else
					{
						 $("#pass_text").val('');
						 $('#cargando').html('<span class="alerta_icono"></span> Se presentaron errores');
                         $('#cargando').addClass('error');
                         $('#errores').after('<div id="alerta" class="ui-state-highlight ui-corner-all" style="display:none; margin-top: 20px; padding: 0 .7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>' + msg + '</p></div>');
                         $('div#alerta').fadeIn('slow');
					}
					$('#cargando').delay(2000).fadeOut('slow',function(){
						$(this).removeClass('correcto');
						$(this).removeClass('error');
					});
                }
		};

		//aqui se intercepta el evento submit y se ejecutan las funciones pasadas por parametro al ajaxForm
		$('#form form').ajaxForm(opciones);
	});
</script>
