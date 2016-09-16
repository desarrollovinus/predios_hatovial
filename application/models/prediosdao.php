<?php
/**
 * DAO que se encarga de gestionar la informacion de los predios registrados en el sistema.
 * @author 		Freddy Alexander Vivas Reyes
 * @copyright	&copy; HATOVIAL S.A.S.
 */
class PrediosDAO extends CI_Model
{
	/**
	 * Determina si una ficha predial ya existe.
	 *
	 * @access	public
	 * @param	string	la ficha predial.
	 * @return	TRUE 	si ya existe.
	 * @return	FALSE 	en caso contrario.
	 */
	function existe_ficha($ficha_predial)
	{
		//clausula WHERE del sql.
		$this->db->where('ficha_predial', $ficha_predial);
		//si hay algun resultado
		if($this->db->get('tbl_predio')->num_rows() > 0)
		{
			return TRUE;
		}
		return FALSE;
	}
	
	/**
	 * Inserta la identificaci&oacute;n de un predio bas&aacute;ndose en un array.
	 *
	 * @access	public
	 * @param	array	la identificaci&oacute;n del predio.
	 */
	function insertar_identificacion($identificacion)
	{
		//el array asociativo pasado por parametro debe tener sus indices nombrados 
		//de la misma forma en que aparecen las columnas de la tabla
		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se inserta la identificacion del predio '.$identificacion['ficha_predial']
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		$this->db->insert('tbl_identificacion', $identificacion);
	}
	
	/**
	 * Inserta la descripci&oacute;n de un predio bas&aacute;ndose en un array.
	 *
	 * @access	public
	 * @param	array	la descripci&oacute;n del predio.
	 */
	function insertar_descripcion($descripcion)
	{
		//el array asociativo pasado por parametro debe tener sus indices nombrados 
		//de la misma forma en que aparecen las columnas de la tabla
		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se inserta la descripcion del predio '.$descripcion['ficha_predial']
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		$this->db->insert('tbl_descripcion', $descripcion);
	}
	
	/**
	 * Inserta los linderos de un predio.
	 *
	 * @access	public
	 * @param	string	la ficha predial.
	 * @param	string	la descripci&oacute;n de los linderos del predio.
	 */
	function insertar_linderos($ficha_predial, $linderos)
	{
		//se asignan los campos a guardar
		$this->db->set('ficha_predial', $ficha_predial);
		$this->db->set('linderos', $linderos);
		//se inserta en la tabla
		$this->db->insert('tbl_predio_req');

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se insertan los linderos del predio '.$ficha_predial
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria
	}
	
	/**
	 * Inserta los datos de un predio.
	 *
	 * @access	public
	 * @param	string	la ficha_predial.
	 * @param	date	fecha y hora en que se realiza el registro.
	 * @param	string	la id del usuario que realiza el registro.
	 */
	function insertar_predio($ficha_predial, $fecha_hora, $usuario)
	{
		//se obtienen las id necesarias
		$identificacion = $this->obtener_id_identificacion($ficha_predial);
		$descripcion = $this->obtener_id_descripcion($ficha_predial);
		$linderos = $this->obtener_id_linderos($ficha_predial);
		//se asignan los valores correspondientes
		$this->db->set('ficha_predial', $ficha_predial);
		$this->db->set('fecha_hora', $fecha_hora);
		$this->db->set('usuario', $usuario);
		//se inserta en la tabla
		$this->db->insert('tbl_predio');

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se insertan los datos del predio '.$ficha_predial
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria
	}
	
	/**
	 * Obtiene la id de la identificaci&oacute;n del predio.
	 *
	 * @access	private
	 * @param	string	la ficha_predial.
	 * @return	string	la id de la identificaci&oacute;n del predio.
	 */	
	private function obtener_id_identificacion($ficha_predial)
	{
		//se selecciona la columna id_identificacion
		$this->db->select('id_identificacion');
		//clausula WHERE del sql
		$this->db->where('ficha_predial', $ficha_predial);
		//se obtienen los resultados
		$resultado = $this->db->get('tbl_identificacion')->row();

		return $resultados;
	}
	
	/**
	 * Obtiene la id de la descripci&oacute;n del predio.
	 *
	 * @access	private
	 * @param	string	la ficha_predial.
	 * @return	string	la id de la descripcion del predio.
	 */	
	private function obtener_id_descripcion($ficha_predial)
	{
		//se selecciona la columna id_descripcion
		$this->db->select('id_descripcion');
		//clausula WHERE del sql
		$this->db->where('ficha_predial', $ficha_predial);
		//se obtienen los resultados
		return $this->db->get('tbl_descripcion')->row();
	}
	
	/**
	 * Obtiene la id de la descripci&oacute;n de los linderos del predio.
	 *
	 * @access	private
	 * @param	string	la ficha_predial.
	 * @return	string	la id de la descripci&oacute;n de los linderos del predio.
	 */	
	private function obtener_id_linderos($ficha_predial)
	{
		//se selecciona la columna id_predio_req
		$this->db->select('id_predio_req');
		//clausula WHERE del sql
		$this->db->where('ficha_predial', $ficha_predial);
		//se obtienen los resultados
		return $this->db->get('tbl_predio_req')->row();
	}
	
	function obtener_fichas()
	{
		$sql=
		"SELECT
		(SELECT
		tbl_propietario.nombre
		FROM
		tbl_relacion
		INNER JOIN tbl_propietario ON tbl_relacion.id_propietario = tbl_propietario.id_propietario
		WHERE
		tbl_relacion.ficha_predial = tbl_predio.ficha_predial
		GROUP BY
		tbl_relacion.ficha_predial) AS propietario,
		tbl_predio.id_predio,
		tbl_predio.fecha_hora,
		tbl_predio.ficha_predial,
		tbl_usuarios.us_nombre,
		tbl_usuarios.us_apellido
		FROM
		tbl_predio
		INNER JOIN tbl_usuarios ON tbl_usuarios.id_usuario = tbl_predio.usuario";


		return $this->db->query($sql)->result();
		/*
		$this->db->select('id_predio');
		$this->db->select('fecha_hora');
		$this->db->select('ficha_predial');
		$this->db->select('us_nombre');
		$this->db->select('us_apellido');
		$this->db->join('tbl_usuarios', 'tbl_usuarios.id_usuario=tbl_predio.usuario');
		$resultado = $this->db->get('tbl_predio')->result();

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se consulta los predios ingresados al sistema'
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
		*/
	}
	
	function listar_fichas($palabra_clave, $max_filas) {
		$this->db->select('ficha_predial');
		$this->db->like('ficha_predial', $palabra_clave); 
		$this->db->order_by('ficha_predial');
		$resultado = $this->db->get('tbl_predio', $max_filas)->result();

		return $resultado;
	}
	
	function obtener_predios_contratista($contratista)
	{
		/*$this->db->select('id_predio');
		$this->db->select('tbl_predio.fecha_hora');
		$this->db->select('tbl_predio.ficha_predial');
		$this->db->select('us_nombre');
		$this->db->select('us_apellido');
		$this->db->where('enc_gestion', $contratista);
		$this->db->from('tbl_predio, tbl_usuarios, tbl_identificacion');
		$this->db->where('tbl_usuarios.id_usuario', 'tbl_predio.usuario');
		$this->db->where('tbl_identificacion.ficha_predial', 'tbl_predio.ficha_predial');
		return $this->db->get()->result();*/
		
		$query = "	SELECT
tbl_predio.id_predio,
tbl_predio.fecha_hora,
tbl_predio.ficha_predial,
tbl_usuarios.us_nombre,
tbl_usuarios.us_apellido,
tbl_propietario.nombre AS propietario
FROM
tbl_predio ,
tbl_usuarios ,
tbl_identificacion ,
tbl_propietario
WHERE tbl_identificacion.enc_gestion LIKE  '$contratista'
					AND tbl_usuarios.id_usuario = tbl_predio.usuario
					AND tbl_identificacion.ficha_predial = tbl_predio.ficha_predial";
		$resultado = $this->db->query($query)->result();

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se filtran los predios del contratista: '.$contratista
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}
	
	function obtener_predio($id_predio)
	{
		$this->db->where('id_predio', $id_predio);
		$resultado = $this->db->get('tbl_predio')->row();

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se consultan los datos del predio con id: '.$id_predio
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}

	function obtener_predio_mapas($ficha)
	{
		$this->db->where('ficha_predial', $ficha);
		$resultado = $this->db->get('tbl_predio')->row();

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se consultan los datos del predio con id: '.$id_predio
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}
	
	function obtener_descripcion($ficha_predial)
	{
		$this->db->where('ficha_predial', $ficha_predial);
		$resultado = $this->db->get('tbl_descripcion')->row();

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se consulta la descripcion del predio: '.$ficha_predial
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}
	
	function obtener_identificacion($ficha_predial)
	{
		$this->db->where('ficha_predial', $ficha_predial);
		$resultado = $this->db->get('tbl_identificacion')->row();

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se consulta la identificacion del predio: '.$ficha_predial
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}
	
	function obtener_linderos($ficha_predial)
	{
		$this->db->where('ficha_predial', $ficha_predial);
		$resultado =  $this->db->get('tbl_predio_req')->row();

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se consultan los linderos del predio: '.$ficha_predial
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}
	
	function actualizar_identificacion($ficha_predial, $identificacion)
	{
		$this->db->where('ficha_predial', $ficha_predial);
		//el array asociativo pasado por parametro debe tener sus indices nombrados 
		//de la misma forma en que aparecen las columnas de la tabla
		$this->db->update('tbl_identificacion', $identificacion);

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se actualiza la identificacion del predio: '.$ficha_predial
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria
	}
	
	function actualizar_descripcion($ficha_predial, $descripcion)
	{
		$this->db->where('ficha_predial', $ficha_predial);
		//el array asociativo pasado por parametro debe tener sus indices nombrados 
		//de la misma forma en que aparecen las columnas de la tabla
		$this->db->update('tbl_descripcion', $descripcion);

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se actualiza la descripcion del predio: '.$ficha_predial
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria
	}
	
	function actualizar_linderos($ficha_predial, $linderos)
	{
		$datos = array(
			'linderos' => $linderos
		);
		$this->db->where('ficha_predial', $ficha_predial);
		//el array asociativo pasado por parametro debe tener sus indices nombrados 
		//de la misma forma en que aparecen las columnas de la tabla
		$this->db->update('tbl_predio_req', $datos);

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se actualizan los linderos del predio: '.$ficha_predial
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria
	}
	
	function obtener_predios_menu() 
	{
		$this->db->order_by("id_predio", "desc");
		$this->db->select('ficha_predial, id_predio');
		$resultado = $this->db->get('tbl_predio', 10, 0)->result();

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se consultan los predios que se muestran en el menu de la izquierda'
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}

	function actualizar_predio_requerido($ficha_predial, $requerido) {
		$data = array('requerido' => $requerido);
		$this->db->where('ficha_predial', $ficha_predial);
		$this->db->update('tbl_predio', $data);
	}

	function obtener_predio_siguiente($ficha_predial, $palabra_clave) {
		$query = "
			SELECT 
				tbl_predio.id_predio, tbl_predio.ficha_predial
			FROM 
				tbl_predio, 
				tbl_usuarios
			WHERE
				tbl_predio.usuario=tbl_usuarios.id_usuario AND
				(
					tbl_predio.fecha_hora like '%$palabra_clave%' OR
					tbl_predio.ficha_predial like'%$palabra_clave%' OR
					tbl_usuarios.us_nombre like '%$palabra_clave%' OR
					tbl_usuarios.us_apellido like '%$palabra_clave%'
				) AND
				tbl_predio.ficha_predial > '$ficha_predial'
			ORDER BY
				tbl_predio.ficha_predial asc
			LIMIT 1
			OFFSET 0
		";
		return $this->db->query($query)->row();
	}

	function obtener_predio_anterior($ficha_predial, $palabra_clave) {
		$query = "
			SELECT 
				tbl_predio.id_predio, tbl_predio.ficha_predial
			FROM 
				tbl_predio, 
				tbl_usuarios
			WHERE
				tbl_predio.usuario=tbl_usuarios.id_usuario AND
				(
					tbl_predio.fecha_hora like '%$palabra_clave%' OR
					tbl_predio.ficha_predial like'%$palabra_clave%' OR
					tbl_usuarios.us_nombre like '%$palabra_clave%' OR
					tbl_usuarios.us_apellido like '%$palabra_clave%'
				) AND
				tbl_predio.ficha_predial < '$ficha_predial'
			ORDER BY
				tbl_predio.ficha_predial desc
			LIMIT 1
			OFFSET 0
		";
		return $this->db->query($query)->row();
	}
}
/* End of file prediosdao.php */
/* Location: ./site_predios/application/models/prediosdao.php */