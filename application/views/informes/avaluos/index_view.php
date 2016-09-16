<label for="tipo_predio">Tipos de predio</label>
<select id="tipo_predio">
	<option value="">Todos los predios</option>
	<option value="1">Requeridos</option>
	<option value="0">No requeridos</option>
</select>

<div id="form"><?php $this->load->view('informes/avaluos/tabla_view') ?></div>

<script type="text/javascript">
	$(document).ready(function(){
        $("#tipo_predio").on("change", function(){
			$("#form").load("<?php echo site_url('informes_controller/avaluos_tabla/'); ?>" + "/" + $(this).val());
        });
	});
</script>