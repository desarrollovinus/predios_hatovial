<?php $permisos = $this->session->userdata('permisos'); ?>
<ul>
	<li><a href="<?php echo site_url('actualizar_controller'); ?>">Gesti&oacute;n de fichas</a></li>
	<li class="current"><a href="<?php echo site_url('bitacora_controller'); ?>">Bit&aacute;cora</a></li>
	<?php if(isset($permisos['Actas']['Consultar'])) { ?><li><a href="<?php echo site_url('actas_controller'); ?>">Gesti&oacute;n de Actas</a></li><?php } ?>
	<?php if(isset($permisos['Pagos']['Consultar'])) { ?><li><a href="<?php echo site_url('pagos_controller'); ?>">Gesti&oacute;n de Pagos</a></li><?php } ?>
	<li><a href="<?php echo site_url('propietarios_controller'); ?>">Gesti&oacute;n de Propietarios</a></li>
</ul>