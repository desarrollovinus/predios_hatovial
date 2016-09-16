<link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table_jui.css" type="text/css" />



<div id="div-tabla">
	<table style='width:100%' id="tabla">
		<thead>
			<tr>
				<th>Nombre del archivo</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$dir = '_00_Normas/';

			foreach (glob("./files/000_Normas/*.pdf") as $nombre_fichero) {
			?>
				<tr>
					<td><?php echo basename($nombre_fichero); ?></td>
					<td>
						<a target="_blank" href="<?php echo base_url().$nombre_fichero; ?>" onClick="window.open(this.href, this.target, width=800,height=600); return false;">
							<img border="0" title="Ver" src="<?php echo base_url(); ?>img/search.png">	
						</a>
					</td>
				</tr>
			<?php
			    // echo "Tamaño de $nombre_fichero " . filesize($nombre_fichero) . "\n";
			}
			?>
		</tbody>
	</table>
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