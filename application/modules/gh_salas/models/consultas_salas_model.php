<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class consultas_salas_model extends CI_Model{

	/**
	 * Lista de salas
	 * @author BMOTTAG
	 * @since 15/10/2013
	 * @review 7/10/2015
	 */	
	public function get_salas($estado = 1)
	{
		if( $this->input->post('salaId') ){
			$this->db->where('ID_SALA', $this->input->post('salaId'));
		}
		if( $estado != 'x' )
		{
			$this->db->where('ESTADO', $estado);
		}		
		$this->db->order_by("SALA_NOMBRE", "asc"); 
		$query = $this->db->get('GH_PARAM_SALAS');
		return $query->result_array();
	}

	/**
	 * Lista de solicitudes para una sala y fecha especifica
	 * @author BMOTTAG
	 * @since 17/10/2013
	 * @review 8/10/2015
	 */	
	public function get_solicitudes($salaId,$fecha,$estado=NULL)
	{
		$this->db->select('S.*, U.NOM_USUARIO, U.APE_USUARIO, U.EXT_USUARIO, P.ID_SALA, P.SALA_NOMBRE, E.*');
		$this->db->join('GH_ADMIN_USUARIOS U', 'U.ID_USUARIO = S.FK_ID_USUARIO', 'INNER');
		$this->db->join('GH_PARAM_SALAS P', 'P.ID_SALA = S.FK_ID_SALA', 'left');
		$this->db->join('GH_PARAM_ESTADOS_SALAS E', 'E.ID_ESTADO = S.FK_ID_ESTADO', 'left');
		if ($estado != NULL) 
		{
			$this->db->where('S.FK_ID_ESTADO', $estado);
		}
		$this->db->where('S.FK_ID_SALA', $salaId );
		$this->db->where('S.FECHA_APARTADO', $fecha );
		
		$query = $this->db->get('GH_FORM_SOLICITUD_SALA S');
		return $query->result_array();
	}

	/**
	 * Lista de solicitudes para un usuario
	 * @author BMOTTAG
	 * @since 05/11/2013
	 * @review 19/10/2015
	 */	
	public function get_estado_solicitudes($idUser)
	{
		$this->db->select('S.*, U.NOM_USUARIO, U.APE_USUARIO, U.EXT_USUARIO, P.ID_SALA, P.SALA_NOMBRE, E.*');
		$this->db->from('GH_FORM_SOLICITUD_SALA S');
		$this->db->join('GH_ADMIN_USUARIOS U', 'U.ID_USUARIO = S.FK_ID_USUARIO', 'INNER');
		$this->db->join('GH_PARAM_SALAS P', 'P.ID_SALA = S.FK_ID_SALA', 'left');
		$this->db->join('GH_PARAM_ESTADOS_SALAS E', 'E.ID_ESTADO = S.FK_ID_ESTADO', 'left');
		$this->db->where('S.FK_ID_USUARIO', $idUser);
		$this->db->order_by("S.ID_SOLICITUD_SALA", "DESC"); 		
		$query = $this->db->get();
		return $query->result_array();
	}	
	
	/**
	 * Lista de nuevas solicitudes
	 * @author BMOTTAG
	 * @since 05/11/2013
	 * @review 22/10/2015
	 */	
	public function get_new_solicitudes($idSolicitud, $estado)
	{
		$this->db->select('*');
		$this->db->from('GH_FORM_SOLICITUD_SALA S');
		$this->db->join('GH_ADMIN_USUARIOS U', 'U.ID_USUARIO = S.FK_ID_USUARIO', 'INNER');
		$this->db->join('GH_PARAM_SALAS P', 'P.ID_SALA = S.FK_ID_SALA', 'left');
		if( $estado != 'x' )
			$this->db->where('S.FK_ID_ESTADO', $estado);
		if( $idSolicitud != 'x' )
			$this->db->where('S.ID_SOLICITUD_SALA', $idSolicitud);
		$this->db->order_by("S.ID_SOLICITUD_SALA", "ASC"); 
		
		$query = $this->db->get();	
		return $query->result_array();
	}
	
	/**
	 * Datos de solicitudes por ID
	 * @author BMOTTAG
	 * @since 20/11/2013
	 * @review 22/10/2015
	 */	
	public function get_solbyID()
	{
		$this->db->select('S.*, U.NOM_USUARIO, U.APE_USUARIO, U.EXT_USUARIO, P.ID_SALA, P.SALA_NOMBRE, E.*');
		$this->db->join('GH_ADMIN_USUARIOS U', 'U.ID_USUARIO = S.FK_ID_USUARIO', 'INNER');
		$this->db->join('GH_PARAM_SALAS P', 'P.ID_SALA = S.FK_ID_SALA', 'left');
		$this->db->join('GH_PARAM_ESTADOS_SALAS E', 'E.ID_ESTADO = S.FK_ID_ESTADO', 'left');
		$this->db->where('S.ID_SOLICITUD_SALA', $this->input->post('solicitudId') );
		$query = $this->db->get('GH_FORM_SOLICITUD_SALA S');
		if($query->num_rows() >= 1){
			return $query->result_array();
		}else return false;	
	}
	
	/**
	 * Historico para descargar en xls
	 * Lista de solicitudes por periodo de fechas
	 * @author BMOTTAG
	 * @since 14/02/2014
	 * @review 22/10/2015
	 */	
	public function get_solicitudes_historico()
	{
		$this->db->select('S.*, U.NOM_USUARIO, U.APE_USUARIO, U.EXT_USUARIO, P.ID_SALA, P.SALA_NOMBRE, E.*');
		$this->db->from('GH_FORM_SOLICITUD_SALA S');
		$this->db->join('GH_ADMIN_USUARIOS U', 'U.ID_USUARIO = S.FK_ID_USUARIO', 'INNER');
		$this->db->join('GH_PARAM_SALAS P', 'P.ID_SALA = S.FK_ID_SALA', 'left');
		$this->db->join('GH_PARAM_ESTADOS_SALAS E', 'E.ID_ESTADO = S.FK_ID_ESTADO', 'left');			
		$this->db->where('S.FECHA_APARTADO >=', $this->input->post('fechaIni') );
		$this->db->where('S.FECHA_APARTADO <=', $this->input->post('fechaFin') );
		$query = $this->db->get();		
		return $query->result_array();		
	}

	/**
	 * Realiza el conteo de registros de solicitudes para un usuario
	 * @since 27/10/2015
	 */
	public function conteoRegistrosUsuario($idUser){
		$conteo = 0;
		
		$sql = "SELECT COUNT(*) AS CONTEO FROM GH_FORM_SOLICITUD_SALA 
				WHERE FK_ID_USUARIO = " . $idUser;
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0){				
			foreach($query->result() as $row){
				$conteo = $row->CONTEO;					
			}
		}
		return $conteo;		
	}	
	
	/**
	 * Consulta permisos usuario para el paginador
	 * @since 27/10/2015
	 * @author BMOTTAG
	 */	
	public function get_solicitudes_usuario( $desde, $hasta )
	{
		$idUser = $this->session->userdata("id");
		$SQL = "SELECT * FROM
				( SELECT A.*, ROWNUM rnum 
					FROM (	SELECT S.*, U.NOM_USUARIO, U.APE_USUARIO, U.EXT_USUARIO, P.ID_SALA, P.SALA_NOMBRE, E.*
							FROM GH_FORM_SOLICITUD_SALA S 
							INNER JOIN GH_ADMIN_USUARIOS U ON S.FK_ID_USUARIO = U.ID_USUARIO 
							INNER JOIN GH_PARAM_SALAS P ON P.ID_SALA = S.FK_ID_SALA 
							INNER JOIN GH_PARAM_ESTADOS_SALAS E ON E.ID_ESTADO = S.FK_ID_ESTADO 
							WHERE S.FK_ID_USUARIO = " . $idUser . "
							ORDER BY S.ID_SOLICITUD_SALA DESC ) A 
					WHERE ROWNUM <= " . $hasta . " ) 
				WHERE rnum  >= " .$desde;
		$query = $this->db->query($SQL);

		if($query->num_rows() >= 1){
			return $query->result_array();
		}else return false;		
	}
	
	
	
	

		
}
?>