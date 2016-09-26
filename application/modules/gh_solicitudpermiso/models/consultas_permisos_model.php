<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class consultas_permisos_model extends CI_Model {

    /**
     * Lista tipo de solicitud
     * @author BMOTTAG
     * @since 12/12/2013
     * @review 17/09/2015
     */
    public function get_tipo() {
        $query = $this->db->get('GH_PARAM_TIPO_SOLICITUD');
        return $query->result_array();
    }

    /**
     * Lista motivo de solicitud
     * @since 12/12/2013
     * @review 17/09/2015
     */
    public function get_motivo() {
        $this->db->where('NIVEL', 1);
        $this->db->where('ESTADO', 1);
        $query = $this->db->get('GH_PARAM_MOTIVO');
        return $query->result_array();
    }

    /**
     * Lista motivo de solicitud
     * @since 12/12/2013
     * @review 21/09/2015
     */
    public function get_submotivo($idMotivo) {
        $this->db->where('ESTADO', 1);
        $this->db->where('ID_RELACION', $idMotivo);
        $query = $this->db->get('GH_PARAM_MOTIVO');
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else
            return false;
    }

    /**
     * Consulta tipo
     * @review 25/09/2015
     */
    public function get_tipo_permiso($idTipo) {
        $query = $this->db->get_where('GH_PARAM_TIPO_SOLICITUD', array('ID_TIPO' => $idTipo));
        return $query->row_array();
    }

    /**
     * Consulta motivo
     * @review 25/09/2015
     */
    public function get_motivo_permiso($idRelacion) {
        $query = $this->db->get_where('GH_PARAM_MOTIVO', array('ID_MOTIVO' => $idRelacion));
        return $query->row_array();
    }

    /**
     * Lista de solicitudes para un usuario
     * @since 08/01/2014
     * @review 24/09/2015
     */
    public function get_estado_permisos($idUser = 'x', $idPermiso = 'x') {
        $this->db->select('S.*, U.NOM_USUARIO, U.APE_USUARIO, U.MAIL_USUARIO, T.ID_TIPO, T.TIPO, M.MOTIVO, E.DESCRIPCION AS ESTADO ,E.CLASE');
        $this->db->from('GH_FORM_SOLICITUD_PERMISO S');
        $this->db->join('GH_ADMIN_USUARIOS U', 'S.FK_ID_USUARIO = U.ID_USUARIO', 'inner');
        $this->db->join('GH_PARAM_TIPO_SOLICITUD T', 'S.FK_ID_TIPO = T.ID_TIPO', 'inner');
        $this->db->join('GH_PARAM_MOTIVO M', 'S.FK_ID_MOTIVO = M.ID_MOTIVO', 'left');
        $this->db->join('GH_PARAM_ESTADOS_PERMISO E', 'E.ID_ESTADO = S.FK_ID_ESTADO', 'left');
        if ($idUser != 'x') {
            $this->db->where('S.FK_ID_USUARIO', $idUser);
        }
        //si se esta revisando una solicitud especifica
        if ($idPermiso != 'x') {
            $this->db->where('S.ID_SOLICITUD', $idPermiso);
        }
        $this->db->order_by('S.ID_SOLICITUD', 'DESC');
        $query = $this->db->get();

        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else
            return false;
    }

    /**
     * Consulta nombre de documentos anexos por usuario
     * @since 24/01/2014
     * @review 24/09/2015
     */
    public function get_nombre_documento($idPermiso) {
        $this->db->where('FK_ID_SOLICITUD', $idPermiso);
        $query = $this->db->get('GH_DOCUMENTOS_PERMISO');
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else
            return false;
    }

    /**
     * Lista de permisos por encargado
     * para administracion
     * @since 23/01/2014
     * @review 28/09/2015
     */
    public function get_permisos_encargado($idPermiso = 'x') {
        $this->db->select('S.*, U.NOM_USUARIO, U.APE_USUARIO, U.MAIL_USUARIO, T.ID_TIPO, T.TIPO, M.MOTIVO, E.DESCRIPCION AS ESTADO ,E.CLASE');
        $this->db->from('GH_FORM_SOLICITUD_PERMISO S');
        $this->db->join('GH_ADMIN_USUARIOS U', 'S.FK_ID_USUARIO = U.ID_USUARIO', 'inner');
        $this->db->join('GH_PARAM_TIPO_SOLICITUD T', 'S.FK_ID_TIPO = T.ID_TIPO', 'inner');
        $this->db->join('GH_PARAM_MOTIVO M', 'S.FK_ID_MOTIVO = M.ID_MOTIVO', 'left');
        $this->db->join('GH_PARAM_ESTADOS_PERMISO E', 'E.ID_ESTADO = S.FK_ID_ESTADO', 'left');
        $this->db->where('S.FK_ID_ENCARGADO', $this->session->userdata("id"));
        $estados = array(1, 4); //Estado: NUEVA SOLICITUD & AVALADA
        $this->db->where_in('S.FK_ID_ESTADO', $estados);
        //si se esta revisando una solicitud especifica
        if ($idPermiso != 'x') {
            $this->db->where('S.ID_SOLICITUD', $idPermiso);
        }
        $this->db->order_by("S.ID_SOLICITUD", "DESC");
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            return $query->result_array();
        } else
            return false;
    }

    /**
     * Lista de permisos por idPermiso
     * @since 25/01/2014
     * @review 28/09/2015
     */
    public function get_permisos_idpermiso($idPermiso) {
        $this->db->select('S.*, U.NOM_USUARIO, U.APE_USUARIO, U.MAIL_USUARIO, T.ID_TIPO, T.TIPO, M.MOTIVO, M.NIVEL, M.ID_RELACION, E.DESCRIPCION AS ESTADO ,E.CLASE');
        $this->db->from('GH_FORM_SOLICITUD_PERMISO S');
        $this->db->join('GH_ADMIN_USUARIOS U', 'S.FK_ID_USUARIO = U.ID_USUARIO', 'inner');
        $this->db->join('GH_PARAM_TIPO_SOLICITUD T', 'S.FK_ID_TIPO = T.ID_TIPO', 'inner');
        $this->db->join('GH_PARAM_MOTIVO M', 'S.FK_ID_MOTIVO = M.ID_MOTIVO', 'left');
        $this->db->join('GH_PARAM_ESTADOS_PERMISO E', 'E.ID_ESTADO = S.FK_ID_ESTADO', 'left');
        $this->db->where('S.ID_SOLICITUD', $idPermiso);
        $query = $this->db->get();
        return $query->row_array();
    }

    /**
     * Lista de los cambios de un permiso especifico
     * @since 12/12/2013
     * @review 17/09/2015
     */
    public function get_proceso_by_id($idPermiso) {
        $this->db->select('P.FECHA, P.OBSERVACIONES, U.NOM_USUARIO, U.APE_USUARIO, E.DESCRIPCION AS ESTADO, E.CLASE');
        $this->db->from('GH_HISTORIAL_PROCESO_SOLICITUD P');
        $this->db->join('GH_ADMIN_USUARIOS U', 'U.ID_USUARIO = P.FK_ID_ADMIN', 'left');
        $this->db->join('GH_PARAM_ESTADOS_PERMISO E', 'E.ID_ESTADO = P.FK_ID_ESTADO', 'left');
        $this->db->where('P.FK_ID_SOLICITUD', $idPermiso);
        $this->db->order_by('P.FECHA', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            return $query->result_array();
        } else
            return false;
    }

    /**
     * Realiza el conteo de registros de permisos por usuario
     * @since 29/09/2015
     */
    public function conteoRegistrosUsuario($idUser) {
        $conteo = 0;

        $sql = "SELECT COUNT(*) AS CONTEO FROM GH_FORM_SOLICITUD_PERMISO 
				WHERE FK_ID_USUARIO = " . $idUser;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $conteo = $row->CONTEO;
            }
        }
        return $conteo;
    }

    /**
     * Realiza el conteo de registros de permisos por jefe
     * @since 29/09/2015
     */
    public function conteoRegistrosEncargado($idJefe) {
        $conteo = 0;

        $sql = "SELECT COUNT(*) AS CONTEO FROM GH_FORM_SOLICITUD_PERMISO 
				WHERE FK_ID_JEFE = " . $idJefe;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $conteo = $row->CONTEO;
            }
        }
        return $conteo;
    }

    /**
     * Realiza el conteo de registros de permisos
     * @since 29/09/2015
     */
    public function conteoRegistros() {
        $conteo = 0;

        $sql = "SELECT COUNT(*) AS CONTEO FROM GH_FORM_SOLICITUD_PERMISO";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $conteo = $row->CONTEO;
            }
        }
        return $conteo;
    }

    /**
     * Consulta las solicitudes de permisos
     * @access Public
     * @author oagarzond
     * @param Array $arrDatos	Arreglo asociativo con los valores para hacer la consulta
     * @return Array Registros devueltos por la consulta
     */
    public function consultar_solicitudes_permiso($arrDatos) {
        $cond = "";
        $data = array();
        if (array_key_exists("idPermiso", $arrDatos)) {
            if (is_int($arrDatos["idPermiso"])) {
                $cond .= " AND SP.ID_SOLICITUD = " . $arrDatos["idPermiso"];
            } else if (is_string($arrDatos["idPermiso"])) {
                $cond .= " AND SP.ID_SOLICITUD = '" . $arrDatos["idPermiso"] . "'";
            } else if (is_array($arrDatos["idPermiso"])) {
                $cond .= " AND SP.ID_SOLICITUD IN (" . implode(",", $arrDatos["idPermiso"]) . ")";
            }
        }
        if (array_key_exists("idPers", $arrDatos)) {
            if (is_int($arrDatos["idPers"])) {
                $cond .= " AND SP.FK_ID_USUARIO = " . $arrDatos["idPers"];
            } else if (is_string($arrDatos["idPers"])) {
                $cond .= " AND SP.FK_ID_USUARIO = '" . $arrDatos["idPers"] . "'";
            } else if (is_array($arrDatos["idPers"])) {
                $cond .= " AND SP.FK_ID_USUARIO IN (7043," . implode(",", $arrDatos["idPers"]) . ")";
            }
        }
        if (array_key_exists("idEstado", $arrDatos)) {
            if (is_int($arrDatos["idEstado"])) {
                $cond .= " AND SP.FK_ID_ESTADO = " . $arrDatos["idEstado"];
            } else if (is_string($arrDatos["idEstado"])) {
                $cond .= " AND SP.FK_ID_ESTADO = '" . $arrDatos["idEstado"] . "'";
            } else if (is_array($arrDatos["idEstado"])) {
                $cond .= " AND SP.FK_ID_ESTADO IN (" . implode(",", $arrDatos["idEstado"]) . ")";
            }
        }
        if (array_key_exists("fechaIniDesde", $arrDatos) && !empty($arrDatos["fechaSoliDesde"])) {
            if (array_key_exists("fechaSoliHasta", $arrDatos) && !empty($arrDatos["fechaSoliHasta"])) {
                $cond .=" AND SP.FECHA_SOLICITUD BETWEEN '" . $arrDatos["fechaSoliDesde"] . "' AND '" . $arrDatos["fechaSoliHasta"] . "'";
            } else {
                $cond .= " AND SP.FECHA_SOLICITUD = '" . $arrDatos["fechaSoliDesde"] . "'";
            }
        } else {
            if (array_key_exists("fechaSoliHasta", $arrDatos) && !empty($arrDatos["fechaSoliHasta"])) {
                $cond .= " AND SP.FECHA_SOLICITUD = '" . $arrDatos["fechaSoliHasta"] . "'";
            }
        }
        if (array_key_exists("fechaIniDesde", $arrDatos) && !empty($arrDatos["fechaIniDesde"])) {
            if (array_key_exists("fechaIniHasta", $arrDatos) && !empty($arrDatos["fechaIniHasta"])) {
                $cond .=" AND SP.FECHA_INI BETWEEN '" . $arrDatos["fechaIniDesde"] . "' AND '" . $arrDatos["fechaIniHasta"] . "'";
            } else {
                $cond .= " AND SP.FECHA_INI = '" . $arrDatos["fechaIniDesde"] . "'";
            }
        } else {
            if (array_key_exists("fechaIniHasta", $arrDatos) && !empty($arrDatos["fechaIniHasta"])) {
                $cond .= " AND SP.FECHA_INI = '" . $arrDatos["fechaIniHasta"] . "'";
            }
        }
        if (array_key_exists("fechaRangoPermiso", $arrDatos) && !empty($arrDatos["fechaRangoPermiso"])) {
            $cond .= " AND (TO_CHAR(SP.FECHA_INI, 'DD/MM/YYYY') <= '" . $arrDatos["fechaRangoPermiso"] . "' AND TO_CHAR(SP.FECHA_FIN, 'DD/MM/YYYY') >= '" . $arrDatos["fechaRangoPermiso"] . "')";
        }
        $sql = "SELECT AUSU.NUM_IDENT, TO_CHAR(SP.FECHA_INI, 'DD/MM/YYYY') FECHA_INICIAL, TO_CHAR(SP.FECHA_FIN, 'DD/MM/YYYY') FECHA_FINAL, SP.* 
            FROM GH_FORM_SOLICITUD_PERMISO SP 
            INNER JOIN GH_ADMIN_USUARIOS AUSU ON (AUSU.ID_USUARIO = SP.FK_ID_USUARIO) 
            WHERE SP.ID_SOLICITUD IS NOT NULL " . $cond .
            " ORDER BY SP.ID_SOLICITUD DESC";
        //pr($sql); exit;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $i = 0;
            foreach ($query->result('array') as $row) {
                $data[] = $row;
            }
        }
        //pr($data); exit;
        $this->db->close();
        return $data;
    }

    /**
     * Consulta permisos usuario para el paginador
     * @since 29/09/2015
     * @author BMOTTAG
     */
    public function get_permisos_usuario($desde, $hasta) {
        $idUser = $this->session->userdata("id");
        $SQL = "SELECT * FROM
                    ( SELECT A.*, ROWNUM rnum 
                        FROM (	SELECT S.*, U.NOM_USUARIO, U.APE_USUARIO, U.MAIL_USUARIO, T.ID_TIPO, T.TIPO, M.MOTIVO, M.NIVEL, M.ID_RELACION, E.DESCRIPCION AS ESTADO, E.CLASE 
                            FROM GH_FORM_SOLICITUD_PERMISO S 
                            INNER JOIN GH_ADMIN_USUARIOS U ON S.FK_ID_USUARIO = U.ID_USUARIO 
                            INNER JOIN GH_PARAM_TIPO_SOLICITUD T ON S.FK_ID_TIPO = T.ID_TIPO 
                            LEFT JOIN GH_PARAM_MOTIVO M ON S.FK_ID_MOTIVO = M.ID_MOTIVO 
                            LEFT JOIN GH_PARAM_ESTADOS_PERMISO E ON E.ID_ESTADO = S.FK_ID_ESTADO 
                            WHERE S.FK_ID_USUARIO = " . $idUser . "
                            ORDER BY S.ID_SOLICITUD DESC ) A 
                        WHERE ROWNUM <= " . $hasta . " ) 
                    WHERE rnum  >= " . $desde;
        $query = $this->db->query($SQL);

        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else
            return false;
    }

    /**
     * Lista de permisos para consultar
     * para administracion
     * @since 23/01/2014
     * @review 28/09/2015
     */
    public function get_permisos_consulta($bandera, $idPermiso = 'x', $idTipo = 'x') {
        $this->db->select('S.*, U.NOM_USUARIO, U.APE_USUARIO, U.MAIL_USUARIO, T.ID_TIPO, T.TIPO, M.MOTIVO, E.DESCRIPCION AS ESTADO ,E.CLASE');
        $this->db->from('GH_FORM_SOLICITUD_PERMISO S');
        $this->db->join('GH_ADMIN_USUARIOS U', 'S.FK_ID_USUARIO = U.ID_USUARIO', 'inner');
        $this->db->join('GH_PARAM_TIPO_SOLICITUD T', 'S.FK_ID_TIPO = T.ID_TIPO', 'inner');
        $this->db->join('GH_PARAM_MOTIVO M', 'S.FK_ID_MOTIVO = M.ID_MOTIVO', 'left');
        $this->db->join('GH_PARAM_ESTADOS_PERMISO E', 'E.ID_ESTADO = S.FK_ID_ESTADO', 'left');
        //El jefe esta revisando las solicitudes
        if ($bandera == 'j') {
            $this->db->where('S.FK_ID_JEFE', $this->session->userdata("id"));
        }
        if ($idTipo != 'x') {
            $this->db->where('S.FK_ID_TIPO', $idTipo);
        }
        //si se esta revisando una solicitud especifica
        if ($idPermiso != 'x') {
            $this->db->where('S.ID_SOLICITUD', $idPermiso);
        }
        $this->db->order_by("S.ID_SOLICITUD", "DESC");
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            return $query->result_array();
        } else
            return false;
    }

    /**
     * Consulta permisos usuario por JEFE para el paginador
     * @since 29/09/2015
     * @author BMOTTAG
     */
    public function get_permisos_usuario_byencargado($desde, $hasta, $bandera) {
        $filtro = '';
        if ($bandera == 'j')//consulta por un jefe especifico
            $filtro = "WHERE S.FK_ID_JEFE = " . $this->session->userdata("id");

        $SQL = "SELECT * FROM
                    ( SELECT A.*, ROWNUM rnum 
                        FROM (	SELECT S.*, U.NOM_USUARIO, U.APE_USUARIO, U.MAIL_USUARIO, T.ID_TIPO, T.TIPO, M.MOTIVO, M.NIVEL, M.ID_RELACION, E.DESCRIPCION AS ESTADO, E.CLASE 
                            FROM GH_FORM_SOLICITUD_PERMISO S 
                            INNER JOIN GH_ADMIN_USUARIOS U ON S.FK_ID_USUARIO = U.ID_USUARIO 
                            INNER JOIN GH_PARAM_TIPO_SOLICITUD T ON S.FK_ID_TIPO = T.ID_TIPO 
                            LEFT JOIN GH_PARAM_MOTIVO M ON S.FK_ID_MOTIVO = M.ID_MOTIVO 
                            LEFT JOIN GH_PARAM_ESTADOS_PERMISO E ON E.ID_ESTADO = S.FK_ID_ESTADO 
                            " . $filtro . "
                            ORDER BY S.ID_SOLICITUD DESC ) A 
                        WHERE ROWNUM <= " . $hasta . " ) 
                    WHERE rnum  >= " . $desde;
        $query = $this->db->query($SQL);

        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else
            return false;
    }

    /**
     * Lista de la cantidad de solicitudes por usuario
     * @since 20/02/2014
     * @review 2/10/2015
     * @param int $idUser
     * @param date $desde
     * @param date $hasta
     * @param int $idDependencia
     * @return array
     */
    public function get_solicitudes_historico($arrDatos) {
        $cond = "";
        $data = array();
        if (!empty($arrDatos["fecha_ini"])) {
            if (!empty($arrDatos["fecha_fin"])) {
                $cond .= " AND TO_CHAR(S.FECHA_SOLICITUD, 'DD/MM/YYYY') BETWEEN '" . $arrDatos["fecha_ini"] . "' AND '" . $arrDatos["fecha_fin"] . "'";
            } else {
                $cond .= " AND TO_CHAR(S.FECHA_SOLICITUD, 'DD/MM/YYYY') = '" . $arrDatos["fecha_ini"] . "'";
            }
        } else {
            if (!empty($arrDatos["fecha_fin"])) {
                $cond .= " AND TO_CHAR(S.FECHA_SOLICITUD, 'DD/MM/YYYY') = '" . $arrDatos["fecha_fin"] . "'";
            }
        }
        if (array_key_exists("tipoPermiso", $arrDatos)) {
            $cond .= " AND S.FK_ID_TIPO = " . $arrDatos["tipoPermiso"];
        }
        if (array_key_exists("motivo", $arrDatos)) {
            $cond .= " AND S.FK_ID_MOTIVO = " . $arrDatos["motivo"];
        }
        if (array_key_exists("despacho", $arrDatos)) {
            $cond .= " AND S.FK_ID_MOTIVO = " . $arrDatos["despacho"];
        }
        if (array_key_exists("dependencia", $arrDatos)) {
            $cond .= " AND U.DEP_USUARIO = " . $arrDatos["dependencia"];
        }
        if (array_key_exists("grupo", $arrDatos)) {
            $cond .= " AND S.FK_ID_MOTIVO = " . $arrDatos["grupo"];
        }        
        if ($this->input->post('agrupado') == 1) {
            $sql = "SELECT V.NUMERO_IDENTIFICACION, U.NOM_USUARIO, U.APE_USUARIO, V.DEPENDENCIA, COUNT(S.FK_ID_USUARIO) CUENTA 
                FROM GH_FORM_SOLICITUD_PERMISO S 
                INNER JOIN GH_ADMIN_USUARIOS U ON (S.FK_ID_USUARIO = U.ID_USUARIO) 
                INNER JOIN RH.V_INFOFUNCIONARIOS V ON (V.NUMERO_IDENTIFICACION = U.NUM_IDENT) 
                WHERE S.FK_ID_ESTADO = 3  " . $cond . 
                " GROUP BY S.FK_ID_USUARIO ORDER BY CUENTA DESC";
        }
        else {
            $sql = "SELECT S.*, V.NUMERO_IDENTIFICACION, U.NOM_USUARIO, U.APE_USUARIO, U.MAIL_USUARIO, V.DEPENDENCIA, T.TIPO, M.MOTIVO, 
                MM.MOTIVO SUBMOTIVO, E.DESCRIPCION AS ESTADO, E.CLASE 
                FROM GH_FORM_SOLICITUD_PERMISO S 
                INNER JOIN GH_ADMIN_USUARIOS U ON (S.FK_ID_USUARIO = U.ID_USUARIO) 
                INNER JOIN RH.V_INFOFUNCIONARIOS V ON (V.NUMERO_IDENTIFICACION = U.NUM_IDENT) 
                INNER JOIN GH_PARAM_TIPO_SOLICITUD T ON (S.FK_ID_TIPO = T.ID_TIPO) 
                LEFT JOIN GH_PARAM_MOTIVO M ON (S.FK_ID_MOTIVO = M.ID_MOTIVO) 
                LEFT JOIN GH_PARAM_MOTIVO MM ON (S.FK_ID_SUBMOTIVO = MM.ID_MOTIVO) 
                LEFT JOIN GH_PARAM_ESTADOS_PERMISO E ON (E.ID_ESTADO = S.FK_ID_ESTADO) 
                WHERE S.FK_ID_USUARIO IS NOT NULL " . $cond . 
                " ORDER BY U.NOM_USUARIO, U.APE_USUARIO";
        }
        //pr($sql); exit;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result('array') as $row) {
                $data[] = $row;
            }
        }
        //pr($data); exit;
        $this->db->close();
        return $data;
    }

    /**
     * Conteo de permisos por tipo
     * @author BMOTTAG
     * @since 6/10/2015
     */
    public function conteoRegistrosTipo($fechaInicio, $fechaFin) {
        $filtro = '';
        if ($idTipo = $this->input->post('tipoPermiso'))
            $filtro.= "AND S.FK_ID_TIPO = '$idTipo'";
        if ($idMotivo = $this->input->post('motivo'))
            $filtro.= "AND S.FK_ID_MOTIVO = '$idMotivo'";
        if ($idDependencia = $this->input->post('dependencia'))
            $filtro.= "AND U.DEP_USUARIO = '$idDependencia'";

        $sql = "SELECT T.TIPO, COUNT(*) CONTEO
				FROM GH_FORM_SOLICITUD_PERMISO S
				INNER JOIN GH_ADMIN_USUARIOS U ON S.FK_ID_USUARIO = U.ID_USUARIO
				INNER JOIN GH_PARAM_TIPO_SOLICITUD T ON S.FK_ID_TIPO = T.ID_TIPO 
				WHERE FECHA_SOLICITUD BETWEEN '$fechaInicio' AND '$fechaFin'
				$filtro
				GROUP BY T.TIPO";
        $query = $this->db->query($sql);
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else
            return false;
    }

    /**
     * Conteo de permisos por motivo
     * @author BMOTTAG
     * @since 6/10/2015
     */
    public function conteoRegistrosMotivo($fechaInicio, $fechaFin) {

        $filtro = '';
        if ($idTipo = $this->input->post('tipoPermiso'))
            $filtro.= "AND S.FK_ID_TIPO = '$idTipo'";
        if ($idMotivo = $this->input->post('motivo'))
            $filtro.= "AND S.FK_ID_MOTIVO = '$idMotivo'";
        if ($idDependencia = $this->input->post('dependencia'))
            $filtro.= "AND U.DEP_USUARIO = '$idDependencia'";


        $sql = "SELECT M.MOTIVO, COUNT(*) CONTEO
				FROM GH_FORM_SOLICITUD_PERMISO S 
				INNER JOIN GH_ADMIN_USUARIOS U ON S.FK_ID_USUARIO = U.ID_USUARIO
				LEFT JOIN GH_PARAM_MOTIVO M ON S.FK_ID_MOTIVO = M.ID_MOTIVO 
				WHERE FECHA_SOLICITUD BETWEEN '$fechaInicio' AND '$fechaFin'
				$filtro
				GROUP BY M.MOTIVO";
        $query = $this->db->query($sql);
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else
            return false;
    }
}
?>