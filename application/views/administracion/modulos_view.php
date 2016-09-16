<link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table_jui.css" type="text/css" />
<div id="form">
	<h1>Administraci&oacute;n -&gt; M&oacute;dulos</h1>
	
	<h3>Crear un nuevo m&oacute;dulo:</h3> 
	<?php 
		echo form_input('nuevo_modulo');
		$crear = array(
			'type' => 'button',
			'name' => 'crear',
			'id' => 'crear',
			'value' => 'Crear'
		);
		echo form_input($crear); 
	?>
	
	
	
	<h3>Ver, Editar o Eliminar m&oacute;dulos existentes</h3>
	<div align="center">
		<table id="tabla" style="width: 100%">
			<thead>
				<tr>
					<th>C&oacute;digo</th>
					<th>M&oacute;dulo</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($modulos as $modulo): ?>
					<tr>
						<td><?php echo form_label($modulo->id) ?></td>
						<td id="<?php echo $modulo->id ?>"><?php echo form_label($modulo->nombre) ?></td>
						<td align="center" width="100px">
							<?php echo anchor(site_url('administracion_controller/modulos')."#", '<img src="'.base_url('').'img/edit.png"', 'title="Actualizar" rel="'.$modulo->id.'"'); ?>
							<?php echo anchor(site_url('administracion_controller/modulos')."#", '<img src="'.base_url().'img/delete.png"', 'title="Eliminar" rel="'.$modulo->id.'"'); ?>
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