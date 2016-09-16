<link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table_jui.css" type="text/css" />
<div id="form">
	<h1>Administraci&oacute;n -&gt; Usuarios</h1>
	<?php 
		$crear = array(
			'type' => 'button',
			'name' => 'crear',
			'id' => 'crear',
			'value' => 'Crear un nuevo usuario'
		);
		echo form_input($crear); 
	?>
	
	
	
	<h3>Ver, Editar o Eliminar usuarios existentes</h3>
	<div align="center">
		<table id="tabla" style="width: 100%">
			<thead>
				<tr>
					<th>Documento</th>
					<th>Nombre</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($usuarios as $usuario): ?>
					<tr>
						<td><?php echo form_label($usuario->id_usuario) ?></td>
						<td id="<?php echo $usuario->id_usuario ?>"><?php echo form_label($usuario->us_nombre.' '.$usuario->us_apellido) ?></td>
						<td align="center" width="120px">
							<?php echo anchor(site_url('administracion_controller/editar_usuario').'/'.$usuario->id_usuario, '<img src="'.base_url('').'img/edit.png"', 'title="Actualizar" rel="'.$usuario->id_usuario.'"'); ?>
							<?php echo anchor(site_url('administracion_controller/usuarios')."#", '<img src="'.base_url().'img/delete.png"', 'title="Eliminar" rel="'.$usuario->id_usuario.'"'); ?>
							<?php echo anchor(site_url('administracion_controller/permisos/'.$usuario->id_usuario), '<img src="'.base_url().'img/access.png"', 'title="Permisos"'); ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>

<div id="dialog-form" title="Nuevo usuario.">
	<?php echo form_fieldset('Todos los datos son requeridos.'); ?>
		<table>
			<tr>
				<td><?php echo form_label('C&eacute;dula', 'cedula'); ?></td>
				<td><?php echo form_input('cedula'); ?></td>
			</tr>
			<tr>
				<td><?php echo form_label('Nombre(s)', 'nombre'); ?></td>
				<td><?php echo form_input('nombre'); ?></td>
				<td><?php echo form_label('Apellido(s)', 'apellido'); ?></td>
				<td><?php echo form_input('apellido'); ?></td>
			</tr>
			<tr>
				<td><?php echo form_label('Usuario', 'usuario'); ?></td>
				<td><?php echo form_input('usuario'); ?></td>
				<td><?php echo form_label('Correo', 'correo'); ?></td>
				<td><?php echo form_input('correo'); ?></td>
			</tr>
			<tr>
				<td><?php echo form_label('Password', 'password1'); ?></td>
				<td><?php echo form_password('password1'); ?></td>
				<td><?php echo form_label('Repita password', 'password2'); ?></td>
				<td><?php echo form_password('password2'); ?></td>
			</tr>
			<tr>
				<td><?php echo form_label('Tel&eacute;fono', 'telefono'); ?></td>
				<td><?php echo form_input('telefono'); ?></td>
				<td><?php echo form_label('Tipo', 'tipo'); ?></td>
				<td><?php echo form_dropdown('tipo', array(1 => 'Normal', 2 => 'Administrador')); ?></td>
			</tr>
		</table>
		<div id="error"></div>
	<?php echo form_fieldset_close(); ?>
</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#tabla').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"bDestroy": true
		});

		// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		$( "#dialog-form" ).dialog({autoOpen:false});
		

		$('#form input[name=crear]').click(function(){
			// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
			$( "#dialog:ui-dialog" ).dialog( "destroy" );

			$('#dialog-form input[name=cedula]').removeAttr('readonly');
			$( "#dialog-form" ).dialog({
				autoOpen: false,
				height: 450,
				width: 680,
				modal: true,
				buttons: {
					'Crear usuario': function() {
						$('span.error').remove();
						$('#error').html('');
						var cedula = $.trim($('#dialog-form input[name=cedula]').val());
						var nombre = $.trim($('#dialog-form input[name=nombre]').val());
						var apellido = $.trim($('#dialog-form input[name=apellido]').val());
						var usuario = $.trim($('#dialog-form input[name=usuario]').val());
						var password1 = $.trim($('#dialog-form input[name=password1]').val());
						var password2 = $.trim($('#dialog-form input[name=password2]').val());
						var correo = $.trim($('#dialog-form input[name=correo]').val());
						var telefono = $.trim($('#dialog-form input[name=telefono]').val());
						var tipo = $.trim($('#dialog-form select[name=tipo]').val());
						var error = false;

						if(cedula == '')
						{
							$('#dialog-form input[name=cedula]').after("<span class='error derecha'>&nbsp;<strong>*</strong></span>");
							error = true;
						}

						if(nombre == '')
						{
							$('#dialog-form input[name=nombre]').after("<span class='error derecha'>&nbsp;<strong>*</strong></span>");
							error = true;
						}

						if(usuario == '')
						{
							$('#dialog-form input[name=usuario]').after("<span class='error derecha'>&nbsp;<strong>*</strong></span>");
							error = true;
						}

						if(password1 == '')
						{
							$('#dialog-form input[name=password1]').after("<span class='error derecha'>&nbsp;<strong>*</strong></span>");
							error = true;
						}

						if(password2 == '')
						{
							$('#dialog-form input[name=password2]').after("<span class='error derecha'>&nbsp;<strong>*</strong></span>");
							error = true;
						}

						if(tipo == '')
						{
							$('#dialog-form select[name=tipo]').after("<span class='error derecha'>&nbsp;<strong>*</strong></span>");
							error = true;
						}

						if(password1 != password2)
						{
							$('#error').html("<span class='error derecha'>&nbsp;<strong>Las contrase&ntilde;as deben coincidir</strong></span>");
							error = true;
						} 
						
						if( ! error )
						{
							$.post(
								'<?php echo site_url('administracion_controller/nuevo_usuario'); ?>', 
								{ 
									cedula:cedula,
									nombre:nombre,
									apellido:apellido,
									usuario:usuario,
									password:password1,
									correo:correo,
									telefono:telefono,
									tipo:tipo,
									<?php echo $this->security->get_csrf_token_name(); ?>:"<?php echo $this->security->get_csrf_hash(); ?>" 
								},
								function(msg)
								{
									if(msg == 'correcto')
									{
										$('#dialog-form input').val('');
										location.reload();
									}
									else
									{
										$('#errores').html('<div id="alerta" class="ui-state-highlight ui-corner-all" style="display:none; margin-top: 20px; padding: 0 .7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>' + msg + '</p></div>');
			                            $('div#alerta').fadeIn('slow');
									}
									$( "#dialog-form" ).dialog( "close" );
								}
							);
						}
					},
					Cancelar: function() {
						$('span.error').remove();
						$('#error').html('');
						$('#dialog-form input').val('');
						$( this ).dialog( "close" );
					}
				},
				close: function() {
					$('span.error').remove();
					$('#error').html('');
					$('#dialog-form input').val('');
				}
			});
			
			$('#dialog-form').dialog( "open" );
		});

		$('#form a[title=Actualizar]').live('click', function(){
			var cedula = $(this).attr('rel');
			$('#dialog-form input[name=cedula]').attr('readonly', 'readonly');
			$('#ui-dialog-title-dialog-form').html('Actualizar usuario');
			$.post(
				'<?php echo site_url('administracion_controller/obtener_usuario'); ?>',
				{ cedula:cedula, <?php echo $this->security->get_csrf_token_name(); ?>:"<?php echo $this->security->get_csrf_hash(); ?>"  },
				function(usuario) {
					// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
					$( "#dialog:ui-dialog" ).dialog( "destroy" );
					$( "#dialog-form" ).dialog({
						autoOpen: false,
						height: 450,
						width: 680,
						modal: true,
						buttons: {
							Actualizar: function() {
								$('span.error').remove();
								$('#error').html('');
								var cedula = $.trim($('#dialog-form input[name=cedula]').val());
								var nombre = $.trim($('#dialog-form input[name=nombre]').val());
								var apellido = $.trim($('#dialog-form input[name=apellido]').val());
								var usuario = $.trim($('#dialog-form input[name=usuario]').val());
								var password1 = $.trim($('#dialog-form input[name=password1]').val());
								var password2 = $.trim($('#dialog-form input[name=password2]').val());
								var correo = $.trim($('#dialog-form input[name=correo]').val());
								var telefono = $.trim($('#dialog-form input[name=telefono]').val());
								var tipo = $.trim($('#dialog-form select[name=tipo]').val());
								var error = false;

								if(cedula == '')
								{
									$('#dialog-form input[name=cedula]').after("<span class='error derecha'>&nbsp;<strong>*</strong></span>");
									error = true;
								}

								if(nombre == '')
								{
									$('#dialog-form input[name=nombre]').after("<span class='error derecha'>&nbsp;<strong>*</strong></span>");
									error = true;
								}

								if(usuario == '')
								{
									$('#dialog-form input[name=usuario]').after("<span class='error derecha'>&nbsp;<strong>*</strong></span>");
									error = true;
								}

								if(password1 != '' && password2 == '')
								{
									$('#dialog-form input[name=password2]').after("<span class='error derecha'>&nbsp;<strong>*</strong></span>");
									error = true;
								}

								if(password2 != '' && password1 == '')
								{
									$('#dialog-form input[name=password1]').after("<span class='error derecha'>&nbsp;<strong>*</strong></span>");
									error = true;
								}

								if(tipo == '')
								{
									$('#dialog-form select[name=tipo]').after("<span class='error derecha'>&nbsp;<strong>*</strong></span>");
									error = true;
								}

								if(password1 != password2)
								{
									$('#error').html("<span class='error derecha'>&nbsp;<strong>Las contrase&ntilde;as deben coincidir</strong></span>");
									error = true;
								} 
								
								if( ! error )
								{
									$.post(
										'<?php echo site_url('administracion_controller/editar_usuario'); ?>', 
										{ 
											cedula:cedula,
											nombre:nombre,
											apellido:apellido,
											usuario:usuario,
											password:password1,
											correo:correo,
											telefono:telefono,
											tipo:tipo,
											<?php echo $this->security->get_csrf_token_name(); ?>:"<?php echo $this->security->get_csrf_hash(); ?>" 
										},
										function(msg)
										{
											if(msg == 'correcto')
											{
												$('#dialog-form input').val('');
												location.reload();
											}
											else
											{
												$('#errores').html('<div id="alerta" class="ui-state-highlight ui-corner-all" style="display:none; margin-top: 20px; padding: 0 .7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>' + msg + '</p></div>');
					                            $('div#alerta').fadeIn('slow');
											}
											$( "#dialog-form" ).dialog( "close" );
										}
									);
								}
							},
							Cancelar: function() {
								$('span.error').remove();
								$('#error').html('');
								$('#dialog-form input').val('');
								$( this ).dialog( "close" );
							}
						},
						close: function() {
							$('span.error').remove();
							$('#error').html('');
							$('#dialog-form input').val('');
						}
					});

					$('#dialog-form input[name=cedula]').val(usuario.cedula);
					$('#dialog-form input[name=nombre]').val(usuario.nombre);
					$('#dialog-form input[name=apellido]').val(usuario.apellido);
					$('#dialog-form input[name=usuario]').val(usuario.usuario);
					$('#dialog-form input[name=password1]').val('');
					$('#dialog-form input[name=password2]').val('');
					$('#dialog-form input[name=correo]').val(usuario.correo);

					$('#dialog-form input[name=telefono]').val(usuario.telefono);
					$('#dialog-form select[name=tipo] option[value=' + usuario.tipo + ']').attr('selected', true);

					$('#dialog-form').dialog( "open" );
					
				},
				'json'
			);
			
			return false;
		});

		$('#form a[title=Eliminar]').click(function(){
			var cedula = $(this).attr('rel');
			$.post(
				'<?php echo site_url('administracion_controller/obtener_usuario')?>',
				{
					cedula:cedula,
					<?php echo $this->security->get_csrf_token_name(); ?>:"<?php echo $this->security->get_csrf_hash(); ?>" 
				},
				function(usuario) {
					//en el template hay un div con id="cargando", despues de ese div se agrega otro con id="dialog-confirm"
					$('#dialog-form').append('<div id="dialog-confirm"></div>');
					//al div que se acaba de crear se le agrega el atributo title="¿Desea borrar este propietario?"
					$('#dialog-confirm').attr('title', 'Confirmaci&oacute;n');
					//tambien se le agrega el siguiente codigo html entre sus tags de inicio y final
					$('#dialog-confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Desea eliminar al usuario: ' + usuario.nombre + ' ' + usuario.apellido + '?</p>');
					//se le da formato con la libreria de jquery y se muestra con las opciones siguientes
					$( "#dialog-confirm" ).dialog({
						resizable: false,
						height:200,
						width:420,
						modal: true,
						buttons: {
							Si: function() {
								$.post(
									'<?php echo site_url('administracion_controller/eliminar_usuario')?>',
									{
										cedula:usuario.cedula,
										<?php echo $this->security->get_csrf_token_name(); ?>:"<?php echo $this->security->get_csrf_hash(); ?>" 
									},
									function(msg) {
										if(msg == 'correcto') {
											location.reload();
										}
										else {
											$('#errores').html('<div id="alerta" class="ui-state-highlight ui-corner-all" style="display:none; margin-top: 20px; padding: 0 .7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>' + msg + '</p></div>');
				                            $('div#alerta').fadeIn('slow');
										}
										$( "#dialog" ).dialog( "close" );
									}
								);
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
				},
				'json'
			);
		});
	});
</script>