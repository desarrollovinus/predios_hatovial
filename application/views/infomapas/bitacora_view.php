<link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table_jui.css" type="text/css" />
<div id="form">
	<?php 
		echo form_fieldset('<b>Bit&aacute;cora</b>'); 
		
		echo form_label('Ficha predial', 'ficha_predial'); 
		echo '&nbsp;&nbsp;';
		echo form_input('ficha_predial', $ficha_predial, 'readonly');
	?>
	<div class="clear">&nbsp;</div>
	<div id="div-tabla">
		<?php echo $bitacora; ?>
	</div>
	<div class="clear">&nbsp;</div>
	<?php echo form_fieldset_close(); ?>
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
