<?php
/**
 * DAO que se encarga de gestionar la informaci&oacute;n correspondiente a los contratistas.
 * @author 		Freddy Alexander Vivas Reyes
 * @copyright	&copy; HATOVIAL S.A.S.
 */
class ContratistasDAO extends  CI_Model
{
	/**
	 * Retorna todos los contratistas que est&aacute;n registrados en el sistema.
	 *
	 * @access	public
	 * @return	todos los estados de procesos registrados en el sistema.
	 */
	function obtener_contratistas()
	{
		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Consulta los contratistas'
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $this->db->get('tbl_contratistas')->result();
	}
	
	function obtener_contratista($id) {
		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Consulta al contratista con id='.$id
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		$this->db->where('id_cont', $id);
		return $this->db->get('tbl_contratistas');
	}
}

/* End of file contratistasdao.php */
/* Location: ./site_predios/application/models/contratistasdao.php */