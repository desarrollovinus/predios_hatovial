<?php
class AccionesDAO extends CI_Model {
	function obtener_acciones() {
		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Consulta las acciones del sistema'
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $this->db->get('tbl_acciones')->result();
	}
}
/* End of file accionesdao.php */
/* Location: ./site_predios/application/models/accionesdao.php */