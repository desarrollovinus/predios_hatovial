<link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table_jui.css" type="text/css" />
<div id="form">
	<?php echo form_fieldset('<b>Identificaci&oacute;n del propietario</b>'); ?>
		<table style="border-style: dashed; text-align:left; width:100%" >
			<tbody>
				<tr>
					<td><?php echo form_label('Tipo documento', 'tipo_documento'); ?></td>
					<td><?php echo form_input('tipo_documento', $propietario->tipo_documento, 'readonly="readonly"'); ?></td>
					<td><?php echo form_label('Propietario', 'propietario'); ?></td>
					<td><?php echo form_input('propietario', utf8_decode($propietario->nombre), 'readonly="readonly"'); ?></td>
				</tr>
				<tr>
					<td><?php echo form_label('Documento', 'documento_propietario'); ?></td>
					<td><?php echo form_input('documento_propietario', $propietario->documento, 'readonly="readonly"'); ?></td>
					<td><?php echo form_label('Telefono', 'telefono'); ?></td>
					<td><?php echo form_input('telefono', $propietario->telefono, 'readonly="readonly"'); ?></td>
				</tr>
			</tbody>
		</table>
		<br>
		<?php			
			$salir = array(
				'type' => 'button',
				'name' => 'salir',
				'id' => 'salir',
				'value' => 'Volver'
			);
			echo form_input($salir);
		?>
	<?php echo form_fieldset_close(); ?>
	<?php echo form_fieldset('<b>Predios asociados al propietario</b>'); ?>
		<table id="tabla" style='width:100%'>
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

		$('#tabla').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers"
		});
	});
</script>