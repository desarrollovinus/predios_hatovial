<link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table_jui.css" type="text/css" />

<div id="form">
	<ul id="navigation">
		<li><a href='<?php echo site_url("informes_controller/bitacora_excel/0"); ?>' rel="excel" title="Exportar todos a Excel"><img src="<?php echo base_url('img/excel.png'); ?>"></a></li>
	</ul>

	<table id="tbl_predios" style="width:100%">
		<thead>
			<tr>
				<th>PREDIO</th>
				<th>REPORTE</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($predios as $predio): ?>
				<tr>
					<td><?php echo $predio->ficha_predial; ?></td>
					<td>
						<?php
						echo anchor("informes_controller/bitacora_excel/".str_replace(' ', '_', $predio->ficha_predial), '<img src="'.base_url().'img/excel.png"', 'title="Subir archivos"');
						?>
					</td>
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

        $('#tbl_predios').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers"
		});
	});
</script>