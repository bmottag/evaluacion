<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class permisos_model extends My_model {

    /**
     * Ingresa nueva solicitud de permisos en la base de datos
     * @since 17/12/2013
     * @review 21/09/2015
     */
    public function add_solicitud() {
        $this->load->model("fecha_hora");
        $postt = $this->input->post();
        if (!empty($postt) && count($postt) > 0) {
            foreach ($postt as $nombre_campo => $valor) {
                if (!is_array($postt[$nombre_campo])) {
                    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
                    eval($asignacion);
                }
            }
        }
        
        $idUsuario = $this->session->userdata("id");
        $fechaAct = $this->fecha_hora->fechaActualOracle('f');
        // oagarzond- Para el reporte de asistencia es necesario que se guarde la fecha de inicio y fin - 2016-06-17
        if(isset($fechaPermiso) && !empty($fechaPermiso)) {
            $fechaIni = (!empty($fechaIni)) ? $fechaIni: $fechaPermiso;
            $fechaFin = (!empty($fechaFin)) ? $fechaFin: $fechaPermiso;
        }
        if(empty($fechaFin) && !empty($fechaIni)) {
            $fechaFin = $fechaIni;
        }
        switch ($tipoPermiso) {
            case 4:/* Tres dias */
                $estadoProceso = 2;
                break;
            case 5:/* Estudio o docencia */
                $motivo = $tipoPermiso;
                $estadoProceso = 1;
                break;
            default:
                $estadoProceso = 1;
                break;
        }
               
        /*$sql = "INSERT INTO GH_FORM_SOLICITUD_PERMISO (ID_SOLICITUD, FK_ID_USUARIO, FECHA_SOLICITUD, FK_ID_TIPO, FK_ID_JEFE, FK_ID_DIRECTOR, FK_ID_ENCARGADO, FK_ID_MOTIVO, OTRO_MOTIVO, FECHA_PERMISO, HORA_INICIO, HORA_FIN, FECHA_INI, FECHA_FIN, TIEMPO_COMPENSAR, ESTADO_PROCESO, DESCRIPCION, FK_ID_ESTADO, FK_ID_SUBMOTIVO) 
				VALUES (SEQ_FORM_SOLICITUD_PERMISO.NEXTVAL, $idUsuario, '$fechaAct', $tipoPermiso, '$idJefe', '$idDirector', '$idJefe', $motivo, '$otroMotivo', '$fechaPermiso', '$horaInicio', '$horaFin', '$fechaIni', '$fechaFin', '$tiempoCompensar', $estadoProceso, '$descripcion', 1, '$submotivo' )";
        //Inserto solicitud
        $query = $this->db->query($sql);*/
        //if ($query) {
        $arrDatosSP = array(
            'ID_SOLICITUD' => 'SEQ_FORM_SOLICITUD_PERMISO.NEXTVAL',
            'FK_ID_USUARIO' => $idUsuario,
            'FECHA_SOLICITUD' => $fechaAct,
            'FK_ID_TIPO' => $tipoPermiso,
            'FK_ID_JEFE' => "$jefe",
            'FK_ID_ENCARGADO' => "$jefe",
            'FK_ID_MOTIVO' => $motivo,
            'FECHA_INI' => $fechaIni,
            'FECHA_FIN' => $fechaFin,
            'ESTADO_PROCESO' => $estadoProceso,
            'FK_ID_ESTADO' => 1
        );
        if(isset($idsubmotivo) && !empty($idsubmotivo)) {
            $arrDatosSP['FK_ID_SUBMOTIVO'] = $idsubmotivo;
        }
        if(isset($director) && !empty($director)) {
            $arrDatosSP['FK_ID_DIRECTOR'] = $director;
        }
        if(isset($otro) && !empty($otro)) {
            $arrDatosSP['OTRO_MOTIVO'] = $otro;
        }
        if(isset($hora_ini) && !empty($hora_ini)) {
            $arrDatosSP['HORA_INICIO'] = $hora_ini;
        }
        if(isset($hora_fin) && !empty($hora_fin)) {
            $arrDatosSP['HORA_FIN'] = $hora_fin;
        }
        if(isset($tiempoCompensar) && !empty($tiempoCompensar)) {
            $arrDatosSP['TIEMPO_COMPENSAR'] = $tiempoCompensar;
        }
        if(isset($descripcion) && !empty($descripcion)) {
            $arrDatosSP['DESCRIPCION'] = $descripcion;
        }
        
        if($this->ejecutar_insert('GH_FORM_SOLICITUD_PERMISO', $arrDatosSP)) {
            $fechaAct = $this->fecha_hora->fechaActualOracle('h');
            $sql = 'SELECT MAX(ID_SOLICITUD) "MAX" FROM GH_FORM_SOLICITUD_PERMISO';
            $query = $this->db->query($sql);
            $row = $query->row();
            $idRegistro = $row->MAX;

            $data = array(
                'FK_ID_SOLICITUD' => $idRegistro,
                'FECHA' => $fechaAct,
                'FK_ID_ADMIN' => $this->session->userdata("id"),
                'FK_ID_ESTADO' => 1
            );
            //Inserto estado de la solicitud
            $query = $this->db->insert('GH_HISTORIAL_PROCESO_SOLICITUD', $data);

            if ($query) {
                return $idRegistro;
            } else {
                $this->db->delete('GH_FORM_SOLICITUD_PERMISO', array('ID_SOLICITUD' => $idRegistro));
            }
        } else
            return false;
    }

    /**
     * Ingresa documentos para Estudio o docencia
     * @since 22/01/2014
     * @review 23/09/2015
     */
    public function guardar_documentos($idRegistro, $archivo) {
        $data = array(
            'FK_ID_SOLICITUD' => $idRegistro,
            'NOMBRE_DOCUMENTO' => $archivo
        );
        $sql = "INSERT INTO GH_DOCUMENTOS_PERMISO (ID_DOCUMENTO, FK_ID_SOLICITUD, NOMBRE_DOCUMENTO) 
				VALUES (SEQ_FORM_DOCUMENTO.NEXTVAL, $idRegistro, '$archivo' )";

        $query = $this->db->query($sql);
        if ($query) {
            return true;
        } else
            return false;
    }

    /**
     * Actualizar estado del permiso
     * @since 25/01/2014
     * @review 25/09/2015
     */
    public function update_estado_permiso() {
        $data = array(
            'FK_ID_ESTADO' => $this->input->post('estado')
        );
        $this->db->where('ID_SOLICITUD', $this->input->post('idSolicitud'));
        /* Actualizo estado */
        $query = $this->db->update('GH_FORM_SOLICITUD_PERMISO', $data);

        if ($query) {
            $this->load->model("fecha_hora");
            $fechaAct = $this->fecha_hora->fechaActualOracle('h');

            $data = array(
                'FK_ID_SOLICITUD' => $this->input->post('idSolicitud'),
                'FECHA' => $fechaAct,
                'FK_ID_ADMIN' => $this->session->userdata("id"),
                'FK_ID_ESTADO' => $this->input->post('estado'),
                'OBSERVACIONES' => $this->input->post('observaciones'),
            );
            //Guardo historial del cambio
            $query = $this->db->insert('GH_HISTORIAL_PROCESO_SOLICITUD', $data);

            if ($query) {
                return true;
            } else
                return false;
        } else
            return false;
    }

    /**
     * Actualizar el encargado de la solicitud cuando pasa a AVALADA
     * @since 5/02/2014
     * @review 28/09/2015
     */
    public function update_encargado() {
        $estado_porceso = $this->input->post('estado_proceso') - 1;
        $data = array(
            'FK_ID_ENCARGADO' => $this->input->post('director'),
            'ESTADO_PROCESO' => $estado_porceso
        );
        $this->db->where('ID_SOLICITUD', $this->input->post('idSolicitud'));
        $query = $this->db->update('GH_FORM_SOLICITUD_PERMISO', $data);
        if ($query) {
            return true;
        } else
            return false;
    }

    /*     * ******************** CODIGO ANTERIOR ****************************** */

    /**
     * Lista de permisos para generar reporte
     * @since 14/02/2014
     */
    public function get_permisos_reporte($idTipo = 'x', $idEstado = 'x', $fecha_permiso = 'x') {
        $this->db->select('s.*, u.completo, u.correo, d.dependencia, t.tipo, m.motivo, m.nivel, m.idrelacion, e.descripcion estado, e.class');
        $this->db->from('danenet_solicitudes.solicitud s');
        $this->db->join('danenet_directorio.directorio u', 's.idUser = u.id_directorio', 'inner');
        $this->db->join('danenet_directorio.dependencia d', 'd.id_depen = u.dependencia', 'left');
        $this->db->join('danenet_solicitudes.tipo_solicitud t', 's.idTipo = t.idTipo', 'inner');
        $this->db->join('danenet_solicitudes.motivo m', 's.idMotivo = m.idMotivo', 'left');
        $this->db->join('danenet_solicitudes.estado e', 'e.idEstado = s.idEstado', 'left');
        if ($idTipo != 'x') {
            $this->db->where('s.idTipo', $idTipo);
        }
        if ($idEstado != 'x') {
            $this->db->where('s.idEstado', $idEstado);
        }
        if ($fecha_permiso != 'x') {
            $this->db->where('s.fecha_solicitud', $fecha_permiso);
        }
        $this->db->order_by("s.idSolicitud", "desc");
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            return $query->result_array();
        } else
            return false;
    }

    /**
     * Consulta lista de estados
     */
    public function get_estados($idEstado = 'x') {
        if ($idEstado != 'x') {
            $this->db->where('idEstado', $idEstado);
        }
        $this->db->order_by("descripcion", "asc");
        $query = $this->db->get('danenet_solicitudes.estado');
        return $query->result_array();
    }
}
//EOC