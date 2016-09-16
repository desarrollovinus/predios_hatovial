<?php $permisos = $this->session->userdata('permisos'); ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table_jui.css" type="text/css" />
<div id="form">
	<?php 
		echo form_fieldset('<b>Bit&aacute;cora</b>'); 
		
		echo form_label('Ficha predial', 'ficha_predial'); 
		echo '&nbsp;&nbsp;';
		echo form_input('ficha_predial', '', 'id="fichas"');
		echo '&nbsp;&nbsp;';
		$consultar = array(
			'type' => 'button',
			'name' => 'consultar',
			'id' => 'consultar',
			'value' => 'Consultar'
		);
		echo form_input($consultar);
	?>
	<input type="hidden" id="errores-arriba" />
	<div class="clear">&nbsp;</div>
	<input type="hidden" id="ubicacion-tabla" />
	<div id="div-tabla">
		<table style='width:100%' id="tabla">
			<thead>
				<tr>
					<th>Fecha</th>
					<th>Remitente</th>
					<th>T&iacute;tulo</th>
					<th>Observaci&oacute;n</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
	<input type="hidden" id="errores-abajo" />
	<div class="clear">&nbsp;</div>
	<?php 
		if(isset($permisos['Bit&aacute;cora']['Insertar anotaciones'])) {
			$agregar = array(
				'type' => 'button',
				'name' => 'agregar',
				'id' => 'agregar',
				'value' => 'Nueva anotacion'
			);
			echo form_input($agregar);
		}
		echo form_fieldset_close();
	?>
	
<div id="dialog-form" title="Agregar nueva entrada.">
	<?php echo form_fieldset('Todos los datos son requeridos.'); ?>
		<table>
			<tr>
				<td><?php echo form_label('Fecha', 'fecha'); ?></td>
				<td><?php echo form_input('fecha'); ?></td>
				<td><?php echo form_label('Titulo', 'titulo'); ?></td>
				<td><?php echo form_input('titulo'); ?></td>
			</tr>
			<tr>
				<td><?php echo form_label('Remitente', 'remitente'); ?></td>
				<td><?php echo form_input('remitente'); ?></td>
				<td><?php echo form_label('Radicado', 'radicado'); ?></td>
				<td><?php echo form_input('radicado'); ?></td>
			</tr>
			<tr>
				<td colspan="6"><?php echo form_label('Observaci&oacute;n'); ?></td>
			</tr>
			<tr>
				<td colspan="6"><?php echo form_textarea('observacion'); ?></td>
			</tr>
		</table>
	<?php echo form_fieldset_close(); ?>
</div>
<div id="dialog-form-editar" title="Editar entrada.">
	<?php echo form_fieldset('Todos los datos son requeridos.'); ?>
		<?php echo form_hidden('id_bitacora'); ?>
		<table>
			<tr>
				<td><?php echo form_label('Fecha', 'fecha_editar'); ?></td>
				<td><?php echo form_input('fecha_editar'); ?></td>
				<td><?php echo form_label('Titulo', 'titulo_editar'); ?></td>
				<td><?php echo form_input('titulo_editar'); ?></td>
			</tr>
			<tr>
				<td><?php echo form_label('Remitente', 'remitente_editar'); ?></td>
				<td><?php echo form_input('remitente_editar'); ?></td>
				<td><?php echo form_label('Radicado', 'radicado_editar'); ?></td>
				<td><?php echo form_input('radicado_editar'); ?></td>
			</tr>
			<tr>
				<td colspan="6"><?php echo form_label('Observaci&oacute;n'); ?></td>
			</tr>
			<tr>
				<td colspan="6"><?php echo form_textarea('observacion_editar'); ?></td>
			</tr>
		</table>
	<?php echo form_fieldset_close(); ?>
</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.ui.autocomplete.js"></script>
<script type="text/javascript">
	$(document).ready(function(){

		//esta funcion saca la ventana de confirmacion jquery
		function abrir_ventana_dialogo(titulo, mensaje, funcion)
		{
			//en el template hay un div con id="cargando", despues de ese div se agrega otro con id="dialog-confirm"
			$('#cargando').append('<div id="dialog-confirm"></div>');
			//al div que se acaba de crear se le agrega el atributo title="¿Desea borrar este propietario?"
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
		
		function log( message ) {
			$( "<div/>" ).text( message ).prependTo( "#fichas" );
			$( "#fichas" ).scrollTop( 0 );
		}

		$( "#fichas" ).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url: "<?php echo site_url('bitacora_controller/lista_fichas'); ?>",
					dataType: "json",
					data: {
						palabraClave: $( "#fichas" ).val(),
						maxRows: 12
					},
					success: function( data ) {
						response( $.map( data, function( item ) {
							return {
								label: item.ficha_predial,
								value: item.ficha_predial
							}
						}));
					}
				});
			},
			minLength: 2,
			select: function( event, ui ) {
				log( ui.item ?
					"Selected: " + ui.item.label :
					"Nothing selected, input was " + this.value);
				$('#consultar').click();
			},
			open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			},
			close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			}
		});

		// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		$( "#dialog-form-editar" ).dialog({
			autoOpen: false,
			height: 510,
			width: 840,
			modal: true,
			buttons: {
				Editar: function() {
					$('span.error').remove();
					var fecha = $.trim($('#dialog-form-editar input[name=fecha_editar]').val());
					var remitente = $.trim($('#dialog-form-editar input[name=remitente_editar]').val());
					var radicado = $.trim($('#dialog-form-editar input[name=radicado_editar]').val());
					var titulo = $.trim($('#dialog-form-editar input[name=titulo_editar]').val());
					var observacion = $.trim($('#dialog-form-editar textarea[name=observacion_editar]').val());
					var id_bitacora = $.trim($('#dialog-form-editar input[name=id_bitacora]').val());
					var error = false;
					
					if(fecha == '')
					{
						$('#dialog-form-editar input[name=fecha_editar]').after("<span class='error derecha'>&nbsp;<strong>*</strong></span>");
						error = true;
					}

					if(remitente == '')
					{
						$('#dialog-form-editar input[name=remitente_editar]').after("<span class='error derecha'>&nbsp;<strong>*</strong></span>");
						error = true;
					}

					if(titulo == '')
					{
						$('#dialog-form-editar input[name=titulo_editar]').after("<span class='error derecha'>&nbsp;<strong>*</strong></span>");
						error = true;
					}

					if(observacion == '')
					{
						$('#dialog-form-editar textarea[name=observacion_editar]').after("<span class='error derecha'>&nbsp;<strong>*</strong></span>");
						error = true;
					}
					
					if( ! error )
					{
						$.post('<?php echo site_url('bitacora_controller/editar_anotacion'); ?>', { id_bitacora:id_bitacora, fecha:fecha, radicado: radicado, remitente:remitente, titulo:titulo, observacion:observacion, <?php echo $this->security->get_csrf_token_name(); ?>:"<?php echo $this->security->get_csrf_hash(); ?>" },
							function(json)
							{
								if(json.mensaje == 'correcto')
								{
									$('#dialog-form-editar input[type=text]').val('');
									$('#dialog-form-editar textarea[name=observacion_editar]').val('');
									$('#form input[name=consultar]').click();
								}
								else
								{
									$('#errores-abajo').after('<div id="alerta" class="ui-state-highlight ui-corner-all" style="display:none; margin-top: 20px; padding: 0 .7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>' + json.mensaje + '</p></div>');
		                            $('div#alerta').fadeIn('slow');
								}
								$( "#dialog-form-editar" ).dialog( "close" );
							} , 'json'
						);
					}
				},
				Cancelar: function() {
					$('#dialog-form-editar input[type=text]').val('');
					$( this ).dialog( "close" );
				}
			},
			close: function() {
				$('#dialog-form-editar input[type=text]').val('');
			}
		});

		$( "#dialog-form" ).dialog({
			autoOpen: false,
			height: 510,
			width: 840,
			modal: true,
			buttons: {
				Insertar: function() {
					$('span.error').remove();
					var ficha = $.trim($('#form input[name=ficha_predial]').val());
					var fecha = $.trim($('#dialog-form input[name=fecha]').val());
					var remitente = $.trim($('#dialog-form input[name=remitente]').val());
					var titulo = $.trim($('#dialog-form input[name=titulo]').val());
					var observacion = $.trim($('#dialog-form textarea[name=observacion]').val());
					var error = false;

					if(ficha == '')
					{
						$('#form input[name=ficha_predial]').after("<span class='error derecha'>&nbsp;<strong>*</strong></span>");
						error = true;
					}
					if(fecha == '')
					{
						$('#dialog-form input[name=fecha]').after("<span class='error derecha'>&nbsp;<strong>*</strong></span>");
						error = true;
					}

					if(remitente == '')
					{
						$('#dialog-form input[name=remitente]').after("<span class='error derecha'>&nbsp;<strong>*</strong></span>");
						error = true;
					}

					if(titulo == '')
					{
						$('#dialog-form input[name=titulo]').after("<span class='error derecha'>&nbsp;<strong>*</strong></span>");
						error = true;
					}

					if(observacion == '')
					{
						$('#dialog-form textarea[name=observacion]').after("<span class='error derecha'>&nbsp;<strong>*</strong></span>");
						error = true;
					}
					
					if( ! error )
					{
						$.post('<?php echo site_url('bitacora_controller/nueva_entrada'); ?>', { ficha:ficha, fecha:fecha, remitente:remitente, titulo:titulo, observacion:observacion, <?php echo $this->security->get_csrf_token_name(); ?>:"<?php echo $this->security->get_csrf_hash(); ?>" },
							function(msg)
							{
								if(msg == 'correcto')
								{
									$('#dialog-form input[type=text]').val('');
									$('#dialog-form textarea[name=observacion]').val('');
									$('#form input[name=consultar]').click();
								}
								else
								{
									$('#errores-abajo').after('<div id="alerta" class="ui-state-highlight ui-corner-all" style="display:none; margin-top: 20px; padding: 0 .7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>' + msg + '</p></div>');
		                            $('div#alerta').fadeIn('slow');
								}
								$( "#dialog-form" ).dialog( "close" );
							} 
						);
					}
				},
				Cancelar: function() {
					$('#dialog-form input[type=text]').val('');
					$( this ).dialog( "close" );
				}
			},
			close: function() {
				$('#dialog-form input[type=text]').val('');
			}
		});
		
		$('#tabla').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"bDestroy": true
		});

		$('#form input[name=consultar]').click(function(){
			$('span.error').remove();
			$('div#alerta').remove();
			if($.trim($('#form input[name=ficha_predial]').val()) == '')
			{
				$('#errores-arriba').after("<span class='error derecha'>* DEBE INDICAR LA FICHA PREDIAL</span>");
			}
			else
			{
				$.post('<?php echo site_url('bitacora_controller/obtener_bitacora'); ?>', { ficha:$.trim($('#form input[name=ficha_predial]').val()), <?php echo $this->security->get_csrf_token_name(); ?>:"<?php echo $this->security->get_csrf_hash(); ?>" }, 
					function(msg){
						respuesta = msg.split('|');
						if(respuesta[0] == 'correcto')
						{
							$('#div-tabla').remove();
							$('#ubicacion-tabla').after('<div id="div-tabla">' + respuesta[1] + '</div>');
							$('#tabla').dataTable({
								"bJQueryUI": true,
								"sPaginationType": "full_numbers",
								"bDestroy": true
							});
						}
						else
						{
							$('#errores-arriba').after('<div id="alerta" class="ui-state-highlight ui-corner-all" style="display:none; margin-top: 20px; padding: 0 .7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>' + respuesta[0] + '</p></div>');
                            $('div#alerta').fadeIn('slow');
						}
					}
				);
			}
		});

		$('#form input[name=agregar]').click(function(){
			$('span.error').remove();
			$('div#alerta').remove();
			if($.trim($('#form input[name=ficha_predial]').val()) == '')
			{
				$('#errores-abajo').after("<span class='error derecha'>* DEBE INDICAR LA FICHA PREDIAL</span>");
			}
			else
			{
				$.post('<?php echo site_url('bitacora_controller/valida_ficha'); ?>', { ficha: $.trim($('#form input[name=ficha_predial]').val()), <?php echo $this->security->get_csrf_token_name(); ?>:"<?php echo $this->security->get_csrf_hash(); ?>" },
					function(msg)
					{
						if(msg == 'correcto')
						{
							$('#dialog-form').dialog( "open" );
						}
						else
						{
							$('#errores-abajo').after('<div id="alerta" class="ui-state-highlight ui-corner-all" style="display:none; margin-top: 20px; padding: 0 .7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>' + msg + '</p></div>');
                            $('div#alerta').fadeIn('slow');
						}
					}
				);
			}
		});

		$('#form a[title=Eliminar]').live('click', function(event){
			var a = $(this);
			var url = a.attr('href');
			var data = {
				"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",
				"id_bitacora":a.attr('id')
			};
			var success = function(json){
				if(json.mensaje == 'correcto') {
					$('#cargando').html('Entrada eliminada correctamente.');
                    $('#cargando').addClass('correcto');
                    $('#form input[name=consultar]').click();
				}
				else {
					 $("#pass_text").val('');
					 $('#cargando').html('<span class="alerta_icono"></span> Se presentaron errores');
                     $('#cargando').addClass('error');
                     $('#errores-arriba, #errores-abajo').after('<div id="alerta" class="ui-state-highlight ui-corner-all" style="display:none; margin-top: 20px; padding: 0 .7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>' + json.mensaje + '</p></div>');
                     $('div#alerta').fadeIn('slow');
				}
				$('#cargando').delay(2000).fadeOut('slow',function(){
					$(this).removeClass('correcto');
					$(this).removeClass('error');
				});
			};

			abrir_ventana_dialogo('Eliminar anotaci&oacute;n de la bit&aacute;cora', 'Esta seguro(a) de realizar esta acci&oacute;n?', function(){
				$('#cargando').html('Eliminando la entrada, por favor espere...');
				$('#cargando').removeClass('error');
	            $("div#alerta").remove();
	            $("span.error").remove();
				$('#cargando').show();
				$.post(url, data, success, 'json');
			});
			event.preventDefault();
		});

		$('#form a[title=Editar]').live('click', function(event){
			$('span.error').remove();
			$('div#alerta').remove();
			$('#dialog-form-editar').dialog( "open" );
			var tr = $(this).closest('tr');
			
			$('#dialog-form-editar input[name=id_bitacora]').val($(this).attr('id'));

			tr.children('td').each(function(index) {
				switch(index) {
					case 0:{ $('#dialog-form-editar input[name=fecha_editar]').val($(this).text()); }break;
					case 1:{ $('#dialog-form-editar input[name=remitente_editar]').val($(this).text()); }break;
					case 2:{ $('#dialog-form-editar input[name=titulo_editar]').val($(this).text()); }break;
					case 3:{ $('#dialog-form-editar textarea[name=observacion_editar]').val($(this).text()); }break;
					case 4:{ $('#dialog-form-editar input[name=radicado_editar]').val($(this).text()); }break;
				}
			});

			$('#dialog-form-editar input[name=fecha_editar]').focus();
			event.preventDefault();
		});


		

		$('#dialog-form input[name=fecha]').datepicker();
		$('#dialog-form-editar input[name=fecha_editar]').datepicker();
	});
</script>
