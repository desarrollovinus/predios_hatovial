<?php
class Infomapas extends CI_Controller {
	var $data = array();
	
	function __construct() {
		parent::__construct();
	}
	
	function ficha() {

		$ficha = $this->uri->segment(3);
		$user= $this->uri->segment(4);

		if($ficha == '' || $user == '') {
			header('HTTP/1.1 403 Forbidden');

		}
		
		$this->load->model('UsuariosDAO');
		
		if($datos_usuario = $this->UsuariosDAO->valida_usuario_infomapas($user)) {
			//Se arma un array indicando los datos que se van a cargan a la sesion
			$datos_sesion = array(
				"nombre_usuario" => $datos_usuario->us_nombre." ".$datos_usuario->us_apellido,
				"id_usuario" => $datos_usuario->id_usuario,
				"mail_usuario" => $datos_usuario->us_mail,
				"tipo_usuario" => $datos_usuario->us_tipo
			);

			//se carga el modelo ProcesosDAO
			$this->load->model(array('PrediosDAO', 'PropietariosDAO'));
			$this->data['usuario'] = $datos_sesion;
			$this->data['predio'] = 				$this->PrediosDAO->obtener_predio_mapas($ficha);
			$this->data['identificacion'] = 		$this->PrediosDAO->obtener_identificacion($this->data['predio']->ficha_predial);
			$this->data['descripcion'] = 			$this->PrediosDAO->obtener_descripcion($this->data['predio']->ficha_predial);
			$this->data['linderos'] = 				$this->PrediosDAO->obtener_linderos($this->data['predio']->ficha_predial);
			$this->data['propietarios'] = 			$this->PropietariosDAO->obtener_propietarios($this->data['predio']->ficha_predial);
			$this->data['titulo_pagina'] = 			'Consultar - '.$this->data['predio']->ficha_predial;
			$this->data['contenido_principal'] = 	'infomapas/ficha_view';
			
			$this->load->view('infomapas/index_view', $this->data);
		}
		else {
			header('HTTP/1.1 403 Forbidden');
		}
	}
	
	function pagos() {
		$id_ficha = $this->uri->segment(3);
		$user = $this->uri->segment(4);

		if($id_ficha == '' || $user == '') {
			header('HTTP/1.1 403 Forbidden');

		}
		
		$this->load->model('UsuariosDAO');
		
		if($datos_usuario = $this->UsuariosDAO->valida_usuario_infomapas($user)) {
			//Se arma un array indicando los datos que se van a cargan a la sesion
			$datos_sesion = array(
				"nombre_usuario" => $datos_usuario->us_nombre." ".$datos_usuario->us_apellido,
				"id_usuario" => $datos_usuario->id_usuario,
				"mail_usuario" => $datos_usuario->us_mail,
				"tipo_usuario" => $datos_usuario->us_tipo
			);
		
			$this->load->model('PagosDAO');
			
			
			$this->db->where('id_predio', $id_ficha);
			$predio = $this->db->get('tbl_predio')->row();
			$ficha_predial = $predio->ficha_predial;
			
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
			
			$this->data['usuario'] = $datos_sesion;
			$this->data['valor_predio'] = number_format($valor_predio->total_avaluo, 3);
			$this->data['total_pagado'] = number_format($total_pagos->valor, 3);
			$this->data['porcentaje_pagado'] = number_format($porcentaje_pagado, 2);
			$this->data['tabla'] = $this->obtiene_tabla($pagos);
			$this->data['titulo_pagina'] = 'Pagos asociados a la ficha '.$ficha_predial;
			$this->data['contenido_principal'] = 'infomapas/pagos_view';
			$this->load->view('infomapas/index_view', $this->data);
		}
		else {
			header('HTTP/1.1 403 Forbidden');
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
	
	function obtener_tabla($bitacora)
	{
		$fila = 0;
		$respuesta = '<table width="100%" id="tabla"><thead><tr><th>Fecha</th><th>Remitente</th><th>Titulo</th><th>Observaci&oacute;n</th></tr></thead><tbody>';
		
		foreach ($bitacora as $anotacion):
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
					$respuesta.= utf8_decode($anotacion->fecha);
				$respuesta.='</td>';
				$respuesta.='<td>';
					$respuesta.= utf8_decode($anotacion->remitente);
				$respuesta.='</td>';
				$respuesta.='<td>';
					$respuesta.= utf8_decode($anotacion->titulo);
				$respuesta.='</td>';
				$respuesta.='<td>';
					$respuesta.= utf8_decode($anotacion->observacion);
				$respuesta.='</td>';
			$respuesta.='</tr>';
			
			$fila++;
		endforeach;
		$respuesta.='</tbody></table>';
		return $respuesta;
	}
	
	function bitacora() {
		$id_ficha = $this->uri->segment(3);
		$user = $this->uri->segment(4);

		if($id_ficha == '' || $user == '') {
			header('HTTP/1.1 403 Forbidden');

		}
		
		$this->load->model('UsuariosDAO');
		
		if($datos_usuario = $this->UsuariosDAO->valida_usuario_infomapas($user)) {
			//Se arma un array indicando los datos que se van a cargan a la sesion
			$datos_sesion = array(
				"nombre_usuario" => $datos_usuario->us_nombre." ".$datos_usuario->us_apellido,
				"id_usuario" => $datos_usuario->id_usuario,
				"mail_usuario" => $datos_usuario->us_mail,
				"tipo_usuario" => $datos_usuario->us_tipo
			);
			
			
			$this->data['usuario'] = $datos_sesion;
			
			
			
			$this->load->model('PropietariosDAO');
			
			$this->db->where('id_predio', $id_ficha);
			$predio = $this->db->get('tbl_predio')->row();
			$ficha_predial = $predio->ficha_predial;
		
			//si se paso por url entonces se carga el modelo que gestiona la informacion de la bitacora
			$this->load->model('BitacoraDAO');
			
			//se pasa la ficha predial
			$this->data['ficha_predial'] = $ficha_predial;
			
			//se pasa el primer propietario
			$this->data['propietario'] = $this->PropietariosDAO->obtener_primer_propietario($ficha_predial);
			
			//se pasa toda la bitacora asociada a la ficha predial
			$this->data['bitacora'] = $this->obtener_tabla($this->BitacoraDAO->obtener_bitacora($ficha_predial));			
			
			//se establece el titulo de la pagina
			$this->data['titulo_pagina'] = 'Bit&aacute;cora';
			
			$this->data['contenido_principal'] = 'infomapas/bitacora_view';
			
			//se carga el template
			$this->load->view('infomapas/index_view', $this->data);
		}
		else {
			header('HTTP/1.1 403 Forbidden');
		}
	}
}