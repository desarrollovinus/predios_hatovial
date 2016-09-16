<?php
/**
 * DAO que se encarga de gestionar la informaci&oacute;n correspondiente a los estados en los que se puede encontrar un proceso
 * @author 		Freddy Alexander Vivas Reyes
 * @copyright	&copy; HATOVIAL S.A.S.
 */
class ProcesosDAO extends CI_Model
{
	/**
	 * Retorna los estados de los procesos que est&aacute;n registrados en el sistema.
	 *
	 * @access	public
	 * @return	todos los estados de procesos registrados en el sistema.
	 */
	function obtener_estados_proceso()
	{
		//se ordena el Record Set por la id del estado del proceso
		$this->db->order_by('estado');
		$resultado = $this->db->get('tbl_estados_proceso')->result();

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se consultan los estados de procesos'
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}
}

/* End of file procesosdao.php */
/* Location: ./site_predios/application/models/procesosdao.php */