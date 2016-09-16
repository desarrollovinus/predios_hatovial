<link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table_jui.css" type="text/css" />
<div id="form">
	<?php 
		echo form_fieldset('<b>Gesti&oacute;n de pagos</b>'); 
		
		echo form_label('Ficha predial', 'ficha_predial'); 
		echo '&nbsp;&nbsp;';
		
		if (isset($ficha_predial)) {
			echo form_input('ficha_predial', utf8_decode($ficha_predial), 'readonly'); 
		}
		else {
			echo form_input('ficha_predial', '', 'id="fichas"');
		}
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
	<table width="100%">
		<tr>
			<td><?php echo form_label('Valor del predio', 'valor_predio'); ?></td>
			<td>
				<?php 
					if(isset($valor_predio)) {
						echo form_input('valor_predio', $valor_predio, 'readonly');
					} else {
						echo form_input('valor_predio');
					} 
				?>
			</td>
			<td><?php echo form_label('Total pagado', 'total_pagado'); ?></td>
			<td>
				<?php 
					if(isset($total_pagado)) {
						echo form_input('total_pagado', $total_pagado, 'readonly');
					} else {
						echo form_input('total_pagado');
					} 
				?>
			</td>
			<td><?php echo form_label('Porcentaje pagado', 'porcentaje_pagado'); ?></td>
			<td>
				<?php
					if(isset($porcentaje_pagado)) {
						echo form_input('porcentaje_pagado', $porcentaje_pagado, 'readonly');
					} else {
						echo form_input('porcentaje_pagado');
					}  
				?>%
			</td>
		</tr>
	</table>
	<div class="clear">&nbsp;</div>
	<input type="hidden" id="ubicacion-tabla" />
	<div id="div-tabla">
		<?php 
			if(isset($tabla)) { 
				echo $tabla; 
			}
			else { 
		?>
			<table width="100%" id="tabla">
				<thead>
					<tr>
						<th>N&uacute;mero de pago</th>
						<th>Fecha</th>
						<th>Documento de pago</th>
						<th>Valor</th>
						<?php if($tipo_usuario == 2): ?>
							<th>&nbsp;</th>
						<?php endif;?>
					</tr>
				</thead>
					<tbody></tbody>
			</table>
		<?php }	?>
	</div>
	<input type="hidden" id="errores-abajo" />
	<div class="clear">&nbsp;</div>
	<?php 
		$agregar = array(
			'type' => 'button',
			'name' => 'agregar',
			'id' => 'agregar',
			'value' => 'Agregar nuevo registro de pago'
		);
		echo form_input($agregar);
		echo form_fieldset_close(); 
	?>
	
<div id="dialog-form" title="Agregar nuevo registro de pago">
	<?php echo form_fieldset('Todos los datos son requeridos.'); ?>
		<table>
			<tr>
				<td><?php echo form_label('Fecha', 'fecha'); ?></td>
				<td><?php echo form_input('fecha'); ?></td>
			</tr>
			<tr>
				<td><?php echo form_label('Documento de pago', 'documento_pago'); ?></td>
				<td><?php echo form_input('documento_pago'); ?></td>
			</tr>
			<tr>
				<td><?php echo form_label('Valor', 'valor'); ?></td>
				<td><?php echo form_input('valor'); ?></td>
			</tr>
		</table>
	<?php echo form_fieldset_close(); ?>
</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.ui.autocomplete.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#form a").live("click", function(){
			var form_data = {
				"ajax":"1"
			};
			var url = $(this).attr("href");

			$.getJSON(
				url,
				form_data,
				function(json) {
					if(json.resultado == "correcto") {
						$("#form input[name=consultar]").click();
					}
					else {
						$('#errores-arriba').after('<div id="alerta" class="ui-state-highlight ui-corner-all" style="display:none; margin-top: 20px; padding: 0 .7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>' + msg + '</p></div>');
					}
				}
			);
			return false;
		});
		
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
				
				
			},
			open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			},
			close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			}
		});

		//esta funcion determina si hay un punto en una tira de caracteres
		function hay_punto(string)
		{
			//si no esta vacio
			if(string.length > 0)
			{
				//se obtiene un array de caracteres
				array = string.split('');
				//se examina cada caracter
				for(i = 0; i < array.length; i++)
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

		// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		$( "#dialog-form" ).dialog({
			autoOpen: false,
			height: 340,
			width: 450,
			modal: true,
			buttons: {
				Insertar: function() {
					$('span.error').remove();
					var ficha = $.trim($('#form input[name=ficha_predial]').val());
					var fecha = $.trim($('#dialog-form input[name=fecha]').val());
					var documento = $.trim($('#dialog-form input[name=documento_pago]').val());
					var valor = $.trim($('#dialog-form input[name=valor]').val());
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

					if(documento == '')
					{
						$('#dialog-form input[name=documento_pago]').after("<span class='error derecha'>&nbsp;<strong>*</strong></span>");
						error = true;
					}

					if(valor == '')
					{
						$('#dialog-form input[name=valor]').after("<span class='error derecha'>&nbsp;<strong>*</strong></span>");
						error = true;
					}
					if( ! error )
					{
						$.post('<?php echo site_url('pagos_controller/nuevo_pago'); ?>', { ficha:ficha, fecha:fecha, documento:documento, valor:valor, <?php echo $this->security->get_csrf_token_name(); ?>:"<?php echo $this->security->get_csrf_hash(); ?>" },
							function(msg)
							{
								if(msg == 'correcto')
								{
									$('#dialog-form input[type=text]').val('');
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
				var form_data = { 
					"ficha":$.trim($('#form input[name=ficha_predial]').val()), 
					"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>" 
				};
				$.ajax({
					data: form_data,
					type: "POST",
					dataType: "json",
					url: "<?php echo site_url('pagos_controller/obtener_pagos'); ?>", 
					success:function(respuesta_json){
						//respuesta_json = eval(msg);
						if(respuesta_json.resultado == 'correcto')
						{
							$('#div-tabla').remove();
							$('#ubicacion-tabla').after('<div id="div-tabla">' + respuesta_json.tabla + '</div>');
							$('#tabla').dataTable({
								"bJQueryUI": true,
								"sPaginationType": "full_numbers",
								"bDestroy": true
							});
							$('#form input[name=valor_predio]').val(respuesta_json.valor_predio);
							$('#form input[name=total_pagado]').val(respuesta_json.total_pagado);
							$('#form input[name=porcentaje_pagado]').val(respuesta_json.porcentaje_pagado);
						}
						else
						{
							$('#errores-arriba').after('<div id="alerta" class="ui-state-highlight ui-corner-all" style="display:none; margin-top: 20px; padding: 0 .7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>' + respuesta_json.resultado + '</p></div>');
                            $('div#alerta').fadeIn('slow');
						}
					}
				});
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
				$.post('<?php echo site_url('pagos_controller/valida_ficha'); ?>', { ficha: $.trim($('#form input[name=ficha_predial]').val()), <?php echo $this->security->get_csrf_token_name(); ?>:"<?php echo $this->security->get_csrf_hash(); ?>" },
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

		$('#dialog-form input[name=fecha]').datepicker();

		//este script se encarga de verificar que este campo sea de tipo double
		$('#dialog-form input[name=valor]').keypress(function(event){
			//48 es el codigo del caracter 0
			//57 es el codigo del caracter 9
			//46 es el codigo del caracter .
			//8  es el codigo del backspace
			//0  es el codigo de los caracteres no alfanuméricos y de puntuacion

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
					else
					{
						if($(this).val().length == 0)
						{
							$(this).val("0" + $(this).val());
						}
					}
				}
				//si no es un punto se cancela el evento
				else
				{
					event.preventDefault();
				}
			}
		});
	});
</script>
