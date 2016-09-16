<link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table_jui.css" type="text/css" />
<div id="form">
	<h1>Administraci&oacute;n -&gt; Acciones</h1>
	
	<h3>Crear una nueva acci&oacute;n:</h3> 
	<?php 
		echo form_input('nueva_accion');
		$crear = array(
			'type' => 'button',
			'name' => 'crear',
			'id' => 'crear',
			'value' => 'Crear'
		);
		echo form_input($crear); 
	?>
	
	
	
	<h3>Ver, Editar o Eliminar acciones existentes</h3>
	<div align="center">
		<table id="tabla" style="width: 100%">
			<thead>
				<tr>
					<th>C&oacute;digo</th>
					<th>Descripci&oacute;n</th>
					<th>M&oacute;dulo</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($acciones as $accion): ?>
					<tr>
						<td><?php echo form_label($accion->id) ?></td>
						<td id="<?php echo $accion->id ?>"><?php echo form_label($accion->descripcion) ?></td>
						<td id="<?php echo $accion->id ?>"><?php echo form_label($accion->modulo) ?></td>
						<td align="center" width="100px">
							<?php echo anchor(site_url('administracion_controller/acciones')."#", '<img src="'.base_url('').'img/edit.png"', 'title="Actualizar" rel="'.$accion->id.'"'); ?>
							<?php echo anchor(site_url('administracion_controller/acciones')."#", '<img src="'.base_url().'img/delete.png"', 'title="Eliminar" rel="'.$accion->id.'"'); ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#tabla').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"bDestroy": true
		});
	});
</script>