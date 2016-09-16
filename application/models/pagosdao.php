<?php
class PagosDAO extends CI_Model
{
	function obtener_pagos($ficha_predial)
	{
		$this->db->where('ficha_predial', $ficha_predial);
		$this->db->order_by('num_pago');
		$resultado = $this->db->get('tbl_pagos')->result();
		
		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Consulta los pagos relacionados con la ficha predial='.$ficha_predial
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}
	
	function obtener_nuevo_numero_pago($ficha_predial)
	{		
		$this->db->select_max('num_pago');
		$this->db->where('ficha_predial', $ficha_predial);
		$this->db->from('tbl_pagos');
		
		$resultado = $this->db->get()->row();
		#if($resultado == '') {
		#	return 1;
		#}
		return $resultado->num_pago + 1;
	}
	
	function insertar_pago($ficha_predial, $numero_pago, $fecha, $documento, $valor)
	{
		$this->db->set('ficha_predial', $ficha_predial);
		$this->db->set('num_pago', $numero_pago);
		$this->db->set('fecha_pago', $fecha);
		$this->db->set('doc_pago', $documento);
		$this->db->set('valor', $valor);
		$resultado = $this->db->insert('tbl_pagos');

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se inserta un nuevo pago relacionado a la ficha predial='.$ficha_predial.' por valor de $'.$valor
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}
	
	function obtiene_avaluo($ficha_predial)
	{
		$this->db->select('total_avaluo');
		$this->db->where('ficha_predial', $ficha_predial);
		$resultado = $this->db->get('tbl_identificacion')->row();

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se consulta el valor de avaluo de la ficha predial '.$ficha_predial
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}
	
	function obtiene_total_pagos($ficha_predial)
	{
		$this->db->select('sum(valor) as valor');
		$this->db->where('ficha_predial', $ficha_predial);
		$resultado = $this->db->get('tbl_pagos')->row();

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se consulta el monto total de los pagos realizados con respecto de la ficha predial '.$ficha_predial
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}
	
	function eliminar_pago($ficha_predial, $num_pago) {
		$this->db->where('ficha_predial', $ficha_predial);
		$this->db->where('num_pago', $num_pago);
		
		if($this->db->delete('tbl_pagos')) {
			#accion de auditoria
			$auditoria = array(
				'fecha_hora' => date('Y-m-d H:i:s', time()),
				'id_usuario' => $this->session->userdata('id_usuario'),
				'descripcion' => 'Se elimina el pago numero '.$num_pago.' correspondiente a la ficha predial '.$ficha_predial
			);
			$this->db->insert('auditoria', $auditoria);
			#fin accion de auditoria
			
			return TRUE;
		}
		
		return FALSE;
	}
}
/* End of file pagosdao.php */
/* Location: ./site_predios/application/models/pagosdao.php */