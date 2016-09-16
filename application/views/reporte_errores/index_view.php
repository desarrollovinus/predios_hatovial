<div id="dialog-form" title="Agregar nueva entrada.">
	<?php echo form_fieldset('Formulario de reporte de errores')?>
		<table>
			<tr>
				<th><?php echo form_label('T&iacute;tulo:', 'titulo-error')?></th>
				<td><?php echo form_input('titulo-error')?></td>
			</tr>
			<tr>
				<th><?php echo form_label('Severidad:', 'severidad-error')?></th>
				<td><?php echo form_input('severidad-error')?></td>
			</tr>
			<tr>
				<th><?php echo form_label('Mensaje:', 'mensaje-error')?></th>
				<td><?php echo form_input('mensaje-error')?></td>
			</tr>
			<tr>
				<th><?php echo form_label('Archivo:', 'archivo-error')?></th>
				<td><?php echo form_input('archivo-error')?></td>
			</tr>
			<tr>
				<th><?php echo form_label('L&iacute;nea:', 'linea-error')?></th>
				<td><?php echo form_input('linea-error')?></td>
			</tr>
		</table>
	<?php echo form_fieldset_close()?>
</div>