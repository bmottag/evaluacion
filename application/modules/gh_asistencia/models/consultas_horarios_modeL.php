<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* * *
 * Modelo para obtener los datos de las asistencias
 * @author oagarzond
 * @since 2016-05-04
 * * */

class Consultas_horarios_model extends My_model {
    
    private $db_asis;

    function __construct() {
        parent::__construct();
        $this->db_asis = $this->load->database("asis", TRUE);
    }
    
    /**
     * Inserta un nuevo registro del horario
     * @access Public
     * @author oagarzond
     * @param   Array   $arrDatos   Campos y valores que se va a insertar
     * @return  True|False
     */
    public function insertar_horario($arrDatos) {
        $query = $this->ejecutar_insert('ASIS_FORM_HORARIOS', $arrDatos);
        //$this->db->insert('SESI_CONTROL_ASISTENCIA', $arrDatos);
        //$query = $this->db->query($this->sql);
        return $query;
    }
    
    /**
     * Editar el registro del horario
     * @access Public
     * @author oagarzond
     * @param   Array   $arrDatos   Campos y valores que se va a insertar
     * @return  True|False
     */
    public function editar_horario($arrDatos, $arrWhere) {
        $query = $this->ejecutar_update('ASIS_FORM_HORARIOS', $arrDatos, $arrWhere);
        return $query;
    }
    
    /**
     * Busca si existe un horario especial para el usuario
     * @access Public
     * @author oagarzond
     * @param   Array $arrDatos	Arreglo asociativo con los valores para hacer la consulta
     * @return Array Registros devueltos por la consulta
     */
    public function consultar_horario($arrDatos) {
        $data = array();
        $cond = '';
        
        if (array_key_exists("idPers", $arrDatos)) {
            $cond .= " AND FH.INTERNO_PERSONA = '" . $arrDatos ["idPers"] . "'";
        }
        if (array_key_exists("idUsua", $arrDatos)) {
            $cond .= " AND FH.FK_ID_USUARIO = '" . $arrDatos ["idUsua"] . "'";
        }
        if (array_key_exists("fechaRangoHorario", $arrDatos) && !empty($arrDatos["fechaRangoPermiso"])) {
            $cond .= " AND (TO_CHAR(FH.FECHA_INICIAL, 'DD/MM/YYYY') >= '" . $arrDatos["fechaRangoPermiso"] . "' OR TO_CHAR(FH.FECHA_FINAL, 'DD/MM/YYYY') <= '" . $arrDatos["fechaRangoPermiso"] . "')";
        }
        
        $sql = "SELECT TO_CHAR(FH.FECHA_REGISTRO, 'DD/MM/YYYY') FECHAR, TO_CHAR(FH.FECHA_INICIAL, 'DD/MM/YYYY') FECHA_INI, TO_CHAR(FH.FECHA_FINAL, 'DD/MM/YYYY') FECHA_FIN, 
            TO_CHAR(FH.FECHA_RESO, 'DD/MM/YYYY') FECHA_RESOLU, FH.* 
            FROM ASIS_FORM_HORARIOS FH 
            WHERE FH.ID_HORARIO IS NOT NULL " . $cond;
        $query = $this->db_asis->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result('array') as $row) {
                $data[] = $row;
            }
        }
        //pr($data); exit;
        $this->db_asis->close();
        return $data;
    }
}
// EOC
