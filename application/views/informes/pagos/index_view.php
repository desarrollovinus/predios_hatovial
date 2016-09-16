<link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table_jui.css" type="text/css" />
<div id="form">
<ul id="navigation">
	<li><a href='<?php echo site_url("informes_controller/pagos_excel"); ?>' rel="excel" title="Exportar a Excel"><img src="<?php echo base_url('img/excel.png'); ?>"></a></li>
	<li><a href='<?php echo site_url("informes_controller/pagos_pdf"); ?>' target="_blank" title="Exportar a PDF"><img src="<?php echo base_url('img/pdf.png'); ?>"></a></li>
</ul>
<table id="tabla" style="width:100%">
	<thead>
		<tr>
			<th>PREDIO</th>
			<th>TOTAL AVALUO</th>
			<th>TOTAL PAGADO</th>
			<th>SALDO</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			foreach ($pagos as $predio):
				$ficha = $predio->PREDIO;
				$total_avaluo = $predio->VALOR_TOTAL;
				$total_pagado = $predio->TOTAL_PAGADO;
				if(empty($total_pagado)) {
					$total_pagado = 0;
				}
				$saldo = $total_avaluo - $total_pagado;
				echo "<tr><td>$ficha</td><td>".number_format($total_avaluo)."</td><td>".number_format($total_pagado)."</td><td>".number_format($saldo)."</td></tr>";
			endforeach;
		?>
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
		
		oTable = $('#tabla').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers"
		});
	});
</script>