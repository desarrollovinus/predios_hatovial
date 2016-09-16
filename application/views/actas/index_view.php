<?php $permisos = $this->session->userdata('permisos'); ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table_jui.css" type="text/css" />
<div id="form">
	<?php echo form_fieldset("<b>Actas</b>"); ?>
		<table id="tabla">
			<thead>
				<tr>
					<th>Predio</th>
					<th>Ficha predial</th>
					<th>Entrega f&iacute;sica</th>
					<th>Promesa de compraventa</th>
					<th>Predio registrado</th>
					<?php if (isset($permisos['Bit&aacute;cora']['Consultar'])) { ?><th></th><?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($actas as $acta): ?>
					<tr>
						<td width="20%"><a rel="<?php echo trim($acta->ficha_predial); ?>"  name="documentos" href="<?php if ( isset($permisos['Archivos y Fotos']['Consultar']) ) { ?>javascript:void(window.open('<?php echo site_url('archivos_controller/obtener_archivos/'.str_replace(' ', '_', $acta->ficha_predial)); ?>','DESCRIPCION','resizable=no,location=no,menubar=no, scrollbars=yes,status=no,toolbar=no,fullscreen=no,d ependent=no,width=800,height=564,left=100,top=100' ))<?php } else { ?>javascript:void(return false)<?php } ?>"><?php echo trim($acta->ficha_predial); ?></a></td>
						<td width="20%" rel="<?php echo $acta->ficha_predial; ?>_1"><?php if($acta->pg_ficha){ echo $acta->pg_ficha; } else { echo "0"; } ?></td>
						<td width="20%" rel="<?php echo $acta->ficha_predial; ?>_2"><?php if($acta->pg_ef) { echo $acta->pg_ef; } else { echo "0"; } ?></td>
						<td width="20%" rel="<?php echo $acta->ficha_predial; ?>_3"><?php if($acta->pg_comp) { echo $acta->pg_comp; } else { echo "0"; } ?></td>
						<td width="20%" rel="<?php echo $acta->ficha_predial; ?>_4"><?php if($acta->pg_reg) { echo $acta->pg_reg; } else { echo "0"; } ?></td>
						<?php if (isset($permisos['Bit&aacute;cora']['Consultar'])) { ?><td width="20%"><a href="javascript:void(window.open('<?php echo site_url("bitacora_controller/obtener_bitacora/$acta->ficha_predial"); ?>','bitacora','resizable=no,location=no,menubar=no, scrollbars=yes,status=no,toolbar=no,fullscreen=no, dependent=no,width=1020,height=600,left=100,top=0' ))"><img border="0" alt="Ver Bit&aacute;cora" title="Ver Bit&aacute;cora" src="<?php echo base_url(); ?>img/bitacora.png"></a></td><?php } ?>					
					</tr>
				<?php endforeach;?>
			</tbody>
		</table>
		<div class="clear">&nbsp;</div>
		<input type="hidden" id="errores" />
		<?php
			if (isset($permisos['Actas']['Actualizar'])) {
				$guardar = array(
					'type' => 'button',
					'name' => 'guardar',
					'id' => 'guardar',
					'value' => 'Guardar cambios'
				); 
				echo form_input($guardar);
			}
		?>
	<?php echo form_fieldset_close(); ?>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		
		oTable = $('#tabla').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers"
		});

		<?php if(isset($permisos['Actas']['Actualizar'])) { ?>
			$('#tabla a[name=documentos]').live("click",function(){
				rel = $(this).attr('rel');
				i = 1;
				$('#tabla td[rel^="' + rel + '_"]').each(function(){
					if(!$('#tabla input[name="input_' + i + '_' + rel + '"]').length) {
						var input = "<input type='text' name='input_" + i + "_" + rel + "' />";
						var dato = $(this).text();
						$(this).html(input);
						$('#tabla input[name="input_' + i + '_' + rel + '"]').val($.trim(dato));
					}
					i++;
				});
			});
		<?php } ?>

		$('#form input[name=guardar]').click(function(){
			$('#tabla input[name^=input_]').each(function(){
				$('div#alerta').remove();
				valor = $(this).val();
				datos = $(this).attr('name');
				array_datos = datos.split('_');
				var form_data = { ficha:array_datos[2], campo:array_datos[1], valor:valor, <?php echo $this->security->get_csrf_token_name(); ?>:"<?php echo $this->security->get_csrf_hash(); ?>" };
				$.ajax
				({
					url: '<?php echo site_url('actas_controller/actualizar_campo'); ?>',
					type: 'POST',
					data: form_data,
					success: function(msg)
					{
						respuesta = msg.split('|');
						resultado = respuesta[0];
						if(resultado == 'correcto')
						{
							valor_respuesta = respuesta[1];
							control = respuesta[2];
							datos_respuesta = control.split('_');
							campo = datos_respuesta[1];
							relacion = datos_respuesta[2];
							$('#tabla td[rel="' + relacion + '_' + campo + '"]').html('<strong>' + valor_respuesta + '</strong>');
						}
						else
						{
							$('#errores').after('<div id="alerta" class="ui-state-highlight ui-corner-all" style="display:none; margin-top: 20px; padding: 0 .7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>' + resultado + '</p></div>');
						}
					}
				});
			});
		});
		
	});
</script>