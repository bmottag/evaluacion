<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Clase para consultas generales a una tabla
 * @author BMOTTAG
 * @since  10/08/2015
 */
class consultas_generales extends CI_Model {

    /**
     * Consulta BASICA A UNA TABLA
     * @param $TABLA: nombre de la tabla
     * @param $ORDEN: orden por el que se quiere organizar los datos
     * @param $COLUMNA: nombre de la columna en la tabla para realizar un filtro (NO ES OBLIGATORIO)
     * @param $VALOR: valor de la columna para realizar un filtro (NO ES OBLIGATORIO)
     * @since 10/08/2015
     */
    public function get_consulta_basica($TABLA, $ORDEN, $COLUMNA = 'x', $VALOR = 'x') {
        if ($VALOR != 'x')
            $this->db->where($COLUMNA, $VALOR);
        $this->db->order_by($ORDEN, "ASC");
        $query = $this->db->get($TABLA);

        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else
            return false;
    }

    /**
     * Lista usuario
     * Modulos: DIRECTORIO; MENU; SOLICITUD PERMISO
     * @param $idUsuario int: id del usuario
     * @since 30/07/2015
     */
    public function get_user_by_id($idUsuario) {
        $this->db->where('ID_USUARIO', $idUsuario);
        $this->db->order_by('NOM_USUARIO', 'asc');
        $query = $this->db->get('GH_ADMIN_USUARIOS');

        if ($query->num_rows() > 0) {
            //$encrypt = $this->danecrypt->encode($passwd);
            foreach ($query->result() as $row) {
                //if (strcmp($row->PAS_USUARIO, $encrypt)===0){
                $user["valid"] = true;
                $user["id"] = $row->ID_USUARIO;
                $user["num_ident"] = $row->NUM_IDENT;
                $user["nom_usuario"] = $row->NOM_USUARIO;
                $user["ape_usuario"] = $row->APE_USUARIO;
                $user["tel_usuario"] = $row->TEL_USUARIO;
                $user["ext_usuario"] = $row->EXT_USUARIO;
                $user["mail_usuario"] = $row->MAIL_USUARIO;
                $user["dep_usuario"] = $row->DEP_USUARIO;
                $user["terr_usuario"] = $row->TERR_USUARIO;
                $user["tipov_usuario"] = $row->TIPOV_USUARIO;
                $user["rol_usuario"] = $row->ROL_USUARIO;
                //}	    			
            }
        }
        $this->db->close();
        return $user;
    }

    /**
     * Lista de usuarios filtrado por tipo de permiso que tiene el usuario en el aplicativo
     * @author BMOTTAG
     * @since 2/9/2015
     * @review 17/09/2015
     */
    public function get_lista_usuarios($idPermiso) {
        $sql = "SELECT * FROM GH_ADMIN_USUARIOS U
                INNER JOIN GH_ADMIN_RELACION_PERMISOS P ON P.FK_ID_USUARIO = U.ID_USUARIO 
                WHERE P.FK_ID_PERMISO = $idPermiso
                ORDER BY U.NOM_usuario";
        $query = $this->db->query($sql);
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else
            return false;
    }

    /**
     * Lista de dependencias
     * @since 15/04/2016
     */
    public function get_dependencias() {
        $deps = array();
        $sql = "SELECT CODIGO_DEPENDENCIA, DESCRIPCION
                FROM GH_PARAM_DEPENDENCIA WHERE ESTADO = 1
                ORDER BY DESCRIPCION";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $i = 0;
            foreach ($query->result() as $row) {
                $deps[$i]["id_dependencia"] = $row->CODIGO_DEPENDENCIA;
                $deps[$i]["nom_dependencia"] = $row->DESCRIPCION;
                $i++;
            }
        }
        $this->db->close();
        return $deps;
    }

    /**
     * Lista de despacho
     * @since 15/04/2016
     */
    public function get_despacho() {
        $deps = array();
        $sql = "SELECT CODIGO_DEPENDENCIA, DESCRIPCION
                FROM GH_PARAM_DEPENDENCIA
                WHERE CODIGO_DEPENDENCIA <= 4 AND ESTADO = 1
                ORDER BY DESCRIPCION";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $i = 0;
            foreach ($query->result() as $row) {
                $deps[$i]["id_dependencia"] = $row->CODIGO_DEPENDENCIA;
                $deps[$i]["nom_dependencia"] = $row->DESCRIPCION;
                $i++;
            }
        }
        $this->db->close();
        return $deps;
    }

    /**
     * Lista de dependencia
     * @since 15/04/2016
     */
    public function get_lista_by_id($filtro) {
        $deps = array();
        $sql = "SELECT CODIGO_DEPENDENCIA, DESCRIPCION
                FROM GH_PARAM_DEPENDENCIA
                WHERE ANTECESOR = '" . $filtro . "' AND CODIGO_DEPENDENCIA > '" . $filtro . "' AND ESTADO = 1
                ORDER BY DESCRIPCION";
        //pr($sql); exit;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $i = 0;
            foreach ($query->result() as $row) {
                $deps[$i]["id_dependencia"] = $row->CODIGO_DEPENDENCIA;
                $deps[$i]["nom_dependencia"] = $row->DESCRIPCION;
                $i++;
            }
        }
        $this->db->close();
        return $deps;
    }

    /**
     * Lista de GRUPOS
     * @review 31/03/2016
     */
    public function get_listaGrupo_by_id($filtro) {
        $deps = array();
        $sql = "SELECT CODIGO_DEPENDENCIA, DESCRIPCION
                FROM GH_PARAM_DEPENDENCIA
                WHERE CODIGO_DEPENDENCIA LIKE '" . $filtro . "%' AND ESTADO = 1
                ORDER BY DESCRIPCION";
        //pr($sql); exit;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $i = 0;
            foreach ($query->result() as $row) {
                $deps[$i]["id_dependencia"] = $row->CODIGO_DEPENDENCIA;
                $deps[$i]["nom_dependencia"] = $row->DESCRIPCION;
                $i++;
            }
        }
        $this->db->close();
        return $deps;
    }

    /**
     * Lista de departamentos
     * @since 20/05/2016
     */
    public function get_departamentos() {
        $deps = array();
        $sql = "SELECT DISTINCT COD_DEPARTAMENTO, NOM_DEPARTAMENTO 
                FROM GH_PARAM_DIVIPOLA 
                ORDER BY NOM_DEPARTAMENTO";
        $query = $this->db->query($sql);
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /**
     * Lista de municipios fistrado por departamento
     * @since 20/05/2016
     */
    public function get_listaMuni_by_id($filtro) {
        $deps = array();
        $sql = "SELECT COD_MUNICIPIO, NOM_MUNICIPIO
                FROM GH_PARAM_DIVIPOLA
                WHERE COD_DEPARTAMENTO = " . $filtro . "
                ORDER BY NOM_MUNICIPIO";
        $query = $this->db->query($sql);
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /**
     * Consulta la fecha y hora actual
     * @access Public
     * @author oagarzond
     * @return  String  Today   Registros devueltos por la consulta
     */
    public function consultar_fecha_hora() {
        $data = array();
        $sql = "SELECT TO_CHAR(SYSDATE , 'DD/MM/YYYY HH24:MI:SS') TODAY FROM DUAL";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result('array') as $row) {
                $data = $row;
            }
        }
        //pr($data); exit;
        $this->db->close();
        return $data["TODAY"];
    }

    /**
     * Consulta las fechas festivos por anio
     * @access Public
     * @author oagarzond
     * @return  Array   $data   Registros devueltos por la consulta
     */
    public function consultar_festivos($anios) {
        $cond = "";
        $data = array();
        if (!empty($anios)) {
            if (is_int($anios)) {
                $cond .= " AND TO_CHAR(FECHA_FESTIVO, 'YYYY') = " . $anios;
            } else if (is_string($anios)) {
                $cond .= " AND TO_CHAR(FECHA_FESTIVO, 'YYYY') = '" . $anios . "'";
            } else if (is_array($anios)) {
                $cond .= " AND TO_CHAR(FECHA_FESTIVO, 'YYYY') IN ('" . implode("','", $anios) . "')";
            }
        }
        $sql = "SELECT TO_CHAR(FECHA_FESTIVO, 'YYYY-MM-DD') FECHA
                FROM RH.RH_CALENDARIO 
                WHERE 1 = 1 " . $cond;
        //pr($sql); exit;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result('array') as $row) {
                $data[] = $row["FECHA"];
            }
        }
        //pr($data); exit;
        $this->db->close();
        return $data;
    }

    /**
     * Lista de jefes para dependencias, filtrado por dependencias activas
     * @since 21/06/2016
     */
    public function get_info_jefes() {
        $cadena_sql = "SELECT D.CODIGO_DEPENDENCIA, D.DESCRIPCION, D.FK_ID_USUARIO, (U.NOM_USUARIO || ' ' || U.APE_USUARIO) AS JEFE, D.CARGO ";
        $cadena_sql.= " FROM GH_PARAM_DEPENDENCIA D";
        $cadena_sql.= " LEFT JOIN GH_ADMIN_USUARIOS U ON U.ID_USUARIO =  D.FK_ID_USUARIO";
		$cadena_sql.= " WHERE D.ESTADO = 1";
		$cadena_sql.= " ORDER BY D.CODIGO_DEPENDENCIA";

        $query = $this->db->query($cadena_sql);

        $result = $query->result();

        return $result;
    }
    
    /**
     * Lista de dependencia y grupo
     * @author oagarzond
     * @since 2016-07-06
     */
    public function get_dependencia_by_id($idDepe) {
        $deps = array();
        $sql = "SELECT CODIGO_DEPENDENCIA, DESCRIPCION 
            FROM GH_PARAM_DEPENDENCIA 
            WHERE ANTECESOR = $idDepe AND ESTADO = 1
            ORDER BY DESCRIPCION";
        //pr($sql); exit;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $i = 0;
            foreach ($query->result() as $row) {
                $deps[$i]["id_dependencia"] = $row->CODIGO_DEPENDENCIA;
                $deps[$i]["nom_dependencia"] = $row->DESCRIPCION;
                $i++;
            }
        }
        $this->db->close();
        return $deps;
    }
	
    /**
     * Lista de dependencias, sin los grupos
     * @since 19/08/2016
     */
    public function get_solo_dependencias() {
        $deps = array();
        $sql = "SELECT CODIGO_DEPENDENCIA, DESCRIPCION
                FROM GH_PARAM_DEPENDENCIA WHERE ESTADO = 1 AND ANTECESOR < 5
                ORDER BY DESCRIPCION";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
}
?> 