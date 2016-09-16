<link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table_jui.css" type="text/css" />
<div id="form">
	<?php
		echo form_fieldset('<b>Gestor de archivos</b>');
		$permisos = $this->session->userdata('permisos');

		if(isset($permisos['Archivos y Fotos']['Subir'])) {

			echo form_open_multipart(site_url("archivos_controller/subir_archivos/".$this->uri->segment(3)));
			$upload = array (
	                "name" => "archivos[]",
	                "multiple"=>"multiple"
	        );
	        echo form_upload($upload);

	        if($es_ie)
	        {
	        	?>&nbsp;&nbsp;&nbsp;<a href="#" rel="agregar">Agregar m&aacute;s archivos</a><br><?php
	        	echo form_hidden('mas_archivos');
	        	echo form_hidden('total_agregados','0');
	        }

			$subir = array(
				'type' => 'submit',
				'name' => 'subir',
				'id' => 'subir',
				'value' => 'Subir'
			);
			echo form_input($subir);

			echo form_close();
		}

		$volver = array(
			'type' => 'button',
			'name' => 'volver',
			'id' => 'volver',
			'value' => 'Volver'
		);
		echo "<br>".form_input($volver);
	?>
	<div id="dialog-confirm" title="Eliminar archivo" hidden>
	  ¿Esta seguro(a) de realizar esta acción?
	</div>
	<br /><input type="hidden" id="errores" />
	<div class="clear"></div>
	<br><br>
	<table id="tabla" style='width:100%'>
		<thead>
			<tr>
				<th>Nombre de archivo</th>
				<th width="10%"></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($archivos as $archivo): ?>
				<tr>
					<td><?php echo $archivo; ?></td>
					<td>
		              <?php echo anchor_popup(base_url().$directorio."/".$archivo, '<img border="0" title="Ver" src="'.base_url().'img/search.png">', "'DESCRIPCION','resizable=no,location=no,menubar=no, scrollbars=yes,status=no,toolbar=no,fullscreen=no,d ependent=no,width=800,height=564,left=100,top=100' ))");?>
		              <?php if (isset($permisos['Archivos y Fotos']['Eliminar'])): ?>
		                <a onclick="javascript:eliminar_mensaje('<?= $archivo ?>')" style="cursor: pointer">
		                  <img src="<?php echo base_url(); ?>img/delete.png" title="Eliminar archivo">
		                </a>
		              <?php endif; ?>
		            </td>
 				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<?php echo form_fieldset_close(); ?>

</div>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#tabla').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers"
		});

		$('#form input[name=volver]').click(function(){
			history.back();
		});

		$('#form a[rel=agregar]').click(function(){
			var consecutivo = parseInt($('#form input[name=total_agregados]').val());
			$('#form input[name=mas_archivos]').before('<p id="' + consecutivo + '"><input name="archivos[]" type="file">&nbsp;&nbsp;&nbsp;<a href="#" rel="eliminar" consecutivo="' + consecutivo + '">Eliminar</a></p>');
			$('#form input[name=total_agregados]').val(consecutivo + 1);
			return false;
		});

		$('#form a[rel=eliminar]').live('click', function(){
			var consecutivo = parseInt($(this).attr('consecutivo'));
			$('#form p[id=' + consecutivo + ']').remove();
			return false;
		});

		var opciones = {
                beforeSubmit: function()
                {
					$('#cargando').html('Enviando la informaci&oacute;n Por favor espere');
					$('#cargando').removeClass('error');
		            $("div#alerta").remove();
		            $("span.error").remove();
					$('#cargando').show();
                },
                success: function(msg)
                {
                	if(msg == "correcto")
					{
						$('#cargando').html('Los archivos se subieron exitosamente. Redireccionando...');
                        $('#cargando').addClass('correcto');
                        location.reload();
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
		};

		//aqui se intercepta el evento submit y se ejecutan las funciones pasadas por parametro al ajaxForm
		$('#form form').ajaxForm(opciones);
	});

	function eliminar_archivo(archivo) {
		console.log({"archivo": archivo, "directorio": "<?= $directorio ?>", "ficha": "<?=  $ficha ?>"});
		$.ajax({
			url: "<?php echo site_url('archivos_controller/eliminar_archivo'); ?>",
			data: {"archivo": archivo, "directorio": "<?= $directorio ?>", "ficha": "<?=  $ficha ?>"},
			type: "POST",
			dataType: "html",
			async: true,
			success: function(respuesta){
				//Si la respuesta no es error
				if(respuesta){
					//Se almacena la respuesta como variable de éxito
					console.log(respuesta);
				}
			},//Success
			error: function(respuesta){
				//Variable de exito será mensaje de error de ajax
		  console.log(respuesta);
			}//Error
		});//Ajax
		location.reload();
	}

	function eliminar_mensaje(archivo) {
		$( "#dialog-confirm" ).dialog({
			resizable: false,
			height:200,
			width:420,
			modal: true,
			buttons: {
				Si: function() {
					eliminar_archivo(archivo);
					//se destruye el elemento dialog
					$( "#dialog:ui-dialog" ).dialog( "destroy" );
					//se remueve el div con id="dialog-confirm" del documento html
					$('#dialog-confirm').remove();
					//se cierra el elemento flotante
					$( this ).dialog( "close" );
				},
				No: function() {
					//se cierra el elemento flotante
					$( this ).dialog( "close" );
				}
			}
		});
	}
</script>
