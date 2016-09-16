<?php
/**
 * DAO que se encarga de gestionar la informacion de los usuarios del sistema.
 * @author 		Freddy Alexander Vivas Reyes
 * @copyright	&copy; HATOVIAL S.A.S.
 */
class UsuariosDAO extends CI_Model
{
	/**
	 * Retorna los datos de un usuario si existe.
	 *
	 * @access	public
	 * @param	string	el usuario.
	 * @param	string	el password.
	 * @return	los datos del usuario, FALSE en caso contrario.
	 */
	function valida_usuario($user, $pass)
	{
		//columnas a retornar
		$this->db->select('id_usuario');
		$this->db->select('us_nombre');
		$this->db->select('us_apellido');
		$this->db->select('us_mail');
		$this->db->select('us_tipo');
		//validacion
		$this->db->where('us_user',$user);
		$this->db->where('us_pass',$pass);
		//retorno consulta
		$resultado = $this->db->get('tbl_usuarios')->row();

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => ' ',
			'descripcion' => 'Intento de validacion por parte del usuario: '.$user
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}
	
	function valida_usuario_infomapas($user){
		//columnas a retornar
		$this->db->select('id_usuario');
		$this->db->select('us_nombre');
		$this->db->select('us_apellido');
		$this->db->select('us_mail');
		$this->db->select('us_tipo');
		//validacion
		$this->db->where('md5(us_user)',$user);
		//retorno consulta
		$resultado = $this->db->get('tbl_usuarios')->row();

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => ' ',
			'descripcion' => 'Intento de validacion por parte del usuario: '.$user.' desde la interfaz de infomapas'
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}
	
	function obtener_usuarios() {
		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se consultan los usuarios del sistema'
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $this->db->get('tbl_usuarios')->result();
	}
	
	function obtener_usuario($id_usuario) {
		$this->db->where('id_usuario', $id_usuario);
		$resultado = $this->db->get('tbl_usuarios')->row();

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se consultan los usuarios del sistema'
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}
	
	function insertar_usuario($usuario) {
		if($this->db->insert("tbl_usuarios", $usuario)) {
			#accion de auditoria
			$auditoria = array(
				'fecha_hora' => date('Y-m-d H:i:s', time()),
				'id_usuario' => $this->session->userdata('id_usuario'),
				'descripcion' => 'Se inserta un nuevo usuario: '.$usuario['us_user']
			);
			$this->db->insert('auditoria', $auditoria);
			#fin accion de auditoria

			return TRUE;
		}
		return FALSE;
	}
	
	function actualizar_usuario($usuario) {
		$this->db->where('id_usuario', $usuario['id_usuario']);
		if($this->db->update("tbl_usuarios", $usuario)) {
			#accion de auditoria
			$auditoria = array(
				'fecha_hora' => date('Y-m-d H:i:s', time()),
				'id_usuario' => $this->session->userdata('id_usuario'),
				'descripcion' => 'Se actualiza la informacion del usuario: '.$usuario['us_user']
			);
			$this->db->insert('auditoria', $auditoria);
			#fin accion de auditoria
			return TRUE;
		}
		return FALSE;
	}	
	
	function eliminar_usuario($cedula) {
		$this->db->where('id_usuario', $cedula);
		if($this->db->delete("tbl_usuarios")) {
			#accion de auditoria
			$auditoria = array(
				'fecha_hora' => date('Y-m-d H:i:s', time()),
				'id_usuario' => $this->session->userdata('id_usuario'),
				'descripcion' => 'Se elimina al usuario con cedula: '.$cedula
			);
			$this->db->insert('auditoria', $auditoria);
			#fin accion de auditoria
			return TRUE;
		}
		return FALSE;
	}
}
/* End of file usuariosdao.php */
/* Location: ./site_predios/application/models/usuariosdao.php */