<link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table_jui.css" type="text/css" />

<div id="form">
	<ul id="navigation">
		<li><a href='<?php echo site_url("informes_controller/actas_excel"); ?>' rel="excel" title="Exportar a Excel"><img src="<?php echo base_url('img/excel.png'); ?>"></a></li>
		<li><a href='<?php echo site_url("informes_controller/actas_pdf"); ?>' target="_blank" title="Exportar a PDF"><img src="<?php echo base_url('img/pdf.png'); ?>"></a></li>
	</ul>
	<table id="actas" style="width:100%">
		<thead>
			<tr>
				<th>PREDIO</th>
				<th>PRIMER PROPIETARIO</th>
				<th>FICHA APROBADA</th>
				<th>ENTREGA F&Iacute;SICA</th>
				<th>COMPRAVENTA</th>
				<th>REGISTRO</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($actas as $acta): ?>
				<tr>
					<td><label><?php echo $acta['PREDIO']; ?></label></td>
					<td><label><?php if($acta['PROPIETARIO'] == '') { echo "0"; } else { echo $acta['PROPIETARIO']; } ?></label></td>
					<td><label><?php if($acta['FICHA APROBADA'] == '') { echo "0"; } else { echo $acta['FICHA APROBADA']; } ?></label></td>
					<td><label><?php if($acta['ENTREGA FISICA'] == '') { echo "0"; } else { echo $acta['ENTREGA FISICA']; } ?></label></td>
					<td><label><?php if($acta['COMPRAVENTA'] == '') { echo "0"; } else { echo $acta['COMPRAVENTA']; } ?></label></td>
					<td><label><?php if($acta['REGISTRO'] == '') { echo "0"; } else { echo $acta['REGISTRO']; } ?></label></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
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
        
		$('#actas').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers"
		});
	});
</script>