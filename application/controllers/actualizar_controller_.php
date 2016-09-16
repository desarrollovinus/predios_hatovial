<?php
/**
 * Clase encargada de controlar las actualizaciones de las fichas prediales
 * @author Freddy Alexander Vivas Reyes
 * @copyright 2012
 */
class Actualizar_controller extends CI_Controller {
	/**
	 * Array que se encarga de enviar las variables a las vistas
	 * @var Array asociativo
	 */
	var $data = array();
	/**
	 * Constructor del controlador
	 */
	function __construct() {
		//se hereda el constructor de CI_Controller
		parent::__construct();
		//si el usuario no esta logueado
		if($this->session->userdata('id_usuario') != TRUE) {
			//redirecciono al controlador de sesion
			redirect('sesion_controller');
		}	
		//se obtienen los permisos del usuario
		$permisos = $this->session->userdata('permisos');
		if( ! isset($permisos['Fichas']['Consultar']) ) {
			//si no tiene permiso de consultar las fichas
			$this->session->set_flashdata('error', 'Usted no cuenta con permisos para consultar el m&oacute;dulo de Gesti&oacute;n de Fichas Prediales.');
			//se redirige al controlador principal
			redirect('');
		}
		//se establece la vista que tiene el contenido del menu
		$this->data['menu'] = 'actualizar/menu';
	}
	/**
	 * Pagina principal del modulo
	 */
	function index() {
		//se carga el modelo que gestiona las consultas del modulo de Predios y del modulo de Contratistas
		$this->load->model(array('PrediosDAO', 'ContratistasDAO'));
		//se arma el array asociativo que se envia a la vista
		$this->data['fichas'] = 				$this->PrediosDAO->obtener_fichas();
		$this->data['contratistas'] =			$this->ContratistasDAO->obtener_contratistas();
		$this->data['titulo_pagina'] = 			'Actualizar';
		$this->data['contenido_principal'] = 	'actualizar/index_view';
		//se carga la vista y se envia el array asociativo
		$this->load->view('includes/template', $this->data);
	}
	/**
	 * Muestra la información de la ficha seleccionada
	 */
	function ficha()
	{
		//se cargan los permisos
		$permisos = $this->session->userdata('permisos');
		if( ! isset($permisos['Fichas']['Actualizar']) ) {
			$this->session->set_flashdata('error', 'Usted no cuenta con permisos para actualizar el m&oacute;dulo de Gesti&oacute;n de Fichas Prediales.');
			redirect('');
		}
		//se obtiene el segmento de la uri correspondiente a la id del predio
		$id_predio = $this->uri->segment(3);
		if( $id_predio )
		{
			//se carga el modelo ProcesosDAO
			$this->load->model(array('ProcesosDAO', 'TramosDAO', 'ContratistasDAO', 'PrediosDAO', 'PropietariosDAO'));
			//se asignan los valores que se van a enviar a la vista
			$this->data['estados'] = 				$this->ProcesosDAO->obtener_estados_proceso();
			$this->data['tramos'] = 				$this->TramosDAO->obtener_tramos();
			$this->data['contratistas'] = 			$this->ContratistasDAO->obtener_contratistas();
			$this->data['predio'] = 				$this->PrediosDAO->obtener_predio($id_predio);
			$this->data['identificacion'] = 		$this->PrediosDAO->obtener_identificacion($this->data['predio']->ficha_predial);
			$this->data['descripcion'] = 			$this->PrediosDAO->obtener_descripcion($this->data['predio']->ficha_predial);
			$this->data['linderos'] = 				$this->PrediosDAO->obtener_linderos($this->data['predio']->ficha_predial);
			$this->data['propietarios'] = 			$this->PropietariosDAO->obtener_propietarios($this->data['predio']->ficha_predial);
			$this->data['titulo_pagina'] = 			'Actualizar - '.$this->data['predio']->ficha_predial;
			$this->data['contenido_principal'] = 	'actualizar/actualizar_view';
			//se carga la vista y se envian los datos
			$this->load->view('includes/template', $this->data);
		}
		else
		{
			//si no se selecciono una ficha predial se retorna al index
			redirect('actualizar_controller');
		}
	}
	/**
	 * Esta funcion retorna las fichas asociadas a un contratista via JSON
	 */
	function fichas_contratista() {
		//se carga el modelo asociado a los predios	
		$this->load->model('PrediosDAO');
		//se obtiene el contratista enviado via POST
		$contratista = $this->input->post('contratista');
		//se obtienen las fichas asociadas al contratista
		$fichas = $this->PrediosDAO->obtener_predios_contratista($contratista);
		//se crea un array
		$resultado = array();
		//se llena el array
		foreach ($fichas as $ficha):
			$array = array();
			$array['predio'] = $ficha->id_predio;
			$array['fecha'] = $ficha->fecha_hora;
			$array['ficha'] = $ficha->ficha_predial;
			$array['usuario'] = $ficha->us_nombre.' '.$ficha->us_apellido;
			array_push($resultado, $array);
		endforeach;
		//se envia el resultado via JSON
		echo json_encode($resultado);
	}
	/**
	 * Esta funcion se encarga de guardar la información de una ficha predial luego de que esta haya sido modificada desde la vista
	 */
	function actualizar_predio()
	{
		//se cargan los permisos del usuario
		$permisos = $this->session->userdata('permisos');
		if( ! isset($permisos['Fichas']['Actualizar']) ) {
			$this->session->set_flashdata('error', 'Usted no cuenta con permisos para actualizar el m&oacute;dulo de Gesti&oacute;n de Fichas Prediales.');
			redirect('');
		}
		//se lee la ficha predial
		$ficha_predial = $this->input->post('ficha');
		//se carga el modelo PrediosDAO
		$this->load->model('PrediosDAO');
		
		//se prepara la identificacion del predio
		$identificacion = array(
			'estado_pro' => 		utf8_encode($this->input->post('estado_proceso')),
			'municipio' => 			utf8_encode($this->input->post('municipio')),
			'barrio' => 			utf8_encode($this->input->post('vereda_barrio')),
			'direccion' => 			utf8_encode($this->input->post('direccion_nombre')),
			'matricula_orig' => 	utf8_encode($this->input->post('numero_matricula_predio_inicial')),
			'escritura_orig' => 	utf8_encode($this->input->post('numero_escritura')),
			'of_registro' => 		utf8_encode($this->input->post('oficina_registro_predio_inicial')),
			'ciudad' => 			utf8_encode($this->input->post('ciudad_predio_inicial')),
			'fecha_escritura' => 	utf8_encode($this->input->post('fecha_predio_inicial')),
			'no_catastral' => 		utf8_encode($this->input->post('numero_catastral_predio_inicial')),
			'no_notaria' => 		utf8_encode($this->input->post('numero_notaria_predio_inicial')),
			'num_matricula_f' => 	utf8_encode($this->input->post('numero_matricula_predio_final')),
			'num_escritura_f' => 	utf8_encode($this->input->post('escritura_sentencia')),
			'of_registro_f' => 		utf8_encode($this->input->post('oficina_registro_predio_final')),
			'ciudad_f' => 			utf8_encode($this->input->post('ciudad_predio_final')),
			'fecha_esc_f' => 		utf8_encode($this->input->post('fecha_predio_final')),
			'num_catastral_f' => 	utf8_encode($this->input->post('numero_catastral_predio_final')),
			'num_notaria_f' => 		utf8_encode($this->input->post('numero_notaria_predio_final')),
			'f_inicio_trab' => 		utf8_encode($this->input->post('inicio_trabajo_fisico')),
			'f_ent_plano_int' => 	utf8_encode($this->input->post('entrega_plano_interventoria')),
			'f_apro_def' => 		utf8_encode($this->input->post('aprobacion_definitiva_plano')),
			'f_envio_int' => 		utf8_encode($this->input->post('envio_interventoria')),
			'f_envio_ger' => 		utf8_encode($this->input->post('envio_gerencia_firmar')),
			'f_recibo_pro' => 		utf8_encode($this->input->post('recibo_notificacion_propietario')),
			'f_envio_av' => 		utf8_encode($this->input->post('envio_avaluador')),
			'f_recibo_av' => 		utf8_encode($this->input->post('recibo_avaluo')),
			'f_notificacion_pro' => utf8_encode($this->input->post('notificacion_propietario')),
			'total_avaluo' => 		utf8_encode($this->input->post('total_avaluo')),
			'valor_mtr' => 			utf8_encode($this->input->post('valor_metro_cuadrado')),
			'valor_total_terr' => 	utf8_encode($this->input->post('valor_total_terreno')),
			'valor_total_mej' => 	utf8_encode($this->input->post('valor_total_mejoras')),
			'entregado' => 			utf8_encode($this->input->post('entregado')),
			'f_entregado' => 		utf8_encode($this->input->post('fecha_entregado')),
			'rad_ent' => 			utf8_encode($this->input->post('radicado')),
			'rad_apro_pla' => 		utf8_encode($this->input->post('radicado_aprobacion_plano')),
			'rad_no_pro' => 		utf8_encode($this->input->post('radicado_notificacion_propietario')),
			'enc_gestion' => 		utf8_encode($this->input->post('encargado_gestion_predial')),
			'r_envio_av' => 		utf8_encode($this->input->post('radicado_envio_avaluador')),
			'rad_env_ger' => 		utf8_encode($this->input->post('radicado_envio_gerencia')),
			'rad_env_int' => 		utf8_encode($this->input->post('radicado_envio_interventoria')),
			'env_esc_not' => 		utf8_encode($this->input->post('envio_escritura_notaria')),
			'ing_esc' => 			utf8_encode($this->input->post('ingreso_escritura')),
			'rec_reg_vol' => 		utf8_encode($this->input->post('recibo_registro_enajenacion')),
			'notif' => 				utf8_encode($this->input->post('notificacion')),
			'ini_juic' => 			utf8_encode($this->input->post('inicio_juicio')),
			'ini_sent' => 			utf8_encode($this->input->post('inicio_sentencia')),
			'ing_sent' => 			utf8_encode($this->input->post('ingreso_sentencia_registro')),
			'rec_reg_exp' => 		utf8_encode($this->input->post('recibo_registro_expropiacion')),
			'rad_int' => 			utf8_encode($this->input->post('radicado_entrega_interventoria')),
			'titulos_adq' => 		utf8_encode($this->input->post('titulos_adquisicion')),
			'lind_titulo' => 		utf8_encode($this->input->post('linderos_segun_titulo')),
			'gravamenes' => 		utf8_encode($this->input->post('gravamenes_limitaciones')),
			'doc_estud' => 			utf8_encode($this->input->post('documentos_estudiados')),
			'ob_titu' => 			utf8_encode($this->input->post('observaciones_estudio_titulos')),
			'conc_titu' => 			utf8_encode($this->input->post('concepto'))
		);
		
		//se inserta la identificacion del predio
		$this->PrediosDAO->actualizar_identificacion($ficha_predial, $identificacion);
		
		//se prepara la descripcion
		$descripcion = array(
			'uso_edificacion' => 		utf8_encode($this->input->post('uso_edificacion')),
			'estado_pre' => 			utf8_encode($this->input->post('estado')),
			'uso_terreno' => 			utf8_encode($this->input->post('uso_terreno')),
			'tipo_tenencia' => 			utf8_encode($this->input->post('tipo_tenencia')),
			'topografia' => 			utf8_encode($this->input->post('topografia')),
			'via_acceso' => 			utf8_encode($this->input->post('via_acceso')),
			'serv_publicos' => 			utf8_encode($this->input->post('servicios_publicos')),
			'nacimiento_agua' => 		utf8_encode($this->input->post('nacimiento_agua')),
			'area_total' => 			utf8_encode($this->input->post('area_total')),
			'area_requerida' => 		utf8_encode($this->input->post('area_requerida')),
			'area_residual' => 			utf8_encode($this->input->post('area_residual')),
			'area_construida' => 		utf8_encode($this->input->post('area_construida')),
			'area_cons_requerida' => 	utf8_encode($this->input->post('area_const_requerida')),
			'abscisa_inicial' => 		utf8_encode($this->input->post('abscisa_inicial')),
			'abscisa_final' => 			utf8_encode($this->input->post('abscisa_final')),
			'observacion' => 			utf8_encode($this->input->post('observacion')),
			'tramo' => 					utf8_encode($this->input->post('tramo')),
		);
		
		//se inserta la descripcion del predio
		$this->PrediosDAO->actualizar_descripcion($ficha_predial, $descripcion);
		
		//se insertan los linderos del predio
		$this->PrediosDAO->actualizar_linderos($ficha_predial, utf8_encode($this->input->post('linderos_predio_requerido')));
		
		$this->PrediosDAO->actualizar_predio_requerido($ficha_predial, utf8_encode($this->input->post('requerido')));
		//se procede a insertar los propietarios
		//se obtiene el numero de propietarios que se han agregado en el formulario
		$numero_propietarios = utf8_encode($this->input->post('propietarios_hidden'));
		
		//pueden haber propietarios que hayan sido eliminados del formulario
		//se va revisar uno por uno todos los que hayan sido agregados
		//teniendo como criterio de insercion que el documento del propietario no este vacio
		//se deja la validacion de este campo del lado cliente
		
		//se carga el modelo que gestiona la informacion de todos los propietarios
		$this->load->model('PropietariosDAO');
		for ($i = 1; $i <= $numero_propietarios; $i++) 
		{
			//variable del formulario que me indica si el propietario ya había sido agregado anteriormente
			$id_propietario = utf8_encode($this->input->post("id_propietario$i"));
			if($id_propietario)
			{
				//se obtiene el documento del propietario
				$documento_propietario = utf8_encode($this->input->post("documento_propietario$i"));
				
				//se eliminan puntos, comas y espacios en blanco
				$documento_propietario = str_replace('.', '', $documento_propietario);
				$documento_propietario = str_replace(',', '', $documento_propietario);
				$documento_propietario = str_replace(' ', '', $documento_propietario);
				
				//se prepara el array que contiene la informacion del propietario
				$info_propietario = array(
					'tipo_documento' => utf8_encode($this->input->post("tipo_documento$i")),
					'nombre' => 		utf8_encode($this->input->post("propietario$i")),
					'documento' => 		number_format($documento_propietario, 0),
					'telefono' => 		$this->input->post("telefono$i")
				);
				
				//se actualiza el propietario
				$this->PropietariosDAO->actualizar_propietario($id_propietario, $info_propietario);
				$this->PropietariosDAO->insertar_relacion_predio($id_propietario, $ficha_predial, utf8_encode($this->input->post("participacion$i")));
			}
			//si no se habia agregado anteriormente, se agrega
			else
			{
				//se verifica que el documento haya sido ingresado			
				$documento_propietario = utf8_encode($this->input->post("documento_propietario$i"));
				if($documento_propietario)
				{
					//se eliminan puntos, comas y espacios en blanco
					$documento_propietario = str_replace('.', '', $documento_propietario);
					$documento_propietario = str_replace(',', '', $documento_propietario);
					$documento_propietario = str_replace(' ', '', $documento_propietario);
					
					//se busca si el propietario ya existe en la base de datos
					//si no existe se inserta
					$propietario = $this->PropietariosDAO->existe_propietario($documento_propietario);
					if($propietario == FALSE)
					{
						//se prepara la informacion que se va a guardar del propietario
						if(trim($this->input->post("telefono$i")) != '')
						{
							$info_propietario = array(
								'tipo_documento' => utf8_encode($this->input->post("tipo_documento$i")),
								'nombre' => 		utf8_encode($this->input->post("propietario$i")),
								'documento' => 		number_format($documento_propietario, 0),
								'telefono' => 		number_format(utf8_encode($this->input->post("telefono$i")), 0, "", "-")//esta tambien se hace por compatibilidad
							);
						}
						else {
							$info_propietario = array(
								'tipo_documento' => utf8_encode($this->input->post("tipo_documento$i")),
								'nombre' => 		utf8_encode($this->input->post("propietario$i")),
								'documento' => 		number_format($documento_propietario, 0)
							);
						}
						//se inserta el propietario
						$this->PropietariosDAO->insertar_propietario($info_propietario);
						//se recupera para insertar la relacion con el predio
						$propietario = $this->PropietariosDAO->existe_propietario(number_format($documento_propietario, 0));
					}
					
					//se inserta la relacion del propietario con el predio
					$this->PropietariosDAO->insertar_relacion_predio($propietario->id_propietario, $ficha_predial, utf8_encode($this->input->post("participacion$i")));				}
			}
		}
		echo "correcto";
	}
	/**
	 * Esta funcion elimina a un propietario
	 */
	function eliminar_propietario()
	{
		//se cargan los permisos
		$permisos = $this->session->userdata('permisos');
		if( ! isset($permisos['Fichas']['Actualizar']) ) {
			$this->session->set_flashdata('error', 'Usted no cuenta con permisos para actualizar el m&oacute;dulo de Gesti&oacute;n de Fichas Prediales.');
			redirect('');
		}
		//se obtiene la id del propietario
		$id_propietario = utf8_encode($this->input->post('id_propietario'));
		//se obtiene la ficha predial
		$ficha_predial = utf8_encode($this->input->post('ficha_predial'));
		//si se envio la id del propietario
		if($id_propietario){
			//se carga el modelo del propietario
			$this->load->model('PropietariosDAO');
			//si se logra eliminar la relacion entre el predio y el propietario
			if($this->PropietariosDAO->eliminar_relacion_propietario($ficha_predial, $id_propietario))
			{
				//se envia la respuesta via JSON
				$respuesta = array('respuesta' => 'correcto');
				echo json_encode($respuesta);
			}
			else 
			{
				//se envia la respuesta via JSON
				$respuesta = array('respuesta' => 'No se pudo borrar al propietario');
				echo json_encode($respuesta);
			}
		}
		else
		{
			//se envia la respuesta via JSON
			$respuesta = array('respuesta' => 'correcto');
			echo json_encode($respuesta);
		}
	}
	/**
	 * Carga la pagina de administracion de propietarios
	 */
	function propietario()
	{
		//se verifican los permisos
		$permisos = $this->session->userdata('permisos');
		if( ! isset($permisos['Fichas']['Actualizar']) ) {
			$this->session->set_flashdata('error', 'Usted no cuenta con permisos para actualizar el m&oacute;dulo de Gesti&oacute;n de Propietarios.');
			redirect('');
		}
		//se obtiene la id del propietario
		$id_propietario = $this->uri->segment(3);
		//si no vino la id
		if ( ! $id_propietario) {
			redirect('propietarios_controller');
		}
		else
		{
			//se carga el modelo de los propietarios
			$this->load->model('PropietariosDAO');
			//se establecen las variables que se envian a las vistas
			$this->data['propietario'] = $this->PropietariosDAO->obtener_propietario($id_propietario);
			$this->data['relaciones'] = $this->PropietariosDAO->obtener_relaciones($id_propietario);
			$this->data['titulo_pagina'] = 'Actualizaci&oacute;n de propietarios';
			$this->data['contenido_principal'] = 'actualizar/propietario_view';
			//se carga la vista
			$this->load->view('includes/template', $this->data);
		}
	}
	/**
	 * Actualiza los datos de un propietario
	 */
	function actualizar_propietario()
	{
		//se cargan los permisos
		$permisos = $this->session->userdata('permisos');
		if( ! isset($permisos['Fichas']['Actualizar']) ) {
			$this->session->set_flashdata('error', 'Usted no cuenta con permisos para actualizar el m&oacute;dulo de Gesti&oacute;n de Propietarios.');
			redirect('');
		}
		//se obtiene el id del propietario
		$id_propietario = $this->input->post('id');
		//se obtiene el tipo de documento
		$tipo_documento = $this->input->post('tipo_documento');
		//se obtiene el nombre del propietario
		$nombre = $this->input->post('nombre');
		//se obtiene el documento del propietario
		$documento = $this->input->post('documento');
		//se obtiene el telefono del propietario
		$telefono = $this->input->post('telefono');
		//se arma el array de datos a actualizar en la base de datos
		$datos_propietario = array(
			'tipo_documento' => $tipo_documento,
			'nombre' => utf8_encode($nombre),
			'documento' => $documento,
			'telefono' => $telefono
		);
		//se carga el modelo de los propietarios
		$this->load->model('PropietariosDAO');
		//si se logra actualizar al propietario
		if($this->PropietariosDAO->actualizar_propietario($id_propietario, $datos_propietario))
		{
			//se envia la respueta via JSON
			echo json_encode(array('respuesta' => 'correcto'));
		}
		else
		{
			//se envia la respuesta viaJSON
			echo json_encode(array('respuesta' => 'error', 'mensaje' => 'Ocurri&oacute; un error al actualizar la informaci&oacute;n del propietario.'));
		}
	}
}
/* End of file actualizar_controller.php */
/* Location: ./site_predios/application/controllers/actualizar_controller.php */