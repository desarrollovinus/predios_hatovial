<?php $permisos = $this->session->userdata('permisos'); ?>
<!DOCTYPE html>
<html>
	<head>
<title><?php echo $titulo_pagina; ?></title>

<!-- estilos -->
<link rel="stylesheet" href="<?php echo base_url(); ?>css/estilo.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url(); ?>css/cupertino/jquery-ui-1.8.16.custom.css" type="text/css" />
<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>css/base/jquery.ui.all.css" type="text/css" /> -->
<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>css/base/jquery.ui.datepicker.css" type="text/css" />-->
<link rel="stylesheet" href="<?php echo base_url(); ?>css/demos.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/fancydropdown.css" type="text/css">

<!-- icono -->
<link rel="shortcut icon" href="<?php echo site_url('img/favicon.ico'); ?>">

<!-- scripts -->
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.ui.button.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.ui.accordion.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.ui.mouse.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.ui.draggable.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.ui.position.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.ui.dialog.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.ui.resizable.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery.effects.core.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.bgiframe-2.1.2.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/fancydropdown.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table_jui.css" type="text/css" />
</head>
	<body>
		<div id="principal">
			<div id="contenido">
				<div id="form">
					<?php echo form_fieldset("Bit&aacute;cora de la ficha predial <b>$ficha_predial</b>"); ?>
						<h3>Primer propietario: 
							<?php 
								if(!empty($propietario)) {
									echo utf8_decode($propietario->nombre); 
								}
								else {
									echo 'No hay propietarios asociados a esta ficha predial';
								}
							?>
						</h3>
						<input type="hidden" id="ubicacion-tabla" />
						<div id="div-tabla"></div>
						<div class="clear">&nbsp;</div>
						<?php
							if (isset($permisos['Bit&aacute;cora']['Insertar anotaciones'])) {
								$anotacion = array(
									'type' => 'button',
									'name' => 'anotacion',
									'id' => 'anotacion',
									'value' => 'Nueva anotacion'
								); 
								echo form_input($anotacion);
							}
						?>
					<?php echo form_fieldset_close(); ?>
					
					<div id="dialog-form" title="Agregar nueva entrada.">
						<?php echo form_fieldset('Todos los datos son requeridos.'); ?>
							<table>
								<tr>
									<td><?php echo form_label('Fecha', 'fecha'); ?></td>
									<td><?php echo form_input('fecha'); ?></td>
									<td><?php echo form_label('T&iacute;tulo', 'titulo'); ?></td>
									<td><?php echo form_input('titulo'); ?></td>
								</tr>
								<tr>
									<td><?php echo form_label('Remitente', 'remitente'); ?></td>
									<td><?php echo form_input('remitente'); ?></td>
									<td><?php echo form_label('Radicado', 'radicado'); ?></td>
									<td><?php echo form_input('radicado'); ?></td>
								</tr>
								<tr>
									<td colspan="6"><?php echo form_label('Observaci&oacute;n'); ?></td>
								</tr>
								<tr>
									<td colspan="6"><?php echo form_textarea('observacion'); ?></td>
								</tr>
							</table>
						<?php echo form_fieldset_close(); ?>
					</div>
					<div id="dialog-form-editar" title="Editar entrada.">
						<?php echo form_fieldset('Todos los datos son requeridos.'); ?>
							<?php echo form_hidden('id_bitacora'); ?>
							<table>
								<tr>
									<td><?php echo form_label('Fecha', 'fecha_editar'); ?></td>
									<td><?php echo form_input('fecha_editar'); ?></td>
									<td><?php echo form_label('Titulo', 'titulo_editar'); ?></td>
									<td><?php echo form_input('titulo_editar'); ?></td>
								</tr>
								<tr>
									<td><?php echo form_label('Remitente', 'remitente_editar'); ?></td>
									<td><?php echo form_input('remitente_editar'); ?></td>
									<td><?php echo form_label('Radicado', 'radicado_editar'); ?></td>
									<td><?php echo form_input('radicado_editar'); ?></td>
								</tr>
								<tr>
									<td colspan="6"><?php echo form_label('Observaci&oacute;n'); ?></td>
								</tr>
								<tr>
									<td colspan="6"><?php echo form_textarea('observacion_editar'); ?></td>
								</tr>
							</table>
						<?php echo form_fieldset_close(); ?>
					</div>
				</div>
				<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
				<script type="text/javascript">
					$(document).ready(function(){
						//esta funcion saca la ventana de confirmacion jquery
						function abrir_ventana_dialogo(titulo, mensaje, funcion)
						{
							//en el template hay un div con id="cargando", despues de ese div se agrega otro con id="dialog-confirm"
							$('#cargando').append('<div id="dialog-confirm"></div>');
							//al div que se acaba de crear se le agrega el atributo title="¿Desea borrar este propietario?"
							$('#dialog-confirm').attr('title', titulo);
							//tambien se le agrega el siguiente codigo html entre sus tags de inicio y final
							$('#dialog-confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>' + mensaje + '</p>');
							//se le da formato con la libreria de jquery y se muestra con las opciones siguientes
							$( "#dialog-confirm" ).dialog({
								resizable: false,
								height:200,
								width:420,
								modal: true,
								buttons: {
									Si: function() {
										funcion();
										//se destruye el elemento dialog
										$( "#dialog:ui-dialog" ).dialog( "destroy" );
										//se remueve el div con id="dialog-confirm" del documento html
										$('#dialog-confirm').remove();
										//se cierra el elemento flotante
										$( this ).dialog( "close" );
									},
									No: function() {
										//se destruye el elemento dialog
										$( "#dialog:ui-dialog" ).dialog( "destroy" );
										//se remueve el div con id="dialog-confirm" del documento html
										$('#dialog-confirm').remove();
										//se cierra el elemento flotante
										$( this ).dialog( "close" );
									}
								}
							});
						}
						
						$.post('<?php echo site_url('bitacora_controller/obtener_bitacora'); ?>', { ficha:'<?php echo $ficha_predial; ?>', <?php echo $this->security->get_csrf_token_name(); ?>:"<?php echo $this->security->get_csrf_hash(); ?>" }, 
							function(msg){
								respuesta = msg.split('|');
								console.log(respuesta)
								if(respuesta[0] == 'correcto')
								{
									$('#div-tabla').remove();
									$('#ubicacion-tabla').after('<div id="div-tabla">' + respuesta[1] + '</div>');
									$('#tabla').dataTable({
										"bJQueryUI": true,
										"sPaginationType": "full_numbers",
										"bDestroy": true
									});
								}
								else
								{
									$('#errores-arriba').after('<div id="alerta" class="ui-state-highlight ui-corner-all" style="display:none; margin-top: 20px; padding: 0 .7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>' + respuesta[0] + '</p></div>');
				                        $('div#alerta').fadeIn('slow');
								}
							}
						);
						
						//esta sentencia es para darle el estilo a los botones jquery.ui 
					    $( "#form input[type=submit], #form input[type=button]").button();
						
						// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
						$( "#dialog:ui-dialog" ).dialog( "destroy" );
						
						$( "#dialog-form-editar" ).dialog({
							autoOpen: false,
							height: 510,
							width: 840,
							modal: true,
							buttons: {
								Editar: function() {
									$('span.error').remove();
									var fecha = $.trim($('#dialog-form-editar input[name=fecha_editar]').val());
									var remitente = $.trim($('#dialog-form-editar input[name=remitente_editar]').val());
									var radicado = $.trim($('#dialog-form-editar input[name=radicado_editar]').val());
									var titulo = $.trim($('#dialog-form-editar input[name=titulo_editar]').val());
									var observacion = $.trim($('#dialog-form-editar textarea[name=observacion_editar]').val());
									var id_bitacora = $.trim($('#dialog-form-editar input[name=id_bitacora]').val());
									var error = false;
									
									if(fecha == '')
									{
										$('#dialog-form-editar input[name=fecha_editar]').after("<span class='error derecha'>&nbsp;<strong>*</strong></span>");
										error = true;
									}
				
									if(remitente == '')
									{
										$('#dialog-form-editar input[name=remitente_editar]').after("<span class='error derecha'>&nbsp;<strong>*</strong></span>");
										error = true;
									}
				
									if(titulo == '')
									{
										$('#dialog-form-editar input[name=titulo_editar]').after("<span class='error derecha'>&nbsp;<strong>*</strong></span>");
										error = true;
									}
				
									if(observacion == '')
									{
										$('#dialog-form-editar textarea[name=observacion_editar]').after("<span class='error derecha'>&nbsp;<strong>*</strong></span>");
										error = true;
									}
									
									if( ! error )
									{
										$.post('<?php echo site_url('bitacora_controller/editar_anotacion'); ?>', { id_bitacora:id_bitacora, fecha:fecha, remitente:remitente, radicado: radicado, titulo:titulo, observacion:observacion, <?php echo $this->security->get_csrf_token_name(); ?>:"<?php echo $this->security->get_csrf_hash(); ?>" },
											function(json)
											{
												if(json.mensaje == 'correcto')
												{
													$('#dialog-form-editar input[type=text]').val('');
													$('#dialog-form-editar textarea[name=observacion_editar]').val('');
													location.reload();
												}
												else
												{
													$('#errores-abajo').after('<div id="alerta" class="ui-state-highlight ui-corner-all" style="display:none; margin-top: 20px; padding: 0 .7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>' + json.mensaje + '</p></div>');
						                            $('div#alerta').fadeIn('slow');
												}
												$( "#dialog-form-editar" ).dialog( "close" );
											} , 'json'
										);
									}
								},
								Cancelar: function() {
									$('#dialog-form-editar input[type=text]').val('');
									$( this ).dialog( "close" );
								}
							},
							close: function() {
								$('#dialog-form-editar input[type=text]').val('');
							}
						});
						
						$( "#dialog-form" ).dialog({
							autoOpen: false,
							height: 510,
							width: 840,
							modal: true,
							buttons: {
								Insertar: function() {
									$('span.error').remove();
									var ficha = "<?php echo $ficha_predial; ?>";
									var fecha = $.trim($('#dialog-form input[name=fecha]').val());
									var remitente = $.trim($('#dialog-form input[name=remitente]').val());
									var radicado = $.trim($('#dialog-form input[name=radicado]').val());
									var titulo = $.trim($('#dialog-form input[name=titulo]').val());
									var observacion = $.trim($('#dialog-form textarea[name=observacion]').val());
									var error = false;

									if(ficha == '')
									{
										$('#form input[name=ficha_predial]').after("<span class='error derecha'>&nbsp;<strong>*</strong></span>");
										error = true;
									}
									if(fecha == '')
									{
										$('#dialog-form input[name=fecha]').after("<span class='error derecha'>&nbsp;<strong>*</strong></span>");
										error = true;
									}
				
									if(remitente == '')
									{
										$('#dialog-form input[name=remitente]').after("<span class='error derecha'>&nbsp;<strong>*</strong></span>");
										error = true;
									}
				
									if(titulo == '')
									{
										$('#dialog-form input[name=titulo]').after("<span class='error derecha'>&nbsp;<strong>*</strong></span>");
										error = true;
									}
				
									if(observacion == '')
									{
										$('#dialog-form textarea[name=observacion]').after("<span class='error derecha'>&nbsp;<strong>*</strong></span>");
										error = true;
									}
									
									if( ! error )
									{
										$.post('<?php echo site_url('bitacora_controller/nueva_entrada'); ?>', { ficha:ficha, fecha:fecha, remitente:remitente, radicado: radicado, titulo:titulo, observacion:observacion, <?php echo $this->security->get_csrf_token_name(); ?>:"<?php echo $this->security->get_csrf_hash(); ?>" },
											function(msg)
											{
												if(msg == 'correcto')
												{
													$('#dialog-form input[type=text]').val('');
													$('#dialog-form textarea[name=observacion]').val('');
													location.reload();
												}
												else
												{
													$('#errores-abajo').after('<div id="alerta" class="ui-state-highlight ui-corner-all" style="display:none; margin-top: 20px; padding: 0 .7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>' + msg + '</p></div>');
						                            $('div#alerta').fadeIn('slow');
												}
												$( "#dialog-form" ).dialog( "close" );
											} 
										);
									}
								},
								Cancelar: function() {
									$('#dialog-form input[type=text]').val('');
									$( this ).dialog( "close" );
								}
							},
							close: function() {
								$('#dialog-form input[type=text]').val('');
							}
						});
				
						$('#form a[title=Eliminar]').live('click', function(event){
							var a = $(this);
							var url = a.attr('href');
							var data = {
								"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",
								"id_bitacora":a.attr('id')
							};
							var success = function(json){
								if(json.mensaje == 'correcto') {
									$('#cargando').html('Entrada eliminada correctamente.');
				                    $('#cargando').addClass('correcto');
				                    location.reload();
								}
								else {
									 $("#pass_text").val('');
									 $('#cargando').html('<span class="alerta_icono"></span> Se presentaron errores');
				                     $('#cargando').addClass('error');
				                     $('#errores-arriba, #errores-abajo').after('<div id="alerta" class="ui-state-highlight ui-corner-all" style="display:none; margin-top: 20px; padding: 0 .7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>' + json.mensaje + '</p></div>');
				                     $('div#alerta').fadeIn('slow');
								}
								$('#cargando').delay(2000).fadeOut('slow',function(){
									$(this).removeClass('correcto');
									$(this).removeClass('error');
								});
							};
				
							abrir_ventana_dialogo('Eliminar anotaci&oacute;n de la bit&aacute;cora', 'Esta seguro(a) de realizar esta acci&oacute;n?', function(){
								$('#cargando').html('Eliminando la entrada, por favor espere...');
								$('#cargando').removeClass('error');
					            $("div#alerta").remove();
					            $("span.error").remove();
								$('#cargando').show();
								$.post(url, data, success, 'json');
							});
							event.preventDefault();
						});
				
						$('#form a[title=Editar]').live('click', function(event){
							$('span.error').remove();
							$('div#alerta').remove();
							$('#dialog-form-editar').dialog( "open" );
							var tr = $(this).closest('tr');
							
							$('#dialog-form-editar input[name=id_bitacora]').val($(this).attr('id'));
				
							tr.children('td').each(function(index) {
								switch(index) {
									case 0:{ $('#dialog-form-editar input[name=fecha_editar]').val($(this).text()); }break;
									case 1:{ $('#dialog-form-editar input[name=remitente_editar]').val($(this).text()); }break;
									case 2:{ $('#dialog-form-editar input[name=titulo_editar]').val($(this).text()); }break;
									case 3:{ $('#dialog-form-editar textarea[name=observacion_editar]').val($(this).text()); }break;
									case 4:{ $('#dialog-form-editar input[name=radicado_editar]').val($(this).text()); }break;
								}
							});
				
							$('#dialog-form-editar input[name=fecha_editar]').focus();
							event.preventDefault();
						});
						
						$('#tabla').dataTable({
							"bJQueryUI": true,
							"sPaginationType": "full_numbers",
							"bDestroy": true
						});
				
						$('#form input[name=anotacion]').click(function(){
							$('#dialog-form').dialog( "open" );
						});
				
						$('#dialog-form input[name=fecha]').datepicker();
						$('#dialog-form-editar input[name=fecha_editar]').datepicker();
					});
				</script>
			</div>
		</div>
		<div id="cargando"></div>
	</body>
</html>
