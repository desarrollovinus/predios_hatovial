<?php
//Se carga la librer&iacute;a de PDF y la libreria de impresion rapida
require('site_predios/libraries/Fpdf.php');

//Definir la ruta de las fuentes
define('FPDF_FONTPATH','site_predios/fonts/');

class Informes_controller extends CI_Controller
{
	var $data = array();
	
	function __construct()
	{
		parent::__construct();

		//Carga de modelo
		$this->load->model('InformesDAO');

		//si el usuario no esta logueado
		if($this->session->userdata('id_usuario') != TRUE)
		{
			//redirecciono al controlador de sesion
			redirect('sesion_controller');
		}	
		//se establece la vista que tiene el contenido del menu
		$this->data['menu'] = 'informes/menu';

		//Librería de Excel
        $this->load->library(array('PHPExcel'));

	}
	
	function index() {
		$this->data['titulo_pagina'] = 'Informes';
		$this->data['contenido_principal'] = 'informes/actas/index_view';
		$this->load->model('InformesDAO');
		$this->data['actas'] = $this->InformesDAO->obtener_informe_actas()->result_array();
		$this->load->view('includes/template', $this->data);
	}
	
	function actas_excel()
	{		
		$this->load->model('InformesDAO');
        $actas = $this->InformesDAO->obtener_informe_actas()->result_array();

        $tabla_html = "<table><thead><tr><th><b>PREDIO</b></th><th><b>PRIMER PROPIETARIO</b></th><th><b>FICHA APROBADA</b></th><th><b>ENTREGA F&Iacute;SICA</b></th><th><b>COMPRAVENTA</b></th><th><b>REGISTRO</b></th></tr></thead><tbody>";
		foreach ($actas as $acta):
			$tabla_html .= "<tr><td><label>".$acta['PREDIO']."</label></td><td><label>".$acta['PROPIETARIO']."</label></td><td><label>";
			if($acta['FICHA APROBADA'] == '') { 
				$tabla_html .= "0"; 
			} 
			else { 
				$tabla_html .= $acta['FICHA APROBADA']; 
			}
			$tabla_html .= "</label></td><td><label>";
			if($acta['ENTREGA FISICA'] == '') { 
				$tabla_html .= "0"; 
			} 
			else { 
				$tabla_html .= $acta['ENTREGA FISICA']; 
			}
			$tabla_html .= "</label></td><td><label>";
			if($acta['COMPRAVENTA'] == '') { 
				$tabla_html .= "0"; 
			}
			else { 
				$tabla_html .= $acta['COMPRAVENTA']; 
			}
			$tabla_html .= "</label></td><td><label>";
			if($acta['REGISTRO'] == '') { 
				$tabla_html .= "0"; 
			} 
			else { 
				$tabla_html .= $acta['REGISTRO']; 
			}
			$tabla_html .= "</label></td></tr>";
		endforeach;
		$tabla_html .= "</tbody></table>";
		
		header('Content-type: application/vnd.ms-excel;');
		header("Content-Disposition: attachment; filename=Informe_de_actas.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo '<!DOCTYPE html><html><head></head><body>'.$tabla_html.'</body></html>';
	}
	
	function actas_pdf() {
		$this->load->library('pdf');

        // set document information
        $this->pdf->SetSubject('Informe');
        $this->pdf->SetKeywords('HATOVIAL, Predios');
        
        // set font
        $this->pdf->SetFont('helvetica', '', 8);
        
        // add a page
        $this->pdf->AddPage();

        $this->load->model('InformesDAO');
        $actas = $this->InformesDAO->obtener_informe_actas()->result_array();

        $tabla_html = "
        <table id=\"actas\" style=\"width:100%\" border=\"1\">
			<thead>
				<tr align=\"center\">
					<th><b>PREDIO</b></th>
					<th><b>PRIMER PROPIETARIO</b></th>
					<th><b>FICHA APROBADA</b></th>
					<th><b>ENTREGA F&Iacute;SICA</b></th>
					<th><b>COMPRAVENTA</b></th>
					<th><b>REGISTRO</b></th>
				</tr>
			</thead>
			<tbody>";
		foreach ($actas as $acta):
			$tabla_html .= "<tr><td><label>".$acta['PREDIO']."</label></td><td><label>".$acta['PROPIETARIO']."</label></td><td><label>";
			if($acta['FICHA APROBADA'] == '') { 
				$tabla_html .= "0"; 
			} 
			else { 
				$tabla_html .= $acta['FICHA APROBADA']; 
			}
			$tabla_html .= "</label></td><td><label>";
			if($acta['ENTREGA FISICA'] == '') { 
				$tabla_html .= "0"; 
			} 
			else { 
				$tabla_html .= $acta['ENTREGA FISICA']; 
			}
			$tabla_html .= "</label></td><td><label>";
			if($acta['COMPRAVENTA'] == '') { 
				$tabla_html .= "0"; 
			}
			else { 
				$tabla_html .= $acta['COMPRAVENTA']; 
			}
			$tabla_html .= "</label></td><td><label>";
			if($acta['REGISTRO'] == '') { 
				$tabla_html .= "0"; 
			} 
			else { 
				$tabla_html .= $acta['REGISTRO']; 
			}
			$tabla_html .= "</label></td></tr>";
		endforeach;
		$tabla_html .= "</tbody></table>";

		$this->pdf->WriteHTML('<div align="center"><h3>INFORME - ACTAS EN LAS QUE SE PAGA LA GESTI&Oacute;N PREDIAL</h3></div>');
		$this->pdf->WriteHTML($tabla_html);
        
        //Close and output PDF document
        $this->pdf->Output('Informe de actas.pdf', 'I');
	}

	function bitacora() {
		$this->load->model('InformesDAO');
		$this->data['predios'] = $this->InformesDAO->obtener_predios_bitacora();
		$this->data['titulo_pagina'] = 'Informes de bitácora';
		$this->data['contenido_principal'] = 'informes/bitacora/index_view';
		$this->data['menu'] = 'informes/bitacora/menu';
		$this->load->view('includes/template', $this->data);
	}

	function bitacora_excel()
	{
		$this->load->model('InformesDAO');
		$ficha_predial = str_replace('_', ' ', $this->uri->segment(3));
		$this->data['registros'] = $this->InformesDAO->obtener_registros_bitacora($ficha_predial);
		$this->load->view('informes/bitacora/excel', $this->data);
	}
	
	function pagos() {
		$this->load->model('InformesDAO');
		$this->data['pagos'] = $this->InformesDAO->obtener_informe_predios();
		$this->data['titulo_pagina'] = 'Informes';
		$this->data['contenido_principal'] = 'informes/pagos/index_view';
		$this->data['menu'] = 'informes/pagos/menu';
		$this->load->view('includes/template', $this->data);
	}

	function normas(){
		$this->data['titulo_pagina'] = 'Normas';
		$this->data['contenido_principal'] = 'informes/normas/index_view';
		$this->load->view('includes/template', $this->data);
	}
	
	function pagos_excel()
	{
		$this->load->model('InformesDAO');
		$datos = $this->InformesDAO->obtener_informe_predios();
		$tabla = '<table border="1px"><thead><tr align="center"><th>PREDIO</th><th>TOTAL AVALUO</th><th>TOTAL PAGADO</th><th>SALDO</th></tr></thead><tbody>';
		foreach ($datos as $predio):
			$ficha = $predio->PREDIO;
			$total_avaluo = $predio->VALOR_TOTAL;
			$total_pagado = $predio->TOTAL_PAGADO;
			if(empty($total_pagado)) {
				$total_pagado = 0;
			}
			$saldo = $total_avaluo - $total_pagado;
			$tabla .= "<tr><td>$ficha</td><td>".number_format($total_avaluo)."</td><td>".number_format($total_pagado)."</td><td>".number_format($saldo)."</td></tr>";
		endforeach;
		$tabla .= '</tbody></table>';
		header('Content-type: application/vnd.ms-excel; charset=iso-8859-1');
		header("Content-Disposition: attachment; filename=Informe_Pagos.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo utf8_decode($tabla);
	}
	
	function pagos_pdf() {
		$this->load->library('pdf');

        // set document information
        $this->pdf->SetSubject('Informe');
        $this->pdf->SetKeywords('HATOVIAL, Predios');
        
        // set font
        $this->pdf->SetFont('helvetica', '', 8);
        
        // add a page
        $this->pdf->AddPage();

		$this->load->model('InformesDAO');
		$datos = $this->InformesDAO->obtener_informe_predios();
		$tabla_html = '<table border="1px"><thead><tr align="center"><th><b>PREDIO</b></th><th><b>TOTAL AVALUO</b></th><th><b>TOTAL PAGADO</b></th><th><b>SALDO</b></th></tr></thead><tbody>';
		foreach ($datos as $predio):
			$ficha = $predio->PREDIO;
			$total_avaluo = $predio->VALOR_TOTAL;
			$total_pagado = $predio->TOTAL_PAGADO;
			if(empty($total_pagado)) {
				$total_pagado = 0;
			}
			$saldo = $total_avaluo - $total_pagado;
			$tabla_html .= "<tr><td>$ficha</td><td>".number_format($total_avaluo)."</td><td>".number_format($total_pagado)."</td><td>".number_format($saldo)."</td></tr>";
		endforeach;
		$tabla_html .= '</tbody></table>';

		$this->pdf->WriteHTML('<div align="center"><h3>INFORME - PAGOS DE LOS PREDIOS</h3></div>');
		$this->pdf->WriteHTML($tabla_html);
        
        //Close and output PDF document
        $this->pdf->Output('Informe de pagos.pdf', 'I');
	}

	function avaluos() {
		$this->load->model(array('InformesDAO', 'ContratistasDAO'));
		$this->data['titulo_pagina'] = 'Informes';
		$this->data['contenido_principal'] = 'informes/avaluos/index_view';
		$this->data['menu'] = 'informes/avaluos/menu';
		$this->load->view('includes/template', $this->data);
	}

	function avaluos_tabla(){
		$this->load->model(array('InformesDAO', 'ContratistasDAO'));

		$this->data['tipo'] = $this->uri->segment(3);

		$this->load->view('informes/avaluos/tabla_view', $this->data);
	}

	function avaluos_excel(){
		$this->load->view('informes/avaluos/excel');
	}

	function avaluos_pdf(){
		$this->load->view('informes/avaluos/pdf');
	}
	
	function avaluos_vencidos() {
		$this->load->model(array('InformesDAO', 'ContratistasDAO'));
		$this->data['titulo_pagina'] = 'Informes';
		$this->data['contenido_principal'] = 'informes/avaluos_vencidos/index_view';
		$this->data['avaluos_vencidos'] = $this->InformesDAO->obtener_avaluos_vencidos();
		$this->data['menu'] = 'informes/avaluos_vencidos/menu';
		$this->load->view('includes/template', $this->data);
	}
	
	function avaluos_vencidos_excel() {
		$this->load->model('InformesDAO');
		$avaluos_vencidos = $this->InformesDAO->obtener_avaluos_vencidos();
		$tabla = '<table border="1px"><thead><tr align="center"><th>PREDIO</th><th>PRIMER PROPIETARIO</th><th>FECHA AVAL&Uacute;O</th><th>FECHA EXPIRACION</th><th>DIAS EXPIRADO</th><th>CONTRATISTA</th></tr></thead><tbody>';
		foreach ($avaluos_vencidos as $avaluo):
			$tabla .= "<tr><td>".$avaluo['ficha_predial']."</td><td>".$avaluo['propietario']."</td><td>".$avaluo['fecha_avaluo']."</td><td>".$avaluo['fecha_expiracion']."</td><td>".$avaluo['dias_expirado']."</td><td>".$avaluo['contratista']."</td></tr>";
		endforeach;  
		$tabla .= '</tbody></table>';
		header('Content-type: application/vnd.ms-excel; charset=iso-8859-1');
		header("Content-Disposition: attachment; filename=Avaluos_Vencidos.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo utf8_decode($tabla);
	}
	
	function avaluos_vencidos_pdf() {
		$this->load->library('pdf');

        // set document information
        $this->pdf->SetSubject('Informe');
        $this->pdf->SetKeywords('HATOVIAL, Predios');
        
        // set font
        $this->pdf->SetFont('helvetica', '', 8);
        
        // add a page
        $this->pdf->AddPage();

		$this->load->model('InformesDAO');
		$avaluos_vencidos = $this->InformesDAO->obtener_avaluos_vencidos();
		$tabla_html = '<table border="1px"><thead><tr align="center"><th><b>PREDIO</b></th><th><b>PRIMER PROPIETARIO</b></th><th><b>FECHA AVAL&Uacute;O</b></th><th><b>FECHA EXPIRACION</b></th><th><b>DIAS EXPIRADO</b></th><th><b>CONTRATISTA</b></th></tr></thead><tbody>';
		foreach ($avaluos_vencidos as $avaluo):
			$tabla_html .= "<tr align=\"center\"><td>".$avaluo['ficha_predial']."</td><td>".$avaluo['propietario']."</td><td>".$avaluo['fecha_avaluo']."</td><td>".$avaluo['fecha_expiracion']."</td><td>".$avaluo['dias_expirado']."</td><td>".$avaluo['contratista']."</td></tr>";
		endforeach;
		$tabla_html .= '</tbody></table>';

		$this->pdf->WriteHTML('<div align="center"><h3>INFORME - AVAL&Uacute;OS VENCIDOS</h3></div>');
		$this->pdf->WriteHTML($tabla_html);
        
        //Close and output PDF document
        $this->pdf->Output('Informe de avaluos vencidos.pdf', 'I');
	}
	
	function avaluos_en_vencimiento() {
		$this->load->model('InformesDAO');
		$this->data['titulo_pagina'] = 'Informes';
		$this->data['contenido_principal'] = 'informes/avaluos_expirando/index_view';
		$this->data['avaluos_en_vencimiento'] = $this->InformesDAO->obtener_avaluos_en_vencimiento();
		$this->data['menu'] = 'informes/avaluos_expirando/menu';
		$this->load->view('includes/template', $this->data);
	}
	
	function avaluos_en_vencimiento_excel() {
		$this->load->model('InformesDAO');
		$avaluos_vencidos = $this->InformesDAO->obtener_avaluos_en_vencimiento();
		$tabla = '<table border="1px"><thead><tr align="center"><th>PREDIO</th><th>FECHA EXPIRACION</th><th>DIAS FALTANTES</th><th>CONTRATISTA</th></tr></thead><tbody>';
		foreach ($avaluos_vencidos as $avaluo):
			$tabla .= "<tr><td>".$avaluo['ficha_predial']."</td><td>".$avaluo['fecha_expiracion']."</td><td>".$avaluo['dias_expirado']."</td><td>".$avaluo['contratista']."</td></tr>";
		endforeach;  
		$tabla .= '</tbody></table>';
		header('Content-type: application/vnd.ms-excel; charset=iso-8859-1');
		header("Content-Disposition: attachment; filename=Avaluos en proceso de vencimiento.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo utf8_decode($tabla);
	}
	
	function avaluos_en_vencimiento_pdf() {
		$this->load->library('pdf');

        // set document information
        $this->pdf->SetSubject('Informe');
        $this->pdf->SetKeywords('HATOVIAL, Predios');
        
        // set font
        $this->pdf->SetFont('helvetica', '', 8);
        
        // add a page
        $this->pdf->AddPage();

		$this->load->model('InformesDAO');
		$avaluos_vencidos = $this->InformesDAO->obtener_avaluos_en_vencimiento();
		$tabla_html = '<table border="1px"><thead><tr align="center"><th><b>PREDIO</b></th><th><b>FECHA EXPIRACION</b></th><th><b>DIAS FALTANTES</b></th><th><b>CONTRATISTA</b></th></tr></thead><tbody>';
		foreach ($avaluos_vencidos as $avaluo):
			$tabla_html .= "<tr><td>".$avaluo['ficha_predial']."</td><td>".$avaluo['fecha_expiracion']."</td><td>".$avaluo['dias_expirado']."</td><td>".$avaluo['contratista']."</td></tr>";
		endforeach;  
		$tabla_html .= '</tbody></table>';

		$this->pdf->WriteHTML('<div align="center"><h3>INFORME - AVAL&Uacute;OS EN VENCIMIENTO</h3><h4>'.date("Y-m-d", time()).'</h4></div>');
		$this->pdf->WriteHTML($tabla_html);
        
        //Close and output PDF document
        $this->pdf->Output('Informe de avaluos en vencimiento.pdf', 'I');
	}
	
	function estudio_titulos($id_predio) {
		$permisos = $this->session->userdata('permisos');
		if( ! isset($permisos['Fichas']['Imprimir estudio de t&iacute;tulos']) ) {
			$this->session->set_flashdata('error', 'Usted no cuenta con permisos para actualizar el m&oacute;dulo de Gesti&oacute;n de Fichas Prediales.');
			redirect('');
		}
		//se carga el modelo ProcesosDAO
		$this->load->model(array('ProcesosDAO', 'TramosDAO', 'ContratistasDAO', 'PrediosDAO', 'PropietariosDAO'));
		//se obtienen todos los estados posibles que tiene un proceso
		$this->data['estados'] = 				$this->ProcesosDAO->obtener_estados_proceso();
		//se obtienen todos los tramos
		$this->data['tramos'] = 				$this->TramosDAO->obtener_tramos();
		//se obtienen todos los contratistas
		$this->data['contratistas'] = 			$this->ContratistasDAO->obtener_contratistas();
		$this->data['predio'] = 				$this->PrediosDAO->obtener_predio($id_predio);
		$this->data['identificacion'] = 		$this->PrediosDAO->obtener_identificacion($this->data['predio']->ficha_predial);
		$this->data['descripcion'] = 			$this->PrediosDAO->obtener_descripcion($this->data['predio']->ficha_predial);
		$this->data['linderos'] = 				$this->PrediosDAO->obtener_linderos($this->data['predio']->ficha_predial);
		$this->data['propietarios'] = 			$this->PropietariosDAO->obtener_propietarios($this->data['predio']->ficha_predial);
		
		
		
		header("Content-Type: application/msword; charset=utf-8");
		header("Expires: 0");
		header("Cache-Control:  must-revalidate, post-check=0, pre-check=0");
		header("Content-disposition: attachment; filename=\"Estudio de titulos - ".$this->data['predio']->ficha_predial.".doc\"");
		
		$this->load->view('informes/estudio_titulos/plantilla', $this->data);
	}

	function gestion_predial() {
		$this->load->model('InformesDAO');
		$this->data['registros'] = $this->InformesDAO->obtener_informe_gestion_predial();
		$this->load->view('informes/gestion_predial/index_view', $this->data);
	}

	function gestion_predial_excel(){
		$this->load->view('informes/gestion_predial/excel');
	}
	
	function filtrar_caracteres($html) {
		/*$html = str_replace("Ã", "&Ntilde;", $html);*/
		$html = str_replace("Ã", "&Oacute;", $html);
		return $html;
	}
}

/* End of file informes_controller.php */
/* Location: ./predios1/application/controllers/informes_controller.php */