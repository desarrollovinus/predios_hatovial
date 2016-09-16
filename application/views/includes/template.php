<?php $permisos = $this->session->userdata('permisos'); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="<?php echo config_item('charset');?>" />
		<?php $this->load->view("includes/header"); ?>
	</head>
	<body>
		<div id="principal">
			<div id="encabezado">
				<div id="usuario">
					<table>
						<tbody>
							<tr>
								<td rowspan="3"><?php if($this->session->userdata('nombre_usuario') == TRUE)  echo "<a href=".site_url('usuario_controller')."><img title='Mis datos' src='".base_url().'img/user.png'."'></a>"; ?></td>
								<td><?php if($this->session->userdata('nombre_usuario') == TRUE) echo "<strong>".$this->session->userdata('nombre_usuario')."</strong>"; ?></td>
							</tr>
							<tr>
								<td><?php if($this->session->userdata('mail_usuario') == TRUE) echo $this->session->userdata('mail_usuario'); ?></td>
							</tr>
							<tr>
								<td><?php if($this->session->userdata('id_usuario') == TRUE) echo anchor('sesion_controller/cerrar_sesion','Cerrar sesi&oacute;n','class=botonCerrar'); ?></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div id="logo"></div>
			</div>
			<div class="clear"></div>
			<?php if($this->uri->segment(1) != "sesion_controller") { ?>
				<ul id="menu">
					<li class="primero"><a class="inicio" href="<?php echo base_url(); ?>"><img border="0" title="Inicio" src="<?php echo base_url(); ?>img/inicio.png"></a></li>
					<?php 
						if (isset($permisos['Fichas']['Crear'])) {
							?><li><a rel="registro" href="<?php echo site_url('registro_controller'); ?>"><span>Registro</span></a></li><?php
						}
					?>
					<?php 
						if(isset($permisos['Fichas']['Consultar'])) {
							?><li><a rel="gestion_predial" href="<?php echo site_url('actualizar_controller'); ?>"><span>Gesti&oacute;n predial</span></a></li><?php
						}
					?>
					<?php 
						if(isset($permisos['Informes']['Ver'])) {
							?><li><a rel="informes" href="<?php echo site_url('informes_controller'); ?>"><span>Informes</span></a></li><?php
						}
					?>
					<?php 
						if($this->session->userdata('tipo_usuario') == 2) {
							?><li><a rel="administracion" href="<?php echo site_url('administracion_controller'); ?>"><span>Administraci&oacute;n</span></a></li><?php
						}
					?>
					
					<li><a rel="normas" href="<?php echo site_url('informes_controller/normas'); ?>"><span>Normas</span></a></li>
					
					<li class="ultimo"><a rel="usuario" href="<?php echo site_url('usuario_controller'); ?>"><span>Usuario</span></a></li>
				</ul>
			<?php } ?>
			<br><br><br>
			<br><br><br>
			<section id="cuerpo">
				<aside><?php $this->load->view($menu); ?></aside>
				<article id="contenido">
					<?php if($this->session->flashdata('error')) { ?>
						<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"> 
							<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Alerta:</strong> <?php echo $this->session->flashdata('error'); ?></p>
						</div>
					<?php } ?>					
					<?php echo $this->load->view($contenido_principal); ?>
				</article>
			</section>
			<div class="clear"></div>
			<br><br><br><br>
			<div id="pie"><?php $this->load->view("includes/footer"); ?></div>
			<?php #print_r($this->session->userdata('permisos')); ?>
			<div id="cargando"></div>
		</div>
		<script type="text/javascript">
			$(document).ready(function(){
				$('ul#menu').css('left', ($(window).width() - $('ul#menu').outerWidth(true)) / 2 + 'px');
			});

			$(window).resize(function() {
				$('ul#menu').css('left', ($(window).width() - $('ul#menu').outerWidth(true)) / 2 + 'px');
			});
		</script>
	</body>
</html>