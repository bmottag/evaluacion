<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class consultas_model extends CI_Model {


	    /**
	     * Busca si la cedula que estan ingresando existe en funcionarios de planta
	     * @author Angela Liliana Rodriguez Mahecha
	     * @since  Julio 07 / 2015
	     */
	    function existeusuario($cedula)
	    {
	    	$data = false;
	    	$sql = "SELECT * FROM RH.V_INFOFUNCIONARIOS F
					INNER JOIN GH_ADMIN_USUARIOS U ON U.NUM_IDENT = F.NUMERO_IDENTIFICACION
					WHERE F.NUMERO_IDENTIFICACION='".$cedula."'";
	    	$query = $this->db->query($sql);
	    	if ($query->num_rows() > 0)
	    	{
	    		foreach ($query->result() as $row)
	    		{
	    			$data = array();
	    			$data["identifica"] = $row->NUMERO_IDENTIFICACION;
		    		$data["nombres"] = $row->NOMBRES ." ". $row->PRIMER_APELLIDO." ".$row->SEGUNDO_APELLIDO;
					$data["idUser"] = $row->ID_USUARIO;
	    		}
		    	
	    	}
	    	$this->db->close();
	    	return $data;
	    }
            
	    /**
	     * Busca si la cedula que estan ingresando existe en BD GESTIOH - GH_ADMIN_USUARIOS y esta ACTIVO
	     * @author BMOTTAG
	     * @since  Junio 30/ 2016
	     */
	    function existeusuarioGH($cedula)
	    {
	    	$data = false;
	    	$sql = "SELECT * FROM GH_ADMIN_USUARIOS U 
                        WHERE U.ESTADO = 1 AND U.NUM_IDENT='".$cedula."'";
	    	$query = $this->db->query($sql);
	    	if ($query->num_rows() > 0)
	    	{
	    		foreach ($query->result() as $row)
	    		{
	    			$data = array();
	    			$data["identifica"] = $row->NUM_IDENT;
		    		$data["nombres"] = $row->NOM_USUARIO ." ". $row->APE_USUARIO;
                                $data["idUser"] = $row->ID_USUARIO;
	    		}
		    	
	    	}
	    	$this->db->close();
	    	return $data;
	    }
	    
	/** REVISAR PARA USAR LA GENERICA EN CONSULTAS GENERALES - get_lista_usuarios
	 * Lista de usuarios administradores
	 * @author BMOTTAG
	 * @since 2/9/2015
	 */	
	public function get_lista_administradores()
	{
		$idPermiso = $this->input->post('tipoLista');

		$sql = "SELECT * FROM GH_ADMIN_USUARIOS U
				INNER JOIN GH_ADMIN_RELACION_PERMISOS P ON P.FK_ID_USUARIO = U.ID_USUARIO
				LEFT JOIN GH_PARAM_DEPENDENCIA D ON D.CODIGO_DEPENDENCIA = U.DEP_USUARIO
				WHERE P.FK_ID_PERMISO = $idPermiso
				ORDER BY U.NOM_usuario";				

		$query = $this->db->query($sql);		
		if($query->num_rows() >= 1){
			return $query->result_array();
		}else return false;
		
	}
	
	/**
	 * Consulta menu por idmenu
	 * @review 25/09/2015
	 */	
	public function get_info_menu($idMenu)
	{
		$sql = "SELECT M.ENLACE, P.FK_ID_MODULOS FROM GH_ADMIN_MENU M
				INNER JOIN GH_ADMIN_PERMISOS P ON P.ID_PERMISO = M.FK_ID_PERMISOS
				WHERE M.ID_MENU = $idMenu";				
		$query = $this->db->query($sql);		
		return $query->row_array();
	}

	/**
	 * Consulta PERMISOS para un modulo especifico
	 * @review 29/10/2015
	 */	
	public function get_permisos_by_modulo($idModulo)
	{
		$sql = "SELECT * FROM GH_ADMIN_PERMISOS P
				INNER JOIN GH_ADMIN_MODULOS M ON M.ID_MODULOS = P.FK_ID_MODULOS
				WHERE P.FK_ID_MODULOS = $idModulo
				ORDER BY P.PERFIL ASC";				
		$query = $this->db->query($sql);		
		return $query->result_array();
	}
	
	/**
	 * Consulta MENU
	 * @param $idMenu: valor de la columna para realizar un filtro (NO ES OBLIGATORIO)
	 * @since 13/05/2016
	 */
	public function get_menu( $idMenu = 'x' )
	{
			if( $idMenu != 'x' )
			{	
				$this->db->where("M.ID_MENU", $idMenu); 
			}
			$this->db->join("GH_ADMIN_PERMISOS P", "P.ID_PERMISO = M.FK_ID_PERMISOS", "INNER");
			$this->db->order_by("M.FK_ID_PERMISOS, M.NOMBRE_MENU", "ASC");
			$query = $this->db->get("GH_ADMIN_MENU M");
			
			if($query->num_rows() >= 1){
				return $query->result_array();
			}else{ return false; }
	}	

	/**
	 * Consulta MODULO
	 * @param $idModulo: valor de la columna para realizar un filtro (NO ES OBLIGATORIO)
	 * @since 13/05/2016
	 */
	public function get_modulo( $idModulo = 'x' )
	{
			if( $idModulo != 'x' )
			{	
				$this->db->where("M.ID_MODULOS", $idModulo); 
			}
			$this->db->join("GH_ADMIN_TEMA T", "T.ID_TEMA = M.FK_ID_TEMA", "INNER");
			$this->db->order_by("M.FK_ID_TEMA, M.NOMBRE_MODULO", "ASC");
			$query = $this->db->get("GH_ADMIN_MODULOS M");
			
			if($query->num_rows() >= 1){
				return $query->result_array();
			}else{ return false; }
	}
	
	/**
	 * Consulta PERMISO
	 * @param $idPermiso: valor de la columna para realizar un filtro (NO ES OBLIGATORIO)
	 * @since 13/05/2016
	 */
	public function get_permiso( $idPermiso = 'x', $idEstado = 'x' )
	{
			if( $idPermiso != 'x' )
			{	
				$this->db->where("P.ID_PERMISO", $idPermiso); 
			}
			if( $idEstado != 'x' )
			{	
				$this->db->where("P.ESTADO", $idEstado); 
			}
			$this->db->join("GH_ADMIN_MODULOS M", "M.ID_MODULOS = P.FK_ID_MODULOS", "INNER");
			$this->db->order_by("P.FK_ID_MODULOS, P.PERFIL, P.ESTADO, P.NOMBRE_PERMISO", "ASC");
			$query = $this->db->get("GH_ADMIN_PERMISOS P");
			
			if($query->num_rows() >= 1){
				return $query->result_array();
			}else{ return false; }
	}
        
        /**
         * Consulta los datos para el reporte de asistencia
         * @access Public
         * @author oagarzond
         * @param   Array $arrDatos	Arreglo asociativo con los valores para hacer la consulta
         * @return Array Registros devueltos por la consulta
         */
        public function buscar_personas($arrDatos) {
            $data = array();
            $filtro = "";
            $filtroDependencia = "";

            if (array_key_exists("tipoDepe", $arrDatos)) {
                $filtroDependencia .= " AND DEP_USUARIO LIKE '" . $arrDatos ["tipoDepe"] . "'";
            }
            if (array_key_exists("tipoGrupo", $arrDatos)) {
                $filtroDependencia .= " AND DEP_USUARIO LIKE '" . $arrDatos ["tipoGrupo"] . "'";
            }
            if (array_key_exists("txtDocu", $arrDatos)) {
                $filtro .= " AND NUM_IDENT = '" . $arrDatos ["txtDocu"] . "'";
            }
            if (array_key_exists("txtNombres", $arrDatos)) {
                $filtro .= " AND UPPER(NOM_USUARIO) LIKE '%" . $arrDatos ["txtNombres"] . "%'";
            }

            if (array_key_exists("txtApellidos", $arrDatos)) {
                $filtro .= " AND UPPER(APE_USUARIO) LIKE '%" . $arrDatos ["txtApellidos"] . "%'";
            }
            

            $sql = "SELECT U.*, D.CODIGO_DEPENDENCIA, D.DESCRIPCION  ";
            $sql.= " FROM GH_ADMIN_USUARIOS U";   
            $sql.= " LEFT JOIN GH_PARAM_DEPENDENCIA D ON U.DEP_USUARIO = D.CODIGO_DEPENDENCIA";
            $sql.= " WHERE U.ESTADO = 1 $filtro $filtroDependencia";
            $sql.= " ORDER BY NOM_USUARIO ASC";  

            //pr($sql); exit;
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                $i = 0;
                foreach ($query->result('array') as $row) {
                    $data[$i]["id"] = $row["ID_USUARIO"];
                    $data[$i]["nume_docu"] = $row["NUM_IDENT"];
                    $data[$i]["nombres"] = $row["NOM_USUARIO"];
                    $data[$i]["apellidos"] = $row["APE_USUARIO"];
                    $data[$i]["telefono"] = $row["TEL_USUARIO"];
                    $data[$i]["email"] = $row["MAIL_USUARIO"];
                    $data[$i]["usuario"] = $row["LOG_USUARIO"];
                    $data[$i]["jefe"] = '';
                    $data[$i]["rol"] = '';
                    $i++;
                }
            }
            //pr($data); exit;
            $this->db->close();
            return $data;
        }
		
    /**
     * Listado de permisos para los modulos
     * @since 04/09/2016
	 * @author AOCUBILLOSA
     */
    public function get_lista_permisos($arrDatos) {
			$this->db->select('P.ID_PERMISO, P.PERFIL, M.NOMBRE_MODULO, P.NOMBRE_PERMISO, P.DESCRIPCION');
			$this->db->join('GH_ADMIN_MODULOS M', 'M.ID_MODULOS = P.FK_ID_MODULOS', 'INNER');
			$this->db->where('P.PERFIL', 'ADMIN');
			if (array_key_exists("idModulo", $arrDatos)) {
				$this->db->where('P.FK_ID_MODULOS', $arrDatos["idModulo"]);
			}
			if (array_key_exists("idPermiso", $arrDatos)) {
				$this->db->where('P.ID_PERMISO', $arrDatos["idPermiso"]);
			}
			$this->db->order_by('P.FK_ID_MODULOS, P.NOMBRE_PERMISO', "ASC");
			$query = $this->db->get('GH_ADMIN_PERMISOS P');

			$result = $query->result();

			return $result;
    }
        

	    
}