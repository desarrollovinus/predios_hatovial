<link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table_jui.css" type="text/css" />
<div id="form">
	<h1>Administraci&oacute;n -&gt; Informes</h1>
	
	<h3>Crear un nuevo informe:</h3> 
	<?php 
		echo form_input('nuevo_informe');
		$crear = array(
			'type' => 'button',
			'name' => 'crear',
			'id' => 'crear',
			'value' => 'Crear'
		);
		echo form_input($crear); 
	?>
	
	
	
	<h3>Ver, Editar o Eliminar informes existentes</h3>
	<div align="center">
		<table id="tabla" style="width: 100%">
			<thead>
				<tr>
					<th>C&oacute;digo</th>
					<th>Informe</th>
					<th>Ruta base</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($informes as $informe): ?>
					<tr>
						<td><?php echo form_label($informe->id) ?></td>
						<td id="<?php echo $informe->id ?>"><?php echo form_label($informe->informe) ?></td>
						<td id="<?php echo $informe->id ?>"><?php echo form_label($informe->ruta_base) ?></td>
						<td align="center" width="100px">
							<?php echo anchor(site_url('administracion_controller/informes')."#", '<img src="'.base_url('').'img/edit.png"', 'title="Actualizar" rel="'.$informe->id.'"'); ?>
							<?php echo anchor(site_url('administracion_controller/informes')."#", '<img src="'.base_url().'img/delete.png"', 'title="Eliminar" rel="'.$informe->id.'"'); ?>
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