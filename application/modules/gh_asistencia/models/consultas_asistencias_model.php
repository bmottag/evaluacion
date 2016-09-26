<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* * *
 * Modelo para obtener los datos de las asistencias
 * @author oagarzond
 * @since 2016-05-04
 * * */

class Consultas_asistencias_model extends My_model {

    private $db_asis;

    function __construct() {
        parent::__construct();
        $this->db_asis = $this->load->database("asis", TRUE);
    }
    
    /**
     * Inserta un nuevo registro de asistencia
     * @access Public
     * @author oagarzond
     * @param   Array   $arrDatos   Campos y valores que se va a insertar
     * @return  True|False
     */
    public function insertar_asistencia($tabla, $arrValores) {
        //$this->db->insert('SESI_CONTROL_ASISTENCIA', $arrDatos);
        $sql = $this->ejecutar_insert($tabla, $arrValores, 'si');
        //pr($sql); exit;
        $query = $this->db_asis->query($sql);
        return $query;
    }
    
    /**
     * Editar el registro de asistencia
     * @access Public
     * @author oagarzond
     * @param   Array   $arrDatos   Campos y valores que se va a insertar
     * @return  True|False
     */
    public function editar_asistencia($tabla, $arrValores, $arrWhere) {
        $sql = $this->ejecutar_update($tabla, $arrValores, $arrWhere, 'si');
        //pr($sql); exit;
        $query = $this->db_asis->query($sql);
        return $query;
    }
    
    /**
     * Consulta los datos de la persona por codigo de barras
     * @access Public
     * @author oagarzond
     * @param   Int $idPers     Codigo de la persona
     * @param   Int $codiBarra  Codigo de barra
     * @return Array Registros devueltos por la consulta
     */
    public function existe_codigo_barras($idPers = '', $codiBarra = '') {
        $cond = "";
        $data = array();
        if (!empty($idPers)) {
            if (is_int($idPers)) {
                $cond .= " AND INTERNO_PERSONA = " . $idPers;
            } else if (is_string($idPers)) {
                $cond .= " AND INTERNO_PERSONA = '" . $idPers . "'";
            } else if (is_array($idPers)) {
                $cond .= " AND INTERNO_PERSONA IN (" . implode(",", $idPers) . ")";
            }
        }
        if (!empty($codiBarra)) {
            if (is_int($codiBarra)) {
                $cond .= " AND CODIGO_BARRAS_EAN8 = " . $codiBarra;
            } else if (is_string($codiBarra)) {
                $cond .= " AND CODIGO_BARRAS_EAN8 = '" . $codiBarra . "'";
            } else if (is_array($codiBarra)) {
                $cond .= " AND CODIGO_BARRAS_EAN8 IN (" . implode(",", $codiBarra) . ")";
            }
        }
        $sql = "SELECT FK_ID_USUARIO, INTERNO_PERSONA, CODIGO_BARRAS_EAN8, CODIGO_BARRAS_EAN13 
                FROM ASIS_CODIGOS_BARRAS 
                WHERE CODIGO_BARRAS_EAN13 IS NOT NULL " . $cond;
        //pr($sql); exit;
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
    
    /**
     * Consulta los datos de la persona por codigo de barras
     * @author oagarzond
     * @param   Int $idPers     ID de la persona
     * @param   Int $codiBarra  Codigo de barras EAN13
     * @param   Int $codiBarra8 Codigo de barras EAN8
     * @return Array Registros devueltos por la consulta
     */
    public function consultar_codigo_barras($idPers = '', $codiBarra = '', $codiBarra8 = '') {
        $cond = "";
        $data = array();
        if (!empty($idPers)) {
            if (is_int($idPers)) {
                $cond .= " AND ACB.INTERNO_PERSONA = " . $idPers;
            } else if (is_string($idPers)) {
                $cond .= " AND ACB.INTERNO_PERSONA = '" . $idPers . "'";
            } else if (is_array($idPers)) {
                $cond .= " AND ACB.INTERNO_PERSONA IN (" . implode(",", $idPers) . ")";
            }
        }
        if (!empty($codiBarra8)) {
            if (is_int($codiBarra8)) {
                $cond .= " AND ACB.CODIGO_BARRAS_EAN8 = " . $codiBarra8;
            } else if (is_string($codiBarra8)) {
                $cond .= " AND ACB.CODIGO_BARRAS_EAN8 = '" . $codiBarra8 . "'";
            } else if (is_array($codiBarra8)) {
                $cond .= " AND ACB.CODIGO_BARRAS_EAN8 IN (" . implode(",", $codiBarra8) . ")";
            }
        }
        if (!empty($codiBarra)) {
            if (is_int($codiBarra)) {
                $cond .= " AND ACB.CODIGO_BARRAS_EAN13 = " . $codiBarra;
            } else if (is_string($codiBarra)) {
                $cond .= " AND ACB.CODIGO_BARRAS_EAN13 = '" . $codiBarra . "'";
            } else if (is_array($codiBarra)) {
                $cond .= " AND ACB.CODIGO_BARRAS_EAN13 IN (" . implode(",", $codiBarra) . ")";
            }
        }
        $sql = "SELECT F.ID_PERSONA, F.NOMBRES, F.PRIMER_APELLIDO, F.SEGUNDO_APELLIDO, 
            ACB.ID_CODIGO_BARRAS, ACB.FK_ID_USUARIO, ACB.INTERNO_PERSONA, ACB.CODIGO_BARRAS_EAN8, ACB.CODIGO_BARRAS_EAN13 
            FROM ASIS_CODIGOS_BARRAS ACB 
            INNER JOIN RH.VM_INFOFUNCIONARIOS F ON (F.ID_PERSONA = ACB.INTERNO_PERSONA) 
            WHERE ACB.ID_CODIGO_BARRAS IS NOT NULL " . $cond;
        //pr($sql); exit;
        $query = $this->db_asis->query($sql);
        if ($query->num_rows() > 0) {
            $i = 0;
            foreach ($query->result('array') as $row) {
                $data[$i] = $row;
                $data[$i]["nombre"] = $row["NOMBRES"];
                if (strlen($row["PRIMER_APELLIDO"]) > 0) {
                    $data[$i]["nombre"] .= ' ' . trim($row["PRIMER_APELLIDO"]);
                }
                if (strlen($row["SEGUNDO_APELLIDO"]) > 0) {
                    $data[$i]["nombre"] .= ' ' . trim($row["SEGUNDO_APELLIDO"]);
                }
                $i++;
            }
        }
        //pr($data); exit;
        $this->db_asis->close();
        return $data;
    }
    
    /**
     * Consulta los datos de los registros de las asistencias
     * @access Public
     * @author oagarzond
     * @param Array $arrDatos	Arreglo asociativo con los valores para hacer la consulta
     * @return Array Registros devueltos por la consulta
     */
    public function consultar_registros_asistencia($arrDatos) {
        $cond = "";
        $data = array();
        if (array_key_exists("fecha", $arrDatos)) {
            $cond .= " AND COAS_FECHA = '" . $arrDatos["fecha"] . "'";
        }
        if (array_key_exists("anio", $arrDatos)) {
            $cond .= " AND TO_CHAR(COAS_FECHA_REGISTRO, 'YYYY') = '" . $arrDatos["anio"] . "'";
        }
        if (array_key_exists("mes", $arrDatos)) {
            $cond .= " AND TO_CHAR(COAS_FECHA_REGISTRO, 'MM') = '" . $arrDatos["mes"] . "'";
        }
        if (array_key_exists("dia", $arrDatos)) {
            $cond .= " AND TO_CHAR(COAS_FECHA_REGISTRO, 'DD') = '" . $arrDatos["dia"] . "'";
        }
        if (array_key_exists("idPers", $arrDatos)) {
            $cond .= " AND INTERNO_PERSONA = " . $arrDatos["idPers"];
        }
        $sql = "SELECT COAS_FECHA, COAS_HORA_ENTRADA, COAS_HORA_SALIDA 
            FROM ASIS_FORM_CONTROL_ASISTENCIA 
            WHERE ID_ASISTENCIA IS NOT NULL " . $cond . 
            " ORDER BY COAS_FECHA DESC ";
        //pr($sql); exit;
        $query = $this->db_asis->query($sql);
        if ($query->num_rows() > 0) {
            $i = 0;
            foreach ($query->result('array') as $row) {
                $data[$i]["HE"] = $row["COAS_HORA_ENTRADA"];
                $data[$i]["HS"] = $row["COAS_HORA_SALIDA"];
                $i++;
            }
        }
        //pr($data); exit;
        $this->db_asis->close();
        return $data;
    }

    /**
     * Consulta los datos de las dependencias
     * @access Public
     * @author oagarzond
     * @param   Int $codiDepe   Codigo de dependencia
     * @return  Array Registros devueltos por la consulta
     */
    public function consultar_dependencias($codiDepe = '') {
        $cond = "";
        $data = array();
        $sql = "SELECT CODIGO_DEPENDENCIA, DESCRIPCION 
			FROM RH.RH_DEPENDENCIAS 
			WHERE FECHA_HASTA IS NULL 
			ORDER BY DESCRIPCION ASC";
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

    /**
     * Consulta los datos de las dependencias
     * @access Public
     * @author oagarzond
     * @param   Int $codiDepe   Codigo de dependencia
     * @return Array Registros devueltos por la consulta
     */
    public function consultar_grupos_dependencias($codiDepe = '') {
        $data = array();
        $cond = "";

        if (!empty($codiDepe)) {
            if (is_int($codiDepe)) {
                $cond .= " AND SESI_GRUPO.CODIGO_DEPENDENCIA = " . $codiDepe;
            } else if (is_string($codiDepe)) {
                $cond .= " AND SESI_GRUPO.CODIGO_DEPENDENCIA = '" . $codiDepe . "'";
            } else if (is_array($codiDepe)) {
                $cond .= " AND SESI_GRUPO.CODIGO_DEPENDENCIA IN (" . implode(",", $codiDepe) . ")";
            }
        }
        // AND RH.RH_DEPENDENCIAS.CODIGO_COMPANIA = SESI_GRUPO.CODIGO_COMPANIA AND RH.RH_DEPENDENCIAS.FECHA_DESDE = SESI_GRUPO.FECHA_DESDE
        $sql = "SELECT SESI_GRUPO.GRUP_NCDGO, SESI_GRUPO.CODIGO_DEPENDENCIA, SESI_GRUPO.GRUP_CDSCRPCION, SESI_GRUPO.GRUP_CCOORDNDOR, RH.RH_DEPENDENCIAS.DESCRIPCION 
			FROM SESI_GRUPO 
			INNER JOIN RH.RH_DEPENDENCIAS ON (RH.RH_DEPENDENCIAS.CODIGO_DEPENDENCIA = SESI_GRUPO.CODIGO_DEPENDENCIA)  
			WHERE SESI_GRUPO.GRUP_NCDGO IS NOT NULL " . $cond .
                " ORDER BY SESI_GRUPO.CODIGO_DEPENDENCIA, SESI_GRUPO.GRUP_CDSCRPCION";
        //pr($sql); exit;
        $query = $this->db_asis_asis->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result('array') as $row) {
                $data[] = $row;
            }
        }
        //pr($data); exit;
        $this->db_asis_asis->close();
        return $data;
    }

    /**
     * Consulta los datos para el reporte de asistencia
     * @access Public
     * @author oagarzond
     * @param Array $arrDatos	Arreglo asociativo con los valores para hacer la consulta
     * @return Array Registros devueltos por la consulta
     */
    public function buscar_asistencias($arrDatos) {
        $data = array();
        $cond = $cond2 = "";
        
        if (array_key_exists("idPers", $arrDatos)) {
            if (is_int($arrDatos["idPers"])) {
                $cond .= " AND VF.ID_PERSONA = " . $arrDatos["idPers"];
            } else if (is_string($arrDatos["idPers"])) {
                $cond .= " AND VF.ID_PERSONA = '" . $arrDatos["idPers"] . "'";
            } else if (is_array($arrDatos["idPers"])) {
                $cond .= " AND VF.ID_PERSONA IN (" . implode(",", $arrDatos["idPers"]) . ")";
            }
        }
        if (!empty($arrDatos["fechaDesde"])) {
            if (!empty($arrDatos["fechaHasta"])) {
                $cond .= " AND CA.COAS_FECHA BETWEEN '" . $arrDatos["fechaDesde"] . "' AND '" . $arrDatos["fechaHasta"] . "'";
            } else {
                $cond .= " AND CA.COAS_FECHA = '" . $arrDatos["fechaDesde"] . "'";
            }
        } else {
            if (!empty($arrDatos["fechaHasta"])) {
                $cond .= " AND CA.COAS_FECHA = '" . $arrDatos["fechaHasta"] . "'";
            }
        }
        if (array_key_exists("despacho", $arrDatos)) {
            $cond .= " AND VF.COD_DEPEN = '" . $arrDatos ["despacho"] . "'";
        }
        if (array_key_exists("depen", $arrDatos)) {
            $cond .= " AND VF.COD_DEPEN = '" . $arrDatos ["depen"] . "'";
        }
        if (array_key_exists("grupo", $arrDatos)) {
            $cond .= " AND VF.COD_GRUPO = '" . $arrDatos ["grupo"] . "'";
        }
        if (array_key_exists("txtDocu", $arrDatos)) {
            $cond .= " AND VF.NUMERO_IDENTIFICACION = '" . $arrDatos ["txtDocu"] . "'";
        }
        if (array_key_exists("txtNombres", $arrDatos)) {
            $cond .= " AND VF.NOMBRES LIKE '%" . $arrDatos ["txtNombres"] . "%'";
        }

        if (array_key_exists("txtApellidos", $arrDatos)) {
            $cond .= " AND (VF.PRIMER_APELLIDO || ' ' || VF.SEGUNDO_APELLIDO) LIKE '%" . $arrDatos ["txtApellidos"] . "%'";
        }
        
        /*$sql = "SELECT (COAS_CDIA || '/' || COAS_CMES || '/' || COAS_CANO) AS COAS_CFECHA, INTERNO_PERSONA, GRUP_NCDGO, GRUP_CDSCRPCION, GRUP_CCOORDNDOR, 
                TIPO_DOCUMENTO, NUMERO_IDENTIFICACION, NOMBRES, PRIMER_APELLIDO, SEGUNDO_APELLIDO, CODIGO_DEPENDENCIA, DESCRIPCION, FECHA_HASTA,
                NVL(ENTRADA,0), NVL(SALIDA,0) 
                FROM CONTROL_ASISTENCIA.VISTA_C_ASISTENCIA_SEP0415
                WHERE TIPO_DOCUMENTO IS NOT NULL " . $cond .
        " ORDER BY TO_DATE((COAS_CDIA || '/' || COAS_CMES || '/' || COAS_CANO),'DD/MM/YYYY'), INTERNO_PERSONA";*/
        /*$sql = "SELECT Z.ID_PERSONA, Z.NUMERO_IDENTIFICACION, TO_CHAR(TO_DATE(Z.FECHA, 'DD/MM/YYYY'), 'DD/MM/YYYY') FECHA_REGISTRO, Z.NOMBRES, Z.PRIMER_APELLIDO, Z.SEGUNDO_APELLIDO,
                    Z.COD_DEPEN, Z.DESC_DEPEN, Z.COD_GRUPO, Z.DESC_GRUPO, Z.ESTADO, Z.COD_TERRITORIAL, CA.COAS_HORA_ENTRADA, CA.COAS_HORA_SALIDA, 
                    SP.ID_SOLICITUD, SP.FK_ID_TIPO, SP.FECHA_SOLICITUD, SP.FECHA_INI, SP.FECHA_FIN, SP.HORA_INICIO, SP.HORA_FIN 
                FROM (SELECT ID_PERSONA, NUMERO_IDENTIFICACION, COD_DEPENDENCIA, DEPENDENCIA, NOMBRES, PRIMER_APELLIDO, SEGUNDO_APELLIDO, COD_TERRITORIAL, ESTADO, FECHA_INGRESO, FECHA,
                COD_DEPEN, DESC_DEPEN, COD_GRUPO, DESC_GRUPO
                FROM RH.V_INFOFUNCIONARIOS , VISTA_C_ASISTENCIA_CALENDAR) Z 
                LEFT JOIN ASIS_FORM_CONTROL_ASISTENCIA CA ON (CA.INTERNO_PERSONA = Z.ID_PERSONA AND TO_CHAR(CA.COAS_FFCHA_REGISTRO, 'DD/MM/YYYY') = Z.FECHA) 
                LEFT JOIN ASIS_CODIGOS_BARRAS CB ON (CB.INTERNO_PERSONA = Z.ID_PERSONA) 
                LEFT JOIN GH_FORM_SOLICITUD_PERMISO SP ON (SP.FK_ID_USUARIO = CB.FK_ID_USUARIO AND SP.FECHA_INI = Z.FECHA) 
                WHERE TO_DATE(Z.FECHA, 'DD/MM/YY') >= (Z.FECHA_INGRESO) AND Z.ESTADO = 'ACTIVO' AND Z.COD_TERRITORIAL = '1' " . $cond . 
            " ORDER BY TO_DATE(Z.FECHA), Z.ID_PERSONA";*/
        // LEFT JOIN RH.V_INFOFUNCIONARIOS F ON (F.ID_PERSONA = CA.INTERNO_PERSONA) 
        /*$sql = "SELECT DL.FECHA, TO_CHAR(DL.FECHA, 'DY', 'NLS_DATE_LANGUAGE=ENGLISH') DIA_REGISTRO,
                    CA.INTERNO_PERSONA, CA.COAS_HORA_ENTRADA, CA.COAS_HORA_SALIDA, ACB.FK_ID_USUARIO ID_USUARIO, 
                    FH.ID_HORARIO, FH.ENTRADA_L, FH.SALIDA_L, FH.ENTRADA_M, FH.SALIDA_M, FH.ENTRADA_X, FH.SALIDA_X, FH.ENTRADA_J, FH.SALIDA_J, FH.ENTRADA_V, FH.SALIDA_V, FH.ENTRADA_S, FH.SALIDA_S, 
                    VF.NUMERO_IDENTIFICACION, VF.NOMBRES, VF.PRIMER_APELLIDO, VF.SEGUNDO_APELLIDO
                    FROM V_DIAS_LABORALES DL 
                    LEFT JOIN ASIS_FORM_CONTROL_ASISTENCIA CA ON (TO_DATE(DL.FECHA, 'DD/MM/YYYY') = TO_DATE(CA.COAS_FECHA, 'DD/MM/YYYY') 
                        AND CA.INTERNO_PERSONA = ANY (SELECT ID_PERSONA FROM RH.VM_INFOFUNCIONARIOS WHERE 1 = 1 " . $cond2 . ")) 
                    LEFT JOIN ASIS_FORM_HORARIOS FH ON (FH.FECHA_INICIAL <= DL.FECHA AND FH.FECHA_FINAL >= DL.FECHA AND FH.INTERNO_PERSONA = CA.INTERNO_PERSONA) 
                    LEFT JOIN ASIS_CODIGOS_BARRAS ACB ON (ACB.INTERNO_PERSONA = CA.INTERNO_PERSONA) 
                    LEFT JOIN RH.VM_INFOFUNCIONARIOS VF ON (VF.ID_PERSONA = CA.INTERNO_PERSONA) 
                    WHERE DL.FECHA IS NOT NULL " . $cond . 
            " ORDER BY TO_DATE(DL.FECHA, 'DD/MM/YYYY') ASC";*/
        $sql = "SELECT TO_CHAR(CA.COAS_FECHA, 'DD/MM/YYYY') FECHA, TO_CHAR(CA.COAS_FECHA, 'DY', 'NLS_DATE_LANGUAGE=ENGLISH') DIA_REGISTRO,
                    CA.INTERNO_PERSONA, CA.COAS_HORA_ENTRADA, CA.COAS_HORA_SALIDA, COAS_RETARDO_ENTRADA, COAS_RETARDO_SALIDA, ACB.FK_ID_USUARIO ID_USUARIO, 
                    FH.ID_HORARIO, FH.ENTRADA_L, FH.SALIDA_L, FH.ENTRADA_M, FH.SALIDA_M, FH.ENTRADA_X, FH.SALIDA_X, FH.ENTRADA_J, FH.SALIDA_J, FH.ENTRADA_V, FH.SALIDA_V, FH.ENTRADA_S, FH.SALIDA_S, 
                    VF.NUMERO_IDENTIFICACION, VF.NOMBRES, VF.PRIMER_APELLIDO, VF.SEGUNDO_APELLIDO, 
                    SP.ID_SOLICITUD, SP.FK_ID_TIPO, SP.FECHA_INI, SP.FECHA_FIN, SP.HORA_INICIO, SP.HORA_FIN 
                FROM ASIS_FORM_CONTROL_ASISTENCIA CA 
                LEFT JOIN RH.VM_INFOFUNCIONARIOS VF ON(VF.ID_PERSONA = CA.INTERNO_PERSONA) 
                LEFT JOIN ASIS_FORM_HORARIOS FH ON (FH.FECHA_INICIAL <= CA.COAS_FECHA AND FH.FECHA_FINAL >= CA.COAS_FECHA AND FH.INTERNO_PERSONA = CA.INTERNO_PERSONA) 
                LEFT JOIN ASIS_CODIGOS_BARRAS ACB ON (ACB.INTERNO_PERSONA = CA.INTERNO_PERSONA) 
                LEFT JOIN GH_FORM_SOLICITUD_PERMISO SP ON (SP.FECHA_INI <= CA.COAS_FECHA AND SP.FECHA_FIN >= CA.COAS_FECHA AND SP.FK_ID_USUARIO = ACB.FK_ID_USUARIO AND SP.FK_ID_ESTADO = 3) 
                WHERE CA.COAS_FECHA IS NOT NULL " . $cond . 
                " ORDER BY TO_DATE(CA.COAS_FECHA, 'DD/MM/YYYY') ASC";
        //pr($sql); exit;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $i = 0;
            foreach ($query->result('array') as $row) {
                $data[$i]["id"] = $row["INTERNO_PERSONA"];
                $data[$i]["id_usua"] = $row["ID_USUARIO"];
                $data[$i]["fecha"] = $row["FECHA"];
                $data[$i]["nume_docu"] = $row["NUMERO_IDENTIFICACION"];
                $data[$i]["nombres"] = $row["NOMBRES"];
                $data[$i]["apellidos"] = $row["PRIMER_APELLIDO"] . " " . $row["SEGUNDO_APELLIDO"];
                $data[$i]["HE"] = $row["COAS_HORA_ENTRADA"];
                $data[$i]["HS"] = $row["COAS_HORA_SALIDA"];
                $data[$i]["RE"] = $row["COAS_RETARDO_ENTRADA"];
                $data[$i]["RS"] = $row["COAS_RETARDO_SALIDA"];
                $data[$i]["id_horario"] = $row["ID_HORARIO"];
                $data[$i]["hora_entrada"] = '08:00';
                $data[$i]["hora_salida"] = '17:00';
                if(!empty($row["ID_HORARIO"])) {
                    switch ($row["DIA_REGISTRO"]) {
                        case 'MON':
                            $data[$i]["hora_entrada"] = $row["ENTRADA_L"];
                            $data[$i]["hora_salida"] = $row["SALIDA_L"];
                            break;
                        case 'TUE':
                            $data[$i]["hora_entrada"] = $row["ENTRADA_M"];
                            $data[$i]["hora_salida"] = $row["SALIDA_M"];
                            break;
                        case 'WED':
                            $data[$i]["hora_entrada"] = $row["ENTRADA_X"];
                            $data[$i]["hora_salida"] = $row["SALIDA_X"];
                            break;
                        case 'THU':
                            $data[$i]["hora_entrada"] = $row["ENTRADA_J"];
                            $data[$i]["hora_salida"] = $row["SALIDA_J"];
                            break;
                        case 'FRI':
                            $data[$i]["hora_entrada"] = $row["ENTRADA_V"];
                            $data[$i]["hora_salida"] = $row["SALIDA_V"];
                            break;
                        case 'SAT':
                            $data[$i]["hora_entrada"] = $row["ENTRADA_S"];
                            $data[$i]["hora_salida"] = $row["SALIDA_S"];
                            break;
                    }
                }
                $data[$i]["id_sp"] = $data[$i]["id_tipo_sp"] = $data[$i]["fecha_ini_sp"] = '';
                $data[$i]["fecha_fin_sp"] = $data[$i]["hora_ini_sp"] = $data[$i]["hora_fin_sp"] = '';
                if(!empty($row["ID_SOLICITUD"])) {
                    $data[$i]["id_sp"] = $row["ID_SOLICITUD"];
                    $data[$i]["id_tipo_sp"] = $row["FK_ID_TIPO"];
                    $data[$i]["fecha_ini_sp"] = $row["FECHA_INI"];
                    $data[$i]["fecha_fin_sp"] = $row["FECHA_FIN"];
                    $data[$i]["hora_ini_sp"] = $row["HORA_INICIO"];
                    $data[$i]["hora_fin_sp"] = $row["HORA_FIN"];
                }
                $i++;
            }
        }
        //pr($data); exit;
        $this->db->close();
        return $data;
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
        $cond = "";
        
        if (array_key_exists("idPers", $arrDatos)) {
            if (is_int($arrDatos["idPers"])) {
                $cond .= " AND F.ID_PERSONA = " . $arrDatos["idPers"];
            } else if (is_string($arrDatos["idPers"])) {
                $cond .= " AND F.ID_PERSONA = '" . $arrDatos["idPers"] . "'";
            } else if (is_array($arrDatos["idPers"])) {
                $cond .= " AND F.ID_PERSONA IN (" . implode(",", $arrDatos["idPers"]) . ")";
            }
        }
        if (array_key_exists("despacho", $arrDatos)) {
            $cond .= " AND F.COD_DEPEN = '" . $arrDatos ["despacho"] . "'";
        }
        if (array_key_exists("depen", $arrDatos)) {
            $cond .= " AND F.COD_DEPEN = '" . $arrDatos ["depen"] . "'";
        }
        if (array_key_exists("grupo", $arrDatos)) {
            $cond .= " AND F.COD_GRUPO = '" . $arrDatos ["grupo"] . "'";
        }
        if (array_key_exists("txtDocu", $arrDatos)) {
            $cond .= " AND F.NUMERO_IDENTIFICACION = '" . $arrDatos ["txtDocu"] . "'";
        }
        if (array_key_exists("txtNombres", $arrDatos)) {
            $cond .= " AND F.NOMBRES LIKE '%" . $arrDatos ["txtNombres"] . "%'";
        }
        if (array_key_exists("txtApellidos", $arrDatos)) {
            $cond .= " AND (F.PRIMER_APELLIDO || ' ' || F.SEGUNDO_APELLIDO) LIKE '%" . $arrDatos ["txtApellidos"] . "%'";
        }

        $sql = "SELECT F.ID_PERSONA, F.NOMBRES, F.PRIMER_APELLIDO, F.SEGUNDO_APELLIDO, F.NUMERO_IDENTIFICACION, F.CORREO, F.ESTADO 
            FROM RH.VM_INFOFUNCIONARIOS F 
            WHERE F.ID_PERSONA IS NOT NULL AND F.ESTADO = 'ACTIVO' " . $cond . 
            " ORDER BY F.ID_PERSONA DESC";
        //pr($sql); exit;
        $query = $this->db_asis->query($sql);
        if ($query->num_rows() > 0) {
            $i = 0;
            foreach ($query->result('array') as $row) {
                $data[$i]["id"] = $row["ID_PERSONA"];
                $data[$i]["nume_docu"] = $row["NUMERO_IDENTIFICACION"];
                $data[$i]["nombres"] = $row["NOMBRES"];
                $data[$i]["apellidos"] = $row["PRIMER_APELLIDO"] . " " . $row["SEGUNDO_APELLIDO"];
                $data[$i]["nombre"] = $row["NOMBRES"];
                if (strlen($row["PRIMER_APELLIDO"]) > 0) {
                    $data[$i]["nombre"] .= ' ' . trim($row["PRIMER_APELLIDO"]);
                }
                if (strlen($row["SEGUNDO_APELLIDO"]) > 0) {
                    $data[$i]["nombre"] .= ' ' . trim($row["SEGUNDO_APELLIDO"]);
                }
                $data[$i]["email"] = strtolower($row["CORREO"]);
                $data[$i]["usuario"] = '';
                $data[$i]["horario"] = '';
                $arrParam = array(
                    'idPers' => $row["ID_PERSONA"],
                    'fechaRangoHorario' => date('d/m/Y')
                );
                $horario = $this->consultar_horario($arrParam);
                if(count($horario) > 0) {
                    $data[$i]["horario"] = $horario[0]['ID_HORARIO'];
                }
                if(!empty($row["CORREO"])) {
                    $tempUsua = explode('@', $row["CORREO"]);
                    $data[$i]["usuario"] = strtolower($tempUsua[0]);
                }
                $data[$i]["opc"] = '';
                $i++;
            }
        }
        //pr($data); exit;
        $this->db_asis->close();
        return $data;
    }

    /**
     * Busca si la cedula que estan ingresando existe en funcionarios de planta
     * @author alrodriguezm
     * @since 2015-07-07
     */
    public function consultar_usuario($arrDatos) {
        $data = array();
        $cond = '';
        
        if (array_key_exists("interno", $arrDatos)) {
            $cond .= " AND F.ID_PERSONA = '" . $arrDatos ["interno"] . "'";
        }
        if (array_key_exists("numeDocu", $arrDatos)) {
            $cond .= " AND F.NUMERO_IDENTIFICACION = '" . $arrDatos ["numeDocu"] . "'";
        }
        
        $sql = "SELECT * 
            FROM RH.VM_INFOFUNCIONARIOS F 
            INNER JOIN GH_ADMIN_USUARIOS U ON (U.NUM_IDENT = F.NUMERO_IDENTIFICACION) 
            WHERE U.ID_USUARIO IS NOT NULL " . $cond;
        //pr($sql); exit;
        $query = $this->db_asis->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result('array') as $row) {
                $data["idUser"] = $row["ID_USUARIO"];
                $data["idPers"] = $row["NUMERO_IDENTIFICACION"];
                $data["nombre"] = $row["NOMBRES"];
                if(strlen($row["PRIMER_APELLIDO"]) > 0) {
                    $data["nombre"] .= ' ' . trim($row["PRIMER_APELLIDO"]);
                }
                if(strlen($row["SEGUNDO_APELLIDO"]) > 0) {
                    $data["nombre"] .= ' ' . trim($row["SEGUNDO_APELLIDO"]);
                }
            }
        }
        $this->db_asis->close();
        return $data;
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
            $cond .= " AND AH.INTERNO_PERSONA = '" . $arrDatos ["idPers"] . "'";
        }
        if (array_key_exists("idUsua", $arrDatos)) {
            $cond .= " AND AH.FK_ID_USUARIO = '" . $arrDatos ["idUsua"] . "'";
        }
        if (array_key_exists("fechaRangoHorario", $arrDatos) && !empty($arrDatos["fechaRangoPermiso"])) {
            $cond .= " AND (AH.FECHA_INICIAL <= '" . $arrDatos["fechaRangoPermiso"] . "' AND AH.FECHA_FINAL >= '" . $arrDatos["fechaRangoPermiso"] . "')";
        }
        
        $sql = "SELECT AH.FECHA_INICIAL, AH.FECHA_FINAL, AH.FECHA_RESO, AH.* 
            FROM ASIS_FORM_HORARIOS AH 
            WHERE AH.ID_HORARIO IS NOT NULL " . $cond;
        //pr($sql); exit;
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
    
    /**
     * Consulta los ID de la personas en cada tabla ASIS_CODIGOS_BARRAS
     * @access Public
     * @author oagarzond
     */
    public function consultar_id_usuarios_CB() {
        $data = array();
        $cond = '';
        
        // WHERE F.ID_PERSONA = 452
        $sql = "SELECT F.ID_PERSONA, AU.ID_USUARIO, ACB.FK_ID_USUARIO 
            FROM RH.VM_INFOFUNCIONARIOS F 
            INNER JOIN GESTIONH.GH_ADMIN_USUARIOS AU ON (AU.NUM_IDENT = F.NUMERO_IDENTIFICACION) 
            LEFT JOIN GESTIONH.ASIS_CODIGOS_BARRAS ACB ON (ACB.INTERNO_PERSONA = F.ID_PERSONA)";
        //pr($sql); exit;
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
    
    /**
     * Consulta los ID de la personas en cada tabla ASIS_FORM_CONTROL_ASISTENCIA
     * @access Public
     * @author oagarzond
     */
    public function consultar_id_usuarios_CA() {
        $data = array();
        $cond = '';
        
        // WHERE F.ID_PERSONA = 452
        /*$sql = "SELECT F.ID_PERSONA, AU.ID_USUARIO, ACB.FK_ID_USUARIO 
            FROM RH.VM_INFOFUNCIONARIOS F 
            INNER JOIN GESTIONH.GH_ADMIN_USUARIOS AU ON (AU.NUM_IDENT = F.NUMERO_IDENTIFICACION) 
            LEFT JOIN GESTIONH.ASIS_CODIGOS_BARRAS ACB ON (ACB.INTERNO_PERSONA = F.ID_PERSONA)";*/
        
        $sql = "SELECT F.ID_PERSONA, AU.ID_USUARIO, CA.FK_ID_USUARIO 
            FROM RH.VM_INFOFUNCIONARIOS F 
            INNER JOIN GESTIONH.GH_ADMIN_USUARIOS AU ON (AU.NUM_IDENT = F.NUMERO_IDENTIFICACION) 
            LEFT JOIN GESTIONH.ASIS_FORM_CONTROL_ASISTENCIA CA ON (CA.INTERNO_PERSONA = F.ID_PERSONA)";
        //pr($sql); exit;
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
