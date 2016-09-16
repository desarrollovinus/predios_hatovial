<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"> 
<p>
	<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span> 
	<strong>Alerta:</strong>Error de PHP.
</p>
</div>
<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;"> 
	<p>
		<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
		Por favor, notifique la siguiente informaci&oacute;n al administrador del sistema:
	</p>
	<p>Severidad: <?php echo $severity ?></p>
	<p>Mensaje:  <?php echo $message ?></p>
	<p>Nombre del archivo: <?php echo $filepath ?></p>
	<p>L&iacute;nea: <?php echo $line ?></p>
</div>
<div class="clear"></div>
