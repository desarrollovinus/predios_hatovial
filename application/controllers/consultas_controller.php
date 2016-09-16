<?php
class Consultas_controller extends CI_Controller
{
	var $data = array();
	
	function __construct()
	{
		parent::__construct();
		//se establece la vista que tiene el contenido del menu
		$this->data['menu'] = 'consultas/menu';
	}
	
	function ficha()
	{
		$permisos = $this->session->userdata('permisos');
		if( ! isset($permisos['Fichas']['Consultar']) ) {
			$this->session->set_flashdata('error', 'Usted no cuenta con permisos para consultar el m&oacute;dulo de Gesti&oacute;n de Fichas Prediales.');
			redirect('');
		}
		$id_predio = $this->uri->segment(3);
		if( $id_predio )
		{
			//se carga el modelo ProcesosDAO
			$this->load->model(array('PrediosDAO', 'PropietariosDAO', 'ContratistasDAO'));
			$this->data['predio'] = 				$this->PrediosDAO->obtener_predio($id_predio);
			$this->data['anterior'] = 				$this->PrediosDAO->obtener_predio_anterior($this->data['predio']->ficha_predial, $this->session->userdata('palabra_clave'));
			$this->data['siguiente'] = 				$this->PrediosDAO->obtener_predio_siguiente($this->data['predio']->ficha_predial, $this->session->userdata('palabra_clave'));
			$this->data['identificacion'] = 		$this->PrediosDAO->obtener_identificacion($this->data['predio']->ficha_predial);
			$this->data['descripcion'] = 			$this->PrediosDAO->obtener_descripcion($this->data['predio']->ficha_predial);
			$this->data['linderos'] = 				$this->PrediosDAO->obtener_linderos($this->data['predio']->ficha_predial);
			$this->data['propietarios'] = 			$this->PropietariosDAO->obtener_propietarios($this->data['predio']->ficha_predial);
			$this->data['contratista'] = 			$this->ContratistasDAO->obtener_contratista(trim($this->data['identificacion']->enc_gestion));
			if($this->data['contratista']->num_rows() > 0) {
				$this->data['contratista'] = $this->data['contratista']->row()->nombre;
			}
			else {
				$this->data['contratista'] = '';
			}
			$this->data['titulo_pagina'] = 			'Consultar - '.$this->data['predio']->ficha_predial;
			$this->data['contenido_principal'] = 	'consultas/ficha_view';
			
			$this->load->view('includes/template', $this->data);
		}
		else
		{
			redirect('propietarios_controller');
		}
	}
	
	function propietario() {	
		$permisos = $this->session->userdata('permisos');
		if( ! isset($permisos['Fichas']['Consultar']) ) {
			$this->session->set_flashdata('error', 'Usted no cuenta con permisos para consultar el m&oacute;dulo de Gesti&oacute;n de Propietarios.');
			redirect('');
		}
		$id_propietario = $this->uri->segment(3);
		if ( ! $id_propietario) {
			redirect('propietarios_controller');
		}
		else
		{
			$this->load->model('PropietariosDAO');
			$this->data['propietario'] = $this->PropietariosDAO->obtener_propietario($id_propietario);
			$this->data['relaciones'] = $this->PropietariosDAO->obtener_relaciones($id_propietario);
			$this->data['titulo_pagina'] = 'Actualizaci&oacute;n de propietarios';
			$this->data['contenido_principal'] = 'consultas/propietario_view';
			$this->load->view('includes/template', $this->data);
		}
	}

	function guarda_palabra_clave() {
		$palabra_clave = $this->input->post('palabra_clave');
		$this->session->set_userdata('palabra_clave', $palabra_clave);
		echo 'correcto';
	}
}