<link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table_jui.css" type="text/css" />
<ul id="navigation">
	<li><a href='<?php echo site_url("informes_controller/avaluos_vencidos_excel"); ?>' rel="excel" title="Exportar a Excel"><img src="<?php echo base_url('img/excel.png'); ?>"></a></li>
	<li><a href='<?php echo site_url("informes_controller/avaluos_vencidos_pdf"); ?>' target="_blank" title="Exportar a PDF"><img src="<?php echo base_url('img/pdf.png'); ?>"></a></li>
</ul>
<table id="tabla" style="width:100%">
	<thead>
		<tr>
			<th>PREDIO</th>
			<th>PRIMER PROPIETARIO</th>
			<th>FECHA AVAL&Uacute;O</th>
			<th>FECHA EXPIRACION</th>
			<th>DIAS EXPIRADO</th>
			<th>CONTRATISTA</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			foreach ($avaluos_vencidos as $avaluo):
				echo "<tr><td>".$avaluo['ficha_predial']."</td><td>".$avaluo['propietario']."</td><td>".$avaluo['fecha_avaluo']."</td><td>".$avaluo['fecha_expiracion']."</td><td>".$avaluo['dias_expirado']."</td><td>".$avaluo['contratista']."</td></tr>";
			endforeach; 
		?>
	</tbody>
</table>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#navigation a').stop().animate({'marginLeft':'85px'},1000);

        $('#navigation > li').hover(
            function () {
                $('a',$(this)).stop().animate({'marginLeft':'2px'},200);
            },
            function () {
                $('a',$(this)).stop().animate({'marginLeft':'85px'},200);
            }
        );
		
		oTable = $('#tabla').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers"
		});
	});
</script>