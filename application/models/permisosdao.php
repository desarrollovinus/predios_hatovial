<?php
class PermisosDAO extends CI_Model {
	function obtener_permisos_usuario($usuario) {
		$query = "SELECT tbl_acciones.id, tbl_modulos.nombre, tbl_acciones.descripcion ";
		$query .= "FROM tbl_modulos, tbl_acciones ";
		$query .= "WHERE tbl_acciones.id ";
		$query .= "IN (";
		$query .= "SELECT accion ";
		$query .= "FROM tbl_permisos ";
		$query .= "WHERE usuario =  '$usuario' ";
		$query .= ") ";
		$query .= "AND tbl_modulos.id = tbl_acciones.modulo";
		$resultado = $this->db->query($query);
		
		$respuesta = array();
		foreach ($resultado->result() as $res):
			$respuesta[$res->nombre][$res->descripcion] = TRUE;
		endforeach;
		
		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Consulta los permisos que tiene el usuario: '.$usuario
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $respuesta;
	}
	
	function actualizar_permisos($acciones, $usuario) {
		$json['resultado'] = 'correcto';
		$error_borrando = FALSE;
		if( ! $this->db->delete('tbl_permisos', array('usuario' => $usuario)) ){
			$error_borrando = TRUE;
		} 
		$error_insertando = FALSE;
		foreach ($acciones as $accion):
			$data = array(
				'accion' => $accion,
				'usuario' => $usuario
			);
			if( ! $this->db->insert('tbl_permisos', $data) ) {
				$error_insertando = TRUE;
			}
		endforeach;
		
		if($error_borrando || $error_insertando) {
			$json['resultado'] = 'error';
			$json['mensaje'] = 'Ocurri&oacute; un error reseteando los permisos del usuario';
		}
		
		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Actualiza los permisos que tiene el usuario: '.$usuario
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $json;
	}
}
/* End of file permisosdao.php */
/* Location: ./site_predios/application/models/permisosdao.php */