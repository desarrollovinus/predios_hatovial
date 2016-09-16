<link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table_jui.css" type="text/css" />
<div id="form">
	<?php 
		echo form_fieldset('<b>Gesti&oacute;n de pagos</b>'); 
		
		echo form_label('Ficha predial', 'ficha_predial'); 
		echo '&nbsp;&nbsp;';
		
		if (isset($ficha_predial)) {
			echo form_input('ficha_predial', utf8_decode($ficha_predial), 'readonly'); 
		}
		else {
			echo form_input('ficha_predial', '', 'id="fichas"');
		}
	?>
	<input type="hidden" id="errores-arriba" />
	<div class="clear">&nbsp;</div>
	<table style='width:"100%";'>
		<tr>
			<td><?php echo form_label('Valor del predio', 'valor_predio'); ?></td>
			<td>
				<?php 
					if(isset($valor_predio)) {
						echo form_input('valor_predio', $valor_predio, 'readonly');
					} else {
						echo form_input('valor_predio');
					} 
				?>
			</td>
			<td><?php echo form_label('Total pagado', 'total_pagado'); ?></td>
			<td>
				<?php 
					if(isset($total_pagado)) {
						echo form_input('total_pagado', $total_pagado, 'readonly');
					} else {
						echo form_input('total_pagado');
					} 
				?>
			</td>
			<td><?php echo form_label('Porcentaje pagado', 'porcentaje_pagado'); ?></td>
			<td>
				<?php
					if(isset($porcentaje_pagado)) {
						echo form_input('porcentaje_pagado', $porcentaje_pagado, 'readonly');
					} else {
						echo form_input('porcentaje_pagado');
					}  
				?>%
			</td>
		</tr>
	</table>
	<div class="clear">&nbsp;</div>
	<input type="hidden" id="ubicacion-tabla" />
	<div id="div-tabla">
		<?php 
			if(isset($tabla)) { 
				echo $tabla; 
			}
			else { 
		?>
			<table style='width:"100%";' id="tabla">
				<thead>
					<tr>
						<th>N&uacute;mero de pago</th>
						<th>Fecha</th>
						<th>Documento de pago</th>
						<th>Valor</th>
						<?php if($tipo_usuario == 2): ?>
							<th>&nbsp;</th>
						<?php endif;?>
					</tr>
				</thead>
					<tbody></tbody>
			</table>
		<?php }	?>
	</div>
	<?php echo form_fieldset_close(); ?>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.ui.autocomplete.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#tabla').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"bDestroy": true
		});
	});
</script>
