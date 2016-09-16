<?php $permisos = $this->session->userdata('permisos'); ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table_jui.css" type="text/css" />
<div id="form">
	<?php echo form_fieldset('<b>Actualizar</b>'); ?>
		<img src="<?php echo base_url(); ?>img/search.png" title="Consultar" >: Consultar Ficha 
		<?php if (isset($permisos['Fichas']['Actualizar'])) { ?><img src="<?php echo base_url(); ?>img/edit.png" title="Actualizar" >: Actualizar Ficha <?php } ?> 
		<?php if (isset($permisos['Bit&aacute;cora']['Consultar'])) { ?><img alt="Ver Bit&aacute;cora" title="Ver Bit&aacute;cora" src="<?php echo base_url(); ?>img/bitacora.png">: Bit&aacute;cora,<?php } ?> 
		<?php if (isset($permisos['Archivos y Fotos']['Consultar'])) {?>
			<img src="<?php echo base_url(); ?>img/archivos.png" title="Subir archivos" >: Subir Archivos 
			<img src="<?php echo base_url(); ?>img/camara.png" title="Subir fotos" >: Subir Fotos 
		<?php } ?>
		<?php if (isset($permisos['Fichas']['Imprimir estudio de t&iacute;tulos'])) { ?><img src="<?php echo base_url(); ?>img/doc.png" title="Estudio de T&iacute;tulos" >: Descargar el Estudio de T&iacute;tulos<?php } ?>
		
		<br><br>

		<?php 
			echo form_label('Contratista', 'contratistas');
			$dropdown = array('' => '');
			foreach ($contratistas as $contratista):
				$dropdown[$contratista->id_cont] = $contratista->nombre;
			endforeach;
			if($this->uri->segment(3)) {
				echo form_dropdown('contratistas', $dropdown, $this->uri->segment(3)); 
			}
			else {
				echo form_dropdown('contratistas', $dropdown);
			}
		?>
		<?php echo form_hidden('posicion_tabla'); ?>
		<div id="tabla">
			<table style="width:100%; font-size: 13px">
				<thead>
					<tr>
						<th>Fecha de creaci&oacute;n</th>
						<th>Ficha predial</th>
						<th>Primer propietario</th>
						<th>Creador</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($fichas as $ficha): ?>
						<tr>
							<td><?php echo $ficha->fecha_hora; ?></td>
							<td><?php echo $ficha->ficha_predial; ?></td>
							<td><?php echo $ficha->propietario; ?></td>
							<td><?php echo $ficha->us_nombre.' '.$ficha->us_apellido; ?></td>
							<td width="220px">
								<?php echo anchor(site_url("consultas_controller/ficha/$ficha->id_predio"), '<img border="0" title="Consultar" src="'.base_url().'img/search.png">');?>
								<?php if (isset($permisos['Fichas']['Actualizar'])) { ?><?php echo anchor("actualizar_controller/ficha/$ficha->id_predio", '<img src="'.base_url().'img/edit.png"', 'title="Actualizar"'); ?><?php } ?>
								<?php if (isset($permisos['Bit&aacute;cora']['Consultar'])) { ?><a href="javascript:void(window.open('<?php echo site_url("bitacora_controller/obtener_bitacora/$ficha->ficha_predial"); ?>','bitacora','resizable=no,location=no,menubar=no, scrollbars=yes,status=no,toolbar=no,fullscreen=no, dependent=no,width=1020,height=600,left=100,top=0' ))"><img border="0" alt="Ver Bit&aacute;cora" title="Ver Bit&aacute;cora" src="<?php echo base_url(); ?>img/bitacora.png"></a><?php } ?>
								<?php 
									if (isset($permisos['Archivos y Fotos']['Consultar'])) {
										echo anchor("archivos_controller/ver_archivos/".str_replace(' ', '_', $ficha->ficha_predial), '<img src="'.base_url().'img/archivos.png"', 'title="Subir archivos"');
										echo anchor("archivos_controller/ver_fotos/".str_replace(' ', '_', $ficha->ficha_predial), '<img src="'.base_url().'img/camara.png"', 'title="Subir fotos"');
									} 
								?>
								<?php if (isset($permisos['Fichas']['Imprimir estudio de t&iacute;tulos'])) { ?><?php echo anchor("informes_controller/estudio_titulos/".$ficha->id_predio, '<img src="'.base_url().'img/doc.png"', 'title="Estudio de T&iacute;tulos"'); ?><?php } ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	<?php echo form_fieldset_close(); ?>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#form table').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers"
		});

		$('#form a[href^="<?php echo site_url('consultas_controller') ?>"]').live('click', function(){
			var palabra_clave = $('div.dataTables_filter input[type=text]').val();
			var url = $(this).attr('href');
			$.post(
				'<?php echo site_url('consultas_controller/guarda_palabra_clave') ?>',
				{
					"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",
					"palabra_clave":palabra_clave
				},
				function (msg) {
					if(msg == 'correcto') {
						location.href = url;
					}
					else {
						return false;
					}
				}
			);
			return false;
		});
		
		$('#form select').change(function(){
			var form_data = {
				"contratista":$('#form select').val(),
				"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"
			};
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('actualizar_controller/fichas_contratista'); ?>",
				data: form_data,
				dataType: "json",
				success: function(msg) {
					var tabla = "<div id='tabla'><table width='100%'><thead><tr><th>Fecha de creaci&oacute;n</th><th>Ficha predial</th><th>Primer propietario</th><th>Usuario</th><th></th></tr></thead><tbody>";
					for(var i = 0; i < msg.length; i++){
						tabla += "<tr>";
						tabla += "<td>" + msg[i].fecha + "</td>";
						tabla += "<td>" + msg[i].ficha + "</td>";
						tabla += "<td>" + msg[i].propietario + "</td>";
						tabla += "<td>" + msg[i].usuario + "</td>";
						tabla += "<td width='220px'>";
						tabla += '<a href="http://www.hatovial.com/site_predios/index.php/consultas_controller/ficha/' + msg[i].predio + '"><img border="0" title="Consultar" src="http://www.hatovial.com/site_predios/img/search.png"></a>';
						<?php if (isset($permisos['Fichas']['Actualizar'])) { ?>tabla += '<a href="http://www.hatovial.com/site_predios/index.php/actualizar_controller/ficha/' + msg[i].predio + '" title="Actualizar"><img src="http://www.hatovial.com/site_predios/img/edit.png"</a>'; <?php } ?>
						<?php if (isset($permisos['Bit&aacute;cora']['Consultar'])) { ?>tabla += '<a href="javascript:void(window.open(\'<?php echo site_url("bitacora_controller/obtener_bitacora"); ?>/' + msg[i].ficha + '\',\'bitacora\',\'resizable=no,location=no,menubar=no, scrollbars=yes,status=no,toolbar=no,fullscreen=no, dependent=no,width=1020,height=600,left=100,top=0\' ))"><img border="0" alt="Ver Bit&aacute;cora" title="Ver Bit&aacute;cora" src="<?php echo base_url(); ?>img/bitacora.png"></a>';<?php } ?>
						<?php if (isset($permisos['Archivos y Fotos']['Consultar'])) { ?>
							tabla += '<a href="http://www.hatovial.com/site_predios/index.php/archivos_controller/ver_archivos/' + msg[i].ficha + '" title="Subir archivos"><img src="http://www.hatovial.com/site_predios/img/archivos.png"</a>';
							tabla += '<a href="http://www.hatovial.com/site_predios/index.php/archivos_controller/ver_fotos/' + msg[i].ficha + '" title="Subir fotos"><img src="http://www.hatovial.com/site_predios/img/camara.png"</a>';
						<?php } ?>
						<?php if (isset($permisos['Informes']['Ver'])) { ?>tabla += '<a href="http://www.hatovial.com/site_predios/index.php/informes_controller/estudio_titulos/' + msg[i].predio + '" title="Estudio de T&iacute;tulos"><img src="http://www.hatovial.com/site_predios/img/doc.png"</a>';<?php } ?>
						tabla += "</td>";
						tabla += "</tr>";
					}
					tabla += "</tbody></table></div>";
					$('#tabla').remove();
					$('#form input[name=posicion_tabla]').after(tabla);
					$('#form table').dataTable({
						"bJQueryUI": true,
						"sPaginationType": "full_numbers"
					});
				}
			});
		});
	});
</script>
