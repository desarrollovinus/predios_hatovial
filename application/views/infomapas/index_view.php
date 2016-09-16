<!DOCTYPE html>
<html>
	<head>
    	<meta charset="<?php echo config_item('charset');?>" />
<title><?php echo $titulo_pagina; ?></title>

<!-- estilos -->
<link rel="stylesheet" href="<?php echo base_url(); ?>css/estilo.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url(); ?>css/cupertino/jquery-ui-1.8.16.custom.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>css/demos.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/fancydropdown.css" type="text/css">

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
<script type="text/javascript" src="<?php echo base_url(); ?>js/fancydropdown.js"></script>
<script type="text/javascript">
	$(document).ready(function () { 
		//esta sentencia es para darle el estilo a los botones jquery.ui 
	    $( "#form input[type=submit], #form input[type=button]").button();
	});
</script>
</head>
	<body>
		<div id="principal">
				<div id="menu-flotante">
					<ul>
						<li><a href="<?php echo site_url('infomapas/ficha/'.$this->uri->segment(3).'/'.$this->uri->segment(4)); ?>"><img title="Ficha predial" src="<?php echo base_url(); ?>img/ficha.png"></a></li>
						<li><a href="<?php echo site_url('infomapas/pagos/'.$this->uri->segment(3).'/'.$this->uri->segment(4)); ?>"><img title="Pagos" src="<?php echo base_url(); ?>img/pagos.png"></a></li>
						<li><a href="<?php echo site_url('infomapas/bitacora/'.$this->uri->segment(3).'/'.$this->uri->segment(4)); ?>"><img title="Bit&aacute;cora" src="<?php echo base_url(); ?>img/bitacora2.png"></a></li>
						<li><div style="top:15px;">Bienvenido <b><?php echo $usuario['nombre_usuario']; ?></b></div></li>
					</ul>
					
				</div>
			<div class="clear"></div>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<div id="contenido">
				<?php echo $this->load->view($contenido_principal); ?>
			</div>
		</div>
		<div id="pie">
			<div align="center">
				<font size="1.5px">Este sitio se visualiza mejor con Internet Explorer 8, Firefox 3.6, Google Chrome 11 (o superiores). Con una resoluci&oacute;n m&iacute;nima de 1024 x 768 pixeles</font>
				<p style="padding-top:5px">&copy; Derechos reservados <?php echo anchor_popup('http://www.hatovial.com/','<b>HATOVIAL S.A.S.</b>'); ?></p>
				<p>Autopista Norte Copacabana<br />Calle 59 No. 48-35<br />PBX: 401 22 77</p>
				<div class="clear"></div>
			</div>
		</div>
		<div id="cargando"></div>
	</body>
</html>