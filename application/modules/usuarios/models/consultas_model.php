<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class consultas_model extends CI_Model {
    
    public function consultar_personas($arrDatos) {
            $data = array();
            $filtro = "";
            $filtroDependencia = "";

            if (array_key_exists("tipoDesp", $arrDatos)) {
                $filtroDependencia .= " AND DEP_USUARIO LIKE '" . $arrDatos ["tipoDesp"] . "'";
            }
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
            if (array_key_exists("txtPolitica", $arrDatos)) {
                if($arrDatos ["txtPolitica"] == '1') {
                    $filtro .= " AND POLITICA = '" . $arrDatos ["txtPolitica"] . "'";
                } else {
                    $filtro .= " AND POLITICA IS NULL";
                }
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
                    $data[$i]["consulta"] = '';
                    if ($row["POLITICA"] == 1) {
                        $data[$i]["politica"] = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span></a>';
                        $data[$i]["consulta"] = '<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>';
                    } else {
                        $data[$i]["politica"] = '<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span></a>';
                    }
                    $i++;
                }
            }
            //pr($data); exit;
            $this->db->close();
            return $data;
        }
}