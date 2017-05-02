<?php 
/**
 * Clase encargada de controlar las operaciones sobre las actas prediales (Cambio de prueba)
 * @author Freddy Alexander Vivas Reyes
 * @copyright 2012
 */
class Actas_controller extends CI_Controller {
	/**
	 * Array que se encarga de enviar las variables a las vistas
	 * @var Array asociativo
	 */
	var $data = array();
	/**
	 * Constructor del controlador
	 */
	function __construct()
	{
		parent::__construct();
		//si el usuario no esta logueado
		if($this->session->userdata('id_usuario') != TRUE)
		{
			//redirecciono al controlador de sesion
			redirect('sesion_controller');
		}
		//obtengo los permisos que tiene el usuario
		$permisos = $this->session->userdata('permisos');
		if( ! isset($permisos['Actas']['Consultar']) ) {
			//si no tiene permisos de consultar el modulo de actas
			$this->session->set_flashdata('error', 'Usted no cuenta con permisos para consultar el m&oacute;dulo de Actas.');
			//redirecciono hacia el controlador principal
			redirect('');
		}
		//se establece la vista que tiene el contenido del menu
		$this->data['menu'] = 'actas/menu';
	}
	/**
	 * Pagina principal del modulo
	 */
	function index() {
		//se carga el modelo encargado de las consultas del modulo de actas
		$this->load->model('ActasDAO');
		//se arma el array asociativo que se pasa a las vistas
		$this->data['actas'] = $this->ActasDAO->obtener_actas();
		$this->data['titulo_pagina'] = 'Actas';
		$this->data['contenido_principal'] = 'actas/index_view';
		//se carga la vista indicada con los parametros pasados por el array asociativo
		$this->load->view('includes/template', $this->data);
	}
	/**
	 * Funcion encargada de guardar cada campo modificado en la tabla.
	 * Por cada ficha que se seleccione para modificar son 4 solicitudes (1 por cada campo a actualizar)a esta funcion.
	 */
	function actualizar_campo() {
		//obtengo los permisos que tiene el usuario
		$permisos = $this->session->userdata('permisos');
		if( ! isset($permisos['Actas']['Actualizar']) ) {
			//si no tiene permisos para actualizar el modulo de actas
			$this->session->set_flashdata('error', 'Usted no cuenta con permisos para actualizar el m&oacute;dulo de Actas.');
			//redirecciono hacia el controlador principal
			redirect('');
		}
		//se obtiene la ficha pasada por POST
		$ficha = $this->input->post('ficha');
		//se obtiene el campo a actualizar pasado por POST
		$campo = $this->input->post('campo');
		//se obtiene el valor a asignar pasado por POST
		$valor = $this->input->post('valor');
		//se carga el modelo que gestiona las consultas del modulo de actas
		$this->load->model('ActasDAO');
		if($this->ActasDAO->actualizar_campo($ficha, $campo, $valor)) {
			//si se logra actualizar el campo
			echo 'correcto|'.$valor.'|input_'.$campo.'_'.$ficha;
		}
		else {
			//si no se logra actualizar el campo
			echo 'Hubo problemas al guardar un valor, intente nuevamente.';
		}
		
		//NOTA: se hace un echo porque la solicitud se realiza via AJAX la cual espera una salida (echo) de este archivo
	}
}
/* End of file actas_controller.php */
/* Location: ./site_predios/application/controllers/actas_controller.php */