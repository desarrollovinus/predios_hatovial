<?php
ini_set('post_max_size','100M');
ini_set('upload_max_filesize','100M');
ini_set('max_execution_time','1000');
ini_set('max_input_time','1000');

/**
 * Clase encargada de controlar las operaciones que se realizan sobre los archivos
 * @author Freddy Alexander Vivas Reyes
 * @copyright 2012
 */
class Archivos_controller extends CI_Controller
{
	/**
	 * Variable encargada de almacenar las variables que van a las vistas
	 * @var Array asociativo
	 */
	var $data = array();
	/**
	 * Ruta raiz de los archivos
	 * @var String
	 */
	var $ruta_archivos = "files/";
	/**
	 * Ruta de las fotos
	 * @var String
	 */
	var $nombre_carpeta_fotos = "fotos/";
	/**
	 * Variable que indica si hubo o no error
	 * @var Boolean
	 */
	var $error = FALSE;
	/**
	 * Metodo constructor del controlador
	 */
	function __construct()
	{
		//se hereda el constructor del controlador padre
		parent::__construct();	
		//si el usuario no esta logueado
		if($this->session->userdata('id_usuario') != TRUE)
		{
			//redirecciono al controlador de sesion
			redirect('sesion_controller');
		}
		//se verifican los permisos del usuario
		$permisos = $this->session->userdata('permisos');
		//se verifica que tenga permiso de consultar los archivos y fotos del sistema
		if ( ! isset($permisos['Archivos y Fotos']['Consultar']) ) {
			//se verifica si la funcion encargada de procesar la accion no es vista_archivos_actas
			//la cual es una funcion que se ofrece para que se puedan consultar los archivos desde
			//el controlador de actas
			if($this->uri->segment(2) != strtolower('vista_archivos_actas')) {
				//si no se tienen permisos se indica que hay un error
				$this->session->set_flashdata('error', 'Usted no cuenta con permisos para visualizar los archivos y fotos.');
				//se redirije al controlador principal
				redirect('');
			}
			else {
				//variable de control
				$this->error = TRUE;
			}
		}
		//se establece la vista que tiene el contenido del menu
		$this->data['menu'] = 'archivos/menu';
	}
	/**
	 * Metodo para ver los archivos del sistema
	 */
	function ver_archivos()
	{
		//se obtiene la ficha predial por url
		$ficha = $this->uri->segment(3);
		//si no llega la ficha
		if( ! $ficha)
		{
			//se redirecciona hacia el controlador de actualizaciones
			redirect('actualizar_controller');
		}
		else
		{
			//sino entonces se verifica que exista la ruta de donde se van a leer los archivos
			if( ! is_dir($this->ruta_archivos.$ficha) )
			{
				//sino entonces se crea la ruta con todos los permisos
				@mkdir($this->ruta_archivos.$ficha, 0777);
			}
				
			//se abre el directorio
			if($directorio = opendir($this->ruta_archivos.$ficha))
			{
				//se arma un array de nombres de archivo
				$nombres = array();
				//se lee archivo por archivo
				while(($file = readdir($directorio)) !== FALSE)
				{
					if($file != '.' && $file != '..' && $file != 'fotos')
					{
						//se guardan los nombres en el array
						array_push($nombres, $file);
					}						
				}
				
				//se cierra el directorio
				closedir();
				//se carga la libreria que permite establecer el browser con el que se abrio la pagina
				$this->load->library('user_agent');
				//se establecen las variables que van a la vista
				$this->data['es_ie'] = $this->agent->is_browser('Internet Explorer');
				$this->data['archivos'] = $nombres;
				$this->data['directorio'] = $this->ruta_archivos.$ficha;
				$this->data['script'] = "/site_predios/archivos_controller/subir_archivos/$ficha";
				$this->data['titulo_pagina'] = "Archivos - ficha predial $ficha";
				$this->data['contenido_principal'] = 'archivos/archivos_view';
				//se carga la vista
				$this->load->view('includes/template',$this->data);
			}
		}	
	}
	/**
	 * Metodo encargado de ofrecer una vista desde los controladores de actualizaciones de fichas prediales y actas
	 */
	function obtener_archivos() {
		//se obtiene la ficha predial pasada por url
		$ficha = $this->uri->segment(3);
		//se obtiene el array de permisos del usuario
		$permisos = $this->session->userdata('permisos');
		//si no tiene permiso de consultar el modulo de actas
		if( ! isset($permisos['Actas']['Consultar']) ) {
			$this->data['titulo_pagina'] = "Archivos - ficha predial $ficha";
		}
		
		if( ! is_dir($this->ruta_archivos.$ficha) )
		{
			@mkdir($this->ruta_archivos.$ficha, 0777);
		}
			
		//se abre el directorio
		if($directorio = opendir($this->ruta_archivos.$ficha))
		{
			//se arma un array de nombres de archivo
			$nombres = array();
			
			while(($file = readdir($directorio)) !== FALSE)
			{
				if($file != '.' && $file != '..' && $file != 'fotos')
				{
					array_push($nombres, $file);
				}						
			}
			
			//se cierra el directorio
			closedir();
			
			$this->load->library('user_agent');
			$this->data['es_ie'] = $this->agent->is_browser('Internet Explorer');
			$this->data['archivos'] = $nombres;
			$this->data['directorio'] = $this->ruta_archivos.$ficha;
			$this->data['script'] = "/site_predios/archivos_controller/subir_archivos/$ficha";
			$this->data['titulo_pagina'] = "Archivos - ficha predial $ficha";
			$this->data['contenido_principal'] = 'archivos/archivos_view';
			$this->load->view('archivos/vista_auxiliar',$this->data);
		}
	}
	
	function ver_fotos()
	{
		$ficha = $this->uri->segment(3);
		if( ! $ficha)
		{
			redirect('actualizar_controller');
		}
		else
		{
			if( ! is_dir($this->ruta_archivos.$ficha) )
			{
				@mkdir($this->ruta_archivos.$ficha, 0777);
			}
			if( ! is_dir($this->ruta_archivos.$ficha.'/'.$this->nombre_carpeta_fotos) )
			{
				@mkdir($this->ruta_archivos.$ficha.'/'.$this->nombre_carpeta_fotos, 0777);
			}
				
			//se abre el directorio
			if($directorio = opendir($this->ruta_archivos.$ficha.'/'.$this->nombre_carpeta_fotos))
			{
				//se arma un array de nombres de archivo
				$nombres = array();
				
				while(($file = readdir($directorio)) !== FALSE)
				{
					if($file != '.' && $file != '..')
					{
						array_push($nombres, $file);
					}						
				}
				
				//se cierra el directorio
				closedir();
				
				$this->load->library('user_agent');
				$this->data['es_ie'] = $this->agent->is_browser('Internet Explorer');
				$this->data['fotos'] = $nombres;
				$this->data['directorio'] = $this->ruta_archivos.$ficha.'/'.$this->nombre_carpeta_fotos;
				$this->data['script'] = "/site_predios/archivos_controller/subir_archivos/$ficha";
				$this->data['titulo_pagina'] = "Archivos - ficha predial $ficha";
				$this->data['contenido_principal'] = 'archivos/fotos_view';
				$this->load->view('includes/template',$this->data);
			}
		}	
	}
	
	function subir_archivos()
	{
		$permisos = $this->session->userdata('permisos');
		if ( ! isset($permisos['Archivos y Fotos']['Subir']) ) {
			$this->session->set_flashdata('error', 'Usted no cuenta con permisos para subir archivos.');
			redirect('');
		}
		$carpeta = $this->ruta_archivos.str_replace(' ','_', $this->uri->segment(3));
		$resultado = "correcto";
		
		if(isset($_FILES['archivos'])) {
			foreach ($_FILES['archivos']['error'] as $key => $error) {
				if ($error == UPLOAD_ERR_OK) {
					$tmp_name = $_FILES['archivos']['tmp_name'][$key];
					$name = $_FILES['archivos']['name'][$key];
					
					if( ! move_uploaded_file($tmp_name, $carpeta.'/'.$name))
					{
						$resultado = "Ocurri&oacute; un error al subir los ficheros, verifique por favor.";
					}
				}
			}
			
			echo $resultado;
		}
		else {
			echo "Debe seleccionar al menos un archivo";
		}
	}
	
	function subir_fotos()
	{
		$permisos = $this->session->userdata('permisos');
		if ( ! isset($permisos['Archivos y Fotos']['Subir']) ) {
			$this->session->set_flashdata('error', 'Usted no cuenta con permisos para subir fotos.');
			redirect('');
		}
		$carpeta = $this->ruta_archivos.str_replace(' ','_', $this->uri->segment(3)).'/'.$this->nombre_carpeta_fotos;
		$resultado = "correcto";
		
		if(isset($_FILES['fotos'])) {
			foreach ($_FILES['fotos']['error'] as $key => $error) {
				if ($error == UPLOAD_ERR_OK) {
					$tmp_name = $_FILES['fotos']['tmp_name'][$key];
					$name = $_FILES['fotos']['name'][$key];
					
					if( ! move_uploaded_file($tmp_name, $carpeta.'/'.$name))
					{
						$resultado = "Ocurri&oacute; un error al subir las fotos, verifique por favor.";
					}
				}
			}
			
			echo $resultado;
		}
		else {
			echo "Debe seleccionar al menos una foto";
		}
	}
	
	function obtener_fotos() {
		$ficha = $this->uri->segment(3);
		
			if( ! is_dir($this->ruta_archivos.$ficha) )
		{
			@mkdir($this->ruta_archivos.$ficha, 0777);
		}
		if( ! is_dir($this->ruta_archivos.$ficha.'/'.$this->nombre_carpeta_fotos) )
		{
			@mkdir($this->ruta_archivos.$ficha.'/'.$this->nombre_carpeta_fotos, 0777);
		}
			
		//se abre el directorio
		if($directorio = opendir($this->ruta_archivos.$ficha.'/'.$this->nombre_carpeta_fotos))
		{
			//se arma un array de nombres de archivo
			$nombres = array();
			
			while(($file = readdir($directorio)) !== FALSE)
			{
				if($file != '.' && $file != '..')
				{
					array_push($nombres, $file);
				}						
			}
			
			//se cierra el directorio
			closedir();
			
			$this->load->library('user_agent');
			$this->data['es_ie'] = $this->agent->is_browser('Internet Explorer');
			$this->data['fotos'] = $nombres;
			$this->data['directorio'] = $this->ruta_archivos.$ficha.'/'.$this->nombre_carpeta_fotos;
			$this->data['script'] = "/site_predios/archivos_controller/subir_archivos/$ficha";
			$this->data['titulo_pagina'] = "Archivos - ficha predial $ficha";
			$this->data['contenido_principal'] = 'archivos/fotos_view';
			$this->load->view('archivos/vista_auxiliar',$this->data);
		}
	}
}
/* End of file archivos_controller.php */
/* Location: ./site_predios/application/controllers/archivos_controller.php */