<div id="form" class="acceder">
	<?php echo form_fieldset('<b>Inicio de sesi&oacute;n</b>'); ?>
		<?php echo form_open("sesion_controller/iniciar_sesion"); ?>
			<div align="center">
				<table style='align:"center";' class="tabla">
					<tr>
						<th><?php echo form_label('Usuario:', 'label_usuario') ?></th>
						<td>
							<?php 
								$usuario_text = array(
									'type' => 'text',
									'name' => 'usuario_text',
									'id' => 'usuario_text',
									'value' => ''
								);
								echo form_input($usuario_text); 
							?>
						</td>
					</tr>
					<tr>
						<th><?php echo form_label('Contrase&ntilde;a:', 'label_pass') ?></th>
						<td>
							<?php 
								$pass_text = array(
									'type' => 'password',
									'name' => 'pass_text',
									'id' => 'pass_text',
									'value' => ''
								);
								echo form_input($pass_text); 
							?>
						</td>
					</tr>
				</table>
				<?php
					$boton_enviar = array(
						'type' => 'submit',
						'name' => 'boton_enviar',
						'id' => 'boton_enviar',
						'value' => 'Iniciar sesion'
					); 
					echo form_input($boton_enviar)
				?>
				<br>
				<input type="hidden" id="errores" />
				<?php
					if($this->session->flashdata('error'))
					{
						echo '<div id="alerta" class="ui-state-highlight ui-corner-all" style="display:none; margin-top: 20px; padding: 0 .7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>' + $this->session->flashdata('error') + '</p></div>';
					}
				?>
			</div>
		<?php echo form_close(); ?>
	<?php echo form_fieldset_close(); ?>
</div>
<script type="text/javascript">
	$(document).ready(function()
	{
		//Autofoco
		$("#usuario_text").focus();

		$("form").submit(function()
		{
			$('#cargando').html('Verificando la informaci&oacute;n Por favor espere');
			$('#cargando').removeClass('correcto');
			$('#cargando').removeClass('error');
            $("div#alerta").remove();
            $("span.error").remove();
            $('#cargando').show();
			//se obtiene el atributo action del formulario
			var url = $(this).attr("action");
			//se obtiene el usuario ingresado
			var usuario_text = $("#usuario_text").val();
			//se obtiene el password ingresado
			var pass_text = $("#pass_text").val();

			//variable de control de errores
			var error = false;
			//si el campo usuario esta vacio
			if(usuario_text=="")
			{
				$("#usuario_text").after("<span class='error derecha'>* este campo es obligatorio</span>");
				error = true;
			}
			//si el campo password esta vacio
			if(pass_text=="")
			{
				$("#pass_text").after("<span class='error derecha'>* este campo es obligatorio</span>");
				error = true;
			}
			//si no hay errores
			if( ! error)
			{
				//armo el array con datos que se va a enviar por post
				var form_data={
						usuario_text:usuario_text,
						pass_text:pass_text,
						<?php echo $this->security->get_csrf_token_name(); ?>:"<?php echo $this->security->get_csrf_hash(); ?>",
						ajax:1
				};
				//se realiza la peticion tipo ajax
				$.ajax
				({
					url: url,
					type: 'POST',
					data: form_data,
					success: function(msg)
					{
						if(msg == "correcto")
						{
							$('#cargando').html('Los datos se validaron correctamente. Redireccionando...');
                                                        $('#cargando').addClass('correcto');
                                                        location.href = "<?php echo base_url(); ?>";
						}
						else
						{
							 $("#pass_text").val('');
							 $('#cargando').html('<span class="alerta_icono"></span> Se presentaron errores');
                                                        $('#cargando').addClass('error');
                                                        $('#errores').after('<div id="alerta" class="ui-state-highlight ui-corner-all" style="display:none; margin-top: 20px; padding: 0 .7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>' + msg + '</p></div>');
                                                        $('div#alerta').fadeIn('slow');
						}
						$('#cargando').delay(2000).fadeOut('slow',function(){
							$(this).removeClass('correcto');
							$(this).removeClass('error');
						});
					}
				});
				
			}
			else
			{
				$('#cargando').html('<span class="alerta_icono"></span> Se presentaron errores');
                                $('#cargando').addClass('error');
                                
				$('#cargando').delay(2000).fadeOut('slow',function(){
					$(this).removeClass('correcto');
					$(this).removeClass('error');
				});
			}
			return false;
		});
	});
</script>