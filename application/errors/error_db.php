<!DOCTYPE html>
<html>
	<head>
		<title>Error de bases de datos</title>
		<?php
			$sitio = "http://www.hatovial.com/site_predios/";
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
						<strong>Alerta:</strong>Error de base de datos.
					</p>
				</div>
				<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;"> 
					<p>
						<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
						Al parecer ocurrió un error en la conexi&oacute;n con la base de datos. Comun&iacute;quese con el administrador del sitio.
					</p>
				</div>
			</div>
		</div>
	</body>
</html>