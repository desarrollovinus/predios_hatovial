<link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table_jui.css" type="text/css" />
<div id="form">
	<h1>Administraci&oacute;n -&gt; Contratistas</h1>
	
	<h3>Crear un nuevo contratista:</h3> 
	<?php 
		echo form_input('nuevo_contratista');
		$crear = array(
			'type' => 'button',
			'name' => 'crear',
			'id' => 'crear',
			'value' => 'Crear'
		);
		echo form_input($crear); 
	?>
	
	
	
	<h3>Ver, Editar o Eliminar contratistas existentes</h3>
	<div align="center">
		<table id="tabla" style="width: 100%">
			<thead>
				<tr>
					<th>C&oacute;digo</th>
					<th>Tramo</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($contratistas as $contratista): ?>
					<tr>
						<td><?php echo form_label($contratista->id_cont) ?></td>
						<td id="<?php echo $contratista->id_cont ?>"><?php echo form_label($contratista->nombre) ?></td>
						<td align="center" width="100px">
							<?php echo anchor(site_url('administracion_controller/contratistas')."#", '<img src="'.base_url('').'img/edit.png"', 'title="Actualizar" rel="'.$contratista->id_cont.'"'); ?>
							<?php echo anchor(site_url('administracion_controller/contratistas')."#", '<img src="'.base_url().'img/delete.png"', 'title="Eliminar" rel="'.$contratista->id_cont.'"'); ?>
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