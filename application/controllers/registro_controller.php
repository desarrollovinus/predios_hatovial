<?php
/**
 * Controlador del m&oacute;dulo de Gesti&oacute;n de Predios.
 * @author 		Freddy Alexander Vivas Reyes
 * @copyright	&copy; HATOVIAL S.A.S.
 */
class Registro_controller extends CI_Controller
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
		$permisos = $this->session->userdata('permisos');
		if ( ! isset($permisos['Fichas']['Crear']) ) {
			$this->session->set_flashdata('error', 'Usted no cuenta con permisos para acceder al m&oacute;dulo de registro de nuevas fichas prediales.');
			redirect('');
		}
		//se establece la vista que tiene el contenido del menu
		$this->load->model('PrediosDAO');
		$this->data['ultimas_fichas'] = $this->PrediosDAO->obtener_predios_menu();
		$this->data['menu'] = 'registro/menu';
	}
	
	/**
	 * Muestra la vista que se encarga de registrar los datos de un predio nuevo.
	 * 
	 * @access	public
	 */
	function index()
	{
		//se carga el modelo ProcesosDAO
		$this->load->model('ProcesosDAO');
		//se carga el modelo TramosDAO
		$this->load->model('TramosDAO');
		//se carga el modelo ContratistasDAO
		$this->load->model('ContratistasDAO');
		//se obtienen todos los estados posibles que tiene un proceso
		$this->data['estados'] = $this->ProcesosDAO->obtener_estados_proceso();
		//se obtienen todos los tramos
		$this->data['tramos'] = $this->TramosDAO->obtener_tramos();
		//se obtienen todos los contratistas
		$this->data['contratistas'] = $this->ContratistasDAO->obtener_contratistas();
		//se establece el titulo de la pagina
		$this->data['titulo_pagina'] = 'Registro de predios';
		//se establece la vista que tiene el contenido principal
		$this->data['contenido_principal'] = 'registro/index_view';
		//se carga el template
		$this->load->view('includes/template', $this->data);
	}
	
	/**
	 * Esta funci&oacute;n se encarga de guardar la informaci&oacute;n del predio nuevo.
	 * 
	 * @access	public
	 */
	function registrar_predio()
	{
		//se lee la ficha predial
		$ficha_predial = utf8_encode($this->input->post('ficha'));
		//se carga el modelo PrediosDAO
		$this->load->model('PrediosDAO');
		//se verifica que la ficha no exista
		if($this->PrediosDAO->existe_ficha($ficha_predial))
		{
			//Si existe se emite el mensaje de error
			echo "La ficha predial $ficha_predial ya existe.";
		}
		//si no existe se procede a guardar toda la informacion		
		else
		{
			//se obtiene la hora en que se registra el predio
			$fecha_hora = date('Y-m-d H:i:s');
			//se prepara la identificacion del predio
			$identificacion = array(
				'estado_pro' => utf8_encode($this->input->post('estado_proceso')),
				'ficha_predial' => $ficha_predial,
				'municipio' => utf8_encode($this->input->post('municipio')),
				'barrio' => utf8_encode($this->input->post('vereda_barrio')),
				'direccion' => utf8_encode($this->input->post('direccion_nombre')),
				'matricula_orig' => utf8_encode($this->input->post('numero_matricula_predio_inicial')),
				'escritura_orig' => utf8_encode($this->input->post('numero_escritura')),
				'of_registro' => utf8_encode($this->input->post('oficina_registro_predio_inicial')),
				'ciudad' => utf8_encode($this->input->post('ciudad_predio_inicial')),
				'fecha_escritura' => utf8_encode($this->input->post('fecha_predio_inicial')),
				'no_catastral' => utf8_encode($this->input->post('numero_catastral_predio_inicial')),
				'no_notaria' => utf8_encode($this->input->post('numero_notaria_predio_inicial')),
				'num_matricula_f' => utf8_encode($this->input->post('numero_matricula_predio_final')),
				'num_escritura_f' => utf8_encode($this->input->post('escritura_sentencia')),
				'of_registro_f' => utf8_encode($this->input->post('oficina_registro_predio_final')),
				'ciudad_f' => utf8_encode($this->input->post('ciudad_predio_final')),
				'fecha_esc_f' => utf8_encode($this->input->post('fecha_predio_final')),
				'num_catastral_f' => utf8_encode($this->input->post('numero_catastral_predio_final')),
				'num_notaria_f' => utf8_encode($this->input->post('numero_notaria_predio_final')),
				'f_inicio_trab' => utf8_encode($this->input->post('inicio_trabajo_fisico')),
				'f_ent_plano_int' => utf8_encode($this->input->post('entrega_plano_interventoria')),
				'f_apro_def' => utf8_encode($this->input->post('aprobacion_definitiva_plano')),
				'f_envio_int' => utf8_encode($this->input->post('envio_interventoria')),
				'f_envio_ger' => utf8_encode($this->input->post('envio_gerencia_firmar')),
				'f_recibo_pro' => utf8_encode($this->input->post('recibo_notificacion_propietario')),
				'f_envio_av' => utf8_encode($this->input->post('envio_avaluador')),
				'f_recibo_av' => utf8_encode($this->input->post('recibo_avaluo')),
				'f_notificacion_pro' => utf8_encode($this->input->post('notificacion_propietario')),
				'total_avaluo' => utf8_encode($this->input->post('total_avaluo')),
				'valor_mtr' => utf8_encode($this->input->post('valor_metro_cuadrado')),
				'valor_total_terr' => utf8_encode($this->input->post('valor_total_terreno')),
				'valor_total_mej' => utf8_encode($this->input->post('valor_total_mejoras')),
				'fecha_hora' => utf8_encode($fecha_hora),
				'entregado' => utf8_encode($this->input->post('entregado')),
				'f_entregado' => utf8_encode($this->input->post('fecha_entregado')),
				'rad_ent' => utf8_encode($this->input->post('radicado')),
				'rad_apro_pla' => utf8_encode($this->input->post('radicado_aprobacion_plano')),
				'rad_no_pro' => utf8_encode($this->input->post('radicado_notificacion_propietario')),
				'enc_gestion' => utf8_encode($this->input->post('encargado_gestion_predial')),
				'r_envio_av' => utf8_encode($this->input->post('radicado_envio_avaluador')),
				'rad_env_ger' => utf8_encode($this->input->post('radicado_envio_gerencia')),
				'rad_env_int' => utf8_encode($this->input->post('radicado_envio_interventoria')),
				'env_esc_not' => utf8_encode($this->input->post('envio_escritura_notaria')),
				'ing_esc' => utf8_encode($this->input->post('ingreso_escritura')),
				'rec_reg_vol' => utf8_encode($this->input->post('recibo_registro_enajenacion')),
				'notif' => utf8_encode($this->input->post('notificacion')),
				'ini_juic' => utf8_encode($this->input->post('inicio_juicio')),
				'ini_sent' => utf8_encode($this->input->post('inicio_sentencia')),
				'ing_sent' => utf8_encode($this->input->post('ingreso_sentencia_registro')),
				'rec_reg_exp' => utf8_encode($this->input->post('recibo_registro_expropiacion')),
				'rad_int' => utf8_encode($this->input->post('radicado_entrega_interventoria')),
				'titulos_adq' => utf8_encode($this->input->post('titulos_adquisicion')),
				'lind_titulo' => utf8_encode($this->input->post('linderos_segun_titulo')),
				'gravamenes' => utf8_encode($this->input->post('gravamenes_limitaciones')),
				'doc_estud' => utf8_encode($this->input->post('documentos_estudiados')),
				'ob_titu' => utf8_encode($this->input->post('observaciones_estudio_titulos')),
				'conc_titu' => utf8_encode($this->input->post('concepto'))
			);
			
			//se inserta la identificacion del predio
			$this->PrediosDAO->insertar_identificacion($identificacion);
			
			//se prepara la descripcion
			$descripcion = array(
				'ficha_predial' => $ficha_predial,
				'uso_edificacion' => utf8_encode($this->input->post('uso_edificacion')),
				'estado_pre' => utf8_encode($this->input->post('estado')),
				'uso_terreno' => utf8_encode($this->input->post('uso_terreno')),
				'tipo_tenencia' => utf8_encode($this->input->post('tipo_tenencia')),
				'topografia' => utf8_encode($this->input->post('topografia')),
				'via_acceso' => utf8_encode($this->input->post('via_acceso')),
				'serv_publicos' => utf8_encode($this->input->post('servicios_publicos')),
				'nacimiento_agua' => utf8_encode($this->input->post('nacimiento_agua')),
				'area_total' => utf8_encode($this->input->post('area_total')),
				'area_requerida' => utf8_encode($this->input->post('area_requerida')),
				'area_residual' => utf8_encode($this->input->post('area_residual')),
				'area_construida' => utf8_encode($this->input->post('area_construida')),
				'area_cons_requerida' => utf8_encode($this->input->post('area_const_requerida')),
				'abscisa_inicial' => utf8_encode($this->input->post('abscisa_inicial')),
				'abscisa_final' => utf8_encode($this->input->post('abscisa_final')),
				'observacion' => utf8_encode($this->input->post('observacion')),
				'tramo' => utf8_encode($this->input->post('tramo')),
				'fecha_hora' => utf8_encode($fecha_hora)
			);
			
			//se inserta la descripcion del predio
			$this->PrediosDAO->insertar_descripcion($descripcion);
			
			//se insertan los linderos del predio
			$this->PrediosDAO->insertar_linderos($ficha_predial, utf8_encode($this->input->post('linderos_predio_requerido')));
			
			//se inserta el predio
			$this->PrediosDAO->insertar_predio($ficha_predial, utf8_encode($fecha_hora), utf8_encode($this->session->userdata('id_usuario')));
			
			
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
								'documento' => 		$documento_propietario,
								'telefono' => 		number_format(utf8_encode($this->input->post("telefono$i")), 0, "", "-")//esta tambien se hace por compatibilidad
							);
						}
						else {
							$info_propietario = array(
								'tipo_documento' => utf8_encode($this->input->post("tipo_documento$i")),
								'nombre' => 		utf8_encode($this->input->post("propietario$i")),
								'documento' => 		$documento_propietario
							);
						}
						//se inserta el propietario
						$this->PropietariosDAO->insertar_propietario($info_propietario);
						//se recupera para obtener su id
						$propietario = $this->PropietariosDAO->existe_propietario($documento_propietario);
						//se inserta la relacion del propietario con el predio
						$this->PropietariosDAO->insertar_relacion_predio($propietario->id_propietario, $ficha_predial, utf8_encode($this->input->post("participacion$i")));
					}
					else 
					{
						//se inserta la relacion del propietario con el predio
						$this->PropietariosDAO->insertar_relacion_predio($propietario->id_propietario, $ficha_predial, utf8_encode($this->input->post("participacion$i")));
					}
					
				}
			}
			echo "correcto";
		}
	}
}

/* End of file predios_controller.php */
/* Location: ./predios1/application/controllers/predios_controller.php */