<link rel="stylesheet" href="<?php echo base_url(); ?>css/anythingslider.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>css/colorbox.css" type="text/css" />
<style>
/* New in version 1.7+ */
 #slider1 {
  width: 700px;
  height: 300px;
  list-style: none;
 }
 /* CSS to expand the image to fit inside colorbox */
 #cboxPhoto { width: 100%; height: 100%; margin: 0 !important; }
 /* Change metallic theme defaults to show thumbnails -
  using #demo2 (page wrapper) to increase this CSS priority */
 div.anythingSlider-metallic .thumbNav a {
  background-image: url();
  height: 30px;
  width: 30px;
  border: #000 1px solid;
  border-radius: 2px;
  -moz-border-radius: 2px;
  -webkit-border-radius: 2px;
  text-indent: 0;
 }
 div.anythingSlider-metallic .thumbNav a span {
  visibility: visible; /* span changed to visibility hidden in v1.7.20 */
 }
 /* border around link (image) to show current panel */
 #demo2 div.anythingSlider-metallic .thumbNav a:hover,
 #demo2 div.anythingSlider-metallic .thumbNav a.cur {
  border-color: #fff;
 }
 /* reposition the start/stop button */
 #demo2 div.anythingSlider-metallic .start-stop {
  margin-top: 15px;
 }
</style>
<div id="form">
	<?php 
		echo form_fieldset('<b>Gestor de fotos</b>');
		$permisos = $this->session->userdata('permisos');

		if(isset($permisos['Archivos y Fotos']['Subir'])) {			
			echo form_open_multipart(site_url("archivos_controller/subir_fotos/".$this->uri->segment(3)));
			$upload = array (
	                "name" => "fotos[]",  
	                "multiple"=>"multiple"
	        );            
	        echo form_upload($upload);
	        
	        if($es_ie)
	        {
	        	?>&nbsp;&nbsp;&nbsp;<a href="#" rel="agregar">Agregar m&aacute;s fotos</a><br><?php 
	        	echo form_hidden('mas_archivos');
	        	echo form_hidden('total_agregados','0');
	        }
			
			$volver = array(
				'type' => 'button',
				'name' => 'volver',
				'id' => 'volver',
				'value' => 'Volver'
			);
			echo "<br>".form_input($volver);
			
			$subir = array(
				'type' => 'submit',
				'name' => 'subir',
				'id' => 'subir',
				'value' => 'Subir'
			);
			echo form_input($subir); 
			
			echo form_close();
		}
	?>
	<input type="hidden" id="errores" />
	<div class="clear"></div>
	<br><br>
	<?php if(count($fotos) > 0) {?>
		<ul id="slider1">
			<?php foreach($fotos as $foto): ?>
				<li><img border="0" title="Ver" src="<?php echo base_url().$directorio."/".$foto; ?>"></li>
			<?php endforeach; ?>
		</ul>
	<?php } else { ?>
		<p>A&uacute;n no hay fotos asociadas a la ficha predial <strong><?php echo $this->uri->segment(3); ?></strong></p>
	<?php } ?>
	<?php echo form_fieldset_close(); ?>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.anythingslider.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.colorbox-min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#slider1').anythingSlider({
			toggleControls : true,
			theme          : 'metallic'
  		})
		// target all images inside the current slider
		// replace with 'img.someclass' to target specific images
		.find('.panel:not(.cloned) img') // ignore the cloned panels
		.attr('rel','group')            // add all slider images to a colorbox group
		.colorbox({
			width: '90%',
			height: '90%',
 			href: function(){ return $(this).attr('src'); }	,
			// use $(this).attr('title') for specific image captions
			title: 'Presione ESC para cerrar',
			rel: 'group'
		});

		$('#form input[name=volver]').click(function(){
			history.back();
		});
		
		$('#form a[rel=agregar]').click(function(){
			var consecutivo = parseInt($('#form input[name=total_agregados]').val());
			$('#form input[name=mas_archivos]').before('<p id="' + consecutivo + '"><input name="fotos[]" type="file">&nbsp;&nbsp;&nbsp;<a href="#" rel="eliminar" consecutivo="' + consecutivo + '">Eliminar</a></p>');
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
						$('#cargando').html('Las fotos se subieron exitosamente. Redireccionando...');
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
</script>
