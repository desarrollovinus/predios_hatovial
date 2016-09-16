<?php
/**
 * Controlador del m&oacute;dulo Sesi&oacute;n.
 * @author 		Freddy Alexander Vivas Reyes
 * @copyright	&copy; HATOVIAL S.A.S.
 */
class Sesion_controller extends CI_Controller
{
	/**
	 * Este array almacena los DTO's (Data Transfer Object) que se envian a las vistas
	 * y que son producto de las consultas que realizan los DAO's (Data Access Object) 
	 * a la base de datos, adem&aacute;s de enviar variables encargadas de construir la vista.
	 * 
	 * @access	public
	 */
	var $data = array();
	
	/**
	 * Funci&oacute;n constructora de la clase Sesion_controller. Esta funci&oacute;n hereda el mismo constructor de la clase Controller 
	 * para evitar sobreescribirlo y de esa manera conservar el funcionamiento de controlador.
	 * 
	 * @access	public
	 */
	function __construct()
	{
		//con esta linea se hereda el constructor de la clase Controller
		parent::__construct();
		
		//$contenido_principal = "Inicio de sesion"
		//En la vista esta variable se interpreta de la siguiente manera:
		//	->	En el paquete predios1/application/views/sesion/ existe una archivo llamado index_view.php que tiene el contenido principal de la vista
		$this->data['menu'] = 'sesion/menu';
	}
	
	/**
	 * Funci&oacute;n que se encarga de verificar si un usuario ya inici&oacute; una sesi&oacute;n
	 * Si el usuario ya inici&oacute; la sesi&oacute;n, lo redirecciona hacia el controlador principal del sistema.
	 * Si el usuario no ha iniciado sesi&oacute;n le muestra la vista asociada de inicio de sesi&oacute;n.
	 * 
	 * @access	public
	 */
	function index()
	{
		//Esta linea comprueba si en las variables de sesion se encuentra la variable id_usuario, si esta existe retorna TRUE, FALSE en caso contrario.
		if($this->session->userdata('id_usuario') == TRUE)
		{
			//Si en la sesion existe la variable id_usuario se redirecciona hacia el controlador principal.
			redirect('');
		}
		
		//De esta manera se pasan variables desde el controlador hacia las vistas
		//Al pasar el array asociativo $data, todos sus indices se convierten en variables
		//que son usados por la pagina template para armar la vista.		 
		$this->data['titulo_pagina'] = 'Inicio de sesi&oacute;n';
		
		//$contenido_principal = "Inicio de sesion"
		//En la vista esta variable se interpreta de la siguiente manera:
		//	->	En el paquete predios1/application/views/sesion/ existe una archivo llamado index_view.php que tiene el contenido principal de la vista
		$this->data['contenido_principal'] = 'sesion/index_view';
		
		//De esta manera el controlador carga las vistas y pasa los parametros. Esta sentencia se interpreta de la siguiente manera:
		//	->	En el paquete predios1/application/views/includes existe un archivo llamado template.php que contiene la plantilla a visualizar 
		//		se le pasa el array $data por parametro para que sus indices se conviertan en variables
		$this->load->view('includes/template',$this->data);
	}
	
	/**
	 * Funci&oacute;n que se encarga de iniciar la sesi&oacute;n seg&uacute;n UsuariosDAO retorne o no alg&uacute;n dato a trav&eacute;s de su funci&oacute;n valida_usuario.
	 * 
	 * @access	public
	 */
	function iniciar_sesion()
	{
		//De esta manera el controlador carga los DAO que realizan todas las operaciones de persistencia
		//Esta sentencia se interpreta de la siguiente manera:
		//	->	En el paquete predios1/application/models existe un archivo llamado usuariosDAO.php que es un modelo (DAO) que contiene las funciones
		//		que realiza las consultas a la base de datos.
		$this->load->model(array('UsuariosDAO', 'PermisosDAO'));
		
		//CodeIgniter posee una ayuda para manejar la seguridad de la aplicacion
		//Aqui se va a usar esa ayuda para encriptar la clave del usuario que se esta logueando
		//$this->load->helper('security');
		
		//De esta manera el controlador obtiene las variables pasadas por POST
		//Esta sentencia se interpreta de la siguiente manera:
		//	->	Se obtiene el valor de un input llamado usuario_text del formulario que se esta pasando
		//
		$user = $this->input->post('usuario_text');
		
		//Esta sentencia se interpreta de la siguiente manera:
		//	->	Se obtiene el valor de un input llamado pass_text del formulario que se esta pasando y cuando se obtenga ese valor se va a encriptar usando la funcion md5
		//$pass = do_hash($this->input->post('pass_text'), 'md5');
		$pass = md5($this->input->post('pass_text'));
		
		//Se invoca la funcion valida_usuario de usuariosDAO que retorna
		//	->	Los datos del usuario si los encuentra
		//	->	FALSE en caso contrario
		$datos_usuario = $this->UsuariosDAO->valida_usuario($user, $pass);
		
		//Se verifica si entre las variables que se pasaron por post existe alguna que se llame ajax
		//Cuando la peticion se realiza via ajax, se envia ademas esta variable de control
		$ajax = $this->input->post('ajax');
		
		//Si la consulta trajo algun resultado
		if($datos_usuario)
		{
			//se obtienen los permisos del usuario
			$permisos_usuario = $this->PermisosDAO->obtener_permisos_usuario($datos_usuario->id_usuario);
			//Se arma un array indicando los datos que se van a cargan a la sesion
			$datos_sesion = array(
				"nombre_usuario" => $datos_usuario->us_nombre." ".$datos_usuario->us_apellido,
				"id_usuario" => $datos_usuario->id_usuario,
				"mail_usuario" => $datos_usuario->us_mail,
				"tipo_usuario" => $datos_usuario->us_tipo,
				"permisos" => $permisos_usuario
			);
			
			//Se cargan los datos a la sesion
			$this->session->set_userdata($datos_sesion);
			
			//Si la solicitud se hizo via ajax
			if($ajax)
			{
				//Se envia el mensaje de respuesta
				echo "correcto";
			}
			
			//Si la solicitud no se hizo via ajax
			else 
			{
				//Se redirecciona al controlador principal
				redirect('');
			}
		}
		
		//Si la consulta no trajo ningun resultado
		else
		{
			//Si la peticion se hizo via ajax
			if($ajax)
			{
				//Se envia la respuesta
				echo "Usuario o contrase&ntilde;a incorrectos";
			}
			
			//Si la solicitud no se hizo via ajax
			else 
			{
				//Se carga una variable volatil a la sesion que se destruye automaticamente cuando se realice la siguiente peticion
				//En este caso cargamos la variable error indicando el problema
				$this->session->set_flashdata('error','Usuario o contrase&ntilde;a incorrectos');
				
				//Se redirecciona al contrlador de sesion
				redirect('sesion_controller');
			}
		}
	}
	
	/**
	 * Funcion encargada de destruir los datos de la sesi&oacute;n.
	 * 
	 * @access	public
	 */
	function cerrar_sesion()
	{
		//Se destruye la sesion actual
		$this->session->sess_destroy();
		
		//Se redirige hacia el controlador principal
		redirect('');
	}
}

/* End of file sesion_controller.php */
/* Location: ./predios1/application/controllers/sesion_controller.php */