<?php
/**
 * Clase encargada de controlar las acciones relacionadas con la administracion de la pagina
 * @author Freddy Alexander Vivas Reyes
 * @copyright 2012
 */
class Administracion_controller extends CI_Controller {
	/**
	 * Variable que almacena los datos pasados a las vistas
	 * @var Array asociativo
	 */
	var $data = array();
	/**
	 * Constructor de la clase
	 */
	function __construct() {
		parent::__construct();
		//si el usuario no esta logueado
		if($this->session->userdata('id_usuario') != TRUE)
		{
			//redirecciono al controlador de sesion
			redirect('sesion_controller');
		}
		//si el rol del usuario es distinto al 2 (administrador)
		if($this->session->userdata('tipo_usuario') != 2) {
			//se redirecciona al controlador principal
			$this->session->set_flashdata('error', 'Usted no cuenta con permisos para consultar el m&oacute;dulo de Administraci&oacute;n.');
			redirect('');
		}
		$this->data['menu'] = 'administracion/menu';
	}
	/**
	 * Pagina principal del modulo de administracion
	 */
	function index() {
		$this->usuarios();
	}
	/**
	 * Modulo para adminsitrar los estados de procesos
	 */
	function estados_procesos() {
		
		//se carga el modelo de los procesos
		$this->load->model('ProcesosDAO');
		//se establecen las variables que irán a las vistas
		$this->data['estados_procesos'] = $this->ProcesosDAO->obtener_estados_proceso();
		$this->data['titulo_pagina'] = 'Administracion -> Estados Procesos';
		$this->data['contenido_principal'] = 'administracion/estados_procesos_view';
		//se carga la vista indicada
		$this->load->view('includes/template', $this->data);
	}
	/**
	 * Modulo para administrar los tramos
	 */
	function tramos() {
		//se carga el modelo de los tramos
		$this->load->model('TramosDAO');
		//se asignan las variables que van para las vistas
		$this->data['tramos'] = $this->TramosDAO->obtener_tramos();
		$this->data['titulo_pagina'] = 'Administracion -> Tramos';
		$this->data['contenido_principal'] = 'administracion/tramos_view';
		//se carga la vista
		$this->load->view('includes/template', $this->data);
	}
	/**
	 * Modulo para administrar los contratistas
	 */
	function contratistas() {
		//se carga el modelo de los contratistas
		$this->load->model('ContratistasDAO');
		//se preparan las variables que van para la vista
		$this->data['contratistas'] = $this->ContratistasDAO->obtener_contratistas();
		$this->data['titulo_pagina'] = 'Administracion -> Contratistas';
		$this->data['contenido_principal'] = 'administracion/contratistas_view';
		//se carga la vista
		$this->load->view('includes/template', $this->data);
	}
	/**
	 * Modulo para administrar los informes
	 */
	function informes() {
		//se carga el modelo de los informes
		$this->load->model('InformesDAO');
		//se establecen las variables que iran a la vista
		$this->data['informes'] = $this->InformesDAO->obtener_informes();
		$this->data['titulo_pagina'] = 'Administracion -> Informes';
		$this->data['contenido_principal'] = 'administracion/informes_view';
		//se carga la vista
		$this->load->view('includes/template', $this->data);
	}
	/**
	 * Modulo para administrar los modulos del sistema
	 */
	function modulos() {
		//se carga el modelo de los modulos del sistema
		$this->load->model('ModulosDAO');
		//se establecen las variables que van a la vista
		$this->data['modulos'] = $this->ModulosDAO->obtener_modulos();
		$this->data['titulo_pagina'] = 'Administracion -> Modulos';
		$this->data['contenido_principal'] = 'administracion/modulos_view';
		//se carga la vista
		$this->load->view('includes/template', $this->data);
	}
	/**
	 * Modulo para administrar las acciones
	 */
	function acciones() {
		//se carga el modelo de las acciones
		$this->load->model('AccionesDAO');
		//se establecen las variables que iran a la vista
		$this->data['acciones'] = $this->AccionesDAO->obtener_acciones();
		$this->data['titulo_pagina'] = 'Administracion -> Acciones';
		$this->data['contenido_principal'] = 'administracion/acciones_view';
		//se carga la vista
		$this->load->view('includes/template', $this->data);
	}
	/**
	 * Modulo para administrar los usuarios
	 */
	function usuarios() {
		//se carga el modelo de los usuarios
		$this->load->model('UsuariosDAO');
		//se establecen las variables que van a la vista
		$this->data['usuarios'] = $this->UsuariosDAO->obtener_usuarios();
		$this->data['titulo_pagina'] = 'Administracion -> Usuarios';
		$this->data['contenido_principal'] = 'administracion/usuarios_view';
		//se carga la vista
		$this->load->view('includes/template', $this->data);
	}
	/**
	 * Modulo para administrar los permisos
	 */
	function permisos() {
		//se obtiene el id del usuario desde la url
		$usuario = $this->uri->segment(3);
		//si no se pasa la id
		if(!$usuario && $usuario != 0) {
			//se redirecciona al controlador principal
			redirect('');
		}
		//se cargan los modelos de los modulos, acciones, usuarios y permisos
		$this->load->model(array('ModulosDAO', 'AccionesDAO', 'UsuariosDAO', 'PermisosDAO'));
		//se establecen las variables que van a la vista
		$this->data['modulos'] = $this->ModulosDAO->obtener_modulos();
		$this->data['acciones'] = $this->AccionesDAO->obtener_acciones();
		$this->data['usuario'] = $this->UsuariosDAO->obtener_usuario($usuario);
		$this->data['permisos'] = $this->PermisosDAO->obtener_permisos_usuario($usuario);
		$this->data['titulo_pagina'] = 'Administracion -> Permisos';
		$this->data['contenido_principal'] = 'administracion/permisos_view';
		//se carga la vista
		$this->load->view('includes/template', $this->data);
	}
	/**
	 * Metodo para actualizar los permisos de un usuario
	 */
	function actualizar_permisos() {
		//se carga el modelo de los permisos
		$this->load->model('PermisosDAO');
		//array que almacenara el estado de los permisos
		$acciones = array();
		foreach ($_POST as $key => $value):
			if($key != 'guardar') {
				//se llena el array 
				array_push($acciones, $key);
			}
		endforeach;
		//se envia la respuesta de la actualizacion de permisos via JSON
		echo json_encode($this->PermisosDAO->actualizar_permisos($acciones, $this->uri->segment(3)));
	}
	
	function nuevo_usuario() {
		$cedula = $this->input->post("cedula");
		$nombre = $this->input->post("nombre");
		$apellido = $this->input->post("apellido");
		$usuario = $this->input->post("usuario");
		$password = $this->input->post("password");
		$correo = $this->input->post("correo");
		$telefono = $this->input->post("telefono");
		$tipo = $this->input->post("tipo");
		
		$this->load->model("UsuariosDAO");
		$user = array(
			"id_usuario" => $cedula,
			"us_nombre" => $nombre,
			"us_apellido" => $apellido,
			"us_user" => $usuario,
			"us_pass" => md5($password),
			"us_mail" => $correo,
			"us_tel" => $telefono,
			"us_tipo" => $tipo,
			"fecha" => date("Y:m:d H:i:s")
		);
		
		if($this->UsuariosDAO->insertar_usuario($user)) {
			echo "correcto";
		}
		else {
			echo "No se logr&oacute;crear el usuario";
		}
	}
	
	function editar_usuario() {
		$cedula = $this->input->post("cedula");
		$nombre = $this->input->post("nombre");
		$apellido = $this->input->post("apellido");
		$usuario = $this->input->post("usuario");
		$password = md5($this->input->post("password"));
		$correo = $this->input->post("correo");
		$telefono = $this->input->post("telefono");
		$tipo = $this->input->post("tipo");
		
		$this->load->model("UsuariosDAO");
		if($password == '') {
			$user = array(
				"id_usuario" => $cedula,
				"us_nombre" => $nombre,
				"us_apellido" => $apellido,
				"us_user" => $usuario,
				"us_mail" => $correo,
				"us_tel" => $telefono,
				"us_tipo" => $tipo,
				"fecha" => date("Y:m:d H:i:s")
			);					
		}
		else {
			$user = array(
				"id_usuario" => $cedula,
				"us_nombre" => $nombre,
				"us_apellido" => $apellido,
				"us_user" => $usuario,
				"us_pass" => $password,
				"us_mail" => $correo,
				"us_tel" => $telefono,
				"us_tipo" => $tipo,
				"fecha" => date("Y:m:d H:i:s")
			);			
		}
		
		if($this->UsuariosDAO->actualizar_usuario($user)) {
			echo "correcto";
		}
		else {
			echo "No se logr&oacute; actualizar el usuario";
		}
	}
	
	function obtener_usuario() {
		$cedula = $this->input->post('cedula');
		$this->load->model('UsuariosDAO');
		$usuario = $this->UsuariosDAO->obtener_usuario($cedula);
		
		$json = array(
			"cedula" => $usuario->id_usuario,
			"nombre" => $usuario->us_nombre,
			"apellido" => $usuario->us_apellido,
			"usuario" => $usuario->us_user,
			"password" => $usuario->us_pass,
			"correo" => $usuario->us_mail,
			"telefono" => $usuario->us_tel,
			"tipo" => $usuario->us_tipo,
			"fecha" => $usuario->fecha
		);
		
		echo json_encode($json);
	}
	
	function eliminar_usuario() {
		$cedula = $this->input->post('cedula');
		$this->load->model('UsuariosDAO');
		
		if($this->UsuariosDAO->eliminar_usuario($user)) {
			echo "correcto";
		}
		else {
			echo "No se logr&oacute; eliminar el usuario";
		}
	}

	function logs () {
		$this->load->model('LogsDAO');

		$this->data['contenido_principal'] = 'administracion/logs_view';
		$this->data['titulo_pagina'] = 'Registro de Logs';
		$this->data['logs'] = $this->LogsDAO->obtener_logs();

		$this->load->view('includes/template', $this->data);
	}
}
/* End of file administracion_controller.php */
/* Location: ./site_predios/application/controllers/administracion_controller.php */