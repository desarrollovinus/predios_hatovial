<div id="form">
	<h1>Administraci&oacute;n -&gt; Permisos del usuario: <?php echo $usuario->us_nombre.' '.$usuario->us_apellido ?></h1>
	
	<div class="clear">&nbsp;</div>
	<?php echo form_open('administracion_controller/actualizar_permisos/'.$this->uri->segment(3))?>
		<div id="accordion">
			<?php foreach ($modulos as $modulo):?>
			<h3><a href="#seccion<?php echo $modulo->id ?>"><?php echo $modulo->nombre?></a></h3>
			<div>
				<table style="width: 100%">
					<?php foreach ($acciones as $accion):?>
						<?php if($accion->modulo == $modulo->id):?>
							<tr>
								<?php if(isset($permisos[$modulo->nombre][$accion->descripcion])):?>
									<td width="100px"><?php echo form_checkbox($accion->id, 'TRUE', TRUE);?></td>
								<?php else: ?>
									<td width="100px"><?php echo form_checkbox($accion->id, 'TRUE', FALSE);?></td>
								<?php endif;?>
								<td><?php echo form_label($accion->descripcion)?></td>
							</tr>
						<?php endif;?>
					<?php endforeach;?>
				</table>
			</div>
			<?php endforeach;?>
		</div>
		<div class="clear"></div>
		<br><br>
		<?php
			$guardar = array(
				'type' => 'submit',
				'name' => 'guardar',
				'id' => 'guardar',
				'value' => 'Guardar cambios'
			);
			echo form_input($guardar); 
			
			$volver = array(
				'type' => 'button',
				'name' => 'volver',
				'id' => 'volver',
				'value' => 'Volver'
			);
			echo form_input($volver); 
		?>
	<?php echo form_close()?>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$( "#accordion" ).accordion
		({
			autoHeight: false,
			navigation: true
		});

		$('#form input[name=volver]').click(function(){
			location.href = '<?php echo site_url('administracion_controller/usuarios'); ?>';
		});

		var opciones = {
			beforeSubmit: function()
			{
				$('#cargando').html('Actualizando los permisos, por favor espere');
				$('#cargando').removeClass('error');
	            $("div#alerta").remove();
	            $("span.error").remove();
				$('#cargando').show();
                },
			success: function(json)
			{
        		json = eval('(' + json + ')');
                if(json.resultado == "correcto")
				{
					$('#cargando').html('Los permisos se actualizaron correctamente.');
					$('#cargando').addClass('correcto');
				}
				else
				{
					$("#pass_text").val('');
					$('#cargando').html('<span class="alerta_icono"></span> Se presentaron errores');
					$('#cargando').addClass('error');
					$('#errores').after('<div id="alerta" class="ui-state-highlight ui-corner-all" style="display:none; margin-top: 20px; padding: 0 .7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>' + json.mensaje + '</p></div>');
					$('div#alerta').fadeIn('slow');
				}
				$('#cargando').delay(2000).fadeOut('slow',function(){
					$(this).removeClass('correcto');
					$(this).removeClass('error');
				});
			}
		};

		$('#form form').ajaxForm(opciones);
	});
</script>