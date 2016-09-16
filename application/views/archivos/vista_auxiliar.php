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
		<script type="text/javascript">
			$(document).ready(function(){
				$('#form input[type=button], #form input[type=submit]').button();
			});
		</script>
	</head>
	<body>
		<div id="principal">
			<div id="contenido">
				<?php if(isset($error)) {?>
					<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"> 
						<p>
							<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span> 
							<strong>Alerta:</strong> <?php echo $this->session->flashdata('error'); ?>
						</p>
					</div>
				<?php } else { $this->load->view($contenido_principal); } ?>
			</div>
		</div>
		<div id="cargando"></div>
	</body>
</html>