<?php
class LogsDAO extends CI_Model {
	function obtener_logs() {
		$this->db->select('auditoria.fecha_hora');
		$this->db->select('tbl_usuarios.us_nombre');
		$this->db->select('tbl_usuarios.us_apellido');		
		$this->db->select('auditoria.descripcion');
		$this->db->from('auditoria');
		$this->db->join('tbl_usuarios', 'auditoria.id_usuario=tbl_usuarios.id_usuario');
		$this->db->order_by('auditoria.fecha_hora', "desc"); 
		return $this->db->get()->result();
	}
}