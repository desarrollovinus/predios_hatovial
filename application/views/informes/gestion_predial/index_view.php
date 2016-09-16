<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/cupertino/jquery-ui-1.8.16.custom.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table_jui.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/estilo.css" type="text/css" media="screen" />
		<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
	</head>
	<body>
		<input type="button" value="Exportar informe a Excel" id="exportar">
		<div id="form">
			<table style="width:100%">
				<thead>
					<tr>
						<th rowspan="2">No. PREDIO</th>
						<th rowspan="2">NOMBRE</th>
						<th rowspan="2">ABSCISAS INICIAL</th>
						<th rowspan="2">ABSCISAS FINAL</th>
						<th rowspan="2">&Aacute;REA TOTAL ADQUIRIDA</th>
						<th rowspan="2">&Aacute;REA CONSTRUCCIONES M2</th>
						<th rowspan="2">FECHA PLANO APROBADO</th>
						<th class="ui-state-default" colspan="2">AVAL&Uacute;O</th>
						<th class="ui-state-default" colspan="4">OFERTA</th>
						<th class="ui-state-default" colspan="3">ACEPTACI&Oacute;N OFERTA</th>
						<th class="ui-state-default" colspan="3">EXPROPIACI&Oacute;N</th>
						<th rowspan="2">FECHA PROMESA</th>
						<th rowspan="2">VALOR ANTICIPO</th>
						<th rowspan="2">SALDO</th>
						<th rowspan="2">TOTAL PAGADO</th>
						<th rowspan="2">VALOR M&sup2;</th>
						<th rowspan="2">No ESCRITURA FECHA NOTARIA</th>
						<th rowspan="2">ESTADO DEL PROCESO</th>
						<th rowspan="2">OBSERVACI&Oacute;N</th>
					</tr>
					<tr>
						<th>FECHA DE ENTREGA DEL AVAL&Uacute;O</th>
						<th>VALOR AVAL&Uacute;O</th>
						<th>FECHA DE OFERTA</th>
						<th>PERSONAL</th>
						<th>EDICTO</th>
						<th>FECHA VENCIMIENTO DE LA OFERTA</th>
						<th>SI</th>
						<th>NO</th>
						<th>FECHA PROBABLE DE ENTREGA VOLUNTARIA DEL INMUEBLE</th>
						<th>RESOLUCI&Oacute;N EXPROPIACI&Oacute;N</th>
						<th>FECHA DE NOTIFICACI&Oacute;N</th>
						<th>FECHA PROBABLE DE ENTREGA DEL INMUEBLE</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($registros as $registro): ?>
					<?php
						$fecha_plano_aprobado = explode(" ", $registro->fecha_plano_aprobado);
						$fecha_notificacion = explode(" ", $registro->fecha_notificacion);
						$fecha_vencimiento = explode(" ", $registro->fecha_vencimiento_oferta);
						$fecha_entrega_avaluo = explode(" ", $registro->fecha_entrega_avaluo);
						$fecha_oferta = explode(" ", $registro->fecha_de_oferta);
						$fecha_entrega_inmueble = explode(" ", $registro->fecha_entrega_inmueble);
					?>
						<tr>
							<td><?php echo $registro->no_predio ?></td>
							<td><?php echo utf8_decode($registro->nombre) ?></td>
							<td><?php 
								$ms = substr($registro->abscisa_inicial, -3);
								$kms = substr($registro->abscisa_inicial, 0, strlen($registro->abscisa_inicial) - 3);
								if($kms == "") {
									$kms = "0";
								}
								echo "K".$kms."+".$ms;
							?></td>
							<td><?php
								$ms = substr($registro->abscisa_final, -3);
								$kms = substr($registro->abscisa_final, 0, strlen($registro->abscisa_final) - 3);
								if($kms == "") {
									$kms = "0";
								} 
								echo "K".$kms."+".$ms;
							?></td>
							<td><?php echo $registro->area_total_adquirida ?></td>
							<td><?php echo $registro->area_construcciones ?></td>
							<td><?php 
								if($fecha_plano_aprobado[0] != '0000-00-00') {
									echo $fecha_plano_aprobado[0];
								}
							?></td>
							<td><?php 
								if($fecha_entrega_avaluo[0] != '0000-00-00') {
									echo $fecha_entrega_avaluo[0];
								}
							?></td>
							<td><?php echo number_format($registro->valor_avaluo) ?></td>
							<td><?php 
								if($fecha_oferta[0] != '0000-00-00') {
									echo $fecha_oferta[0];
								}
							?></td>
							<td><?php echo $registro->personal ?></td>
							<td>&nbsp;</td>
							<td><?php 
								if($fecha_vencimiento[0] != '0000-00-00') {
									echo $fecha_vencimiento[0];
								}
							?></td>
							<td><?php 
								if($fecha_notificacion[0] == '0000-00-00') {
									echo "X";
								}
							?></td>
							<td><?php 
								if($fecha_notificacion[0] != '0000-00-00') {
									echo "X";
								}
							?></td>
							<td><?php 
								if($fecha_entrega_inmueble[0] != '0000-00-00' && $fecha_notificacion[0] == '0000-00-00') {
									echo $fecha_entrega_inmueble[0];
								}
							?></td>
							<td>&nbsp;</td>
							<td><?php 
								if($fecha_notificacion[0] != '0000-00-00') {
									echo $fecha_notificacion[0];
								}
							?></td>
							<td><?php 
								if($fecha_entrega_inmueble[0] != '0000-00-00' && $fecha_notificacion[0] != '0000-00-00') {
									echo $fecha_entrega_inmueble[0];
								}
							?></td>
							<td>&nbsp;</td>
							<td><?php echo number_format($registro->valor_anticipo); ?></td>
							<td><?php echo number_format($registro->saldo); ?></td>
							<td><?php echo number_format($registro->total_pagado); ?></td>
							<td><?php echo number_format($registro->valor_metro_cuadrado); ?></td>
							<td><?php echo $registro->numero_escritura; ?></td>
							<td><?php echo $registro->estado_proceso; ?></td>					
							<td><?php echo $registro->observacion; ?></td>					
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</body>
	<script type="text/javascript">
		$('table').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers"
		});

		$('#exportar').click(function(){
			window.location = "<?php echo site_url('informes_controller/gestion_predial_excel/'); ?>";
		});
	</script>
</html>