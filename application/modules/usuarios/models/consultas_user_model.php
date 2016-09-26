<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class consultas_user_model extends CI_Model {
    
    /**
     * Numero de usuarios que aceptaron las politicas
     * @param   Array   $arrDatos   Int $arrDatos["politica"]  Int $arrDatos["idDependencia"]
     * @return row Numero de resgistros
     * @since 11/08/2016
     */
    public function contar_usuario_politica($arrDatos) {
        $this->db->select('COUNT(ID_USUARIO) CONTEO');
		$this->db->where('POLITICA', $arrDatos["politica"]);
        if (array_key_exists("idDependencia", $arrDatos)) {  
			$this->db->like('DEP_USUARIO', $arrDatos["idDependencia"], 'after'); 
        }
		$this->db->where('ESTADO', 1);
        $query = $this->db->get('GH_ADMIN_USUARIOS');

        $row = $query->row();
        return $row->CONTEO;
    }
	
    /**
     * Numero de usuarios que hablan otro idioma diferente al español
     * @param   Array   $arrDatos   Int $arrDatos["idDependencia"]
	 * @param   Int $arrDatos["idDependencia"]
     * @return row Numero de resgistros
     * @since 21/08/2016
     */
    public function contar_usuario_idioma($arrDatos) {
        $this->db->select('COUNT(DISTINCT(I.FK_ID_USUARIO)) CONTEO');
		$this->db->join('GH_ADMIN_USUARIOS U', 'U.ID_USUARIO = I.FK_ID_USUARIO', 'INNER');
        if (array_key_exists("idDependencia", $arrDatos)) {
            $this->db->where('U.DEP_USUARIO', $arrDatos["idDependencia"]);
        }
		$this->db->where("FK_ID_IDIOMA <>", 7); //idiomas diferente al español
        $query = $this->db->get('USER_IDIOMA I');

        $row = $query->row();
        if ($query->num_rows() > 0) {
            return $row->CONTEO;  
        } else {
            return false;   
        }
    }
	
    /**
     * Numero de usuarios que tienen dependeintes
     * @param   Array   $arrDatos   Int $arrDatos["idDependencia"]
	 * @param   Int $arrDatos["idDependencia"]
     * @return row Numero de resgistros
     * @since 21/08/2016
     */
    public function contar_usuario_dependiente($arrDatos) {
        $this->db->select('COUNT(DISTINCT(D.FK_ID_USUARIO)) CONTEO');
		$this->db->join('GH_ADMIN_USUARIOS U', 'U.ID_USUARIO = D.FK_ID_USUARIO', 'INNER');
        if (array_key_exists("idDependencia", $arrDatos)) {
            $this->db->where('U.DEP_USUARIO', $arrDatos["idDependencia"]);
        }
        $query = $this->db->get('USER_DEPENDIENTE D');

        $row = $query->row();
        if ($query->num_rows() > 0) {
            return $row->CONTEO;  
        } else {
            return false;
        } 
    }
	
    /**
     * Numero de usuarios que que hacen una actividad
     * @param   Array   $arrDatos   Int $arrDatos["idDependencia"]
	 * @param   Int $arrDatos["idDependencia"]
	 * @param   Varchar $arrDatos["filtro"]
     * @return row Numero de resgistros
     * @since 21/08/2016
     */
    public function contar_usuario_actividades($arrDatos) {
        $this->db->select('COUNT(DISTINCT(A.FK_ID_USUARIO)) CONTEO');
		$this->db->join('GH_ADMIN_USUARIOS U', 'U.ID_USUARIO = A.FK_ID_USUARIO', 'INNER');
        if (array_key_exists("idDependencia", $arrDatos)) {
            $this->db->where('U.DEP_USUARIO', $arrDatos["idDependencia"]);
        }
        if (array_key_exists("filtro", $arrDatos)) {
			$this->db->where($arrDatos["filtro"], 99);
        }
        $query = $this->db->get('USER_ACTIVIDADES A');

        $row = $query->row();
        if ($query->num_rows() > 0) {
            return $row->CONTEO;  
        } else {
            return false;
        } 
    }
	
    /**
     * Numero de usuarios que tienen mascotas
     * @param   Array   $arrDatos   Int $arrDatos["idDependencia"]
	 * @param   Int $arrDatos["idDependencia"]
	 * @param   Varchar $arrDatos["filtro"]
     * @return row Numero de resgistros
     * @since 11/08/2016
     */
    public function contar_usuario_mascotas($arrDatos) {
        $this->db->select('COUNT(DISTINCT(M.FK_ID_USUARIO)) CONTEO');
		$this->db->join('GH_ADMIN_USUARIOS U', 'U.ID_USUARIO = M.FK_ID_USUARIO', 'INNER');
        if (array_key_exists("idDependencia", $arrDatos)) {
            $this->db->where('U.DEP_USUARIO', $arrDatos["idDependencia"]);
        }
        if (array_key_exists("filtro", $arrDatos)) {
			$this->db->where($arrDatos["filtro"], 99);
        }
        $query = $this->db->get('USER_MASCOTAS M');

        $row = $query->row();
        if ($query->num_rows() > 0) {
            return $row->CONTEO;
        } else {
            return false;
        } 
    }

    /**
     * Consultar usuarios por dependencia, por estado activo y politica aceptada
     * @since 19/08/2016
     * @author AOCUBILLOSA
     */
    public function get_usuarios_by_dependencia() 
	{
		$dependencia = $_POST["idDependenica"];

        $SQL = "SELECT U.*, D.CODIGO_DEPENDENCIA, D.DESCRIPCION 
				FROM GH_ADMIN_USUARIOS U 
				LEFT JOIN GH_PARAM_DEPENDENCIA D ON U.DEP_USUARIO = D.CODIGO_DEPENDENCIA
				WHERE U.ESTADO = 1 AND U.POLITICA = 1 AND U.DEP_USUARIO LIKE '" . $dependencia . "%'
				ORDER BY NOM_USUARIO ASC";
        $query = $this->db->query($SQL);   

        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else
            return false;
    }	
	
	
}