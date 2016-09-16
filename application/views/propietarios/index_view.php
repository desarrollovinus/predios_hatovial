<?php $permisos = $this->session->userdata('permisos'); ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table_jui.css" type="text/css" />
<div id="form">
	<?php echo form_fieldset("<b>Propietarios</b>"); ?>
		<table id="tabla" style='width:100%'>
			<thead>
				<tr>
					<th>Tipo Documento</th>
					<th>N&uacute;mero de Documento</th>
					<th>Nombre</th>
					<th>Tel&eacute;fono</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($propietarios as $propietario): ?>
					<tr>
						<td><?php echo $propietario->tipo_documento; ?></td>
						<td><?php echo $propietario->documento; ?></td>
						<td><?php echo utf8_decode($propietario->nombre); ?></td>
						<td><?php echo $propietario->telefono; ?></td>
						<td width="70px">
							<?php echo anchor(site_url("consultas_controller/propietario/$propietario->id_propietario"), '<img border="0" title="Consultar" src="'.base_url().'img/search.png"'); ?>
							<?php if (isset($permisos['Fichas']['Actualizar'])) { echo anchor(site_url("actualizar_controller/propietario/$propietario->id_propietario"), '<img border="0" title="Actualizar" src="'.base_url().'img/edit.png"'); } ?>
						</td>					
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php echo form_fieldset_close(); ?>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#tabla').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers"
		});
	});
</script>
