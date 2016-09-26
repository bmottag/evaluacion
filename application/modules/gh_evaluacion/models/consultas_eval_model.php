<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class consultas_eval_model extends CI_Model {

    /**
     * Lista parametrica de oficinas
     * @since 01/06/2016
     */
    public function get_oficinas($arrDatos) {
        $this->db->select('O.*, D.DESCRIPCION');
        $this->db->join('GH_PARAM_DEPENDENCIA D', 'D.CODIGO_DEPENDENCIA = O.FK_ID_DEPENDENCIA', 'INNER');

        if (array_key_exists("estado", $arrDatos)) {
            $this->db->where('O.ESTADO', $arrDatos["estado"]);
        }
        if (array_key_exists("idOficina", $arrDatos)) {
            $this->db->where('O.ID_OFICINA', $arrDatos["idOficina"]);
        }
        if (array_key_exists("tipoEvaluador", $arrDatos) && $arrDatos["tipoEvaluador"] < 3) { //filtra si es el director o el subdirecor
            $this->db->where('O.EVALUADOR', $arrDatos["tipoEvaluador"]);
        }
        //consultar oficinas para crear acuerdo para la plantilla dependiendo del tipo de gerente publico
        if (array_key_exists("tipoGerente", $arrDatos)) {
            $this->db->where('O.TIPO_GERENTE_PUBLICO', $arrDatos["tipoGerente"]);
        }
        $this->db->order_by('O.EVALUADOR, D.DESCRIPCION', "ASC");
        $query = $this->db->get('EVAL_PARAM_OFICINA O');

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /**
     * Lista parametrica de macroproceso
     * @since 01/06/2016
     */
    public function get_macroproceso() {
        $cadena_sql = "SELECT ID_MACROPROCESO, AREA, MACROPROCESO,  (U.NOM_USUARIO || ' ' || U.APE_USUARIO) AS JEFE, D.ESTADO ";
        $cadena_sql.= " FROM EVAL_PARAM_MACROPROCESO D";
        $cadena_sql.= " INNER JOIN GH_ADMIN_USUARIOS U ON (U.ID_USUARIO =  D.FK_ID_USUARIO)";
        $cadena_sql.= " INNER JOIN EVAL_PARAM_AREA A ON (A.ID_AREA =  D.FK_ID_AREA)";
        $cadena_sql.= " ORDER BY AREA, MACROPROCESO";
        //pr($cadena_sql); exit;
        $query = $this->db->query($cadena_sql);
        $result = $query->result();
        
        return $result;
    }

    /**
     * Lista parametrica de pilar estrategico
     * @since 07/06/2016
     */
    public function get_pilar() {
        $cadena_sql = "SELECT ID_PILAR, PILAR ";
        $cadena_sql.= " FROM EVAL_PARAM_PILAR ";

        $query = $this->db->query($cadena_sql);
        $result = $query->result();
        return $result;
    }

    /**
     * Lista oficinas con su acuerdo
     * @since 13/06/2016
     */
    public function get_acuerdo($idOficina) {
        $vigencia = date('Y');

        $this->db->select();
        $this->db->where('A.VIGENCIA', $vigencia);
        $this->db->where('A.FK_ID_OFICINA', $idOficina);
        $query = $this->db->get('EVAL_ACUERDO A');

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    /**
     * Informacion acuerdo
     * @since 18/06/2016
     */
    public function get_acuerdo_byID($idAcuerdo) {
        $this->db->select('A.ID_ACUERDO, A.VIGENCIA, A.OBSERVACIONES, D.DESCRIPCION, D.FK_ID_USUARIO, O.TIPO_GERENTE_PUBLICO, O.EVALUADOR');
        $this->db->join('EVAL_PARAM_OFICINA O', 'O.ID_OFICINA = A.FK_ID_OFICINA', 'INNER');
        $this->db->join('GH_PARAM_DEPENDENCIA D', 'D.CODIGO_DEPENDENCIA = O.FK_ID_DEPENDENCIA', 'INNER');
        $this->db->where('A.ID_ACUERDO', $idAcuerdo);
        $query = $this->db->get('EVAL_ACUERDO A');

        //$query = $this->db->query($cadena_sql);

        $result = $query->result();

        return $result;
    }

    /**
     * Informacion macroproceso asignado
     * @since 19/06/2016
     */
    public function get_macro_byID($idMacro) {
        $this->db->select();
        $this->db->join('EVAL_ACUERDO A', 'A.ID_ACUERDO = M.FK_ID_ACUERDO', 'INNER');
        $this->db->where('M.ID_ASIGNAR_MACRO', $idMacro);
        $query = $this->db->get('EVAL_ASIGNAR_MACRO M');

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    /**
     * Lista macroprocesos asignados
     * @since 13/06/2016
	 * @review 11/09/2016
     */
    public function get_asignacion_macro($arrDatos) {
        $this->db->select();
        $this->db->join('EVAL_PARAM_MACROPROCESO P', 'P.ID_MACROPROCESO = M.FK_ID_MACROPROCESO', 'INNER');
        $this->db->join('EVAL_PARAM_AREA A', 'A.ID_AREA = P.FK_ID_AREA', 'INNER');

        if (array_key_exists("idAcuerdo", $arrDatos)) {
            $this->db->where('M.FK_ID_ACUERDO', $arrDatos["idAcuerdo"]);
        }
        if (array_key_exists("idUsuario", $arrDatos)) {
            $this->db->where('P.FK_ID_USUARIO', $arrDatos["idUsuario"]);
        }
        if (array_key_exists("idAsignarMacro", $arrDatos)) {
            $this->db->where('M.ID_ASIGNAR_MACRO', $arrDatos["idAsignarMacro"]);
        }
		$this->db->where('M.ESTADO', 1); //Macroprocesos Activos
        $query = $this->db->get('EVAL_ASIGNAR_MACRO M');

        if ($query->num_rows() > 0) {
            return $result = $query->result();
        } else {
            return false;
        }
    }

    /**
     * Validar si ya existe acuerdos para la territorial o direcion y la vigencia actual
     * @author AOCUBILLOSA
     * @since  23/07/2016
     */
    public function get_porcentaje_area($idMacroproceso) {
        $sql = "SELECT PORCENTAJE_AREA";
        $sql.= " FROM EVAL_PARAM_MACROPROCESO M";
        $sql.= " INNER JOIN EVAL_PARAM_AREA A ON A.ID_AREA = M.FK_ID_AREA";
        $sql.= " WHERE M.ID_MACROPROCESO = '$idMacroproceso'";

        $query = $this->db->query($sql);
        $row = $query->row();
        return $row->PORCENTAJE_AREA;
    }

    /**
     * Lista de compromisos asignados al macroproceso
     * @since 13/06/2016
	 * @review 11/09/2016
     */
    public function get_asignacion_compromiso($idAsignarMacro) {
        $this->db->select();
        $this->db->join('EVAL_PARAM_PILAR P', 'P.ID_PILAR = A.FK_ID_PILAR', 'INNER');
        $this->db->where('A.FK_ID_ASIGNAR_MACRO', $idAsignarMacro);
		$this->db->where('A.ESTADO', 1); //Compromisos Activos
        $query = $this->db->get('EVAL_ASIGNAR_PILAR A');

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /**
     * Informacion del compromiso
     * @since 13/07/2016
     */
    public function get_compromiso_byID($idAsignarPilar) {
        $this->db->select();
        $this->db->join('EVAL_ASIGNAR_MACRO M', 'M.ID_ASIGNAR_MACRO = P.FK_ID_ASIGNAR_MACRO', 'INNER');
        $this->db->where('P.ID_ASIGNAR_PILAR', $idAsignarPilar);
        $query = $this->db->get('EVAL_ASIGNAR_PILAR P');

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    /**
     * Lista de dependencias a evaluar 
     * @since 21/06/2016
     */
    public function get_listado_evaluar() {
        $idUser = $this->session->userdata("id");

        $this->db->select('DISTINCT(E.FK_ID_ACUERDO) ID_ACUERDO, D.DESCRIPCION, O.TIPO_GERENTE_PUBLICO');
        $this->db->join('EVAL_PARAM_MACROPROCESO M', 'M.ID_MACROPROCESO = E.FK_ID_MACROPROCESO', 'INNER');
        $this->db->join('EVAL_ACUERDO A', 'A.ID_ACUERDO = E.FK_ID_ACUERDO', 'INNER');
        $this->db->join('EVAL_PARAM_OFICINA O', 'O.ID_OFICINA = A.FK_ID_OFICINA', 'INNER');
        $this->db->join('GH_PARAM_DEPENDENCIA D', 'D.CODIGO_DEPENDENCIA = O.FK_ID_DEPENDENCIA', 'INNER');
        $this->db->order_by('D.DESCRIPCION', "ASC");
        $this->db->where('M.FK_ID_USUARIO', $idUser);
        $query = $this->db->get('EVAL_ASIGNAR_MACRO E');

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /**
     * Validar si ya se asigno evaluador a la depencia
     * @author BMOTTAG
     * @since  07/07/2016
     */
    public function existeDependencia() {
        $result = false;

        $idOficina = $this->input->post('hddIdentificador');
        $idOficina = $idOficina == '' ? 0 : $idOficina;
        $dependencia = $this->input->post("dependencia");

        $sql = "SELECT * FROM EVAL_PARAM_OFICINA WHERE FK_ID_DEPENDENCIA = '$dependencia' AND ID_OFICINA <> '$idOficina'";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = true;
        }
        $this->db->close();
        return $result;
    }

    /**
     * Validar si la dependencia tiene jefe
     * @author AOCUBILLOSA
     * @since  22/07/2016
     */
    public function existeJefe() {
        $result = false;

        $dependencia = $this->input->post("dependencia");

        $sql = "SELECT * FROM GH_PARAM_DEPENDENCIA WHERE CODIGO_DEPENDENCIA = '$dependencia' AND FK_ID_USUARIO IS NOT NULL";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = true;
        }
        $this->db->close();
        return $result;
    }

    /**
     * Validar si ya se asignado macroproceso para la plantilla
     * @author BMOTTAG
     * @since  08/07/2016
     */
    public function existeMacroPlantilla() {
        $result = false;

        $tipoGerente = $this->input->post('hddIdParam');
        $idMacro = $this->input->post('macroproceso');

        $sql = "SELECT * FROM EVAL_PARAM_PLANTILLA WHERE TIPO_GERENTE_PUBLICO = '$tipoGerente' AND FK_ID_MACROPROCESO = '$idMacro'";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = true;
        }
        $this->db->close();
        return $result;
    }

    /**
     * Validar si ya se asignado macroproceso para el acuerdo
     * @author BMOTTAG
     * @since  11/07/2016
     */
    public function existeMacro($idAcuerdo) {
        $result = false;

        $idMacro = $this->input->post('macroproceso');

        $sql = "SELECT * FROM EVAL_ASIGNAR_MACRO WHERE FK_ID_ACUERDO = '$idAcuerdo' AND FK_ID_MACROPROCESO = '$idMacro' AND ESTADO = 1";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = true;
        }
        $this->db->close();
        return $result;
    }

    /**
     * Datos de la plantilla, Macroproceso sugerido con el peso para cada tipo de gerente publico
     * @since 08/07/2016
     */
    public function get_plantilla($tipoGerente) {
        $cadena_sql = "SELECT ID_PLANTILLA, FK_ID_MACROPROCESO, AREA, MACROPROCESO, PESO_SUGERIDO ";
        $cadena_sql.= " FROM EVAL_PARAM_PLANTILLA P";
        $cadena_sql.= " INNER JOIN EVAL_PARAM_MACROPROCESO M ON M.ID_MACROPROCESO =  P.FK_ID_MACROPROCESO";
        $cadena_sql.= " INNER JOIN EVAL_PARAM_AREA A ON A.ID_AREA =  M.FK_ID_AREA";
        $cadena_sql.= " WHERE TIPO_GERENTE_PUBLICO = '$tipoGerente'";
        $cadena_sql.= " ORDER BY AREA, MACROPROCESO";

        $query = $this->db->query($cadena_sql);
        $result = $query->result();
        return $result;
    }

    /**
     * Retornar la suma de peso programada para cada tipo de gerente publico
     * @since 09/07/2016
     */
    public function get_suma_peso($id = 'x') {
        $this->db->select("TIPO_GERENTE_PUBLICO, SUM(PESO_SUGERIDO) PESO");
        if ($id != 'x') {
            $this->db->where("TIPO_GERENTE_PUBLICO", $id);
        }
        $this->db->group_by('TIPO_GERENTE_PUBLICO');
        $this->db->order_by("TIPO_GERENTE_PUBLICO", "asc");
        $query = $this->db->get('EVAL_PARAM_PLANTILLA');

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /**
     * Validar si ya existe acuerdos para la territorial o direcion y la vigencia actual
     * @author BMOTTAG
     * @since  10/07/2016
     */
    public function existeAcuerdo($tipoGestion) {
        $vigencia = date('Y');
        if ($tipoGestion == "terr") {
            $filtro = "D.ANTECESOR = 4";
        } elseif ($tipoGestion == "dir") {
            $filtro = "D.ANTECESOR <> 4";
        }

        $sql = "SELECT count(A.ID_ACUERDO) CONTEO";
        $sql.= " FROM EVAL_ACUERDO A";
        $sql.= " INNER JOIN EVAL_PARAM_OFICINA O ON O.ID_OFICINA = A.FK_ID_OFICINA";
        $sql.= " INNER JOIN GH_PARAM_DEPENDENCIA D ON D.CODIGO_DEPENDENCIA = O.FK_ID_DEPENDENCIA";
        $sql.= " WHERE A.VIGENCIA = '$vigencia' AND $filtro";

        $query = $this->db->query($sql);
        $row = $query->row();
        return $row->CONTEO;
    }

    /**
     * Verificar si faltan compromisos para hacer seguimiento
     * @since 01/06/2016
     */
    public function existeSeguimientoCompleto($arrDatos) {
        if ($arrDatos["periodo"] == "ABRIL") {
            $where = "SEGUIMIENTO_ABRIL IS NULL";
        } elseif ($arrDatos["periodo"] == "AGOSTO") {
            $where = "SEGUIMIENTO_AGOSTO IS NULL";
        } elseif ($arrDatos["periodo"] == "DICIEMBRE") {
            $where = "SEGUIMIENTO_DICIEMBRE IS NULL";
        } else {
            return false;
        }

        $this->db->select('ID_ASIGNAR_PILAR');
        $this->db->join('EVAL_ASIGNAR_MACRO M', 'M.FK_ID_ACUERDO = A.ID_ACUERDO', 'INNER');
        $this->db->join('EVAL_ASIGNAR_PILAR P', 'P.FK_ID_ASIGNAR_MACRO = M.ID_ASIGNAR_MACRO', 'INNER');
        $this->db->where('A.ID_ACUERDO', $arrDatos["idAcuerdo"]);
        $this->db->where($where);
        $query = $this->db->get('EVAL_ACUERDO A');

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /**
     * Verificar si faltan compromisos para hacer aprobacion
     * @since 01/06/2016
     */
    public function existeAprobacionCompleto($arrDatos) {
        if ($arrDatos["periodo"] == "ABRIL") {
            $where = "APROBAR_ABRIL IS NULL";
        } elseif ($arrDatos["periodo"] == "AGOSTO") {
            $where = "APROBAR_AGOSTO IS NULL";
        } elseif ($arrDatos["periodo"] == "DICIEMBRE") {
            $where = "APROBAR_DICIEMBRE IS NULL";
        } else {
            return false;
        }

        $this->db->select('ID_ASIGNAR_PILAR');
        $this->db->join('EVAL_ASIGNAR_MACRO M', 'M.FK_ID_ACUERDO = A.ID_ACUERDO', 'INNER');
        $this->db->join('EVAL_ASIGNAR_PILAR P', 'P.FK_ID_ASIGNAR_MACRO = M.ID_ASIGNAR_MACRO', 'INNER');
        $this->db->where('A.ID_ACUERDO', $arrDatos["idAcuerdo"]);
        $this->db->where($where);
        $query = $this->db->get('EVAL_ACUERDO A');

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /**
     * Verifica si el usuario es el director o el subdirector
     * @author BMOTTAG
     * @since  11/07/2016
     */
    public function get_cargo_user($idUser) {
        $this->db->select("CODIGO_DEPENDENCIA");
        $this->db->where("FK_ID_USUARIO", $idUser);
        $query = $this->db->get('GH_PARAM_DEPENDENCIA');

        $row = $query->row();
        return $row->CODIGO_DEPENDENCIA;
    }

    /**
     * Lista de jefes para el modulo de crear macroprocesos
     * @since 16/07/2016
     */
    public function get_jefes() {
        $cadena_sql = "SELECT DISTINCT(D.FK_ID_USUARIO) AS FK_ID_USUARIO, (U.NOM_USUARIO || ' ' || U.APE_USUARIO) AS JEFE ";
        $cadena_sql.= " FROM GH_PARAM_DEPENDENCIA D";
        $cadena_sql.= " INNER JOIN GH_ADMIN_USUARIOS U ON U.ID_USUARIO =  D.FK_ID_USUARIO";
        $cadena_sql.= " ORDER BY JEFE";

        $query = $this->db->query($cadena_sql);

        $result = $query->result();

        return $result;
    }

    /**
     * Verfica si termino la programacion para un acuerdo especifico
     * @since 26/07/2016
     */
    public function progrmacion_completa($idAcuerdo) {
        $cadena_sql = "SELECT * ";
        $cadena_sql.= " FROM EVAL_ASIGNAR_MACRO";
        $cadena_sql.= " WHERE FK_ID_ACUERDO = '$idAcuerdo' AND PESO_ASIGNADO <> PESO_PROGRAMADO";

        $query = $this->db->query($cadena_sql);
        if ($query->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Consultar calificacion guardada si existe
     * @since 04/08/2016
     */
    public function get_calificacion_compromiso($idAcuerdo) {
        $this->db->select();
        $this->db->join('EVAL_PARAM_COMPROMISO C', 'C.ID_COMPROMISO = M.FK_ID_COMPROMISO', 'INNER');
        $this->db->order_by('C.ID_COMPROMISO', "ASC");
        $this->db->where('M.FK_ID_ACUERDO', $idAcuerdo);
        $query = $this->db->get('EVAL_COMPROMISO_MEJORA M');

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
	
    /**
     * Lista del historial para el acuerdo
     * @since 18/09/2016
     */
    public function get_historial($arrDatos) {
        $this->db->select('H.*, U.NOM_USUARIO, U.APE_USUARIO, U.EXT_USUARIO');
        $this->db->join('GH_ADMIN_USUARIOS U', 'U.ID_USUARIO = H.FK_ID_USUARIO', 'INNER');
        if (array_key_exists("idAcuerdo", $arrDatos)) {
            $this->db->where('H.FK_ID_ACUERDO', $arrDatos["idAcuerdo"]);
        }
		$this->db->order_by('H.ID_HISTORICO', "ASC");
        $query = $this->db->get('EVAL_HISTORICO H');

        if ($query->num_rows() > 0) {
            return $result = $query->result();
        } else {
            return false;
        }
    }

}

?>