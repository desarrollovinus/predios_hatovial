<?php
class Reporte_errores_controller extends CI_Controller {
	var $data = array();
	
	function __construct() {
		parent::__construct();
	}
	
	function index() {
		$this->data['contenido_principal'] = 'reporte_errores/index_view';
		$this->data['titulo_pagina'] = 'Reporte de errores';
		$this->data['menu'] = 'reporte_errores/menu';
		$this->load->view('includes/template', $this->data);
	}
	
	function enviar () {
		
	}
}