<?php
/**
 * DAO que se encarga de gestionar la informacion de los propietarios registrados en el sistema.
 * @author 		Freddy Alexander Vivas Reyes
 * @copyright	&copy; HATOVIAL S.A.S.
 */
class PropietariosDAO extends CI_Model
{
	/**
	 * Determina si un propietario ya existe en la base de datos.
	 *
	 * @access	public
	 * @param	string	el documento del propietario.
	 * @return	TRUE 	si ya existe.
	 * @return	FALSE 	en caso contrario.
	 */
	function existe_propietario($documento)
	{
		//query que busca un propietario por el documento, bien sea que este tenga formato o no
		$query = "select * from tbl_propietario where documento='".$documento."' or documento='".number_format($documento, 0, "", ",")."'";
		$propietario = $this->db->query($query);
		//si hay algun resultado con el numero sin formato
		if($this->db->count_all_results() > 0)
		{
			#accion de auditoria
			$auditoria = array(
				'fecha_hora' => date('Y-m-d H:i:s', time()),
				'id_usuario' => $this->session->userdata('id_usuario'),
				'descripcion' => 'Se consultan la informacion del propietario con documento: '.$documento
			);
			$this->db->insert('auditoria', $auditoria);
			#fin accion de auditoria

			return $propietario->row();
		}
		return FALSE;
	}

	/**
	 * Determina si un propietario ya existe en la base de datos.
	 *
	 * @access	public
	 * @param	array	la informacion del propietario.
	 */
	function insertar_propietario($propietario)
	{
		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se inserta un nuevo usuario con documento: '.$propietario['documento']
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		$this->db->insert('tbl_propietario', $propietario);
	}

	/**
	 * Relaciona un propietario con un predio.
	 *
	 * @access	public
	 * @param	string	el documento del propietario.
	 * @param	string	la ficha predial.
	 * @param	double	el porcentaje de participacion.
	 */
	function insertar_relacion_predio($id_propietario, $ficha_predial, $participacion)
	{
		//se inserta en la tabla
		return $this->db->insert('tbl_relacion', array("ficha_predial" => $ficha_predial, "id_propietario" => $id_propietario, "participacion" => $participacion));

		#accion de auditoria
		// $auditoria = array(
		// 	'fecha_hora' => date('Y-m-d H:i:s', time()),
		// 	'id_usuario' => $this->session->userdata('id_usuario'),
		// 	'descripcion' => 'Se inserta la relacion entre el predio '.$ficha_predial.' y el propietario con id '.$id_propietario
		// );
		// $this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria
	}

	function obtener_propietarios($ficha_predial)
	{
		$this->db->select('tbl_propietario.*');
		$this->db->select('tbl_relacion.participacion');
		$this->db->from('tbl_propietario');
		$this->db->join('tbl_relacion', 'tbl_propietario.id_propietario=tbl_relacion.id_propietario');
		$this->db->where('tbl_relacion.ficha_predial',$ficha_predial);
		$resultado = $this->db->get()->result();

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se consultan los propietarios'
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}

	function actualizar_propietario($id_propietario, $datos_propietario)
	{
		$this->db->where('id_propietario', $id_propietario);
		$resultado = $this->db->update('tbl_propietario', $datos_propietario);

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se actualiza la informacion del propietario '.$datos_propietario['nombre']
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}
	
	function eliminar_relacion_propietario($ficha_predial, $id_propietario)
	{
		$this->db->where('ficha_predial', $ficha_predial);
		$this->db->where('id_propietario', $id_propietario);
		$resultado = $this->db->delete('tbl_relacion');

		#accion de auditoria
		$this->db->select('documento');
		$this->db->where('id_propietario', $id_propietario);
		$propietario = $this->db->get('tbl_propietario');
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se elimina la relacion entre el predio '.$ficha_predial.' y el propietario '.$propietario->documento
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}
	
	function eliminar_relaciones_predio($ficha_predial)
	{
		// Se borran todas las relaciones del predio
		$this->db->where('ficha_predial', $ficha_predial);
		return $this->db->delete('tbl_relacion');
	}
	
	function obtener_todos_los_propietarios()
	{
		$this->db->order_by('nombre, id_propietario');
		$resultado = $this->db->get('tbl_propietario')->result();

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se consultan todos los propietarios'
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}
	
	function obtener_propietario($id_propietario)
	{
		$this->db->where('id_propietario', $id_propietario);
		$resultado = $this->db->get('tbl_propietario')->row();

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se consultan la informacion del propietario '.$resultado->documento
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}
	
	function obtener_relaciones($id_propietario)
	{
		$this->db->select('tbl_predio.id_predio');
		$this->db->select('tbl_relacion.ficha_predial');
		$this->db->select('tbl_relacion.participacion');
		$this->db->join('tbl_predio', 'tbl_relacion.ficha_predial=tbl_predio.ficha_predial');
		$this->db->where('id_propietario', $id_propietario);
		$resultado = $this->db->get('tbl_relacion')->result();

		#accion de auditoria
		$this->db->select('documento');
		$this->db->where('id_propietario', $id_propietario);
		$propietario = $this->db->get('tbl_propietario')->row();
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se consultan los predios asociados al propietario '.$propietario->documento
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}
	
	
	
	function obtener_primer_propietario($ficha_predial) {
		$this->db->where('ficha_predial', $ficha_predial);
		$relacion = $this->db->get('tbl_relacion')->row();
		
		if($relacion) {
			$this->db->where('id_propietario', $relacion->id_propietario);
			$resultado = $this->db->get('tbl_propietario')->row();

			#accion de auditoria
			$auditoria = array(
				'fecha_hora' => date('Y-m-d H:i:s', time()),
				'id_usuario' => $this->session->userdata('id_usuario'),
				'descripcion' => 'Se consulta el primer propietario relacionado con la ficha predial '.$ficha_predial
			);
			$this->db->insert('auditoria', $auditoria);
			#fin accion de auditoria

			return $resultado;
		}
		
		return FALSE;
	}
}
/* End of file propietariosdao.php */
/* Location: ./site_predios/application/models/propietariosdao.php */