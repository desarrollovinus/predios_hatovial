<?php
/**
 * DAO que se encarga de gestionar la informaci&oacute;n correspondiente a los tramos en los que se encuentran los predios.
 * @author 		Freddy Alexander Vivas Reyes
 * @copyright	&copy; HATOVIAL S.A.S.
 */
class TramosDAO extends CI_Model
{
	/**
	 * Retorna los tramos que est&aacute;n registrados en el sistema.
	 *
	 * @access	public
	 * @return	todos los tramos registrados en el sistema.
	 */
	function obtener_tramos()
	{
		//se ordena el Record Set por la id del tramo
		#$this->db->select('tramo');
		$this->db->order_by('id');
		$resultado = $this->db->get('tbl_tramos')->result();

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se consultan los tramos'
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}
}

/* End of file tramosdao.php */
/* Location: ./site_predios/application/models/tramosdao.php */