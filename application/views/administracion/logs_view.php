<link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table_jui.css" type="text/css" />
<div id="form">
	<table id="tabla" style="width:100%">
		<thead>
			<tr>
				<th>Fecha y hora</th>
				<th>Usuario</th>
				<th>Descripci&oacute;n</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($logs as $log): ?>
				<tr>
					<td><?php echo form_label($log->fecha_hora); ?></td>
					<td><?php echo form_label($log->us_nombre.' '.$log->us_apellido); ?></td>
					<td><?php echo form_label($log->descripcion); ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
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