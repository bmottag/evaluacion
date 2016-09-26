<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controlador para solcitar permisos de los Funcionarios del DANE
 * @since 12/12/2013
 * @review 16/09/2015
 * @author BMOTTAG
 */
class GH_Solicitudpermiso extends MX_Controller {

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
     * Index 
     * Formulario para solicitar permisos
     */
    public function index() {
        $data['tipo'] = $this->consultas_model->get_tipo();
        $data['motivo'] = $this->consultas_model->get_motivo();
        $data['funcionarios'] = $this->consultas_generales->get_lista_usuarios(GH_Solicitudpermiso::IDAPROBARPERMISO);
        $data['director'] = $this->consultas_generales->get_lista_usuarios(GH_Solicitudpermiso::IDAPROBARPERMISO3DIAS);
        $data["view"] = "form_permiso";
        $this->load->view("layout", $data);
    }

    /**
     * Guardar datos del Formulario para solicitar permisos
     * @since 12/12/2013
     * @review 16/09/2015
     * @author BMOTTAG
     */
    public function permisos() {
        $data['titulo'] = 'Solicitud de Permiso';
        $data["msgError"] = $data["msgSuccess"] = '';
        
        if ($this->input->post()) {
            if ($idRegistro = $this->permisos_model->add_solicitud()) {
                $this->load->library("email");
                for ($i = 1; $i <= 2; $i++) {
                    if ($i == 1) {//Envio de correo al usuario
                        $idUser = $this->session->userdata("id");
                        $data['usuario'] = $this->consultas_generales->get_user_by_id($idUser);
                        $email = $data['usuario']['mail_usuario'];
                        $data['msj'] = "Su solicitud se esta verificando para su aprobaci&oacute;n. 
                            <p>Se enviar&aacute; respuesta por correo electr&oacute;nico o puede ir al enlace 'Ver mis permisos'.</p>";
                    } else {//Envio de correo al administrador
                        $idJefe = $this->input->post('jefe');
                        $data['usuario'] = $this->consultas_generales->get_user_by_id($idJefe);
                        $email = $data['usuario']['mail_usuario'];
                        $data['msj'] = "Hay una nueva solicitud de permiso para su revisi&oacute;n.";
                    }
                    $this->email->from("controlacceso@dane.gov.co", "Sistema Integrado de Gestion Humana");
                    $this->email->to($email); //to('bmottag@dane.gov.co');
                    $this->email->subject("Solicitud permisos - DANE");
                    $html = $this->load->view("email", $data, true);
                    $this->email->message($html);
                    $this->email->send();
                }

                $data["msgSuccess"] = 'Su solicitud se ha enviado con &eacute;xito.';
                $data["idRegistro"] = $idRegistro;

                //Si el tipo de permisos es estudio o docencia entonces subir documentos
                if ($this->input->post('tipoPermiso') == 5) {
                    $config['upload_path'] = './files/certificados/';
                    $config['allowed_types'] = 'gif|jpg|png|txt|docx|pdf|xlsx|xls|doc|htm|html';
                    $config['max_size'] = '2048';
                    $config['max_width'] = '1024';
                    $config['max_height'] = '768';

                    $this->load->library('upload', $config);
                    //cargo archivo y guardo nombre en la BD
                    foreach ($_FILES as $key => $value) {
                        if (!empty($key['name'])) {
                            $this->upload->initialize($config);
                            if (!$this->upload->do_upload($key)) {
                                //hubo un error con el cargue de documentos
                                $data = array('error' => $this->upload->display_errors());
                                $data["msgSuccess"] = 'Su solicitud se ha enviado con &eacute;xito.';
                            } else {
                                $data[$key] = array('upload_data' => $this->upload->data());
                                //guardo nombre del documento en la base de datos
                                $this->permisos_model->guardar_documentos($idRegistro, $data[$key]['upload_data']['file_name']);
                            }
                        }
                    }
                }
            } else {
                $data["msgError"] = 'Ocurrió un problema al crear la solicitud de permiso.';
            }
            $data["view"] = "respuesta";
            $this->load->view("layout", $data);
        }
    }

    /**
     * Lista de submotivos dependiendo del motivo
     * @since 22/09/2015
     */
    public function list_dropdown() {
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
        $idMotivo = $this->input->post('idMotivo');
        $matches = $this->consultas_model->get_submotivo($idMotivo);
        if ($matches) {
            echo "<option value='' >Seleccione...</option>";
            foreach ($matches as $match) {
                echo "<option value='{$match["ID_MOTIVO"]}'>{$match["MOTIVO"]} </option>";
            }
        } else
            echo 'vacio';
    }

    /**
     * Lista de los estado de las solicitudes
     * @since 8/1/2014
     * @review 24/09/2015
     * @author BMOTTAG
     */
    public function estado_permisos($idPermiso) {
        $data['titulo'] = 'Solicitud de Permiso';
        $data["msgError"] = $data["msgSuccess"] = '';
        
        $idUser = $this->session->userdata("id");
        $numRegistros = $this->consultas_model->conteoRegistrosUsuario($idUser);

        if (!$numRegistros) {
            $data["msgError"] = 'No hay ninguna solicitud de permiso.';
            $data["view"] = "respuesta";
        } else {
            $data['solicitudes'] = $this->consultas_model->get_estado_permisos($idUser, $idPermiso);
            $data['idPermiso'] = $idPermiso;
            $data['detalle'] = false;
            //Si es un permiso especifico cargto detalle del permiso
            if ($idPermiso != 'x') {
                $data['detalle'] = true;
                $tipo_solicitud = $data['solicitudes'][0]['ID_TIPO'];
                $submotivo = $data['solicitudes'][0]['FK_ID_SUBMOTIVO'];
                $data['solicitudes'][0]['SUBMOTIVO'] = 0;

                $data['jefe'] = $this->consultas_generales->get_user_by_id($data['solicitudes'][0]['FK_ID_JEFE']);
                $data['proceso'] = $this->consultas_model->get_proceso_by_id($idPermiso);
                /* Si es estudio o docencia consultar documentos */
                if ($tipo_solicitud == 5) {
                    $data['documentos'] = $this->consultas_model->get_nombre_documento($idPermiso);
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
                $config["base_url"] = site_url("gh_solicitudpermiso/estado_permisos/x/");
                $config["total_rows"] = $numRegistros;
                $config["per_page"] = $limit;   //Cantidad de registros por pagina que debe mostrar el paginador
                $config["uri_segment"] = 4;
                $config["num_links"] = 10;  //Cantidad de links para cambiar de página que va a mostrar el paginador.

                $config["use_page_numbers"] = TRUE;
                $this->pagination->initialize($config);
                //Trabajo de paginacion
                $pagina = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1; //Si esta definido un valor por get, utilice el valor, de lo contrario utilice cero (para el primer valor a mostrar).
                //echo $pagina; die();
                $desde = $pagina != 1 ? (($pagina - 1) * $limit) + 1 : 0;
                $hasta = $pagina != 1 ? $desde + $limit - 1 : $desde + $limit;
                $data["solicitudes"] = $this->consultas_model->get_permisos_usuario($desde, $hasta);
                $data["links"] = $this->pagination->create_links();
            }
            $data["view"] = "listaEstadoPermisos";
        }
        $this->load->view("layout", $data);
    }

    /**
     * Cancelar solicitud
     * @since 19/02/2014
     * @review 25/09/2015
     */
    public function cancelar_solicitud() {
        $data['titulo'] = 'Cancelar Solicitud de Permiso';
        $data["msgError"] = $data["msgSuccess"] = '';
        $data["idRegistro"] = $this->input->post('idSolicitud');
        
        if ($this->permisos_model->update_estado_permiso()) {
            $data["msgSuccess"] = 'Su solicitud de permiso fue correctamente cancelado. Por favor verifique en el enlace "ver mis permisos"';
        } else {
            $data["msgError"] = 'Ocurrió un problema al cancelar la solicitud de permiso.';
        }
        $data["view"] = "respuesta";
        $this->load->view("layout", $data);
    }
    
    public function consultarPermiso() {
        $postt = $this->input->post();
        if (!empty($postt) && count($postt) > 0) {
            foreach ($postt as $nombre_campo => $valor) {
                if (!is_array($postt[$nombre_campo])) {
                    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
                    eval($asignacion);
                }
            }
        }
        
        $permiso = $this->consultas_model->get_estado_permisos('x', $idPermiso);
        //pr($data['permiso']);
        if($permiso != false) {
            echo 'exito';
            $data['jefe'] = $data['proceso'] = $data['documentos'] = array();
            $data['permiso'] = $permiso[0];
            $tipo_solicitud = $data['permiso']['ID_TIPO'];
            $submotivo = $data['permiso']['FK_ID_SUBMOTIVO'];
            $data['permiso']['SUBMOTIVO'] = 0;
            $data['jefe'] = $this->consultas_generales->get_user_by_id($data['permiso']['FK_ID_JEFE']);
            if(count($data['jefe']) > 0) {
                $data['jefe']['nombre'] = (strlen($data['jefe']['nom_usuario']) > 0) ? $data['jefe']['nom_usuario']: '';
                $data['jefe']['nombre'] .= (strlen($data['jefe']['ape_usuario']) > 0) ? ' ' . $data['jefe']['ape_usuario']: '';
            }
            $proceso = $this->consultas_model->get_proceso_by_id($idPermiso);
            if($proceso != false) {
                $data['proceso'] = $proceso[0];
            }
            /* Si es estudio o docencia consultar documentos */
            if ($tipo_solicitud == 5) {
                $data['documentos'] = $this->consultas_model->get_nombre_documento($idPermiso);
            }
            /* Si es submotivo consultar motivo */
            if (isset($submotivo)) {
                $data['submotivo'] = $this->consultas_model->get_motivo_permiso($submotivo);
                $data['permiso']['SUBMOTIVO'] = $data['submotivo']['MOTIVO'];
            }
            //pr($data); exit;
            $html = $this->load->view("form_info_permiso", $data, true);
            echo $html;
        }
    }
} //EOC