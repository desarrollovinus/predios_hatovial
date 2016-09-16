<!DOCTYPE html>
<html>
	<head>
		<title>P&aacute;gina no encontrada</title>
		<?php
			$sitio = "http://www.hatovial.com/predios/";
		?>
		<link rel="stylesheet" href="<?php echo $sitio ?>css/estilo.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $sitio ?>css/cupertino/jquery-ui-1.8.16.custom.css" type="text/css" media="screen" />
		<link rel="shortcut icon" href="<?php echo $sitio ?>img/favicon.ico">
	</head>
	<body>
		<div id="principal">
			<div id="encabezado">
				<div id="nombre_aplicacion"></div>
				<div id="logo"></div>
			</div>
			<div class="clear"></div>
			<div id="contenido">
				<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"> 
					<p>
						<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span> 
						<strong>Alerta:</strong>La p&aacute;gina que est&aacute; buscando no existe.
					</p>
				</div>
				<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;"> 
					<p>
						<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
						Puede intentar lo siguiente:
					</p>
					<ul>
						<li>Volver a escribir la direcci&oacute;n</li>
						<li><a href="javascript:history.back()" style="text-decoration:none"><font color="blue">Regresar a la p&aacute;gina anterior.</font></a></li>
					</ul>
				</div>
			</div>
		</div>
	</body>
</html>