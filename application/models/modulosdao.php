<?php
class ModulosDAO extends CI_Model {
	function obtener_modulos() {
		
		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Consulta los modulos del sistema'
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $this->db->get('tbl_modulos')->result();
	}
}
/* End of file modulosdao.php */
/* Location: ./site_predios/application/models/modulosdao.php */