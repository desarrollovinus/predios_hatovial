<?php
class ActasDAO extends CI_Model
{	
	function obtener_actas()
	{
		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Consulta las actas'
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria
		
		//SELECT tbl_predio.ficha_predial, tbl_actas.pg_ficha, tbl_actas.pg_ef, tbl_actas.pg_comp, tbl_actas.pg_reg FROM { OJ tbl_predio LEFT OUTER JOIN tbl_actas ON tbl_predio.id_predio=tbl_actas.id_predio } ORDER BY tbl_predio.ficha_predial
		$query = "SELECT tbl_predio.ficha_predial, tbl_actas.pg_ficha, tbl_actas.pg_ef, tbl_actas.pg_comp, tbl_actas.pg_reg FROM { OJ tbl_predio LEFT OUTER JOIN tbl_actas ON tbl_predio.id_predio=tbl_actas.id_predio } ORDER BY tbl_predio.ficha_predial"; 
		return $this->db->query($query)->result();
	}
	
	function actualizar_campo($ficha, $campo, $valor)
	{
		//obtiene el campo id_predio de la tabla tbl_predio
		$this->db->select('id_predio');
		$this->db->where('ficha_predial', $ficha);
		$id_predio = $this->db->get('tbl_predio')->row();
		
		//ubico el nombre del campo de la tabla a actualizar
		$nombre_campo = '';
		switch($campo)
		{
			case '1':$nombre_campo='pg_ficha';break;
			case '2':$nombre_campo='pg_ef';break;
			case '3':$nombre_campo='pg_comp';break;
			case '4':$nombre_campo='pg_reg';break;
		}
		
		//busco los registros en la tabla tbl_actas con ese id_predio
		$this->db->where('id_predio', $id_predio->id_predio);
		$this->db->from('tbl_actas');
		$registros = $this->db->count_all_results();
		
		//armo el dato a actualizar
		$data = array($nombre_campo => $valor);	
		
		//realizo el query respectivo ya sea un update o un insert
		
		if($registros > 0)
		{			
			$data = array($nombre_campo => $valor);	
			$this->db->where('id_predio', $id_predio->id_predio);
			$resultado = $this->db->update('tbl_actas', $data);

			#accion de auditoria
			$this->db->select('ficha_predial');
			$this->db->where('id_predio', $id_predio->id_predio);
			$predio = $this->db->get('tbl_predio')->row();
			$auditoria = array(
				'fecha_hora' => date('Y-m-d H:i:s', time()),
				'id_usuario' => $this->session->userdata('id_usuario'),
				'descripcion' => 'Se actualiza un registro de actas: '.$nombre_campo.'='.$valor.' en el predio: '.$predio->ficha_predial
			);
			$this->db->insert('auditoria', $auditoria);
			#fin accion de auditoria
			
			return $resultado;
		}
		else
		{
			$data = array('id_predio' => $id_predio->id_predio, $nombre_campo => $valor);	
			$resultado = $this->db->insert('tbl_actas', $data);

			#accion de auditoria
			$this->db->select('ficha_predial');
			$this->db->where('id_predio', $id_predio->id_predio);
			$predio = $this->db->get('tbl_predio')->row();
			$auditoria = array(
				'fecha_hora' => date('Y-m-d H:i:s', time()),
				'id_usuario' => $this->session->userdata('id_usuario'),
				'descripcion' => 'Se actualiza un registro de actas: '.$nombre_campo.'='.$valor.' en el predio: '.$predio->ficha_predial
			);
			$this->db->insert('auditoria', $auditoria);
			#fin accion de auditoria

			return $resultado;
		}
	}
}
/* End of file actasdao.php */
/* Location: ./site_predios/application/models/actasdao.php */