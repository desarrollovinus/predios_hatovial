<?php
class Pagos_controller extends CI_Controller
{

	var $data = array();
	
	function __construct()
	{
		parent::__construct();
		//si el usuario no esta logueado
		if($this->session->userdata('id_usuario') != TRUE)
		{
			//redirecciono al controlador de sesion
			redirect('sesion_controller');
		}
		$this->load->helper('html');
		//se establece la vista que tiene el contenido del menu
		$this->data['menu'] = 'pagos/menu';
	}
	
	function index()
	{
		$this->data['titulo_pagina'] = 'Pagos';
		$this->data['contenido_principal'] = 'pagos/index_view';
		$this->data['tipo_usuario'] = $this->session->userdata("tipo_usuario");
		$this->load->view('includes/template', $this->data);
	}
	
	function lista_fichas() {
		$this->load->model('PrediosDAO');
		
		$palabra_clave = $this->input->get('palabraClave');
		$max_filas = $this->input->get('maxRows');
		echo json_encode($this->PrediosDAO->listar_fichas($palabra_clave, $max_filas));
	}
	
	function vista_actualizar($ficha_predial) {
		$this->load->model('PagosDAO');
		
		$ficha_predial = str_replace("_", " ", $ficha_predial);

		$pagos = $this->PagosDAO->obtener_pagos($ficha_predial);

		$this->data['ficha_predial'] = $ficha_predial;

		$valor_predio = $this->PagosDAO->obtiene_avaluo($ficha_predial);
		$total_pagos = $this->PagosDAO->obtiene_total_pagos($ficha_predial);
		if($valor_predio->total_avaluo == 0) {
			$porcentaje_pagado = 0;
		}
		else {
			$porcentaje_pagado = ($total_pagos->valor / $valor_predio->total_avaluo) * 100;
		}
		$this->data['valor_predio'] = number_format($valor_predio->total_avaluo, 3);
		$this->data['total_pagado'] = number_format($total_pagos->valor, 3);
		$this->data['porcentaje_pagado'] = number_format($porcentaje_pagado, 2);
		$this->data['tabla'] = $this->obtiene_tabla($pagos);
		$this->data['titulo_pagina'] = 'Pagos asociados a la ficha '.$ficha_predial;
		$this->data['contenido_principal'] = 'pagos/index_view';
		$this->load->view('pagos/vista_auxiliar', $this->data);
	}
	
	function obtener_pagos()
	{
		$ficha_predial = $this->input->post('ficha');
		$this->load->model('PrediosDAO');
		if($this->PrediosDAO->existe_ficha($ficha_predial))
		{
			$this->load->model('PagosDAO');
			$pagos = $this->PagosDAO->obtener_pagos($ficha_predial);
			$valor_predio = $this->PagosDAO->obtiene_avaluo($ficha_predial);
			$total_pagos = $this->PagosDAO->obtiene_total_pagos($ficha_predial);
			if($valor_predio->total_avaluo == 0) {
				$porcentaje_pagado = 0;
			}
			else {
				$porcentaje_pagado = ($total_pagos->valor / $valor_predio->total_avaluo) * 100;
			}
			$respuesta = array(
				'resultado' => 'correcto',
				'tabla' => $this->obtiene_tabla($pagos),
				'valor_predio' => number_format($valor_predio->total_avaluo, 3),
				'total_pagado' => number_format($total_pagos->valor, 3),
				'porcentaje_pagado' => number_format($porcentaje_pagado, 3)
			);
			echo json_encode($respuesta);
		}
		else
		{
			$respuesta = array('resultado' => 'La ficha predial ingresada no existe.');
			echo json_encode($respuesta);
		}
	}
	
	private function obtiene_tabla($pagos)
	{
		$fila = 0;
		$respuesta = '<table width="100%" id="tabla"><thead><tr><th>N&uacute;mero de pago</th><th>Fecha</th><th>Documento de pago</th><th>Valor</th>';
		if($this->session->userdata('tipo_usuario') == 2) {
			$respuesta .= '<th>&nbsp;</th>';
		}
		
		$respuesta .= '</tr></thead><tbody>';
		
		foreach ($pagos as $pago):
			$respuesta.='<tr class="';
			if($fila % 2 == 0)
			{
				$respuesta.='odd">';
			}
			else
			{
				$respuesta.='even">';
			}
				$respuesta.='<td class=" sorting_1">';
					$respuesta.= utf8_decode($pago->num_pago);
				$respuesta.='</td>';
				$respuesta.='<td>';
					$respuesta.= utf8_decode($pago->fecha_pago);
				$respuesta.='</td>';
				$respuesta.='<td>';
					$respuesta.= utf8_decode($pago->doc_pago);
				$respuesta.='</td>';
				$respuesta.='<td>';
					$respuesta.= utf8_decode(number_format($pago->valor, 3));
				$respuesta.='</td>';
				if($this->session->userdata('tipo_usuario') == 2) {
					$respuesta.='<td>';
						$respuesta.= '<a title="Eliminar" href="'.site_url('pagos_controller/eliminar_pago/'.utf8_decode($pago->ficha_predial).'/'.utf8_decode($pago->num_pago)).'">'.img(base_url().'img/delete.png').'</a>';
					$respuesta.='</td>';
				}
			$respuesta.='</tr>';
			
			$fila++;
		endforeach;
		return $respuesta.'</tbody></table>';
	}
	
	function nuevo_pago()
	{
		$ficha = 		utf8_encode($this->input->post('ficha'));
		$fecha = 		utf8_encode($this->input->post('fecha'));
		$documento = 	utf8_encode($this->input->post('documento'));
		$valor = 		utf8_encode($this->input->post('valor'));
		
		$this->load->model('PagosDAO');
		$numero_pago = $this->PagosDAO->obtener_nuevo_numero_pago($ficha);
		if($this->PagosDAO->insertar_pago($ficha, $numero_pago, $fecha, $documento, $valor))
		{
			echo 'correcto';
		}
		else
		{
			echo 'Hubo un error al insertar el registro de pago, verifique e intente nuevamente.';
		}
	}
	
	function valida_ficha()
	{
		$ficha_predial = $this->input->post('ficha');
		$this->load->model('PrediosDAO');
		if($this->PrediosDAO->existe_ficha($ficha_predial))
		{
			echo 'correcto';
		}
		else
		{
			echo 'La ficha predial ingresada no existe.';
		}
	}
	
	function eliminar_pago($ficha_predial, $num_pago) {
		$this->load->model('PagosDAO');
		
		$json['resultado'] = 'correcto';
		if( ! $this->PagosDAO->eliminar_pago($ficha_predial, $num_pago) ) {
			$json['resultado'] = 'error';
			$json['mensaje'] = 'No se pudo eliminar el pago.';
		}
		
		echo json_encode($json);
	}
}

/* End of file pagos_controller.php */
/* Location: ./predios1/application/controllers/pagos_controller.php */