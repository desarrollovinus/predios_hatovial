<?php
class Usuario_controller extends CI_Controller {
	var $data = array();
	function __construct() {
		parent::__construct();
		//si el usuario no esta logueado
		if($this->session->userdata('id_usuario') != TRUE) {
			//redirecciono al controlador de sesion
			redirect('sesion_controller');
		}	
		//se establece la vista que tiene el contenido del menu
		$this->data['menu'] = 'usuario/menu';
	}
	
	function index() {
		$this->load->model('UsuariosDAO');
		$this->data['usuario'] = $this->UsuariosDAO->obtener_usuario($this->session->userdata('id_usuario'));
		$this->data['titulo_pagina'] = 'Datos personales';
		$this->data['contenido_principal'] = 'usuario/index_view';
		
		$this->load->view('includes/template', $this->data);
	}
	
	function actualizar() {
		$cedula = $this->input->post("cedula");
		$nombre = $this->input->post("nombre");
		$apellido = $this->input->post("apellido");
		$usuario = $this->input->post("usuario");
		$password = $this->input->post("password");
		$correo = $this->input->post("correo");
		$telefono = $this->input->post("telefono");
		
		$this->load->model("UsuariosDAO");
		if($password == '') {
			$user = array(
				"id_usuario" => $cedula,
				"us_nombre" => $nombre,
				"us_apellido" => $apellido,
				"us_user" => $usuario,
				"us_mail" => $correo,
				"us_tel" => $telefono
			);					
		}
		else {
			$user = array(
				"id_usuario" => $cedula,
				"us_nombre" => $nombre,
				"us_apellido" => $apellido,
				"us_user" => $usuario,
				"us_pass" => md5($password),
				"us_mail" => $correo,
				"us_tel" => $telefono
			);			
		}
		
		if($this->UsuariosDAO->actualizar_usuario($user)) {
			echo "correcto";
		}
		else {
			echo "No se logr&oacute; actualizar el usuario";
		}
	}
}