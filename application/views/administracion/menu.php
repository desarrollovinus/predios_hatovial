<ul>
	<li <?php if ($this->uri->segment(2)=='' || $this->uri->segment(2)=='Usuarios') {
		echo 'class="current"';
	} ?>><a href="<?php echo site_url('administracion_controller'); ?>"><span>Usuarios</span></a></li>
	<li <?php if ($this->uri->segment(2)=='contratistas') {
		echo 'class="current"';
	} ?>><a href="<?php echo site_url('administracion_controller/contratistas'); ?>"><span>Contratistas</span></a></li>
	<li <?php if ($this->uri->segment(2)=='tramos') {
		echo 'class="current"';
	} ?>><a href="<?php echo site_url('administracion_controller/tramos'); ?>"><span>Tramos</span></a></li>
	<li <?php if ($this->uri->segment(2)=='logs') {
		echo 'class="current"';
	} ?>><a href="<?php echo site_url('administracion_controller/logs'); ?>"><span>Logs</span></a></li>
</ul>