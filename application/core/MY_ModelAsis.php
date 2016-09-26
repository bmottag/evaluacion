<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class My_model extends CI_Model {
    
    private $sql;
    private $db_asis;
    protected $exepcion;
    protected $msgError;
    
    public function construct() {
        parent::__construct();
        $this->db_asis = $this->load->database("asis", TRUE);
        $this->sql = 'qwerty';
    }

    /**
     * 
     * @access public
     * @author oagarzond
     * @return  String  Comando de SQL
     */
    public function get_sql() {
        return $this->sql;
    }
    
    /**
     * Metodo que ejecuta todas las sentencias INSERT en la Base de Datos
     * @access public
     * @author oagarzond
     * @param   String  $tabla      Nombre de la tabla   
     * @param   Array   $arrValores Arreglo asociativo con los valores a insertar
     * @return  Bool                dependiendo de si se realizo correctamente la operación o no
     */
    public function ejecutar_insert($tabla, $arrValores) {
        $this->sql = '';
        try {
            $this->sql = "INSERT INTO " . $tabla . " (" . implode(",", array_keys($arrValores)) . ") VALUES (";
            $i = 0;
            foreach ($arrValores as $campo => $valor) {
                $arrExp = array("nextval", "sysdate","to_char", "to_date", "to_timestamp");
                foreach ($arrExp as $ie => $ve) {
                    if (substr_count(strtolower($valor), $ve) > 0) {
                        $this->sql .= $valor;
                        $valor = null;
                        break;
                    }
                }
                if(es_fecha_valida($valor)) {
                    $this->sql .= "TO_DATE('" . $valor . "', 'DD/MM/YYYY')";
                } else if(is_string($valor)) {
                    $this->sql .= "'" . str_replace("'", "''", $valor) . "'";
                } else {
                    $this->sql .= $valor;
                }
                $this->sql .= (count($arrValores) != ($i + 1)) ? ", " : ")";
                $i++;
            }
            //pr($this->sql); exit;
            //return $this->sql . ";";
            $query = $this->db_asis->query($this->sql);
            $this->db_asis->close();
            return $query;
            //return true;
        } catch (PDOException $e) {
            $this->exepcion = $e;
            return false;
        }
    }

    public function ejecutar_update($tabla, $arrValores, $arrWhere) {
        $this->sql = $sql = '';
        try {
            $this->sql = "UPDATE " . $tabla . " SET ";
            if (is_array($arrValores)) {
                foreach ($arrValores as $campo => $valor) {
                    $arrExp = array("nextval", "sysdate","to_char", "to_date", "to_timestamp");
                    foreach ($arrExp as $ie => $ve) {
                        if (substr_count(strtolower($valor), $ve) > 0) {
                            $sql .= $campo . " = " . $valor . ", ";
                            $valor = array('0');
                            break;
                        }
                    }
                    
                    if ($valor == NULL) {
                        $sql .= $campo . " = NULL, ";
                    } else if (is_string($valor) && strtolower($valor) == "null") {
                        $sql .= $campo . " = NULL, ";
                    } else if (is_string($valor)) {
                        $sql .= $campo . " = " . "'" . str_replace("'", "''", $valor) . "', ";
                    } else if (is_int($valor)) {
                        $sql .= $campo . " = " . $valor . ", ";
                    }
                }
                $sql = substr($sql, 0, -2);
            }
            $i = 0;
            if (is_array($arrWhere)) {
                $sql .= " WHERE ";
                foreach ($arrWhere as $campo => $valor) {
                    if ($i != 0) {
                        $sql .= " AND ";
                    }
                    if ($valor == NULL) {
                        $sql .= $campo . " IS NULL";
                    } else if (strtolower($valor) == "null") {
                        $sql .= $campo . " IS NULL";
                    } elseif (is_string($valor)) {
                        $sql .= $campo . " = " . "'" . str_replace("'", "''", $valor) . "'";
                    } else {
                        $sql .= $campo . " = " . $valor;
                    }
                    $i++;
                }
            }
            $this->sql .= $sql;
            //pr($this->sql); exit;
            //return $this->sql . ";";
            $query = $this->db_asis->query($this->sql);
            $this->db_asis->close();
            return $query;
            //return true;
        } catch (PDOException $e) {
            $this->exepcion = $e;
            return false;
        }
    }
    
    /**
     * Consulta la fecha y hora actual
     * @access Public
     * @author oagarzond
     * @return Array Registros devueltos por la consulta
     */
    public function consultar_fecha_hora() {
        $data = array();
        $sql = "SELECT TO_CHAR(SYSDATE , 'DD/MM/YYYY HH24:MI:SS') TODAY FROM DUAL";
        $query = $this->db_asis->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result('array') as $row) {
                $data = $row;
            }
        }
        //pr($data); exit;
        $this->db_asis->close();
        return $data["TODAY"];
    }
    
    /**
     * Metodo que obtiene el ultimo id insertado en la BD en una tabla con campo 
     * serial o autoincremento
     * @author oagarzond
     * @return int|bool Retorna el ultimo id insertado o false dependiendo de si se 
     * realizo correctamente la operacion o no
     */
    public function obtener_ultimo_id($tabla, $id) {
        if ($this->db_asis) {
            $data = array();
            $sql = "SELECT MAX($id) MAXIMO FROM $tabla";
            //pr($sql); exit;
            $query = $this->db_asis->query($sql);
            if ($query->num_rows() > 0) {
                foreach ($query->result('array') as $row) {
                    $data["MAX"] = $row["MAXIMO"];
                }
            }
            return $data["MAX"];
            //return $this->db_asis->insert_id();
        } else {
            $this->msgError = "No hay conexion";
            return false;
        }
    }
}
//EOC