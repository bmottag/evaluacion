<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Controlador para solcitar permisos de los Funcionarios del DANE
 * @since 12/12/2013
 * @review 16/09/2015
 * @author BMOTTAG
 */
class Admin_permisos extends MX_Controller {

    const IDAPROBARPERMISO = 12; //ID_PERMISOS DE JEFES PARA APROBAR SOLICITUDES
    const IDAPROBARPERMISO3DIAS = 14; //ID_PERMISOS DE JEFES PARA APROBAR 3 DIAS

    public function __construct() {
        parent::__construct();
        $this->load->model('consultas_generales');
        $this->load->model('consultas_permisos_model', 'consultas_model');
        $this->load->model('permisos_model');
        $this->load->library("pagination");
    }

    /**
     * Lista de nuevas solicitudes
     * @since 23/01/2014
     * @review 28/09/2015
     * @author BMOTTAG
     */
    public function index($idPermiso) {
        $data['msgError'] = $data['msgSuccess'] = '';
        $data['titulo'] = 'Administraci&oacute;n';
        $data['idPermiso'] = $idPermiso;
        $data['detalle'] = false;

        $data['solicitudes'] = $this->consultas_model->get_permisos_encargado($idPermiso);

        if ($data['solicitudes']) {
            $data['solicitudes'][0]['submotivo'] = 0;
            $data["view"] = "listaNuevosPermisos";
        } else {
            $data['text'] = "En el momento no hay solicitudes nuevas.";
            $data['clase'] = 'alert-danger';
            $data["view"] = "respuesta";
        }

        if ($idPermiso != 'x') {
            $data['detalle'] = true;
            $tipo_solicitud = $data['solicitudes'][0]['ID_TIPO'];
            $submotivo = $data['solicitudes'][0]['FK_ID_SUBMOTIVO'];
            $data['solicitudes'][0]['SUBMOTIVO'] = 0;
            /* Si es estudio o docencia consultar documentos */
            if ($tipo_solicitud == 5) {
                $data['documentos'] = $this->consultas_model->get_nombre_documento($idPermiso);
            }
            /* Si es submotivo consultar motivo */
            if (isset($submotivo)) {
                $data['submotivo'] = $this->consultas_model->get_motivo_permiso($submotivo);
                $data['solicitudes'][0]['SUBMOTIVO'] = $data['submotivo']['MOTIVO'];
            }
        }

        $this->load->view("layout", $data);
    }

    /**
     * Respuesta a la solicitud
     *
     * actualiza el estado de la solicitud
     * guarda fecha del cambio e id del administrador
     * envio correo al usuario con la respuesta
     * @since 25/01/2014
     * @review 28/09/2015
     * @author BMOTTAG
     */
    public function respuesta() {
        $data['msgError'] = $data['msgSuccess'] = '';
        $data['titulo'] = 'Administraci&oacute;n';
        $this->load->library('email', array('mailtype' => 'html'));
        $data['title'] = 'Aprobar permisos';
        //Guardar respuesta en la base de datos				
        if ($this->permisos_model->update_estado_permiso()) {
            $estado = $this->input->post('estado') == 2 ? 'Rechazada' : 'Aprobada';
            if ($this->input->post('estado_proceso') == 1 || $this->input->post('estado') == 2) {
                //enviar correo al usuario con la respuesta
                $data['usuario'] = $this->consultas_model->get_permisos_idpermiso($this->input->post('idSolicitud'));
                $data['usuario']["nom_usuario"] = $data['usuario']["NOM_USUARIO"];
                $data['usuario']["ape_usuario"] = $data['usuario']["APE_USUARIO"];

                $this->email->from("controlacceso@dane.gov.co", "Sistema Integrado de Gestion Humana");
                $this->email->to('$data["usuario"]["MAIL_USUARIO"]'); //to(bmottag@dane.gov.co);
                $this->email->subject("Solicitud permisos - DANE");

                $data['msj'] = "Se reviso su solicitud y fue <strong>" . $estado . ".</strong>";
                if ($this->input->post('estado') == 2) {
                    $data['msj'].="<br /><br /><strong>Observaciones:</strong> " . $this->input->post('observaciones');
                }
                $html = $this->load->view("email", $data, true);
                $this->email->message($html);
                $this->email->send();
            } else {
                //actualizar encargado
                if ($this->permisos_model->update_encargado()) {
                    //enviar correo al encargado
                    $idJefe = $this->input->post('director');
                    $data['usuario'] = $this->consultas_generales->get_user_by_id($idJefe);
                    $email = $data['usuario']['mail_usuario'];
                    $data['msj'] = "Hay una nueva solicitud de permiso para su revisi&oacute;n.";

                    $this->email->from("controlacceso@dane.gov.co", "Sistema Integrado de Gestion Humana");
                    $this->email->to($email); //to('bmottag@dane.gov.co');
                    $this->email->subject("Solicitud permisos - DANE");
                    $html = $this->load->view("email", $data, true);
                    $this->email->message($html);
                    $this->email->send();
                }
            }
            $data['text'] = 'Se actualiz&oacute; el estado de la solicitud.';
            $data['clase'] = 'alert-success';
        } else {
            $data['text'] = "Problema guardando en la base de datos";
            $data['clase'] = 'alert-danger';
        }

        $data["view"] = "respuesta";
        $this->load->view("layout", $data);
    }

    /**
     * Consulta de permisos
     * @since 8/1/2014
     * @review 30/09/2015
     * @author BMOTTAG
     */
    public function consulta_permisos($bandera = '', $idPermiso = '') {
        $idUser = $this->session->userdata("id");
        $data['msgError'] = $data['msgSuccess'] = '';
        $data['titulo'] = 'Estado solicitudes';
        if (empty($bandera)) {
            show_error('No se definio bandera');
        } else {
            $data['bandera'] = $bandera;
        }
        if (empty($idPermiso)) {
            show_error('No se definio ID de permiso');
        } else {
            $data['idPermiso'] = $idPermiso;
        }
        $data['detalle'] = false;

        if ($bandera == 'j') {//consulta por un jefe especifico
            $numRegistros = $this->consultas_model->conteoRegistrosEncargado($idUser);
        } else if ($bandera == 'c') {//consultas generales
            $numRegistros = $this->consultas_model->conteoRegistros($idUser);
        } else {
            $numRegistros = 1;
        }

        if (!$numRegistros) {
            $data['text'] = 'No hay ninguna solicitud de permiso.';
            $data['clase'] = 'alert-danger';
            $data["view"] = "respuesta";
        } else {
            //Si es un permiso especifico cargo detalle del permiso
            if ($idPermiso != 'x') {
                $data['solicitudes'] = $this->consultas_model->get_permisos_consulta($bandera, $idPermiso);
                $data['detalle'] = true;
                $tipo_solicitud = $data['solicitudes'][0]['ID_TIPO'];
                $submotivo = $data['solicitudes'][0]['FK_ID_SUBMOTIVO'];
                $data['solicitudes'][0]['SUBMOTIVO'] = 0;

                $data['jefe'] = $this->consultas_generales->get_user_by_id($data['solicitudes'][0]['FK_ID_JEFE']);
                $data['proceso'] = $this->consultas_model->get_proceso_by_id($data['idPermiso']);
                /* Si es estudio o docencia consultar documentos */
                if ($tipo_solicitud == 5) {
                    $data['documentos'] = $this->consultas_model->get_nombre_documento($data['idPermiso']);
                }
                /* Si es submotivo consultar motivo */
                if (isset($submotivo)) {
                    $data['submotivo'] = $this->consultas_model->get_motivo_permiso($submotivo);
                    $data['solicitudes'][0]['SUBMOTIVO'] = $data['submotivo']['MOTIVO'];
                }
            } else {
                //Configuracion del paginador
                $limit = 10;
                $config = array();
                $config["base_url"] = site_url("gh_solicitudpermiso/admin_permisos/consulta_permisos/" . $bandera . "/" . $idPermiso);
                $config["total_rows"] = $numRegistros;
                $config["per_page"] = $limit;   //Cantidad de registros por pagina que debe mostrar el paginador
                $config["uri_segment"] = 6;
                $config["num_links"] = 10;  //Cantidad de links para cambiar de p�gina que va a mostrar el paginador.
                $config["use_page_numbers"] = TRUE;
                $this->pagination->initialize($config);
                //Trabajo de paginacion
                $pagina = ($this->uri->segment(6)) ? $this->uri->segment(6) : 1; //Si esta definido un valor por get, utilice el valor, de lo contrario utilice cero (para el primer valor a mostrar).
                $desde = $pagina != 1 ? (($pagina - 1) * $limit) + 1 : 0;
                $hasta = $pagina != 1 ? $desde + $limit - 1 : $desde + $limit;
                $data["solicitudes"] = $this->consultas_model->get_permisos_usuario_byencargado($desde, $hasta, $bandera);

                $data["links"] = $this->pagination->create_links();
            }
            $data["view"] = "listaConsultaPermisos";
        }
        $this->load->view("layout", $data);
    }

    /**
     * Consulta de permisos avanzado
     * @author bmottag
     * @since 2014-02-21
     * @review 2015-10-01
     */
    public function consulta_avanzada() {
        $data['msgError'] = $data['msgSuccess'] = '';
        $fechHasta = date("Y-m-d");
        $unixMark = strtotime("-1 day", strtotime($fechHasta));
        $data['fecha_ini'] = date("d/m/Y", $unixMark);
        $data['fecha_fin'] = formatear_fecha($fechHasta);
        $data['tipo'] = $this->consultas_model->get_tipo();
        $data['motivo'] = $this->consultas_model->get_motivo();
        $data['title'] = 'Historico';
        $data["view"] = 'form_filtro_avanzado';
        $this->load->view("layout", $data);
    }

    /**
     * Descargar reporte de permisos
     * @author bmottag
     * @review 2015-10-02
     */
    public function generar_xls() {
        $postt = $this->input->post();
        if (!empty($postt) && count($postt) > 0) {
            foreach ($postt as $nombre_campo => $valor) {
                if (!is_array($postt[$nombre_campo])) {
                    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
                    eval($asignacion);
                }
            }
        } else {
            return false;
        }
        
        $data['msgError'] = $data['msgSuccess'] = '';
        $fechHasta = date("Y-m-d");
        $unixMark = strtotime("-1 day", strtotime($fechHasta));
        $data['fecha_ini'] = date("d/m/Y", $unixMark);
        $data['fecha_fin'] = formatear_fecha($fechHasta);
        $data['tipo'] = $this->consultas_model->get_tipo();
        $data['motivo'] = $this->consultas_model->get_motivo();
        $arrParam = array();
        
        if(!empty($fecha_ini)) {
            $arrParam['fecha_ini'] = $fecha_ini;
        }
        if(!empty($fecha_fin)) {
            $arrParam['fecha_fin'] = $fecha_fin;
        }
        if(!empty($tipoPermiso)) {
            $arrParam['tipoPermiso'] = $tipoPermiso;
        }
        if(!empty($motivo)) {
            $arrParam['motivo'] = $motivo;
        }
        if(!empty($cmbDespacho)) {
            $arrParam['despacho'] = $cmbDespacho;
        }
        if(!empty($dependencia)) {
            $arrParam['dependencia'] = $dependencia;
            unset($arrParam['despacho']);
        }
        if(!empty($grupo)) {
            $arrParam['grupo'] = $grupo;
            unset($arrParam['despacho'], $arrParam['dependencia']);
        }
        
        $data['solicitudes'] = $this->consultas_model->get_solicitudes_historico($arrParam);
        if (count($data['solicitudes']) > 0) {
            // redireccionamos la salida al navegador del cliente (Excel2007)
            header('Content-type: application/vnd.ms-excel; charset=UTF-8');
            header("Content-Disposition: attachment; filename=reporte.xls");
            if ($this->input->post('agrupar_aprobados') == 1) {
                //cargo vista de listas de permmisos aprobados por usuario
                $this->load->view('listaAgrupada', $data);
            } else {
                $desde = $this->input->post('fecha_ini');
                $hasta = $this->input->post('fecha_fin');
                $data['tipo'] = 'x';
                $data['motivo'] = 'x';

                $data['numRegistros'] = count($data['solicitudes']);
                $data['numRegistrosTipo'] = $this->consultas_model->conteoRegistrosTipo($fecha_ini, $fecha_fin);
                $data['numRegistrosMotivo'] = $this->consultas_model->conteoRegistrosMotivo($fecha_ini, $fecha_fin);
                if ($idTipo = $this->input->post('tipoPermiso'))
                    $data['tipo'] = $this->consultas_model->get_tipo_permiso($idTipo);

                if ($idMotivo = $this->input->post('motivo'))
                    $data['motivo'] = $this->consultas_model->get_motivo_permiso($idMotivo);
                
                $this->load->view("listaDescarga", $data);
            }
        }else {
            $data['msgError'] = 'No se encontraron solicitudes de permiso con dicho filtro.';
            $data["view"] = "form_filtro_avanzado";
            $this->load->view("layout", $data);
        }
    }

    /**
     * Descargar reporte
     */
    public function xls($idTipo, $idEstado, $fecha_permiso) {
        if ($this->session->userdata('is_logged_in')) {
            $data['solicitudes'] = $this->permisos_model->get_permisos_reporte($idTipo, $idEstado, $fecha_permiso);
            $data['idTipo'] = $idTipo;
            if ($idEstado != 'x') {
                $estado = $this->permisos_model->get_estados($idEstado);
                $data['estado'] = $estado[0]['descripcion'];
            } else {
                $data['estado'] = $idEstado;
            }
            $data['fecha_permiso'] = $fecha_permiso;
            //var_dump($data['solicitudes'][0]);die();
            if ($data['solicitudes']) {
                // redireccionamos la salida al navegador del cliente (Excel2007)
                header('Content-type: application/vnd.ms-excel; charset=UTF-8');
                header("Content-Disposition: attachment; filename=excel.xls");
                $this->load->view('permisos/listaDescarga', $data);
            } else {
                $data['menu'] = $this->consultas_model->get_submenu($this->session->userdata('idAdmin'), 4);
                $data['title'] = 'Estado solicitudes';
                $this->load->view('templates/submenu', $data);
                $data['text'] = "No se encontraron solicitudes de permiso con dicho filtro.";
                $this->load->view('templates/success', $data);
            }
        } else {
            redirect('main/restricted');
        }
    }
}
//EOC