<div id="form">
	<h1>Datos personales</h1>
	<table>
		<tr>
			<th><?php echo form_label('C&eacute;dula', 'cedula'); ?></th>
			<td><?php echo form_input('cedula', $usuario->id_usuario, 'readonly="readonly"'); ?></td>
		</tr>
		<tr>
			<th><?php echo form_label('Nombre(s)', 'nombre'); ?></th>
			<td><?php echo form_input('nombre', $usuario->us_nombre); ?></td>
		</tr>
		<tr>
			<th><?php echo form_label('Apellido(s)', 'apellido'); ?></th>
			<td><?php echo form_input('apellido', $usuario->us_apellido); ?></td>
		</tr>
		<tr>
			<th><?php echo form_label('Usuario', 'usuario'); ?></th>
			<td><?php echo form_input('usuario', $usuario->us_user); ?></td>
		</tr>
		<tr>
			<th><?php echo form_label('Correo', 'correo'); ?></th>
			<td><?php echo form_input('correo', $usuario->us_mail); ?></td>
		</tr>
		<tr>
			<th><?php echo form_label('Tel&eacute;fono', 'telefono'); ?></th>
			<td><?php echo form_input('telefono', $usuario->us_tel); ?></td>
		</tr>
		<tr>
			<th><?php echo form_label('Password', 'password1'); ?></th>
			<td><?php echo form_password('password1'); ?></td>
		</tr>
		<tr>
			<th><?php echo form_label('Repita password', 'password2'); ?></th>
			<td><?php echo form_password('password2'); ?></td>
		</tr>
	</table>
	<div id="errores"></div>
	<br>
	<?php 
		$actualizar = array(
			'type' => 'button',
			'name' => 'actualizar',
			'id' => 'actualizar',
			'value' => 'Actualizar datos'
		);
		echo form_input($actualizar); 
	?>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#form input[name=actualizar]').click(function(){
			$('#cargando').html('Actualizando los datos, por favor espere...');
			$('#cargando').removeClass('error');
	        $("div#alerta").remove();
	        $("span.error").remove();
			$('#cargando').show();
			var cedula = $.trim($('#form input[name=cedula]').val());
			var nombre = $.trim($('#form input[name=nombre]').val());
			var apellido = $.trim($('#form input[name=apellido]').val());
			var usuario = $.trim($('#form input[name=usuario]').val());
			var password1 = $.trim($('#form input[name=password1]').val());
			var password2 = $.trim($('#form input[name=password2]').val());
			var correo = $.trim($('#form input[name=correo]').val());
			var telefono = $.trim($('#form input[name=telefono]').val());
			var error = false;
			
			if(nombre == '')
			{
				$('#form input[name=nombre]').after("<span class='error derecha'>&nbsp;<strong>Debe ingresar su nombre</strong></span>");
				error = true;
			}
			
			if(password1 != '' && password2 == '')
			{
				$('#form input[name=password2]').after("<span class='error derecha'>&nbsp;<strong>*</strong></span>");
				error = true;
			}
			
			if(password2 != '' && password1 == '')
			{
				$('#form input[name=password1]').after("<span class='error derecha'>&nbsp;<strong>*</strong></span>");
				error = true;
			}
			
			if(password1 != password2)
			{
				$('#errores').before("<span class='error derecha'>&nbsp;<strong>Las contrase&ntilde;as deben coincidir</strong></span>");
				error = true;
			} 
			
			if( ! error )
			{
				$.post(
					'<?php echo site_url('usuario_controller/actualizar'); ?>', 
					{
						cedula:cedula,
						nombre:nombre,
						apellido:apellido,
						usuario:usuario,
						password:password1,
						correo:correo,
						telefono:telefono,
						<?php echo $this->security->get_csrf_token_name(); ?>:"<?php echo $this->security->get_csrf_hash(); ?>" 
					},
					function(msg)
					{
						if(msg == 'correcto')
						{
							$('#cargando').html('Los datos se actualizaron correctamente.');
                                                        $('#cargando').addClass('correcto');
						}
						else
						{
							$('#errores').html('<div id="alerta" class="ui-state-highlight ui-corner-all" style="display:none; margin-top: 20px; padding: 0 .7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>' + msg + '</p></div>');
                                                        $('div#alerta').fadeIn('slow');
						}
						$('#cargando').delay(2000).fadeOut('slow',function(){
							$(this).removeClass('correcto');
							$(this).removeClass('error');
						});
					}
				);
			}
			else
			{
				$('#cargando').html('<span class="alerta_icono"></span> Se presentaron errores');
                $('#cargando').addClass('error');
				$('#errores').html('<div id="alerta" class="ui-state-highlight ui-corner-all" style="display:none; margin-top: 20px; padding: 0 .7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>Por favor, revise los campos marcados con <font color="red">*</font></p></div>');
                $('div#alerta').fadeIn('slow');
			}
			$('#cargando').delay(2000).fadeOut('slow',function(){
				$(this).removeClass('correcto');
				$(this).removeClass('error');
			});
		});
	});
</script>