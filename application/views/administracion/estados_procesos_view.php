<link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table_jui.css" type="text/css" />
<div id="form">
	<h1>Administraci&oacute;n -&gt; Estados</h1>
	
	<h3>Crear un nuevo estado:</h3> 
	<?php 
		echo form_input('nuevo_estado');
		$crear = array(
			'type' => 'button',
			'name' => 'crear',
			'id' => 'crear',
			'value' => 'Crear'
		);
		echo form_input($crear); 
	?>
	
	
	
	<h3>Ver, Editar o Eliminar estados existentes</h3>
	<div align="center">
		<table id="tabla" style="width: 100%">
			<thead>
				<tr>
					<th>C&oacute;digo</th>
					<th>Estado</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($estados_procesos as $estado): ?>
					<tr>
						<td><?php echo form_label($estado->id) ?></td>
						<td id="<?php echo $estado->id ?>"><?php echo form_label($estado->estado) ?></td>
						<td align="center" width="100px">
							<?php echo anchor(site_url('administracion_controller/estados_procesos')."#", '<img src="'.base_url('').'img/edit.png"', 'title="Actualizar" rel="'.$estado->id.'"'); ?>
							<?php echo anchor(site_url('administracion_controller/estados_procesos')."#", '<img src="'.base_url().'img/delete.png"', 'title="Eliminar" rel="'.$estado->id.'"'); ?>
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