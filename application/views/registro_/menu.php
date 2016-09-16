<?php $permisos = $this->session->userdata('permisos'); ?>
<?php if(isset($permisos['Fichas']['Consultar'])) { ?>
&Uacute;ltimos 10 predios registrados:
<ul>
	<?php foreach ($ultimas_fichas as $ficha_predial): ?>
		<li><a href="<?php echo site_url('consultas_controller/ficha')."/".$ficha_predial->id_predio; ?>"><?php echo $ficha_predial->ficha_predial; ?></a></li>
	<?php endforeach; ?>
</ul>
<?php } ?>