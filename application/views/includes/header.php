<title><?php echo $titulo_pagina; ?></title>

<!-- estilos -->
<link rel="stylesheet" href="<?php echo base_url(); ?>css/estilo.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url(); ?>css/cupertino/jquery-ui-1.8.16.custom.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>css/demos.css" type="text/css">

<!-- icono -->
<link rel="shortcut icon" href="<?php echo base_url(); ?>img/favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo base_url(); ?>img/favicon.ico" type="image/x-icon">

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
<script type="text/javascript">
	$(document).ready(function () { 
		//esta sentencia es para darle el estilo a los botones jquery.ui 
	    $( "#form input[type=submit], #form input[type=button]").button();

	    //este script es para visualizar correctamente el menu
	    $('.dropdown').each(function () {
			$(this).parent().eq(0).hoverIntent({
				timeout: 100,
				over: function () {
					var current = $('.dropdown:eq(0)', this);
					current.slideDown(100);
				},
				out: function () {
					var current = $('.dropdown:eq(0)', this);
					current.fadeOut(200);
				}
			});
		});

		//este script es para navegar entre controles dentro de la pagina lentamente
		jQuery.fn.scrollTo = function(time){
			var t = $(this).offset().top;
			if(t > 10){t = t - 10;}
			if(time == 'fast'){time = 400;}
			if(time == 'medium'){time = 800;}
			if(time == 'slow'){time = 1200;}
			if(time == null){time = 1000;}
			$('html,body').animate({scrollTop: t}, time);
	    	  
		};

		$('div.ui-state-highlight button[name=ver]')
			.button()
			.click(function(){
				$('#dialog-form-error').dialog('open');
			});

		
		
	    $( "#dialog-form-error" ).dialog({
			autoOpen: false,
			height: $(window).height() < 840 ? $(window).height() : 840,
			width: 670,
			modal: true,
			buttons: {
				Enviar: function() {
					
				},
				Cancelar: function() {
					$('#dialog-form-error input[type=text]').val('');
					$( this ).dialog( "close" );
				}
			},
			close: function() {
				$('#dialog-form-error input[type=text]').val('');
			}
		});
	});  
</script>
