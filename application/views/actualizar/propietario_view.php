<link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table_jui.css" type="text/css" />
<div id="form">
	<?php echo form_fieldset('<b>Identificaci&oacute;n del propietario</b>'); ?>
		<table style="border-style: dashed; text-align:left" style="width:100%">
			<tbody>
				<tr>
					<td><?php echo form_label('Tipo documento', 'tipo_documento'); ?></td>
					<td><?php echo form_dropdown('tipo_documento', array(' ' => ' ', 'Cedula' => 'CC','Nit' => 'Nit'), $propietario->tipo_documento); ?></td>
					<td><?php echo form_label('Propietario', 'propietario'); ?></td>
					<td><?php echo form_input('propietario', utf8_decode($propietario->nombre)); ?></td>
				</tr>
				<tr>
					<td><?php echo form_label('Documento', 'documento_propietario'); ?></td>
					<td><?php echo form_input('documento_propietario', $propietario->documento); ?></td>
					<td><?php echo form_label('Telefono', 'telefono'); ?></td>
					<td><?php echo form_input('telefono', $propietario->telefono); ?></td>
				</tr>
			</tbody>
		</table>
		<br>
		<?php
			$guardar = array(
				'type' => 'button',
				'name' => 'guardar',
				'id' => 'guardar',
				'value' => 'Guardar y volver'
			);
			echo form_input($guardar);
		
			$continuar = array(
				'type' => 'button',
				'name' => 'continuar',
				'id' => 'continuar',
				'value' => 'Guardar y continuar'
			);
			echo form_input($continuar);
			
			$salir = array(
				'type' => 'button',
				'name' => 'salir',
				'id' => 'salir',
				'value' => 'Cancelar y volver'
			);
			echo form_input($salir);
		?>
	<?php echo form_fieldset_close(); ?>
	<?php echo form_fieldset('<b>Predios asociados al propietario</b>'); ?>
		<table id="tabla" style="width:100%">
			<thead>
				<tr>
					<th>Ficha predial</th>
					<th>Participaci&oacute;n</th>
					<th>Acci&oacute;n</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($relaciones as $relacion): ?>
					<tr>
						<td><?php echo $relacion->ficha_predial; ?></td>
						<td><?php echo $relacion->participacion; ?></td>
						<td align="center">
							<?php echo anchor(site_url("consultas_controller/ficha/$relacion->id_predio"), '<img border="0" title="Consultar" src="'.base_url().'img/search.png">');?>
							<?php echo anchor(site_url("actualizar_controller/ficha/$relacion->id_predio"), '<img border="0" title="Actualizar" src="'.base_url().'img/edit.png">');?>
						</td>
					</tr>
				<?php endforeach;?>
			</tbody>
		</table>
	<?php echo form_fieldset_close(); ?>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){

		$('#form input[name=salir]').click(function(){
			history.back();
		});

		$('#form input[name=continuar], #form input[name=guardar]').click(function(){

			var operacion = $(this).attr("name");
			$('#cargando').html('Actualizando el registro. Por favor espere');
			$('#cargando').removeClass('error');
            $("div#alerta").remove();
            $("span.error").remove();
			$('#cargando').show();
			$.post(
				"<?php echo site_url('actualizar_controller/actualizar_propietario'); ?>", 
				{
					"id":"<?php echo $propietario->id_propietario; ?>",
					"tipo_documento":$('#form select[name=tipo_documento]').val(),
					"nombre":$('#form input[name=propietario]').val(),
					"documento":$('#form input[name=documento_propietario]').val(),
					"telefono":$('#form input[name=telefono]').val(), 
					"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"
				}, 
				function(json){
					if(json.respuesta == "correcto")
					{
						$('#cargando').addClass('correcto');
						if(operacion == "guardar")
						{
							$('#cargando').html('Los datos se actualizaron correctamente. Redireccionando...');
							location.href = "<?php echo site_url('propietarios_controller'); ?>";
						}
						else
						{
							$('#cargando').html('Los datos se actualizaron correctamente.');
						}
					}
					else
					{
						$('#cargando').html('<span class="alerta_icono"></span> Se presentaron errores');
	                     $('#cargando').addClass('error');
	                     $('#errores').after('<div id="alerta" class="ui-state-highlight ui-corner-all" style="display:none; margin-top: 20px; padding: 0 .7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>' + json.mensaje + '</p></div>');
	                     $('div#alerta').fadeIn('slow');
					}
					$('#cargando').delay(2000).fadeOut('slow',function(){
						$(this).removeClass('correcto');
						$(this).removeClass('error');
					});
				},
				"json"
			);
		});


		$('#tabla').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers"
		});
	});
</script>
