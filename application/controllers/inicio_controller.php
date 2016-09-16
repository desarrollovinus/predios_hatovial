<?php
/**
 * Controlador del m&oacute;dulo de Inicio.
 * @author 		Freddy Alexander Vivas Reyes
 * @copyright	&copy; HATOVIAL S.A.S.
 */
class Inicio_controller extends CI_Controller{
	/**
	 * Este array almacena los DTO's (Data Transfer Object) que se envian a las vistas
	 * y que son producto de las consultas que realizan los DAO's (Data Access Object) 
	 * a la base de datos, adem&aacute;s de enviar variables encargadas de construir la vista.
	 * 
	 * @access	public
	 */
	var $data = array();
	
	/**
	 * Funci&oacute;n constructora de la clase Inicio_controller. Esta funci&oacute;n se encarga de verificar que se haya
	 * iniciado sesi&oacute;n, si no se ha iniciado sesi&oacute;n inmediatamente redirecciona hacia Sesion_controller.
	 * 
	 * Se hereda el mismo constructor de la clase Controller para evitar sobreescribirlo y de esa manera 
	 * conservar el funcionamiento de controlador.
	 * 
	 * @access	public
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
		
		//$contenido_principal = "Inicio de sesion"
		//En la vista esta variable se interpreta de la siguiente manera:
		//	->	En el paquete predios1/application/views/sesion/ existe una archivo llamado index_view.php que tiene el contenido principal de la vista
		$this->data['menu'] = 'inicio/menu';
	}
	
	/**
	 * Muestra la vista principal de la aplicaci&oacute;n.
	 * 
	 * @access	public
	 */
	function index(){
		//se establece el titulo de la pagina
		$this->data['titulo_pagina'] = 'P&aacute;gina de Inicio';
		//se establece la vista que tiene el contenido principal
		$this->data['contenido_principal'] = 'inicio/index_view';
		//se carga el template
		$this->load->view('includes/template', $this->data);
	}
	

	
	function adminsitrar_usuarios()
	{
		$this->load->scaffolding('tbl_usuarios');
	}
}

/* End of file inicio_controller.php */
/* Location: ./predios1/application/controllers/inicio_controller.php */