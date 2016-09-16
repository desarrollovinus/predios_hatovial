<?php 
$avaluos = $this->InformesDAO->obtener_avaluos($tipo); 
// echo count($avaluos)."<br>";
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table_jui.css" type="text/css" />
<ul id="navigation">
	<li><a href='<?php echo site_url("informes_controller/avaluos_excel/")."/".$tipo; ?>' rel="excel" title="Exportar a Excel"><img src="<?php echo base_url('img/excel.png'); ?>"></a></li>
	<li><a href='<?php echo site_url("informes_controller/avaluos_pdf")."/".$tipo;; ?>' target="_blank" title="Exportar a PDF"><img src="<?php echo base_url('img/pdf.png'); ?>"></a></li>
</ul>

<table id="avaluos" style="width:100%">
	<thead>
		<tr>
			<th>Predio</th>
			<th>Nro. Catastral</th>
			<th>Primer propietario</th>
			<th>Env&iacute;o del avaluador</th>
			<th>Radicado</th>
			<th>Fecha</th>
			<th>Valor m2</th>
			<th>&Aacute;rea</th>
			<th>Valor Terreno</th>
			<th>Valor Total</th>
			<th>Estado</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($avaluos as $avaluo){ ?>
		<tr>
			<td><?php echo $avaluo->ficha; ?></td>
			<td><?php echo $avaluo->numero_catastral; ?></td>
			<td><?php echo $avaluo->primer_propietario; ?></td>
			<td><?php echo $avaluo->envio_avaluador; ?></td>
			<td><?php echo $avaluo->radicado_envio; ?></td>
			<td><?php echo $avaluo->fecha_recibo; ?></td>
			<td><?php echo number_format( $avaluo->valor_metro, 0, ',', '.'); ?></td>
			<td><?php echo $avaluo->area_total; ?></td>
			<td><?php echo number_format( $avaluo->valor_terreno, 0, ',', '.'); ?></td>
			<td><?php echo number_format( $avaluo->valor_total, 0, ',', '.'); ?></td>
			<td><?php echo $avaluo->estado; ?></td>
		</tr>
		<?php }; ?>
	</tbody>
</table>

<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#avaluos').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers"
		});

		$('#navigation a').stop().animate({'marginLeft':'85px'},1000);

        $('#navigation > li').hover(
            function () {
                $('a',$(this)).stop().animate({'marginLeft':'2px'},200);
            },
            function () {
                $('a',$(this)).stop().animate({'marginLeft':'85px'},200);
            }
        );
	});
</script>