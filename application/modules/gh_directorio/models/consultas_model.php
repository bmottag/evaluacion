<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class consultas_model extends CI_Model {

    function __construct() {
        parent::__construct();
        //$this->load->library("validarsesion");	    	
    }

    /**
     * Lista para el directorio
     * @since 30/07/2015

      public function get_directorio()
      {
      $this->db->order_by('NOM_USUARIO', 'asc');
      $query = $this->db->get('GH_ADMIN_USUARIOS');
      return $query->result_array();
      } */
    /**
     * Lista Actos Administrativos
     * @since 14/07/2015

      public function get_actosadmin()
      {
      $query = $this->db->get('actos_administrativos');
      if($query->num_rows() >= 1){
      return $query->result_array();
      }else return false;
      } */

    /**
     * Realiza el conteo de Actos Administrativos
     * @since 14/07/2015
     */
    public function conteoUsuarios() {
        $conteo = 0;
        $filtro = '';
        $filtroDependencia = '';

        $nombre = "";
        $apellido = "";
        $despacho = "";
        $dependencia = "";
        $grupo = "";
        $correo = "";

        if ($_POST) {
            $correo = str_replace(array("<", ">", "[", "]", "*", "^", "-", "'", "="), "", $_POST["correo"]);
            $nombre = str_replace(array("<", ">", "[", "]", "*", "^", "-", "'", "="), "", $_POST["nombre"]);
            $apellido = str_replace(array("<", ">", "[", "]", "*", "^", "-", "'", "="), "", $_POST["apellido"]);
            $despacho = $_POST["cmbDespacho"];
            $dependencia = $_POST["dependencia"];
            $grupo = $_POST["grupo"];
        }
        
        if ($correo != '') {
            $filtro .= " AND MAIL_USUARIO LIKE '%" . strtolower($correo) . "%'";
        }
        if ($nombre != '') {
            $filtro .= " AND UPPER(NOM_USUARIO) LIKE '%" . strtoupper($nombre) . "%'";
        }
        if ($apellido != '') {
            $filtro .= " AND UPPER(APE_USUARIO) LIKE '%" . strtoupper($apellido) . "%'";
        }
        //filtro para la dependencia
        if ($despacho != '' && $despacho != "-") {
            $filtroDependencia = " AND DEP_USUARIO LIKE '" . $despacho . "%'";
        }
        if ($dependencia != '' && $dependencia != "-") {
            $filtroDependencia = " AND DEP_USUARIO LIKE '" . $dependencia . "%'";
        }
        if ($grupo != '' && $grupo != "-") {
            $filtroDependencia = " AND DEP_USUARIO LIKE '" . $grupo . "%'";
        }

        $sql = "SELECT COUNT(*) AS CONTEO 
            FROM GH_ADMIN_USUARIOS 
            WHERE ESTADO = 1 $filtro $filtroDependencia";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $conteo = $row->CONTEO;
            }
        }
        return $conteo;
    }

    /**
     * Consulta Actos Administrativos 
     * @since 14/07/2015
     * @author BMOTTAG
     */
    public function get_usuarios($desde, $hasta) {
        $filtro = '';
        $filtroDependencia = '';
        $nombre = "";
        $apellido = "";
        $despacho = "";
        $dependencia = "";
        $grupo = "";
        $correo = "";

        if ($_POST) {
            $correo = str_replace(array("<", ">", "[", "]", "*", "^", "-", "'", "="), "", $_POST["correo"]);
            $nombre = str_replace(array("<", ">", "[", "]", "*", "^", "-", "'", "="), "", $_POST["nombre"]);
            $apellido = str_replace(array("<", ">", "[", "]", "*", "^", "-", "'", "="), "", $_POST["apellido"]);
            $despacho = $_POST["cmbDespacho"];
            $dependencia = $_POST["dependencia"];
            $grupo = $_POST["grupo"];
        }
        
        if ($correo != '') {
            $filtro .= " AND MAIL_USUARIO LIKE '%" . strtolower($correo) . "%'";
        }
        if ($nombre != '') {
            $filtro .= " AND UPPER(NOM_USUARIO) LIKE '%" . strtoupper($nombre) . "%'";
        }
        if ($apellido != '') {
            $filtro .= " AND UPPER(APE_USUARIO) LIKE '%" . strtoupper($apellido) . "%'";
        }
        //filtro para la dependencia
        if ($despacho != '' && $despacho != "-") {
            $filtroDependencia = " AND DEP_USUARIO LIKE '" . $despacho . "%'";
        }
        if ($dependencia != '' && $dependencia != "-") {
            $filtroDependencia = " AND DEP_USUARIO LIKE '" . $dependencia . "%'";
        }
        if ($grupo != '' && $grupo != "-") {
            $filtroDependencia = " AND DEP_USUARIO LIKE '" . $grupo . "%'";
        }

        $SQL = "SELECT * FROM 
            ( SELECT A.*, ROWNUM rnum 
                FROM ( SELECT U.*, D.CODIGO_DEPENDENCIA, D.DESCRIPCION 
                        FROM GH_ADMIN_USUARIOS U 
                        LEFT JOIN GH_PARAM_DEPENDENCIA D ON U.DEP_USUARIO = D.CODIGO_DEPENDENCIA
                        WHERE U.ESTADO = 1 $filtro $filtroDependencia
                        ORDER BY NOM_USUARIO ASC ) A 
                WHERE ROWNUM <= " . $hasta . " ) 
            WHERE rnum  >= " . $desde;
        $query = $this->db->query($SQL);

        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else
            return false;
    }

    /**
     * Consultar nombre
     * @since 30/03/2016
     * @author BMOTTAG
     */
    function autocomplete_nombre($q) {

        $row_set = "";
        $sql = "SELECT DISTINCT(UPPER(U.NOM_USUARIO)) NOM_USUARIO
						FROM GH_ADMIN_USUARIOS U
						WHERE LOWER(NOM_USUARIO) LIKE '%$q%' AND ESTADO = 1
						ORDER BY NOM_USUARIO";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row_set[] = $row['NOM_USUARIO'];
            }
        }
        echo json_encode($row_set);
    }

    /**
     * Consulta apellidos
     * @since 08/04/2016
     * @author BMOTTAG
     */
    function autocomplete_apellido($q) {

        $row_set = "";
        $sql = "SELECT DISTINCT(UPPER(U.APE_USUARIO)) APE_USUARIO
						FROM GH_ADMIN_USUARIOS U
						WHERE LOWER(APE_USUARIO) LIKE '%$q%' AND ESTADO = 1
						ORDER BY APE_USUARIO";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row_set[] = $row['APE_USUARIO'];
            }
        }
        echo json_encode($row_set);
    }
}
?> 