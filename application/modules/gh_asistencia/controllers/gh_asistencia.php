<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controlador para reportes de asistencia de funcionarios
 * @author oagarzond
 * @since 2015-05-04
 * @review 2015-05-04
 */
class GH_Asistencia extends MX_Controller {
    
    public function __construct() {
        parent::__construct();
        //$this->load->model('consultas_generales');
    }

    /**
     * Formulario para ingresar y actualizar el codigo de barras para el registro 
     * de asistencia
     * @author oagarzond
     * @since  2016-05-05
     */
    public function index() {
        //pr($this->session->all_userdata()); exit;
        $this->load->model('consultas_asistencias_model', 'cam');
        $this->load->model('gh_solicitudpermiso/consultas_permisos_model', 'cpm');
        
        $postt = $this->input->post();
        if (!empty($postt) && count($postt) > 0) {
            foreach ($postt as $nombre_campo => $valor) {
                if (!is_array($postt[$nombre_campo])) {
                    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
                    eval($asignacion);
                }
            }
        }
        
        $data["msgError"] = $data["msgSuccess"] = $data["msgPerfetti"] = '';
        $data["IPValida"] = TRUE;
        $tgracia = 10;
        $fechahoraactual = $this->cam->consultar_fecha_hora();
        $fechaactual = substr($fechahoraactual, 0, 10);
        
        // Se valida si la IP donde se esta accediendo es valida - 2016-09-01 - oagarzond
        $remoteIP = $_SERVER['REMOTE_ADDR'];
        $IPValidas = array('10.57.24.230', '10.57.24.232', '10.57.24.239', '10.57.24.68', '192.168.1.74');
        if(!in_array($remoteIP, $IPValidas)) {
            $data["msgError"] = "Su direcci&oacute;n IP es: " . $remoteIP . ".<br>Desde esta direccion IP no es posible registrar la asistencia.";
            $data["IPValida"] = FALSE;
        }
        // Se muestra el mensaje de que mañana es dia Perfetti - 2016-09-09 - oagarzond
        $arrAnios = array(intval(date('Y')) - 1, intval(date('Y')), intval(date('Y')) + 1);
        $perfetti = calcular_viernes_perfetti($arrAnios);
        $num_dia = date("w", strtotime($fechaactual));
        if ($num_dia == '4') { // Es jueves
            $fechaViernes = date("Y-m-d", strtotime("+1 day", strtotime(formatear_fecha($fechaactual))));
            if(in_array(formatear_fecha($fechaViernes), $perfetti)) {
                $data["msgPerfetti"] = 'Recuerde que mañana será viernes especial.';
            }
        }
        
        if (!empty($postt) && count($postt) > 0) {
            $arrParam = array();
            if(strlen($codigoBarras) == 7) {
                $codigoBarras8 = $codigoBarras;
                $codigoBarras = '';
            } else if(strlen($codigoBarras) == 8) {
                $codigoBarras8 = substr($codigoBarras, 0, 7);
                $codigoBarras = '';
            } else if(strlen($codigoBarras) == 12) {
                $codigoBarras8 = '';
            } else if(strlen($codigoBarras) == 13) {
                $codigoBarras8 = substr($codigoBarras, 0, 12);
                $codigoBarras = '';
            }
            //$codigoBarras = '254793493522'; // William
            //$codigoBarras8 = '9349352'; // William
            if (!empty($codigoBarras) || !empty($codigoBarras8)) {
                $arrPers = $this->cam->consultar_codigo_barras('', $codigoBarras, $codigoBarras8);
                //pr($arrPers); exit;
                if (count($arrPers) > 0) {
                    $ano = substr($fechahoraactual, 6, 4);
                    $mes = substr($fechahoraactual, 3, 2);
                    $dia = substr($fechahoraactual, 0, 2);
                    $hora = substr($fechahoraactual, 11, 5);
                    
                    $idPers = $arrPers[0]["ID_PERSONA"];
                    $idUsua = $arrPers[0]["FK_ID_USUARIO"];
                    $nombre = $arrPers[0]["nombre"];

                    // oagarzond- 2016-05-20 - Se consulta si tiene permiso aprobado en el dia
                    $arrPP = array(
                        'idPers' => $idUsua,
                        'idEstado' => array(3, 4),
                        'fechaIniDesde' => $fechaactual
                    );
                    $permiso = $this->cpm->consultar_solicitudes_permiso($arrPP);
                    //pr($permiso); exit;
                    if ($permiso != false) {
                        switch ($permiso[0]["FK_ID_TIPO"]) {
                            case 1: // Fraccion
                                if (!empty($permiso[0]["HORA_INICIO"]) && !empty($permiso[0]["HORA_FIN"])) {
                                   $data["msgError"] = 'Usted no puede registrar su ';
                                   $data["msgError"] .= ($hora < '12:00') ? 'entrada' : 'salida';
                                   $data["msgError"] .= ' porque tiene un permiso aprobado o avalado con el No. de solicitud ' . $permiso[0]["ID_SOLICITUD"] .
                                            ' para el día ' . $permiso[0]["FECHA_INICIAL"] . ' entre las ' . $permiso[0]["HORA_INICIO"] . ' y las ' . $permiso[0]["HORA_FIN"] . '. 
                                Por favor acérquese a la oficina de Talento Humano para modificar o cancelar la solicitud.';
                                }
                                break;
                            case 2: // Un dia
                               $data["msgError"] = 'Usted no puede registrar su entrada o salida porque tiene un permiso aprobado o avalado con el No. de solicitud ' . $permiso[0]["ID_SOLICITUD"] .
                                        ' para el día ' . $permiso[0]["FECHA_INICIAL"] . '. Por favor acérquese a la oficina de Talento Humano para modificar o cancelar la solicitud.';
                                break;
                            case 3: // Dos dias
                            case 4: // Tres dias
                               $data["msgError"] = 'Usted no puede registrar su entrada o salida porque tiene un permiso aprobado o avalado con el No. de solicitud ' . $permiso[0]["ID_SOLICITUD"];
                                if (empty($permiso[0]["FECHA_FINAL"])) {
                                   $data["msgError"] .= ' para el día ' . $permiso[0]["FECHA_INICIAL"] . '.';
                                } else {
                                   $data["msgError"] .= ' entre los días ' . $permiso[0]["FECHA_INICIAL"] . ' y ' . $permiso[0]["FECHA_FINAL"] . '.';
                                }
                               $data["msgError"] .= ' Por favor acérquese a la oficina de Talento Humano para modificar o cancelar la solicitud.';
                                break;
                            default:
                                break;
                        }
                    }

                    if (empty($data["msgError"])) {
                        $arrParam = array(
                            "idPers" => $idPers,
                            "fecha" => $fechaactual
                        );
                        $arrRegi = $this->cam->consultar_registros_asistencia($arrParam);
                        //pr($arrRegi); exit;
                        //$arrRegi = array();
                        if (count($arrRegi) > 0) {
                            $HE = $arrRegi[0]["HE"];
                            $HS = $arrRegi[0]["HS"];
                            // oagarzond - 2016-05-10 - se calcula que el siguiente registro sea 10 minutos despues del primer registro
                            $timestampE = $timestampE2 = 0;
                            if (strlen($HE) > 0) {
                                $horaE = substr($HE, 0, 2);
                                $minE = substr($HE, 3, 2);
                                $timestampE = mktime($horaE, $minE, 0, $mes, $dia, $ano);
                            }
                            $horaE2 = substr($hora, 0, 2);
                            $minE2 = substr($hora, 3, 2);
                            $timestampE2 = mktime($horaE2, $minE2, 0, $mes, $dia, $ano);
                            if (strlen($HE) > 0) {
                                if (($timestampE2 - $timestampE) / 60 > $tgracia) {
                                    // Se actualiza la hora de salida
                                    $arrDatosAsis["COAS_HORA_SALIDA"] = '' . $hora;
                                    $arrWhereAsis = array(
                                        'INTERNO_PERSONA' => $idPers,
                                        'COAS_FECHA' => $fechaactual,
                                        'COAS_HORA_ENTRADA' => $HE
                                    );
                                    if (!$this->cam->editar_asistencia('ASIS_FORM_CONTROL_ASISTENCIA', $arrDatosAsis, $arrWhereAsis)) {
                                       $data["msgError"] = "No se pudo editar la asistencia.";
                                    } else {
                                        $data["msgSuccess"] = 'REGISTRO DE SALIDA DE ' . $nombre . ' DEL DÍA ' . $fechaactual . ' A LAS  ' . $hora . ' SE GUARDÓ CORRECTAMENTE.';
                                    }
                                } else {
                                   $data["msgError"] = 'Usted ya registró su hora de entrada a las ' . $HE . '.' . $this->cam->get_sql();
                                }
                            } else {
                                // Se actualiza la hora de entrada
                                $arrDatosAsis["COAS_HORA_ENTRADA"] = '' . $hora;
                                $arrWhereAsis = array(
                                    'INTERNO_PERSONA' => $idPers,
                                    'COAS_FECHA' => $fechaactual
                                );
                                if (!$this->cam->editar_asistencia('ASIS_FORM_CONTROL_ASISTENCIA', $arrDatosAsis, $arrWhereAsis)) {
                                   $data["msgError"] = "No se pudo editar la asistencia.";
                                } else {
                                    $data["msgSuccess"] = 'REGISTRO DE ENTRADA DE ' . $nombre . ' DEL DÍA ' . $fechaactual . ' A LAS  ' . $hora . ' SE GUARDÓ CORRECTAMENTE.';
                                }
                            }
                        } else { // Se inserta el primer registro
                            $arrDatosAsis = array(
                                'ID_ASISTENCIA' => 'SEQ_CONTROL_ASISTENCIA.Nextval',
                                'FK_ID_USUARIO' => $idUsua,
                                'INTERNO_PERSONA' => $idPers,
                                'FECHA_REGISTRO' => "TO_TIMESTAMP('" . $fechaactual . " " . $hora . ":00', 'DD/MM/YYYY HH24:MI:SS')",
                                'COAS_FECHA' => $fechaactual
                            );
                            if ($hora < '12:00') {
                                $arrDatosAsis["COAS_HORA_ENTRADA"] = '' . $hora;
                                $txtCampo = 'entrada';
                            } else {
                                $arrDatosAsis["COAS_HORA_SALIDA"] = '' . $hora;
                                $txtCampo = 'salida';
                            }
                            if (!$this->cam->insertar_asistencia('ASIS_FORM_CONTROL_ASISTENCIA', $arrDatosAsis)) {
                               $data["msgError"] = "No se pudo insertar la asistencia.";
                            } else {
                                $data["msgSuccess"] = 'Registro de ' . $txtCampo . ' de ' . $nombre . ' del día ' . $fechaactual . ' a las  ' . $hora . ' se guardó correctamente.';
                            }
                        }
                    }
                } else {
                   $data["msgError"] = "El usuario no se encuentra registrado. Dirígase con el área de Gestión Humana.";
                }
            } else {
               $data["msgError"] = "Debe ingresar el código de barras.";
            }
        }
        
        /*if(strlen($data["msgError"]) > 0) {
            $this->session->set_flashdata('msgError', $data["msgError"]);
        }
        if(strlen($data["msgSuccess"]) > 0) {
            $this->session->set_flashdata('msgSuccess', $data["msgSuccess"]);
        }*/
        $data["view"] = "form_registro";
        //pr($data); exit;
        $this->load->view("layout", $data);
    }
    
    /**
     * Valida si hay sesion activa
     * @author hhchavezv
     * @since  2016-01-12
     */
    public function validaSesion() {
        header("Content-Type: text/plain; charset=utf-8");
        $usuario = $this->session->userdata("id");
        if (empty($usuario))
            echo 'Error';
        else
            echo '-ok-';
    }
    
    /**
     * Consulta las personas que tienen codigo de barras para insertar el registro 
     * en la tabla de asistencia
     * @author oagarzond
     * @since  2016-06-07
     */
    public function insertarAsisDiario() {
        // Esto va en el crontab para que se ejecute automaticamente - 2016-06-09
        // 05 04 * * 1 /home1/home/dimpe/daneweb/ghumana/application/third_party/ejecutarTareasLunes.sh
        // 05 04 * * 1,2,3,4,5 /home1/home/dimpe/daneweb/ghumana/application/third_party/ejecutarTareasDiario.sh
        // 05 04 * * 1,2,3,4,5 /var/www/html/aplicativos/ghumana/application/third_party/ejecutarTareasDiario.sh
        $this->load->model('consultas_generales', 'cg');
        $this->load->model('consultas_asistencias_model', 'cam');
        
        $data["msgError"] = $data["msgSuccess"] = '';
        //Se calcula si hoy no es sabado, domingo o festivo
        $fechahoraactual = $this->cg->consultar_fecha_hora();
        $fechaactual = substr($fechahoraactual, 0, 10);
        $ano = intval(substr($fechahoraactual, 6, 4));
        $hora = substr($fechahoraactual, 11, 5);
        $arrFest = $this->cg->consultar_festivos(array($ano - 1, $ano));
        if(!es_dia_habil(formatear_fecha($fechaactual), $arrFest)) {
            echo "La fecha " . $fechaactual . " no se debe agregar registros de asistencia.";
            return false;
        }
        //$fechaactual = '14/06/2016';
        $arrCB = $this->cam->consultar_codigo_barras();
        //pr($arrCB); exit;
        if (count($arrCB) > 0) {            
            foreach ($arrCB as $kCB => $vCB) {
                if($vCB["INTERNO_PERSONA"] == 'S') {
                    continue;
                }
                $arrParam = array(
                    "idPers" => $vCB["INTERNO_PERSONA"],
                    "fecha" => $fechaactual
                );
                $existeCB = $this->cam->consultar_registros_asistencia($arrParam);
                if (count($existeCB) == 0) {
                    $arrDatosAsis = array(
                        'ID_ASISTENCIA' => 'SEQ_CONTROL_ASISTENCIA.Nextval',
                        'FK_ID_USUARIO' => $vCB["FK_ID_USUARIO"],
                        'INTERNO_PERSONA' => $vCB["INTERNO_PERSONA"],
                        'FECHA_REGISTRO' => "TO_TIMESTAMP('" . $fechaactual . " " . $hora . ":00', 'DD/MM/YYYY HH24:MI:SS')",
                        'COAS_FECHA' => $fechaactual
                    );
                    if (!$this->cam->insertar_asistencia('ASIS_FORM_CONTROL_ASISTENCIA', $arrDatosAsis)) {
                        $data["msgError"][] = "No se pudo insertar la asistencia.";
                    }
                } else {
                    $data["msgError"][] = "La persona " . $vCB["INTERNO_PERSONA"] . " ya tiene asistencia para el " . $fechaactual . ".";
                }
            }
        }
        
        if(!empty($data["msgError"])) {
            foreach ($data["msgError"] as $ke => $ve) {
                echo $ve . '<br />';
            }
        }
    }
    
    /**
     * Formulario para agregar o editar el registro de la llegada o salida del funcionario
     * @author oagarzond
     * @since  2016-06-28
     */
    public function editarAsistencia($idAsis = 'x') {
         //pr($this->session->all_userdata()); exit;
        $this->load->model('consultas_asistencias_model', 'cam');
        
        $postt = $this->input->post();
        if (!empty($postt) && count($postt) > 0) {
            foreach ($postt as $nombre_campo => $valor) {
                if (!is_array($postt[$nombre_campo])) {
                    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
                    eval($asignacion);
                }
            }
        }
        
        $data["msgError"] = $data["msgSuccess"] = '';
        
        if (!empty($postt) && count($postt) > 0) {
            $arrParam = array();
            //$numeDocu = '79349352'; // William
            if (!empty($numeDocu)) {
                $arrPers = $this->cam->buscar_personas(array('txtDocu' => $numeDocu));
                if(count($arrPers) > 0) {
                    $idPers = $arrPers[0]["id"];
                    $fechahoraactual = $this->cam->consultar_fecha_hora();
                    $fechaactual = substr($fechahoraactual, 0, 10);
                    $arrParam = array(
                        "idPers" => $idPers,
                        "fecha" => $fechaactual
                    );
                    $arrRegi = $this->cam->consultar_registros_asistencia($arrParam);
                    //pr($arrRegi); exit;
                    
                    if(empty($hora)) {
                        $hora = substr($fechahoraactual, 11, 5);
                    }
                    // Se actualiza la hora una sola vez por dia
                    if ($hora < '12:00') {
                        $arrDatosAsis["COAS_HORA_ENTRADA"] = '' . $hora;
                        $txtCampo = 'entrada';
                    } else {
                        $arrDatosAsis["COAS_HORA_SALIDA"] = '' . $hora;
                        $txtCampo = 'salida';
                    }
                    if(!empty($arrRegi[0]["HE"]) && $txtCampo == 'entrada') {
                        $data["msgError"] = "Ya existe un registro de hora de " . $txtCampo . " del " . $fechaactual . " a las " . $arrRegi[0]["HE"] .  ".";
                    }                    
                    if(!empty($arrRegi[0]["HS"]) && $txtCampo == 'salida') {
                        $data["msgError"] = "Ya existe un registro de hora de " . $txtCampo . " del " . $fechaactual . " a las " . $arrRegi[0]["HS"] .  ".";
                    }
                    
                    if (empty($data["msgError"])) {
                        $arrWhereAsis = array(
                            'INTERNO_PERSONA' => $idPers,
                            'COAS_FECHA' => $fechaactual
                        );
                        if (!$this->cam->editar_asistencia('ASIS_FORM_CONTROL_ASISTENCIA', $arrDatosAsis, $arrWhereAsis)) {
                            $data["msgError"] = "No se pudo editar la asistencia.";
                        } else {
                            $data["msgSuccess"] = 'Registro de ' . $txtCampo . ' de ' . $arrPers[0]["nombre"] . ' del día ' . $fechaactual . ' a las  ' . $hora . ' se guardó correctamente.';
                        }
                    }
                } else {
                    $data["msgError"] = "No se encontró el funcionario activo en el sistema.";
                }
            }
        }
        if (empty($hora)) {
            $fechahoraactual = $this->cam->consultar_fecha_hora();
            $data["hora"] = substr($fechahoraactual, 11, 5);
        } else {
            $data["hora"] = $hora;
        }
        
        $data["view"] = "form_editar_asistencia";
        //pr($data); exit;
        $this->load->view("layout", $data);
    }
    
    /**
     * Formulario para agregar o editar el codigo de barras de un funcionario activo
     * @author oagarzond
     * @since  2016-05-11
     */
    public function editarCodigoBarras($idCB = 'x') {
        
        $this->load->model('consultas_generales', 'cg');
        //$this->load->model('consultas_asistencias_model', 'cam');
        
        if($idCB == 'x') {
            
        }
        $data["msgError"] = $data["msgSuccess"] = '';
        $data['regreso'] = 'editarCodigoBarras';//valor para regresar a este mismo controlador
        $data['cedula'] = $this->session->userdata('num_ident');
        $data["arrDespacho"] = $this->cg->get_despacho();
        $codi_desp = 1;
        $data["arrDepe"] = $this->cg->get_dependencia_by_id($codi_desp);
        $data['codi_depe'] = ''; //13 - Sistemas
        $data["view"] = "lista_consulta_personas";
        //pr($data); exit;
        $this->load->view("layout", $data);
    }
    
    /**
     * Consultar para mostrar la informacion de los usuarios que tienen codigo de barras
     * @author oagarzond
     * @since  2016-05-13
     */
    public function buscarPersonas($param) {
        $this->load->model('consultas_asistencias_model', 'cam');
        
        $gett = $this->input->get();
        if (!empty($gett) && count($gett) > 0) {
            foreach ($gett as $nombre_campo => $valor) {
                if (!is_array($gett[$nombre_campo])) {
                    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
                    eval($asignacion);
                }
            }
        }
        
        $postt = $this->input->post();
        if (!empty($postt) && count($postt) > 0) {
            foreach ($postt as $nombre_campo => $valor) {
                if (!is_array($postt[$nombre_campo])) {
                    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
                    eval($asignacion);
                }
            }
        }
        
        $config["per_page"] = ($rows > 0) ? $rows: 200;
        $start = ($page > 0) ? (($config["per_page"] * $page) - $config["per_page"]): 0;
        $sidx = "INTERNO_PERSONA";
        $sord = (strlen($sord))? "DESC": "DESC";
        
        $i = 3;
        unset($arrParam);
        $arrParam = $datosPers = $responce = array();
        
        for ($i = 1; $i < 20; $i++) {
            $valor = $this->uri->segment($i);
            if ($i == 3 && !empty($valor) && ($valor != "-" && $valor != "0")) {
                $arrParam["despacho"] = urldecode($valor);
            }
            if ($i == 4 && !empty($valor) && ($valor != "-" && $valor != "0")) {
                $arrParam["depen"] = urldecode($valor);
                unset($arrParam["despacho"]);
            }
            if ($i == 5 && !empty($valor) && ($valor != "-" && $valor != "0")) {
                $arrParam["grupo"] = urldecode($valor);
                unset($arrParam["despacho"], $arrParam["depen"]);
            }
            if ($i == 6 && !empty($valor) && $valor != "-") {
                $arrParam["txtDocu"] = urldecode($valor);
            }
            if ($i == 7 && !empty($valor) && $valor != "-") {
                $arrParam["txtNombres"] = strtoupper(urldecode($valor));
            }
            if ($i == 8 && !empty($valor) && $valor != "-") {
                $arrParam["txtApellidos"] = strtoupper(urldecode($valor));
            }
        }
        if(empty($arrParam)) {
            $arrParam["depen"] = 13;
            //$arrParam['idPers'] = array('2249','2224','2214','2158','2119','452');
        }
        //pr($arrParam); exit;
        $datosPers = $this->cam->buscar_personas($arrParam);
        //pr($datosPers); exit;
        if (count($datosPers) > 0) {
            $total = count($datosPers);
            $limit = (($config["per_page"] * $page) > $total) ? $total: ($config["per_page"] * $page);
            $responce["page"] = $page;
            $responce["total"] = ceil($total / $config["per_page"]);
            $responce["records"] = $total;
            // Se revisa que se va a mostrar en la grilla - 2016-05-10
            $i = 0;
            for($j = $start; $j < $limit; $j++) {
                $datosPers[$j]["horario"] = (strlen($datosPers[$j]["horario"] ) > 0) ? 'Especial': 'Normal';
                $datosPers[$j]["horario"] = '<a href="' . base_url('gh_asistencia/editarHorarioFunc/' . $datosPers[$j]["id"]) . '">' . $datosPers[$j]["horario"] . '</a>';
                if(count($this->cam->existe_codigo_barras($datosPers[$j]["id"])) > 0) {
                    $datosPers[$j]["opc"] .= '<a href="' . base_url('gh_asistencia/editarCodigoBarra/' . $datosPers[$j]["id"]) . '"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>';
                } else {
                    $datosPers[$j]["opc"] .= '<a href="' . base_url('gh_asistencia/editarCodigoBarra/' . $datosPers[$j]["id"]) . '"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></a>';
                }
                $responce["rows"][$i]["id"] = $datosPers[$j]["id"];
                $responce["rows"][$i]["cell"] = array(
                    $datosPers[$j]["nume_docu"], 
                    $datosPers[$j]["apellidos"], 
                    $datosPers[$j]["nombres"], 
                    $datosPers[$j]["email"], 
                    $datosPers[$j]["usuario"],
                    $datosPers[$j]["horario"],
                    $datosPers[$j]["opc"]
                );
                $i++;
            }
        }
        //pr($responce); exit;
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode($responce);
    }
    
    /**
     * Formulario para agregar o editar el codigo de barras de un funcionario activo
     * @author oagarzond
     * @since  2016-05-11
     */
    public function editarCodigoBarra($idPers = 'x') {
        $this->load->model('consultas_asistencias_model', 'cam');
        $this->load->library('barcode');
        /*if($idPers == 'x') {
            redirect(base_url('gh_asistencia/editarCodigoBarras'));
        }*/
        
        $msgError = $msgSuccess = '';
        
        $postt = $this->input->post();
        if (!empty($postt) && count($postt) > 0) {
            foreach ($postt as $nombre_campo => $valor) {
                if (!is_array($postt[$nombre_campo])) {
                    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
                    eval($asignacion);
                }
            }
        }
        
        if (!empty($postt) && count($postt) > 0) {
            //pr($postt); exit;
            switch ($opc) {
                case 'c':
                    $arrCB = $this->cam->consultar_codigo_barras($idPers);
                    if (count($arrCB) > 0) {
                        $arrDatosCB['CODIGO_BARRAS_EAN8'] = $codigoBarras8;
                        $arrDatosCB['CODIGO_BARRAS_EAN13'] = $codigoBarras;
                        $arrWhereCB = array('INTERNO_PERSONA' => $idPers);
                        if (!$this->cam->editar_asistencia('ASIS_CODIGOS_BARRAS', $arrDatosCB, $arrWhereCB)) {
                            $msgError = 'El c&oacute;digo de barras no se pudo actualizar correctamente. Error.';
                        }
                    } else {
                        // Se consulta el id usuario de la persona actual
                        $arrPers = $this->cam->consultar_usuario(array('interno' => $idPers));
                        $idUusua = '7041';
                        if(count($arrPers) > 0) {
                            $idUusua = $arrPers["idUser"];
                        }
                        $arrDatosCB = array(
                            'ID_CODIGO_BARRAS' => 'SEQ_CODIGOS_BARRAS.Nextval',
                            'INTERNO_PERSONA' => $idPers,
                            'FK_ID_USUARIO' => $idUusua,
                            'CODIGO_BARRAS_EAN8' => $codigoBarras8,
                            'CODIGO_BARRAS_EAN13' => $codigoBarras
                        );
                        if (!$this->cam->insertar_asistencia('ASIS_CODIGOS_BARRAS', $arrDatosCB)) {
                            $msgError = 'El c&oacute;digo de barras no se pudo guardar correctamente. Error.';
                        } else {
                            /* $usuario = strtoupper($this->session->userdata('usuario'));
                              $maquina = gethostbyaddr($_SERVER['REMOTE_ADDR']);
                              $maquina = explode(".", $maquina);
                              $arrDatosSA = array(
                              'SEPR_NCDGO' => 1,
                              'SEAU_CTBLA' => 'RH_PERSONAS_COD_BARRAS',
                              'SEAU_CRGSTRO' => $idPers . '-' . $codigoBarras,
                              'SEAU_FFERE' => 'SYSDATE',
                              'SEAU_CUSCO' => $this->session->userdata('usuario'),
                              'SEAU_CMAQU' => $maquina[0]
                              );
                              if (!$this->cam->insertar_asistencia('SESI_AUDITORIA', $arrDatosSA)) {
                              $data["msgError"] = 'No se pudo registrar el control de auditoria.';
                              } else {
                              $data["msgSuccess"] = 'El c&oacute;digo de barras se pudo guardar correctamente.';
                              $data = $this->consultarCodigoBarraPers($idPers);
                              } */
                            $msgSuccess = 'El c&oacute;digo de barras se pudo guardar correctamente.';
                        }
                    }
                    $data = $this->consultarCodigoBarraPers($idPers);
                    
                    break;
                case 'u':
                    $arrDatosCB = array('CODIGO_BARRAS_EAN13' => $codigoBarras);
                    $arrWhereCB = array('INTERNO_PERSONA' => $idPers);
                    if (!$this->cam->editar_asistencia('ASIS_CODIGOS_BARRAS', $arrDatosCB, $arrWhereCB)) {
                        $msgError = 'El c&oacute;digo de barras no se pudo actualizar correctamente. Error.';
                    } else {
                        /*$usuario = strtoupper($this->session->userdata('usuario'));
                        $maquina = gethostbyaddr($_SERVER['REMOTE_ADDR']);
                        $maquina = explode(".", $maquina);
                        $arrDatosSA = array(
                            'SEPR_NCDGO' => 3,
                            'SEAU_CTBLA' => 'RH_PERSONAS_COD_BARRAS',
                            'SEAU_CRGSTRO' => $idPers . '-' . $codigoBarras,
                            'SEAU_FFERE' => 'SYSDATE',
                            'SEAU_CUSCO' => $this->session->userdata('usuario'),
                            'SEAU_CMAQU' => $maquina[0]
                        );
                        if (!$this->cam->insertar_asistencia('SESI_AUDITORIA', $arrDatosSA)) {
                            $data["msgError"] = 'No se pudo registrar el control de auditoria.';
                        } else {
                            $data["msgSuccess"] = 'El c&oacute;digo de barras se pudo actualizar correctamente.';
                            $data = $this->consultarCodigoBarraPers($idPers);
                        }*/
                        $msgSuccess = 'El c&oacute;digo de barras se pudo actualizar correctamente.';
                    }
                    $data = $this->consultarCodigoBarraPers($idPers);
                    break;
                default:
                    $data["msgError"] = 'No se seleccion&oacute; una opci&oacute;n v&aacute;lida.';
                    break;
            }
        } else {
            $data = $this->consultarCodigoBarraPers($idPers);
        }
        
        $data["msgError"] = $data["msgSuccess"] = '';
        if (!empty($msgError)) {
            $data["msgError"] = $msgError;
        }
        if (!empty($msgSuccess)) {
            $data["msgSuccess"] = $msgSuccess;
        }
        //pr($data); exit;
        $data["view"] = "form_editar_codigo_barras";
        $this->load->view("layout", $data);
    }
    
    private function consultarCodigoBarraPers($idPers = 'x') {
        $data = array();
        $datosPers = $this->cam->buscar_personas(array('idPers' => $idPers));
        //pr($datosPers); exit;
        $data['idPers'] = $data['nume_docu'] = $data['nombres'] = '';
        $data['apellidos'] = $data['telefono'] = $data['email'] = '';
        $data['usuario'] = $data['codigoBarras'] = '' . $data['codigoBarras8'] = '';
        $data['imagenCB'] = '';
        $data['existeCB'] = 'NO';
        if (count($datosPers) > 0) {
            $data['idPers'] = $datosPers[0]['id'];
            $data['nume_docu'] = $datosPers[0]['nume_docu'];
            $data['nombres'] = $datosPers[0]['nombres'];
            $data['apellidos'] = $datosPers[0]['apellidos'];
            $data['email'] = $datosPers[0]['email'];
            $data['usuario'] = $datosPers[0]['usuario'];
            $arrCB = $this->cam->existe_codigo_barras($data['idPers']);
            if (count($arrCB) > 0) {
                $data['codigoBarras'] = $arrCB[0]['CODIGO_BARRAS_EAN13'];
                $data['existeCB'] = 'SI';
            } else {
                $lencodbarras = strlen($data['nume_docu']);
                if ($lencodbarras == 7) {
                    $inicia = 0;
                } else if ($lencodbarras == 8) {
                    $inicia = 1;
                } else if ($lencodbarras == 10) {
                    $inicia = 3;
                }
                for ($i = $inicia; $i < $lencodbarras; $i++) {
                    $data['codigoBarras8'] .= $data['nume_docu'][$i];
                }
                // oagarzond - Se genera el codigo de barras uniendo el numero de interno_persona invertido 
                // con el numero de identificacion, creando un numero de longitud fija de 12 digitos - 2016-06-10
                $lean13 = 12 - intval(strlen($data['idPers']));
                $lnd = intval(strlen($data['nume_docu']));
                if($lean13 > $lnd) {
                    $lfcb = intval($lean13 - $lnd);
                    if($lfcb == 1) {
                        $inirnd = 1;
                        $finrnd = 9;
                    } else if($lfcb > 1) {
                        $inirnd = '1';
                        $finrnd = '';
                        for ($i = 0; $i < $lfcb; $i++) {
                            $inirnd .= '0';
                            $finrnd .= '9';
                        }
                        $inirnd = intval(substr($inirnd, 0, -1));
                        $finrnd = intval($finrnd);
                    }
                    $data['codigoBarras'] = strrev($data['idPers'])  . $data['nume_docu'] . rand($inirnd, $finrnd);
                } else if($lean13 == $lnd) {
                    $data['codigoBarras'] = strrev($data['idPers'])  . $data['nume_docu'];
                } else {
                    $data['codigoBarras'] = strrev($data['idPers'])  . (substr($data['nume_docu'], $lnd - $lean13, $lnd));
                }
            }
        }
        
        if (!empty($data['codigoBarras'])) {
            $imagenCB = $this->barcode->generar_barcode_ean13($data['codigoBarras']);
            if (!empty($imagenCB)) {
                $data['imagenCB'] = $imagenCB['url'];
            }
        }
        //pr($data); exit;
        return $data;
    }

    public function descargarCodigoBarras() {
        $postt = $this->input->post();
        if (!empty($postt) && count($postt) > 0) {
            foreach ($postt as $nombre_campo => $valor) {
                if (!is_array($postt[$nombre_campo])) {
                    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
                    eval($asignacion);
                }
            }
        }
        
        if ($this->uri->segment(3) != false) {
            if ($this->uri->segment(3) == 'x') {
                redirect(base_url('gh_asistencia/editarCodigoBarras'));
            } else {
                $arrCB[] = $this->uri->segment(3);
            }
        }
        
        if (!empty($codigoBarrasSele) && strlen($codigoBarrasSele) > 0) {
            $arrCB = explode(',', $codigoBarrasSele);
        }
        //pr($arrCB); exit;
        if(count($arrCB) == 0) {
            redirect(base_url('gh_asistencia/editarCodigoBarras'));
        }
        
        
        $this->load->model('consultas_asistencias_model', 'cam');
        $this->load->library('html2pdf');
        $this->load->library('barcode');
        
        //importante el slash del final o no funcionará correctamente
        $this->html2pdf->folder(base_dir('tmp/'));
        
        $this->html2pdf->paper('a4', 'landscape');
        $this->html2pdf->filename('error.pdf');
        $data['titulo'] = 'Codigo de barras';
        $data['CB'] = array();
        $idCB = 0;
        foreach ($arrCB as $kCB => $vCB) {
            $data['CB'][$kCB]['nombre'] = $data['CB'][$kCB]['codigoBarras'] = $data['CB'][$kCB]['imagenCB'] = '';
            $arrPers = $this->cam->consultar_codigo_barras($arrCB[$kCB]);
            //pr($arrPers); exit;
            if (count($arrPers) > 0) {
                if(!empty($arrPers[0]["CODIGO_BARRAS_EAN13"])) {
                    $idCB = $arrPers[0]["CODIGO_BARRAS_EAN13"];
                } else {
                    show_error('No se encontró un código de barras válido. Por favor revise si las personas seleccionadas existe el código de barras.', 500, 'Un error ha sido encontrado');
                }
                $this->html2pdf->filename($idCB . '.pdf');
                $data['CB'][$kCB]['codigoBarras'] = $idCB;
                $data['CB'][$kCB]['nombre'] = '';
                if (strlen($arrPers[0]["PRIMER_APELLIDO"]) > 0) {
                    $data['CB'][$kCB]['nombre'] .= ' ' . $arrPers[0]["PRIMER_APELLIDO"];
                }
                if (strlen($arrPers[0]["SEGUNDO_APELLIDO"]) > 0) {
                    $data['CB'][$kCB]['nombre'] .= ' ' . $arrPers[0]["SEGUNDO_APELLIDO"];
                }
                $data['CB'][$kCB]['nombre'] .= '<br>' . $arrPers[0]["NOMBRES"];
                
                // Se genera la imagen de cosigo de barras
                $imagenCB = $this->barcode->generar_barcode_ean13($idCB);
                if (!empty($imagenCB)) {
                    $data['CB'][$kCB]['imagenCB'] = $imagenCB['dir'];
                }
            }
        }
        
        if(count($data['CB']) > 1 && count($data['CB']) % 4 != 0) {
            $totalCB = count($data['CB']);
            $comp = $totalCB % 4;
            if($comp == 1) {
                $data['CB'][$totalCB]['nombre'] = $data['CB'][$totalCB]['codigoBarras'] = $data['CB'][$totalCB]['imagenCB'] = '';
                $data['CB'][$totalCB + 1]['nombre'] = $data['CB'][$totalCB + 1]['codigoBarras'] = $data['CB'][$totalCB + 1]['imagenCB'] = '';
                $data['CB'][$totalCB + 2]['nombre'] = $data['CB'][$totalCB + 2]['codigoBarras'] = $data['CB'][$totalCB + 2]['imagenCB'] = '';
            } else if($comp == 2) {
                $data['CB'][$totalCB]['nombre'] = $data['CB'][$totalCB]['codigoBarras'] = $data['CB'][$totalCB]['imagenCB'] = '';
                $data['CB'][$totalCB + 1]['nombre'] = $data['CB'][$totalCB + 1]['codigoBarras'] = $data['CB'][$totalCB + 1]['imagenCB'] = '';
            } else if($comp == 3) {
                $data['CB'][$totalCB]['nombre'] = $data['CB'][$totalCB]['codigoBarras'] = $data['CB'][$totalCB]['imagenCB'] = '';
            }
        }
        
        if ($idCB > 0) {
            //$html = utf8_decode($this->load->view('barcode_pdf', $data, true));
            //echo $html; exit;
            $this->html2pdf->html(utf8_decode($this->load->view('barcode_pdf', $data, true)));
            //si el pdf se guarda correctamente lo mostramos en pantalla
            //pr(base_dir('tmp/')); exit;
            if ($this->html2pdf->create('save')) {
                $this->html2pdf->show();
            }
        } else {
            show_error('No se encontró un código de barras válido.', 500, 'Un error ha sido encontrado');
        }
    }
    
    public function descargarCodigoBarras8() {
        $postt = $this->input->post();
        if (!empty($postt) && count($postt) > 0) {
            foreach ($postt as $nombre_campo => $valor) {
                if (!is_array($postt[$nombre_campo])) {
                    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
                    eval($asignacion);
                }
            }
        }
        
        if ($this->uri->segment(3) != false) {
            if ($this->uri->segment(3) == 'x') {
                redirect(base_url('gh_asistencia/editarCodigoBarras'));
            } else {
                $arrCB[] = $this->uri->segment(3);
            }
        }
        
        if (!empty($codigoBarrasSele) && strlen($codigoBarrasSele) > 0) {
            $arrCB = explode(',', $codigoBarrasSele);
        }
        //pr($arrCB); exit;
        if(count($arrCB) == 0) {
            redirect(base_url('gh_asistencia/editarCodigoBarras'));
        }
        
        
        $this->load->model('consultas_asistencias_model', 'cam');
        $this->load->library('html2pdf');
        $this->load->library('barcode');
        
        //importante el slash del final o no funcionará correctamente
        $this->html2pdf->folder(base_dir('tmp/'));
        
        $this->html2pdf->paper('a4', 'landscape');
        $this->html2pdf->filename('error.pdf');
        $data['titulo'] = 'Codigo de barras';
        $data['CB'] = array();
        $idCB = 0;
        foreach ($arrCB as $kCB => $vCB) {
            $data['CB'][$kCB]['nombre'] = $data['CB'][$kCB]['codigoBarras'] = $data['CB'][$kCB]['imagenCB'] = '';
            $arrPers = $this->cam->consultar_codigo_barras($arrCB[$kCB]);
            //pr($arrPers); exit;
            if (count($arrPers) > 0) {
                if(!empty($arrPers[0]["CODIGO_BARRAS_EAN8"])) {
                    $idCB = $arrPers[0]["CODIGO_BARRAS_EAN8"];
                } else {
                    show_error('No se encontró un código de barras válido. Por favor revise si las personas seleccionadas existe el código de barras.', 500, 'Un error ha sido encontrado');
                }                
                $this->html2pdf->filename($idCB . '.pdf');
                $data['CB'][$kCB]['codigoBarras'] = $idCB;
                $data['CB'][$kCB]['nombre'] = '';
                if (strlen($arrPers[0]["PRIMER_APELLIDO"]) > 0) {
                    $data['CB'][$kCB]['nombre'] .= ' ' . $arrPers[0]["PRIMER_APELLIDO"];
                }
                if (strlen($arrPers[0]["SEGUNDO_APELLIDO"]) > 0) {
                    $data['CB'][$kCB]['nombre'] .= ' ' . $arrPers[0]["SEGUNDO_APELLIDO"];
                }
                $data['CB'][$kCB]['nombre'] .= '<br>' . $arrPers[0]["NOMBRES"];
                
                // Se genera la imagen de cosigo de barras
                $imagenCB = $this->barcode->generar_barcode_ean8($idCB);
                if (!empty($imagenCB)) {
                    $data['CB'][$kCB]['imagenCB'] = $imagenCB['dir'];
                }
            }
        }
        
        if(count($data['CB']) > 1 && count($data['CB']) % 4 != 0) {
            $totalCB = count($data['CB']);
            $comp = $totalCB % 4;
            if($comp == 1) {
                $data['CB'][$totalCB]['nombre'] = $data['CB'][$totalCB]['codigoBarras'] = $data['CB'][$totalCB]['imagenCB'] = '';
                $data['CB'][$totalCB + 1]['nombre'] = $data['CB'][$totalCB + 1]['codigoBarras'] = $data['CB'][$totalCB + 1]['imagenCB'] = '';
                $data['CB'][$totalCB + 2]['nombre'] = $data['CB'][$totalCB + 2]['codigoBarras'] = $data['CB'][$totalCB + 2]['imagenCB'] = '';
            } else if($comp == 2) {
                $data['CB'][$totalCB]['nombre'] = $data['CB'][$totalCB]['codigoBarras'] = $data['CB'][$totalCB]['imagenCB'] = '';
                $data['CB'][$totalCB + 1]['nombre'] = $data['CB'][$totalCB + 1]['codigoBarras'] = $data['CB'][$totalCB + 1]['imagenCB'] = '';
            } else if($comp == 3) {
                $data['CB'][$totalCB]['nombre'] = $data['CB'][$totalCB]['codigoBarras'] = $data['CB'][$totalCB]['imagenCB'] = '';
            }
        }
        
        if ($idCB > 0) {
            //$html = utf8_decode($this->load->view('barcode_pdf', $data, true));
            //echo $html; exit;
            $this->html2pdf->html(utf8_decode($this->load->view('barcode_pdf', $data, true)));
            //si el pdf se guarda correctamente lo mostramos en pantalla
            //pr(base_dir('tmp/')); exit;
            if ($this->html2pdf->create('save')) {
                $this->html2pdf->show();
            }
        } else {
            show_error('No se encontró un código de barras válido.', 500, 'Un error ha sido encontrado');
        }
    }
    
    /**
     * Busca el nombre del funcionario
     * @since 2015-08-06
     */
    public function buscarFuncionario() {
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
        $this->load->model('consultas_asistencias_model', 'cam');
        $data = array();
        $html = '';
        $cedula = $this->input->post("cedula");
        $regreso = $this->input->post("regreso"); //viene para indicar a donde debe volver
        $data = $this->cam->consultar_usuario(array('numeDocu' => $cedula));
        if (count($data) > 0) {
            $html = '<div class="col-md-4">';
            $html .= '<label for="txtNombres">' . $data['nombre'] . '</label>';
            $html .= '</div>';
            $html .= '<div class="col-md-4">';
            $html .= '<input type="text" name="txtCodiBarras" id="txtCodiBarras" value="" class="form-control" placeholder="Código de barras" required />';
            $html .= '</div>';
            $html .= '<div class="col-md-4">';
            $html .= '<input type="button" name="btnAgregar" id="btnAgregar" value="Agregar código de barra" class="btn btn-success" />';
            $html .= '</div>';
            echo $html;
        } else {
            $html = '<br/><label for="txtNombres">El usuario no existe.</label>';
        }
    }

    /**
     * Muestra el formulario del reporte general
     * @author oagarzond
     * @since  2016-05-05
     */
    public function reporteGeneral() {
        //pr($this->session->all_userdata()); exit;
        $this->load->model('consultas_generales', 'cg');
        $this->load->model('consultas_asistencias_model', 'cam');
        
        $data["msgError"] = $data["msgSuccess"] = '';
        $fechahoraactual = $this->cam->consultar_fecha_hora();
        //$fechHasta = date("Y-m-d");
        $fechHasta = substr($fechahoraactual, 0, 10);
        //$unixMark = strtotime("-1 day", strtotime($fechHasta));
        //$data['fecha_ini'] = date("d/m/Y", $unixMark);
        $data['fecha_ini'] = $fechHasta;
        $data['fecha_fin'] = $fechHasta;
        $data["arrDespacho"] = $this->cg->get_despacho();
        //$data['codi_desp'] = 1;
        //$data["arrDepe"] = $this->cg->get_dependencia_by_id($data['codi_desp']);
        $data['codi_depe'] = ''; //13 - Sistemas
        $data['cedula'] = $this->session->userdata('num_ident');
        $data['view'] = 'lista_consulta_asistencia';
        //pr($data); exit;
        $this->load->view('layout', $data);
    }

    public function consultarGruposDepes($codi_depe = '') {
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
        $this->load->model('consultas_asistencias_model', 'cam');

        $html = '<select class="form-control" id="tipoGrupo" name="tipoGrupo">';
        $html .= '<option value="">Seleccione</option>';
        if (!empty($codi_depe)) {
            $arrGrupo = $this->cam->consultar_grupos_dependencias($codi_depe);
            if (count($arrGrupo) > 0) {
                foreach ($arrGrupo AS $ig => $vg) {
                    $html .= '<option value="' . $vg['GRUP_NCDGO'] . '">' . $vg['GRUP_CDSCRPCION'] . '</option>';
                }
            }
        }
        $html .= '</select>';
        echo $html;
    }

    /**
     * Muestra los datos de la consulta general
     * @author oagarzond
     * @since  2016-05-05
     */
    public function buscarAsistencias() {
        $this->load->model('consultas_asistencias_model', 'cam');
        
        $gett = $this->input->get();
        if (!empty($gett) && count($gett) > 0) {
            foreach ($gett as $nombre_campo => $valor) {
                if (!is_array($gett[$nombre_campo])) {
                    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
                    eval($asignacion);
                }
            }
        }
        
        $postt = $this->input->post();
        if (!empty($postt) && count($postt) > 0) {
            foreach ($postt as $nombre_campo => $valor) {
                if (!is_array($postt[$nombre_campo])) {
                    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
                    eval($asignacion);
                }
            }
        }
        
        $config["per_page"] = ($rows > 0) ? $rows: 100;
        $start = ($page > 0) ? (($config["per_page"] * $page) - $config["per_page"]): 0;
        $sidx = "TO_DATE(FECHA), Z.ID_PERSONA";
        $sord = (strlen($sord))? "DESC": "DESC";
        
        $i = 3;
        $tgracia = 10;
        $arrParam = $arrParam2 = $arrParam3 = $datosAsis = array();
        $responce = $datosPers = $idenPers = array();
        
        for ($i = 3; $i < 50; $i++) {
            $valor = $this->uri->segment($i);
            if ($i == 3 && !empty($valor) && $valor != "-") {
                $arrParam["fechaDesde"] = urldecode(formatear_fecha($valor));
            }
            if ($i == 4 && !empty($valor) && $valor != "-") {
                //$arrParam["fechaHasta"] = urldecode(formatear_fecha($valor));
                // Para que traiga el resultado real se debe sumar un dia mas a la fecha final
                $unixMark = strtotime("+1 day", strtotime(urldecode($valor)));
                $arrParam["fechaHasta"] = date("d/m/Y", $unixMark);
            }
            if ($i == 5 && !empty($valor) && ($valor != "-" && $valor != "0")) {
                $arrParam["despacho"] = urldecode($valor);
            }
            if ($i == 6 && !empty($valor) && ($valor != "-" && $valor != "0")) {
                $arrParam["depen"] = urldecode($valor);
                unset($arrParam["despacho"]);
            }
            if ($i == 7 && !empty($valor) && ($valor != "-" && $valor != "0")) {
                $arrParam["grupo"] = urldecode($valor);
                unset($arrParam["despacho"], $arrParam["depen"]);
            }
            if ($i == 8 && !empty($valor) && $valor != "-") {
                $arrParam["txtDocu"] = urldecode($valor);
            }
            if ($i == 9 && !empty($valor) && $valor != "-") {
                $arrParam["txtNombres"] = strtoupper(urldecode($valor));
            }
            if ($i == 10 && !empty($valor) && $valor != "-") {
                $arrParam["txtApellidos"] = strtoupper(urldecode($valor));
            }
        }
        //$arrParam["idPers"] = 452;
        //unset($arrParam["despacho"], $arrParam["depen"]);
        //pr($arrParam); exit;
        $datosAsis = $this->cam->buscar_asistencias($arrParam);
        //pr($datosAsis); exit;
        if (count($datosAsis) > 0) {
            $total = count($datosAsis);
            $limit = (($config["per_page"] * $page) > $total) ? $total: ($config["per_page"] * $page);
            $arrAnios = array(intval(date('Y')) - 1, intval(date('Y')), intval(date('Y')) + 1);
            $perfetti = calcular_viernes_perfetti($arrAnios);
            
            $responce["page"] = $page;
            $responce["total"] = ceil($total / $config["per_page"]);
            $responce["records"] = $total;
            foreach ($datosAsis AS $ia => $va) {
                $HE = $HS = $TR = 0;
                $datosAsis[$ia]["RE"] = $datosAsis[$ia]["RS"] = $datosAsis[$ia]["TR"] = '';
                $datosAsis[$ia]["permiso"] = '';
                
                if (!empty($va["fecha"])) {
                    $tempFecha = explode("/", $va["fecha"]);
                    $tempHorarioE = explode(":", $va["hora_entrada"]);
                    $tempHorarioS = explode(":", $va["hora_salida"]);
                    $timestampE = mktime($tempHorarioE[0], $tempHorarioE[1] + $tgracia, 0, $tempFecha[1], $tempFecha[0], $tempFecha[2]);
                    $timestampS = mktime($tempHorarioS[0], $tempHorarioS[1], 0, $tempFecha[1], $tempFecha[0], $tempFecha[2]);
                    if (in_array(formatear_fecha($va["fecha"]), $perfetti) && $va["hora_entrada"] == '08:00') {
                        $datosAsis[$ia]["hora_entrada"] = '07:' . 30;
                        $datosAsis[$ia]["hora_salida"] = '15:' . 30;
                        $tempHorarioE = explode(":", $datosAsis[$ia]["hora_entrada"]);
                        $tempHorarioS = explode(":", $datosAsis[$ia]["hora_salida"]);
                        $timestampE = mktime(7, (30 + $tgracia), 0, $tempFecha[1], $tempFecha[0], $tempFecha[2]);
                        $timestampS = mktime(15, 30, 0, $tempFecha[1], $tempFecha[0], $tempFecha[2]);
                        if (!empty($va["HE"])) {
                            $tempHE = explode(':', $va["HE"]);
                            $timestampHE = mktime($tempHE[0], $tempHE[1], 0, $tempFecha[1], $tempFecha[0], $tempFecha[2]);
                            if($timestampHE > $timestampE) {
                                $timestampE = mktime($tempHorarioE[0], $tempHorarioE[1] + $tgracia, 0, $tempFecha[1], $tempFecha[0], $tempFecha[2]);
                                $timestampS = mktime($tempHorarioS[0], $tempHorarioS[1], 0, $tempFecha[1], $tempFecha[0], $tempFecha[2]);
                            }
                        }
                    }
                }
                
                if (empty($va["RE"])) {
                    if (!empty($va["HE"])) {
                        $tempHE = explode(':', $va["HE"]);
                        $timestampHE = mktime($tempHE[0], $tempHE[1], 0, $tempFecha[1], $tempFecha[0], $tempFecha[2]);
                        $HE = ($timestampHE - $timestampE) / 60;
                        if ($HE > 0) {
                            $HE = $HE + $tgracia;
                            $datosAsis[$ia]["RE"] = $HE;
                            $TR = $TR + $HE;
                        }
                    } else {
                        $HE = 240;
                        $datosAsis[$ia]["RE"] = $HE;
                        $TR = $TR + $HE;
                    }
                } else {
                    $TR = $TR + $va["RE"];
                }
                
                if (empty($va["RS"])) {
                    if (!empty($va["HS"])) {
                        $tempHS = explode(':', $va["HS"]);
                        $timestampHS = mktime($tempHS[0], $tempHS[1], 0, $tempFecha[1], $tempFecha[0], $tempFecha[2]);
                        $HS = ($timestampS - $timestampHS) / 60;
                        if ($HS > 0) {
                            $datosAsis[$ia]["RS"] = $HS;
                            $TR = $TR + $HS;
                        }
                    } else {
                        //$datosAsis[$ia]["HS"] = '<input type="text" id="HS|' . $va["id"] . '|' . formatear_fecha($va["fecha"]) . '" placeholder="00:00" size="5" maxlength="5" onBlur="guardarHora(this.id)" />';
                        $HS = 240;
                        $datosAsis[$ia]["RS"] = $HS;
                        $TR = $TR + $HS;
                    }
                } else {
                    $TR = $TR + $va["RS"];
                }
                
                // Se revisa si tiene permiso para el mismo dia del registro
                if(!empty($va["id_sp"])) {
                    switch ($va["id_tipo_sp"]) {
                        case '1': // Fraccion
                            if(!empty($va["hora_ini_sp"]) && !empty($va["hora_fin_sp"])) {
                                $tempFechaIni = explode("/", $va["fecha_ini_sp"]);
                                $tempHIni = explode(':', $va["hora_ini_sp"]);
                                $timestampHIni = mktime($tempHIni[0], $tempHIni[1], 0, $tempFechaIni[1], $tempFechaIni[0], $tempFechaIni[2]);
                                $tempHFin = explode(':', $va["hora_fin_sp"]);
                                $timestampHFin = mktime($tempHFin[0], $tempHFin[1], 0, $tempFechaIni[1], $tempFechaIni[0], $tempFechaIni[2]);
                                $horas_permiso = ($timestampHFin - $timestampHIni) / 60;
                            }
                            break;
                        case '2': // Un dia
                            $horas_permiso = 480;
                            break;
                        case '3': // Dos dias
                            $horas_permiso = 480;
                            break;
                        case '4': // Tres dias
                            $horas_permiso = 480;
                            break;
                        default:
                            break;
                    }
                    $datosAsis[$ia]["permiso"] = '<a href="#" id="btnAsisPermiso-' . $va["id_sp"] . '" onclick="mostrarInfoPermiso(this.id, \'' . $va["id_sp"] . '\')">' . $horas_permiso . '</a>';
                    $TR = $TR - $horas_permiso;
                }
                if($TR > 0) {
                    $datosAsis[$ia]["TR"] = '<div class="ui-jqgrid-dark-red">' . $TR . '</div>';
                }
            }
            
            // Se revisa que se va a mostrar en la grilla - 2016-05-10
            $i = 0;
            for($j = $start; $j < $limit; $j++) {
                $datosAsis[$j]["horario"] = $datosAsis[$j]["hora_entrada"] . ' - ' . $datosAsis[$j]["hora_salida"];
                $responce["rows"][$i]["id"] = $datosAsis[$j]["id"] . '-' . formatear_fecha($datosAsis[$j]["fecha"]);
                if (in_array(formatear_fecha($datosAsis[$j]["fecha"]), $perfetti)) {
                    $datosAsis[$j]["fecha"] = '<div class="ui-jqgrid-light-blue">' . $datosAsis[$j]["fecha"] . '</div>';
                } else {
                    $datosAsis[$j]["fecha"] = '<div class="ui-jqgrid-dark-green">' . $datosAsis[$j]["fecha"] . '</div>';
                }
                $responce["rows"][$i]["cell"] = array(
                    $datosAsis[$j]["nume_docu"], 
                    $datosAsis[$j]["apellidos"], 
                    $datosAsis[$j]["nombres"], 
                    $datosAsis[$j]["fecha"], 
                    $datosAsis[$j]["horario"], 
                    $datosAsis[$j]["HE"], 
                    $datosAsis[$j]["HS"], 
                    $datosAsis[$j]["RE"], 
                    $datosAsis[$j]["RS"], 
                    $datosAsis[$j]["permiso"],
                    $datosAsis[$j]["TR"]
                );
                $i++;
            }
        }
        //pr($responce); exit;
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode($responce);
    }

    /**
     * Formulario para agregar o editar el horario especial de la persona
     * @author oagarzond
     * @since  2016-05-27
     */
    public function editarHorarioFunc($idPers = 'x') {
        $this->load->model('consultas_horarios_model', 'chm');
        $this->load->model('consultas_asistencias_model', 'cam');
        
        $gett = $this->input->get();
        if (!empty($gett) && count($gett) > 0) {
            foreach ($gett as $nombre_campo => $valor) {
                if (!is_array($gett[$nombre_campo])) {
                    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
                    eval($asignacion);
                }
            }
        }
        
        $postt = $this->input->post();
        if (!empty($postt) && count($postt) > 0) {
            foreach ($postt as $nombre_campo => $valor) {
                if (!is_array($postt[$nombre_campo])) {
                    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
                    eval($asignacion);
                }
            }
        }
        $data["msgError"] = $data["msgSuccess"] = '';
        $data["nombre"] = $data["nume_docu"] = '';
        $data["idPers"] = $idPers;
        $data["horario"] = array(
            'ID_HORARIO' => 0,
            'FECHA_INI' => '',
            'FECHA_FIN' => '',
            'NUME_RESO' => '',
            'FECHA_RESOLU' => '',
            'RUTA_RESO' => '',
            'ENTRADA_L' => '',
            'SALIDA_L' => '',
            'ENTRADA_M' => '',
            'SALIDA_M' => '',
            'ENTRADA_X' => '',
            'SALIDA_X' => '',
            'ENTRADA_J' => '',
            'SALIDA_J' => '',
            'ENTRADA_V' => '',
            'SALIDA_V' => '',
            'ENTRADA_S' => '',
            'SALIDA_S' => ''
        );
        
        if ($idPers != 'x') {
            $arrParam = array('idPers' => $idPers);
            $horario = $this->chm->consultar_horario($arrParam);
            //pr($horario); exit;
            if(count($horario) > 0) {
                $data["horario"] = array_shift($horario);
            }
        }
        
        $datosPers = $this->cam->buscar_personas(array("idPers" => $idPers));
        if(count($datosPers) > 0) {
            $data["nume_docu"] = $datosPers[0]["nume_docu"];
            $data["nombre"] = $datosPers[0]["nombre"];
        }
        if (!empty($postt) && count($postt) > 0) {
            $fechahoraactual = $this->chm->consultar_fecha_hora();
            //pr($_FILES); exit;
            if ($_FILES['fileReso']['size'] > 0 && !empty($txtFechaReso)) {
                $anioReso = substr(formatear_fecha($txtFechaReso), 0, 4);
                //oagarzond - 2016-06-07 - Se debe dejar todos los permisos para la ruta donde se guarda la resolucion
                $config["upload_path"] = "./files/horarios/" . $anioReso;
                $config["overwrite"] = true;
                $config["allowed_types"] = "pdf";
                $config["max_size"] = 3072;

                $this->load->helper('form');
                $this->load->library('upload', $config);
            }
            // Se guarda el registro en la tabla
            if(!empty($idHorario)) {
                $arrWH = array(
                    "ID_HORARIO" => $idHorario
                );
                $arrDH = array(
                    "FECHA_REGISTRO" => "TO_TIMESTAMP('" . $fechahoraactual . "', 'DD/MM/YYYY HH24:MI:SS')",
                    "NUME_RESO" => intval($txtNumeroReso),
                    "FECHA_RESO" => $txtFechaReso,
                    "ESTADO" => '1',
                    "FECHA_INICIAL" => $txtFechaInicial,
                    "FECHA_FINAL" => $txtFechaFinal,
                    "ENTRADA_L" => $txtEntradaL,
                    "SALIDA_L" => $txtSalidaL,
                    "ENTRADA_M" => $txtEntradaM,
                    "SALIDA_M" => $txtSalidaM,
                    "ENTRADA_X" => $txtEntradaX,
                    "SALIDA_X" => $txtSalidaX,
                    "ENTRADA_J" => $txtEntradaJ,
                    "SALIDA_J" => $txtSalidaJ,
                    "ENTRADA_V" => $txtEntradaV,
                    "SALIDA_V" => $txtSalidaV,
                    "ENTRADA_S" => $txtEntradaS,
                    "SALIDA_S" => $txtSalidaS
                );
                
                if (!empty($_FILES['fileReso']['size'])) {
                    $_FILES['fileReso']['name'] = 'H' . $idHorario . '.pdf';
                    //$this->upload->initialize($config);
                    if (!$this->upload->do_upload('fileReso')) {
                        $data["msgError"] = 'No se pudo almacenar el archivo. Error: ' . $this->upload->display_errors('<label>','</label>');
                    } else {
                        $data["fileReso"] = array('upload_data' => $this->upload->data());
                        $arrDH['RUTA_RESO'] = $_FILES['fileReso']['name'];
                    }
                }
                if (!$this->chm->editar_horario($arrDH, $arrWH)) {
                   $data["msgError"] = 'No se pudo editar el hoarario. SQL: ' . $this->chm->get_sql()  . '.';
                } else {
                    $data["msgSuccess"] = 'Registro del horario se actualizó correctamente.';
                    $arrParam = array('idHorario' => $idHorario);
                    $horario = $this->chm->consultar_horario($arrParam);
                    //pr($horario); exit;
                    if (count($horario) > 0) {
                        $data["horario"] = array_shift($horario);
                    }
                }
            } else {
                $arrDH = array(
                    "ID_HORARIO" => 'SEQ_FORM_HORARIOS.Nextval',
                    "FK_ID_USUARIO" => '7041',
                    "INTERNO_PERSONA" => $idPers,
                    "FECHA_REGISTRO" => "TO_TIMESTAMP('" . $fechahoraactual . "', 'DD/MM/YYYY HH24:MI:SS')",
                    "NUME_RESO" => intval($txtNumeroReso),
                    "FECHA_RESO" => $txtFechaReso,
                    "ESTADO" => '1',
                    "FECHA_INICIAL" => $txtFechaInicial,
                    "FECHA_FINAL" => $txtFechaFinal,
                    "ENTRADA_L" => $txtEntradaL,
                    "SALIDA_L" => $txtSalidaL,
                    "ENTRADA_M" => $txtEntradaM,
                    "SALIDA_M" => $txtSalidaM,
                    "ENTRADA_X" => $txtEntradaX,
                    "SALIDA_X" => $txtSalidaX,
                    "ENTRADA_J" => $txtEntradaJ,
                    "SALIDA_J" => $txtSalidaJ,
                    "ENTRADA_V" => $txtEntradaV,
                    "SALIDA_V" => $txtSalidaV,
                    "ENTRADA_S" => $txtEntradaS,
                    "SALIDA_S" => $txtSalidaS
                );
                
                if (!$this->chm->insertar_horario($arrDH)) {
                   $data["msgError"] = 'No se pudo insertar el horario. SQL: ' . $this->chm->get_sql()  . '.';
                } else {
                    $data["msgSuccess"] = 'Registro del horario se guardó correctamente.';
                    $idHorario = $this->chm->obtener_ultimo_id('ASIS_FORM_HORARIOS', 'ID_HORARIO');
                    if (!empty($idHorario)) {
                        $arrParam = array('idHorario' => $idHorario);
                        $horario = $this->chm->consultar_horario($arrParam);
                        //pr($horario); exit;
                        if (count($horario) > 0) {
                            $data["horario"] = array_shift($horario);
                        }
                    }
                }
            }
            //pr($data); exit;
            $data["view"] = "form_editar_horario";
            $this->load->view("layout", $data);
        } else {
            if ($idPers == 'x') {
                redirect(base_url('gh_asistencia/editarCodigoBarras/x'));
            }
            
            //pr($data); exit;
            $data["view"] = "form_editar_horario";
            $this->load->view("layout", $data);
        }
    }
    
    public function editarListAsistencias() {
        $this->load->model('consultas_asistencias_model', 'cam');
        
        $postt = $this->input->post();
        if (!empty($postt) && count($postt) > 0) {
            foreach ($postt as $nombre_campo => $valor) {
                if (!is_array($postt[$nombre_campo])) {
                    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
                    eval($asignacion);
                }
            }
        }
        
        $data["msgError"] = $data["msgSuccess"] = '';
        
        $temp = explode('-', $id);
        $idPers = $temp[0];
        $fecha = formatear_fecha($temp[1] . '-' . $temp[2] . '-' . $temp[3]);
        if(!empty($HE)) {
            $arrDatosAsis["COAS_HORA_ENTRADA"] = '' . $HE;
        }
        if(!empty($HS)) {
            $arrDatosAsis["COAS_HORA_SALIDA"] = '' . $HS;
        }
        $arrWhereAsis = array(
            'INTERNO_PERSONA' => $idPers,
            'COAS_FECHA' => $fecha
        );
        if (!$this->cam->editar_asistencia('ASIS_FORM_CONTROL_ASISTENCIA', $arrDatosAsis, $arrWhereAsis)) {
            echo "No se pudo editar la asistencia.";
        }
    }
    
    /**
     * Corrige los ID usuario de produccion en la tabla asis_codigo_barras
     * @access Public
     * @author oagarzond
     */
    public function correccionIDUsuario() {
        $this->load->model('consultas_asistencias_model', 'cam');
        
        $arrIDs = $this->cam->consultar_id_usuarios_CB();
        //pr($arrIDs); exit;
        if(count($arrIDs) > 0) {
            foreach ($arrIDs as $kid => $vid) {
                // Si son diferentes se actualiza en asis_codigo_barras
                if(!empty($vid["FK_ID_USUARIO"]) && $vid["ID_USUARIO"] != $vid["FK_ID_USUARIO"]) {
                    $arrDatosCB = array('FK_ID_USUARIO' => $vid["ID_USUARIO"]);
                    $arrWhereCB = array('INTERNO_PERSONA' => $vid["ID_PERSONA"]);
                    if (!$this->cam->editar_asistencia('ASIS_CODIGOS_BARRAS', $arrDatosCB, $arrWhereCB)) {
                        echo 'El ID de usuario de ' . $vid["ID_PERSONA"] . ' no se pudo actualizar correctamente. Error.<br />';
                    }
                }
            }
        }
        
        $arrIDs = $this->cam->consultar_id_usuarios_CA();
        //pr($arrIDs); exit;
        if(count($arrIDs) > 0) {
            foreach ($arrIDs as $kid => $vid) {
                // Si son diferentes se actualiza en asis_codigo_barras
                if(!empty($vid["FK_ID_USUARIO"]) && $vid["ID_USUARIO"] != $vid["FK_ID_USUARIO"]) {
                    $arrDatosCB = array('FK_ID_USUARIO' => $vid["ID_USUARIO"]);
                    $arrWhereCB = array('INTERNO_PERSONA' => $vid["ID_PERSONA"]);
                    if (!$this->cam->editar_asistencia('ASIS_FORM_CONTROL_ASISTENCIA', $arrDatosCB, $arrWhereCB)) {
                        echo 'El ID de usuario de ' . $vid["ID_PERSONA"] . ' no se pudo actualizar correctamente. Error.<br />';
                    }
                }
            }
        }
    }
    
    /**
     * Consulta las personas que tienen codigo de barras para insertar el registro 
     * en la tabla de asistencia
     * @author oagarzond
     * @since  2016-06-07
     */
    public function actualizarRetardosDiario() {
        // Esto va en el crontab para que se ejecute automaticamente - 2016-06-09
        // 05 04 * * 1 /home1/home/dimpe/daneweb/ghumana/application/third_party/ejecutarTareasLunes.sh
        // 05 04 * * 1,2,3,4,5 /home1/home/dimpe/daneweb/ghumana/application/third_party/ejecutarTareasDiario.sh
        // 05 04 * * 1,2,3,4,5 /var/www/html/aplicativos/ghumana/application/third_party/ejecutarTareasDiario.sh
        $this->load->model('consultas_generales', 'cg');
        $this->load->model('consultas_asistencias_model', 'cam');
        
        $data["msgError"] = $data["msgSuccess"] = '';
        //Se calcula si hoy no es sabado, domingo o festivo
        $fechahoraactual = $this->cg->consultar_fecha_hora();
        $fechaactual = substr($fechahoraactual, 0, 10);
        if(date("w", strtotime($fechaactual)) == 1) {
            // Si la fecha actual es un lunes
            $unixMark = strtotime("-3 day", strtotime(formatear_fecha($fechaactual)));
        } else {
            $unixMark = strtotime("-1 day", strtotime(formatear_fecha($fechaactual)));
        }
        $arrParam['fechaDesde'] = date("d/m/Y", $unixMark);
        //$arrParam['fechaHasta'] = $fechaactual;
        $arrParam['fechaHasta'] = date("d/m/Y", $unixMark);
        $arrParam["idPers"] = 452;
        //pr($arrParam); exit;
        
        $datosAsis = $this->cam->buscar_asistencias($arrParam);
        //pr($datosAsis); exit;
        
        if (count($datosAsis) > 0) {
            foreach ($datosAsis AS $ia => $va) {
                $HE = $HS = $TR = 0;
                $va["REG"] = $va["RSG"] = $va["TR"] = '';
                $datosAsis[$ia]["REG"] = $datosAsis[$ia]["RSG"] = $datosAsis[$ia]["TR"] = '';
                
                if (!empty($va["fecha"])) {
                    $tempFecha = explode("/", $va["fecha"]);
                    $tempHorarioE = explode(":", $va["hora_entrada"]);
                    $tempHorarioS = explode(":", $va["hora_salida"]);
                    $timestampE = mktime($tempHorarioE[0], $tempHorarioE[1] + $tgracia, 0, $tempFecha[1], $tempFecha[0], $tempFecha[2]);
                    $timestampS = mktime($tempHorarioS[0], $tempHorarioS[1], 0, $tempFecha[1], $tempFecha[0], $tempFecha[2]);
                    if (in_array(formatear_fecha($va["fecha"]), $perfetti)) {
                        $timestampE = mktime(7, (30 + $tgracia), 0, $tempFecha[1], $tempFecha[0], $tempFecha[2]);
                        $timestampS = mktime(15, 30, 0, $tempFecha[1], $tempFecha[0], $tempFecha[2]);
                        if (!empty($va["HE"])) {
                            $tempHE = explode(':', $va["HE"]);
                            $timestampHE = mktime($tempHE[0], $tempHE[1], 0, $tempFecha[1], $tempFecha[0], $tempFecha[2]);
                            if($timestampHE > $timestampE) {
                                $timestampE = mktime($tempHorarioE[0], $tempHorarioE[1] + $tgracia, 0, $tempFecha[1], $tempFecha[0], $tempFecha[2]);
                                $timestampS = mktime($tempHorarioS[0], $tempHorarioS[1], 0, $tempFecha[1], $tempFecha[0], $tempFecha[2]);
                            }
                        }
                    }
                }

                if (!empty($va["HE"])) {
                    $tempHE = explode(':', $va["HE"]);
                    $timestampHE = mktime($tempHE[0], $tempHE[1], 0, $tempFecha[1], $tempFecha[0], $tempFecha[2]);
                    $HE = ($timestampHE - $timestampE) / 60;
                    if ($HE > 0) {
                        $HE = $HE + $tgracia;
                        $va["REG"] = $datosAsis[$ia]["REG"] = $HE;
                        $TR = $TR + $HE;
                    }
                } else {
                    $HE = 240;
                    $va["REG"] = $datosAsis[$ia]["REG"] = $HE;
                    $TR = $TR + $HE;
                }
                
                if (!empty($va["HS"])) {
                    $tempHS = explode(':', $va["HS"]);
                    $timestampHS = mktime($tempHS[0], $tempHS[1], 0, $tempFecha[1], $tempFecha[0], $tempFecha[2]);
                    $HS = ($timestampS - $timestampHS) / 60;
                    if ($HS > 0) {
                        $va["RSG"] = $datosAsis[$ia]["RSG"] = $HS;
                        $TR = $TR + $HS;
                    }
                } else {
                    $HS = 240;
                    $va["RSG"] = $datosAsis[$ia]["RSG"] = $HS;
                    $TR = $TR + $HS;
                }
                
                // Se revisa si tiene permiso para el mismo dia del registro
                if(!empty($va["id_sp"])) {
                    switch ($va["id_tipo_sp"]) {
                        case '1': // Fraccion
                            if(!empty($va["hora_ini_sp"]) && !empty($va["hora_fin_sp"])) {
                                $tempFechaIni = explode("/", $va["fecha_ini_sp"]);
                                $tempHIni = explode(':', $va["hora_ini_sp"]);
                                $timestampHIni = mktime($tempHIni[0], $tempHIni[1], 0, $tempFechaIni[1], $tempFechaIni[0], $tempFechaIni[2]);
                                $tempHFin = explode(':', $va["hora_fin_sp"]);
                                $timestampHFin = mktime($tempHFin[0], $tempHFin[1], 0, $tempFechaIni[1], $tempFechaIni[0], $tempFechaIni[2]);
                                $horas_permiso = ($timestampHFin - $timestampHIni) / 60;
                            }
                            break;
                        case '2': // Un dia
                            $horas_permiso = 480;
                            break;
                        case '3': // Dos dias
                            $horas_permiso = 480;
                            break;
                        case '4': // Tres dias
                            $horas_permiso = 480;
                            break;
                        default:
                            break;
                    }
                    $TR = $TR - $horas_permiso;
                }
                
                if($TR > 0) {
                    $datosAsis[$ia]["TR"] = $TR;
                }
                //pr($va); exit;
                // Se almacena el valor de retardo en la tabla ASIS_FORM_CONTROL_ASISTENCIA - 2016-07-11
                if (!empty($va["REG"])) {
                    if ((empty($va["RE"])) || (intval($va["RE"]) != intval($va["REG"]))) {
                        $arrDatosCA["COAS_RETARDO_ENTRADA"] = $datosAsis[$ia]["REG"];
                    }
                }
                if (!empty($va["RSG"])) {
                    if (empty($va["RS"]) || (intval($va["RS"]) != intval($va["RSG"]))) {
                        $arrDatosCA["COAS_RETARDO_SALIDA"] = $datosAsis[$ia]["RSG"];
                    }
                }
                
                if(!empty($arrDatosCA)) {
                    //@todo: probar que guarde correctamente
                    $arrWhereCA["INTERNO_PERSONA"] = $datosAsis[$ia]["id"];
                    $arrWhereCA["TO_CHAR(FECHA_REGISTRO, 'DD/MM/YYYY')"] = $datosAsis[$ia]["fecha"];
                    if (!$this->cam->editar_asistencia('ASIS_FORM_CONTROL_ASISTENCIA', $arrDatosCA, $arrWhereCA)) {
                        $msgError = 'El retardo no se pudo actualizar correctamente. Error.' . $this->cam->get_sql();
                    }
                    unset($arrDatosCA);
                }
            }
        }
    }
}
// EOC