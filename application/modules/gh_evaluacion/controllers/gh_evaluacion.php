<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Controlador para actulizar datos parametricos del modulo de evaluacion
 * @since 02/06/2016
 * @author BMOTTAG
 */
class GH_Evaluacion extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("evaluacion_model");
        $this->load->model("consultas_eval_model");
        $this->load->model("consultas_generales");
    }

    /**
     * Adicionar/Editar MACROPROCESOS para uns oficina especifica
     * @since 13/06/2016
     * @author BMOTTAG
     */
    public function asignarMacro() {
        $idUser = $this->session->userdata("id");
        //verificar si es el director o subdirector, 1:Director; 2:Subdirector"
        $data['codDependencia'] = $this->consultas_eval_model->get_cargo_user($idUser);

        $arrParam = array(
            "estado" => 1,
            "tipoEvaluador" => $data['codDependencia']
        );
        $data['oficinas'] = $this->consultas_eval_model->get_oficinas($arrParam); //listado oficinas

        $data["view"] = "lista_acuerdo";
        $this->load->view("layout", $data);
    }

    /**
     * Cargo modal- formulario de captura de macroproceso y tabla con datos
     * @since 11/07/2016
     */
    public function cargarModal_macro() {
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

        $data["idOficina"] = $this->input->post("idOficina");

        $arrParam = array(
            "idOficina" => $data["idOficina"]
        );
        $data['oficinas'] = $this->consultas_eval_model->get_oficinas($arrParam); //datos oficina 

        $data['info_acuerdo'] = $this->consultas_eval_model->get_acuerdo($data["idOficina"]); //informacion del acuerdo para esta oficina

        if ($data['info_acuerdo']) {
            $arrParam["idAcuerdo"] = $data['info_acuerdo']["ID_ACUERDO"];
            $data['macroAsignado'] = $this->consultas_eval_model->get_asignacion_macro($arrParam); //informacion de los macroprocesos				
        }

        $data['macropoceso'] = $this->consultas_eval_model->get_macroproceso(); //para lista desplegable en el formulario

        $this->load->view("modal_macro", $data);
    }

    /**
     * Guardar datos del macroproceso, si no existe el acuerdo se crea de lo contrario actualiza el total programado
     */
    public function guardarMacro() {
        header('Content-Type: application/json');

        $bandera = true;

        $idOficina = $this->input->post('hddIdOficina'); //id oficina para asignar ACUERDO
        $idAcuerdo = '';
        $peso = '';
        if ($acuerdo = $this->consultas_eval_model->get_acuerdo($idOficina)) {//datos del acuerdo si existe
            $idAcuerdo = $acuerdo['ID_ACUERDO'];
        }
        //Verificar peso total no se pase
        //200 para DIRECCIONES TERRITORIALES(1) = 100 PARA AREA DE APOYO Y 100 PARA MISIONAL
        //100 PARA NIVEL CENTRAL(2)
        $tipoGerente = $this->input->post('hddIdParam');
        $pesoTotal = $this->input->post('hddIdPesoProgramado');
        $peso = $this->input->post('peso');
        if ($tipoGerente == 1) {
            $pesoMax = 200; //peso maximo que se puede programar ----HACER TABLA PARAMETRICA PARA ESTE DATO
        } elseif ($tipoGerente == 2) {
            $pesoMax = 100; //peso maximo que se puede programar ----HACER TABLA PARAMETRICA PARA ESTE DATO
        }
        $pesoProgramado = $pesoTotal + $peso; //suma de peso guardado mas el nuevo peso

        if ($pesoProgramado > $pesoMax) {
            $data["result"] = "error";
            $data["mensaje"] = "No se puede asignar ese peso, sobrepasa el permitido.";
            $bandera = false;
        }

        if ($bandera) {
            $result = false;
            //Verificar que no se adicine el mismo macroproceso
            if ($idAcuerdo != '') {
                $result = $this->consultas_eval_model->existeMacro($idAcuerdo);
            }

            if ($result) {
                $data["result"] = "error";
                $data["mensaje"] = "Ya se asigno este Macroproceso para esta plantilla.";
            } else {
                if ($idAsignarMacro = $this->evaluacion_model->add_macro($idAcuerdo, $pesoProgramado)) {
                    $data["result"] = true;
                    $data["mensaje"] = "Solicitud guardada correctamente.";
					//INICIO --- guardar datos en la tabla historico
					$infoMacro = $this->consultas_eval_model->get_macro_byID($idAsignarMacro); //info del macroproceso para saber el ID del acuerdo
					
					$arrParam = array(
						"idMensaje" => 2,  //ID = 2 -> se asigna macroproceso
						"mensaje" => "Se asignó macroproceso",
						"idAcuerdo" => $infoMacro['FK_ID_ACUERDO'],
						"idAsignarMacro" => $idAsignarMacro
					);
			
					$this->evaluacion_model->add_historico($arrParam);
					//FIN --- guardar datos en la tabla historico
                } else {
                    $data["result"] = "error";
                    $data["mensaje"] = "Error al guardar. Intente nuevamente o actualice la p\u00e1gina.";
                }
            }
        }
        echo json_encode($data);
    }

    /**
     * Eliminar ASIGNACION DE MACROPROCESO
     */
    public function eliminarMacro($idMacro) {
        //Verificar si existe datos de concertacion
        if ($this->consultas_eval_model->get_asignacion_compromiso($idMacro)) {
            $this->session->set_flashdata('retornoError', 'Error al eliminar, debe eliminar datos de concertaci&oacute;n de compromisos');
        } else {
            //actualizo peso total asignado en la tabla acuerdo
            $infoMacro = $this->consultas_eval_model->get_macro_byID($idMacro); //informacion del macroproceso	
            $pesoNuevo = $infoMacro['PESO_TOTAL'] - $infoMacro['PESO_ASIGNADO']; //calcular nuevo peso total asignado
            $this->evaluacion_model->update_acuerdo($infoMacro['FK_ID_ACUERDO'], $pesoNuevo); //actualizar datos
				
            //eliminar datos, cambiandole el estado 
            $arrParam = array(
                "tabla" => "EVAL_ASIGNAR_MACRO",
                "llavePrimaria" => "ID_ASIGNAR_MACRO",
                "id" => $idMacro,
				"campo" => "ESTADO",
				"valor" => 2
            );
			
			//cambio el estado del registro a bloqueado
            if ($this->evaluacion_model->updateRegistro($arrParam)) {
                $this->session->set_flashdata('retornoExito', 'Se elimino el macroproceso');
				//INICIO --- guardar datos en la tabla historico
				$arrParam = array(
					"idMensaje" => 3,  //ID = 3 -> se elimina macroprocesos
					"mensaje" => "Se eliminó macroproceso",
					"idAcuerdo" => $infoMacro['FK_ID_ACUERDO'],
					"idAsignarMacro" => $idMacro
				);
		
				$this->evaluacion_model->add_historico($arrParam);
				//FIN --- guardar datos en la tabla historico
            } else {
                $this->session->set_flashdata('retornoError', 'Error al eliminar');
            }
        }
        redirect(base_url('gh_evaluacion/asignarMacro'), 'refresh');
    }

    /**
     * Adicionar/Editar compromisos a un Acuerdo
     * @since 13/06/2016
     * @author BMOTTAG
     */
    public function compromiso($idAcuerdo) {
        $arrParam["idAcuerdo"] = $idAcuerdo;
        $data['macro'] = $this->consultas_eval_model->get_asignacion_macro($arrParam); //listado macroporcesos para el acuerdo
        $data['acuerdo'] = $this->consultas_eval_model->get_acuerdo_byID($idAcuerdo);
		
		//inicio datos del evaluador
        $evaluador = $data['acuerdo'][0]->EVALUADOR;
        $infoEvaluador = $this->consultas_generales->get_consulta_basica('GH_PARAM_DEPENDENCIA', 'CODIGO_DEPENDENCIA', 'CODIGO_DEPENDENCIA', $evaluador);
        $idUserEvaluador = $infoEvaluador[0]['FK_ID_USUARIO'];
        $data['usuarioEvaluador'] = $this->consultas_generales->get_user_by_id($idUserEvaluador);
        if ($evaluador == 1) {
            $data['usuarioEvaluador']['cargo'] = 'Director';
        } elseif ($evaluador == 2) {
            $data['usuarioEvaluador']['cargo'] = 'Subdirector';
        }
		//fin datos del evaluador
		
		//inicio datos del gerente publico
        $idUserJefe = $data['acuerdo'][0]->FK_ID_USUARIO;
        $data['usuarioJefe'] = $this->consultas_generales->get_user_by_id($idUserJefe);
		//fin datos del gerente publico
		
        $data["view"] = "lista_macro";
        $this->load->view("layout", $data);
    }

    /**
     * Cargo modal- formulario de captura de COMPROMISOS y tabla con datos
     * @since 12/07/2016
     */
    public function cargarModal_compromiso() {
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

        $data["idAsignarMacro"] = $this->input->post("idAsignarMacro");
        $data['macro'] = $this->consultas_eval_model->get_asignacion_macro($data); //info del macroproceso
        $data['compromisos'] = $this->consultas_eval_model->get_asignacion_compromiso($data["idAsignarMacro"]); //lista de compromisos programados

        $data['pilar'] = $this->consultas_eval_model->get_pilar(); //para lista desplegable en el formulario

        $this->load->view("modal_compromiso", $data);
    }

    /**
     * Guardar datos del compromiso
     */
    public function guardarCompromiso() {
        header('Content-Type: application/json');

        $bandera = true;

        $PesoPermitido = $this->input->post('hddPesoPermitido');
        $peso = $this->input->post('hddIdOficina');
        $abril = $this->input->post('abril') != '' ? 0 : $this->input->post('abril');
        $agosto = $this->input->post('agosto') != '' ? 0 : $this->input->post('agosto');
        $diciembre = $this->input->post('diciembre') != '' ? 0 : $this->input->post('diciembre');
        $sumaSeguimientos = $abril + $agosto + $diciembre;
        //verificar que peso asignado no sea mayor al permitido
        if ($peso > $PesoPermitido) {
            $data["result"] = "error";
            $data["mensaje"] = "ERROR. El peso supera al permitido.";
            $bandera = false;
        }
        //verificar que la suma de los seguimientos sea igual al peso asignado
        if ($sumaSeguimientos != $peso && $bandera) {
            $data["result"] = "error";
            $data["mensaje"] = "ERROR. La suma de los seguimientos deber ser igual al peso.";
            $bandera = false;
        }

        if ($bandera) {
            if ($idAsignarPilar = $this->evaluacion_model->add_compromiso()) {
                $data["result"] = true;
                $data["mensaje"] = "Solicitud guardada correctamente.";
				//INICIO --- guardar datos en la tabla historico
				$infoCompromiso = $this->consultas_eval_model->get_compromiso_byID($idAsignarPilar); //info del compromiso para saber el ID del acuerdo
					
				$arrParam = array(
					"idMensaje" => 4,  //ID = 4 -> se asigna compromisos
					"mensaje" => "Se asignó compromiso",
					"idAcuerdo" => $infoCompromiso['FK_ID_ACUERDO'],
					"idAsignarPilar" => $idAsignarPilar
				);
		
				$this->evaluacion_model->add_historico($arrParam);
				//FIN --- guardar datos en la tabla historico
            } else {
                $data["result"] = "error";
                $data["mensaje"] = "Error al guardar. Intente nuevamente o actualice la p\u00e1gina.";
            }
        }
        echo json_encode($data);
    }

    /**
     * Eliminar ASIGNACION COMPROMISO
	 * los compromisos que se les empezo a hacer seguimiento no se pueden eliminar
     */
    public function eliminarCompromiso($idAsignarPilar) {
        //Verificar si ya se empezo a hacer seguimiento a la asignacion 
        $infoCompromiso = $this->consultas_eval_model->get_compromiso_byID($idAsignarPilar);

        if (isset($infoCompromiso["SEGUIMIENTO_ABRIL"]) || isset($infoCompromiso["SEGUIMIENTO_AGOSTO"]) || isset($infoCompromiso["SEGUIMIENTO_DICIEMBRE"])) {
            $this->session->set_flashdata('retornoError', 'Error al eliminar, ya se empezo a realizar seguimiento al compromiso.');
        } else {
            //actualizar peso programado para el mracroproceso
            $pesoEliminar = $infoCompromiso["PESO_PILAR"];
            $idAsignarMacro = $infoCompromiso["ID_ASIGNAR_MACRO"];
            $infoMacro = $this->consultas_eval_model->get_macro_byID($infoCompromiso["FK_ID_ASIGNAR_MACRO"]); //informacion del macroproceso	
            $pesoProgramado = $infoMacro['PESO_PROGRAMADO'] - $pesoEliminar; //calcular nuevo peso programado
            $this->evaluacion_model->update_asignar_macro($idAsignarMacro, $pesoProgramado); //actualizar datos macroproceso
            //eliminar datos
            $arrParam = array(
                "tabla" => "EVAL_ASIGNAR_PILAR",
                "llavePrimaria" => "ID_ASIGNAR_PILAR",
                "id" => $idAsignarPilar,
				"campo" => "ESTADO",
				"valor" => 2
            );
			
			//cambio el estado del registro a bloqueado
            if ($this->evaluacion_model->updateRegistro($arrParam)) {
                $this->session->set_flashdata('retornoExito', 'Se eliminó el Compromiso');
				//INICIO --- guardar datos en la tabla historico
				$arrParam = array(
					"idMensaje" => 5,  //ID = 5 -> se elimina compromisos
					"mensaje" => "Se eliminó compromiso",
					"idAcuerdo" => $infoCompromiso['FK_ID_ACUERDO'],
					"idAsignarPilar" => $idAsignarPilar
				);
		
				$this->evaluacion_model->add_historico($arrParam);
				//FIN --- guardar datos en la tabla historico
            } else {
                $this->session->set_flashdata('retornoError', 'Error al eliminar');
            }
        }
        redirect(base_url('gh_evaluacion/compromiso/' . $infoCompromiso['FK_ID_ACUERDO']), 'refresh');
    }

    /**
     * Ver inofrmacion del Acuerdo
     * @since 13/06/2016
     * @author BMOTTAG
     */
    public function acuerdo($idAcuerdo) {
        $idUser = $this->session->userdata("id");
		//verificar si es el director o subdirector, 1:Director; 2:Subdirector para habilitar o desabilitar los botones
        $data['codDependencia'] = $this->consultas_eval_model->get_cargo_user($idUser);
		$arrParam["idAcuerdo"] = $idAcuerdo;
        $data['macro'] = $this->consultas_eval_model->get_asignacion_macro($arrParam); //listado macroporcesos para el acuerdo
        $data['acuerdo'] = $this->consultas_eval_model->get_acuerdo_byID($idAcuerdo);
        $data['completa'] = $this->consultas_eval_model->progrmacion_completa($idAcuerdo); //se verifica si se programo todo el peso del acuerdo asignado a los macroporcesos
        //pr($data['completa']); exit;
        $evaluador = $data['acuerdo'][0]->EVALUADOR;
        $infoEvaluador = $this->consultas_generales->get_consulta_basica('GH_PARAM_DEPENDENCIA', 'CODIGO_DEPENDENCIA', 'CODIGO_DEPENDENCIA', $evaluador);
        $idUserEvaluador = $infoEvaluador[0]['FK_ID_USUARIO'];
        $data['usuarioEvaluador'] = $this->consultas_generales->get_user_by_id($idUserEvaluador);
        if ($evaluador == 1) {
            $data['usuarioEvaluador']['cargo'] = 'Director';
        } elseif ($evaluador == 2) {
            $data['usuarioEvaluador']['cargo'] = 'Subdirector';
        }
        $idUserJefe = $data['acuerdo'][0]->FK_ID_USUARIO;
        $data['usuarioJefe'] = $this->consultas_generales->get_user_by_id($idUserJefe);
        
        $data["view"] = "acuerdo";
        $this->load->view("layout", $data);
    }

    /**
     * Listado de los macroprocesos a los cuales se les debe hace seguimiento el usuario que esta logueado
     * @since 21/06/2016
     * @author BMOTTAG
     */
    public function listaEvaluar() {
        $data['listaEvaluar'] = $this->consultas_eval_model->get_listado_evaluar();
        $data["view"] = "lista_evaluar";
        $this->load->view("layout", $data);
    }

    /**
     * lista de macroprocesos para un acuerdo especifico para realizar el seguimiento
     * @since 22/06/2016
     * @author BMOTTAG
     */
    public function seguimiento($idAcuerdo) {
        $data["idAcuerdo"] = $idAcuerdo;
        $data["idUsuario"] = $this->session->userdata("id");
		

        $data['macro'] = $this->consultas_eval_model->get_asignacion_macro($data); //listado macroporcesos para el acuerdo
        if ($data['macro']) {
            $data['acuerdo'] = $this->consultas_eval_model->get_acuerdo_byID($idAcuerdo);
			
			//inicio datos del evaluador
			$evaluador = $data['acuerdo'][0]->EVALUADOR;
			$infoEvaluador = $this->consultas_generales->get_consulta_basica('GH_PARAM_DEPENDENCIA', 'CODIGO_DEPENDENCIA', 'CODIGO_DEPENDENCIA', $evaluador);
			$idUserEvaluador = $infoEvaluador[0]['FK_ID_USUARIO'];
			$data['usuarioEvaluador'] = $this->consultas_generales->get_user_by_id($idUserEvaluador);
			if ($evaluador == 1) {
				$data['usuarioEvaluador']['cargo'] = 'Director';
			} elseif ($evaluador == 2) {
				$data['usuarioEvaluador']['cargo'] = 'Subdirector';
			}
			//fin datos del evaluador
			
			//inicio datos del gerente publico
			$idUserJefe = $data['acuerdo'][0]->FK_ID_USUARIO;
			$data['usuarioJefe'] = $this->consultas_generales->get_user_by_id($idUserJefe);
			//fin datos del gerente publico
			
            $data["view"] = "seguimiento";
            $this->load->view("layout", $data);
        } else {
            show_error('ERROR!!! - usted esta en el lugar equivocado');
        }
    }

    /**
     * Guardar datos del seguimiento
     */
    public function guardarSeguimiento() {
        $idAcuerdo = $this->input->post('hddIdAcuerdo');
        $periodo = $this->input->post('hddPeriodo'); //periodo al que se esta haciendo seguimiento

        if ($resultado = $this->evaluacion_model->add_seguimiento()) {
            //verificar si se termino de hacer el seguimiento de todos los compromisos para el periodo
            $arrParam = array(
                "idAcuerdo" => $idAcuerdo,
                "periodo" => $periodo
            );

            $seguimientos = $this->consultas_eval_model->existeSeguimientoCompleto($arrParam);
            if (!$seguimientos) {
                //enviar correo al director para que apruebe
                $envioCorreo = $this->mailDirector($arrParam);
            }

            $this->session->set_flashdata('retornoExito', 'Se registro el seguimiento');
			//INICIO --- guardar datos en la tabla historico
			$periodo = $this->input->post('hddPeriodo'); //periodo al que se esta haciendo seguimiento
			$idAsignarPilar = $this->input->post('hddIdAsignarPilar');
			$infoCompromiso = $this->consultas_eval_model->get_compromiso_byID($idAsignarPilar); //info del compromiso para saber el ID del acuerdo
			
			$arrParam = array(
				"idMensaje" => 6,  //ID = 6 -> se hace el seguimiento
				"mensaje" => "Se realizó seguimiento de ". $periodo,
				"idAcuerdo" => $infoCompromiso['FK_ID_ACUERDO'],
				"idAsignarPilar" => $idAsignarPilar
			);
	
			$this->evaluacion_model->add_historico($arrParam);
			//FIN --- guardar datos en la tabla historico
        } else {
            $this->session->set_flashdata('retornoError', 'Error al registrar ');
        }
        redirect(base_url('gh_evaluacion/seguimiento/' . $idAcuerdo), 'refresh');
    }

    /**
     * Cargo modal- formulario para aprobar periodo
     * @since 16/07/2016
     */
    public function cargarModal_aprobacion() {
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

        $idModal = $this->input->post("idModal");

        $parte = explode("-", $idModal);
        $data['idAsignarPilar'] = $parte[0];
        $data['periodo'] = $parte[1];

        $data["info_compromisos"] = $this->consultas_eval_model->get_compromiso_byID($data['idAsignarPilar']);
        $this->load->view("modal_aprobar", $data);
    }

    /**
     * Guardar datos de la aprobacion del seguimiento
     */
    public function guardarAprobacion() {
        header('Content-Type: application/json');

        if ($this->evaluacion_model->update_aprobacion()) {
            $data["result"] = true;
            $data["mensaje"] = "Solicitud guardada correctamente.";
            $idAcuerdo = $this->input->post('hddIdAcuerdo');
            $periodo = $this->input->post('hddPeriodo');
            //verificar si se termino de hacer la aprobacion de todos los compromisos para el periodo
            $arrParam = array(
                "idAcuerdo" => $idAcuerdo,
                "periodo" => $periodo
            );
            $aprobacion = $this->consultas_eval_model->existeAprobacionCompleto($arrParam);

            if (!$aprobacion) {
                //enviar correo al gerente publico para que revise el seguimiento
                $envioCorreo = $this->mailGerente($arrParam);
            }
            //INICIO CALIFICACION
            $idAsignarPilar = $this->input->post('hddIdAsignarPilar');
            $info_compromisos = $this->consultas_eval_model->get_compromiso_byID($idAsignarPilar); //datos del compromiso
            $info_acuerdo = $this->consultas_eval_model->get_acuerdo_byID($idAcuerdo); //datos del acuerdo

            $abril = is_null($info_compromisos['SEGUIMIENTO_ABRIL']) ? 0 : $info_compromisos['SEGUIMIENTO_ABRIL'];
            $agosto = is_null($info_compromisos['SEGUIMIENTO_AGOSTO']) ? 0 : $info_compromisos['SEGUIMIENTO_AGOSTO'];
            $diciembre = is_null($info_compromisos['SEGUIMIENTO_DICIEMBRE']) ? 0 : $info_compromisos['SEGUIMIENTO_DICIEMBRE'];
            if ($info_compromisos['APROBAR_ABRIL'] == 2) {
                $abril = $info_compromisos['SEG_EVALUADOR_ABRIL'];
            }
            if ($info_compromisos['APROBAR_AGOSTO'] == 2) {
                $agosto = $info_compromisos['SEG_EVALUADOR_AGOSTO'];
            }
            if ($info_compromisos['APROBAR_DICIEMBRE'] == 2) {
                $diciembre = $info_compromisos['SEG_EVALUADOR_DICIEMBRE'];
            }

            $calificacion = ( $abril + $agosto + $diciembre );

            if ($info_acuerdo[0]->TIPO_GERENTE_PUBLICO == 1) {//gerente publico = direcciones territoriales
                //revisar el area del macroproceso para saber el porcentaje y aplicarlo a la calificacion
                $porcentaje = $this->consultas_eval_model->get_porcentaje_area($info_compromisos['FK_ID_MACROPROCESO']);
                $calificacion = ( $abril + $agosto + $diciembre ) * $porcentaje / 100;
            }

            $arrParam = array(
                "idAsignarPilar" => $idAsignarPilar,
                "calificacion" => $calificacion
            );
            $this->evaluacion_model->update_asignar_pilar($arrParam);
            //FIN CALIFICACION
			
			//INICIO --- guardar datos en la tabla historico
			$infoCompromiso = $this->consultas_eval_model->get_compromiso_byID($idAsignarPilar); //info del compromiso para saber el ID del acuerdo

			$arrParam = array(
				"idMensaje" => 7,  //ID = 7 -> se hace aprobacion
				"mensaje" => "Se realizó arobación de ". $periodo,
				"idAcuerdo" => $infoCompromiso['FK_ID_ACUERDO'],
				"idAsignarPilar" => $idAsignarPilar
			);
	
			$this->evaluacion_model->add_historico($arrParam);
			//FIN --- guardar datos en la tabla historico
        } else {
            $data["result"] = "error";
            $data["mensaje"] = "Error al guardar. Intente nuevamente o actualice la p\u00e1gina.";
        }
        echo json_encode($data);
    }

    /**
     * Compromisos adicionales del acuerdo
     * @since 2/08/2016
     * @author AOCUBILLOSA
     */
    public function compromisosAdicionales($idAcuerdo) 
	{
		$idUser = $this->session->userdata("id");
        //verificar si es el director o subdirector, 1:Director; 2:Subdirector para habilitar o desabilitar los botones
        $data['codDependencia'] = $this->consultas_eval_model->get_cargo_user($idUser);
		
        $data['compromisos'] = $this->consultas_generales->get_consulta_basica('EVAL_PARAM_COMPROMISO', 'ID_COMPROMISO');

        $data['detalle'] = $this->consultas_eval_model->get_calificacion_compromiso($idAcuerdo); //detalle de la calificacion si existe
        if ($data['detalle']) {
            $data['compromisos'] = $data['detalle'];
        }

        $data['acuerdo'] = $this->consultas_eval_model->get_acuerdo_byID($idAcuerdo);
        $data['completa'] = $this->consultas_eval_model->progrmacion_completa($idAcuerdo); //se verifica si se programo todo el peso del acuerdo asignado a los macroporcesos

        if ($this->input->post()) {
            //guardo los datos
            if ($this->evaluacion_model->guardar_compromisos($idAcuerdo)) {
                $data['msj'] = "Se guardo su información.";
                $data['clase'] = "alert-success";
            } else {
                $data['msj'] = "Problema guardando en la base de datos, solicitar soporte.";
                $data['clase'] = "alert-danger";
            }
			//INICIO --- guardar datos en la tabla historico
			$arrParam = array(
				"idMensaje" => 8,  //ID = 8 -> se guardan los compromisos adicionales
				"mensaje" => "Se guardaron los compromisos adicionales",
				"idAcuerdo" => $idAcuerdo
			);
	
			$this->evaluacion_model->add_historico($arrParam);
			//FIN --- guardar datos en la tabla historico
            redirect('gh_evaluacion/compromisosAdicionales/' . $idAcuerdo);
        }
        
        $evaluador = $data['acuerdo'][0]->EVALUADOR;
        $infoEvaluador = $this->consultas_generales->get_consulta_basica('GH_PARAM_DEPENDENCIA', 'CODIGO_DEPENDENCIA', 'CODIGO_DEPENDENCIA', $evaluador);
        $idUserEvaluador = $infoEvaluador[0]['FK_ID_USUARIO'];
        $data['usuarioEvaluador'] = $this->consultas_generales->get_user_by_id($idUserEvaluador);
        if ($evaluador == 1) {
            $data['usuarioEvaluador']['cargo'] = 'Director';
        } elseif ($evaluador == 2) {
            $data['usuarioEvaluador']['cargo'] = 'Subdirector';
        }
        $idUserJefe = $data['acuerdo'][0]->FK_ID_USUARIO;
        $data['usuarioJefe'] = $this->consultas_generales->get_user_by_id($idUserJefe);

        $data["view"] = "form_compromisos_adicionales";
        $this->load->view("layout", $data);
    }
	
    /**
     * Ver el historial del Acuerdo
     * @since 18/09/2016
     * @author AOCUBILLOSA
     */
    public function historial($idAcuerdo) {
        $arrParam["idAcuerdo"] = $idAcuerdo;
        $data['historico'] = $this->consultas_eval_model->get_historial($arrParam); //listado historico para el acuerdo
        $data['acuerdo'] = $this->consultas_eval_model->get_acuerdo_byID($idAcuerdo);

		//inicio datos del evaluador
        $evaluador = $data['acuerdo'][0]->EVALUADOR;
        $infoEvaluador = $this->consultas_generales->get_consulta_basica('GH_PARAM_DEPENDENCIA', 'CODIGO_DEPENDENCIA', 'CODIGO_DEPENDENCIA', $evaluador);
        $idUserEvaluador = $infoEvaluador[0]['FK_ID_USUARIO'];
        $data['usuarioEvaluador'] = $this->consultas_generales->get_user_by_id($idUserEvaluador);
        if ($evaluador == 1) {
            $data['usuarioEvaluador']['cargo'] = 'Director';
        } elseif ($evaluador == 2) {
            $data['usuarioEvaluador']['cargo'] = 'Subdirector';
        }
		//fin datos del evaluador
		
		//inicio datos del gerente publico
        $idUserJefe = $data['acuerdo'][0]->FK_ID_USUARIO;
        $data['usuarioJefe'] = $this->consultas_generales->get_user_by_id($idUserJefe);
		//fin datos del gerente publico
		
        $data["view"] = "historial";
        $this->load->view("layout", $data);
    }

    /**
     * Método para descargar el PDF del ACUERDO
     * @author BMOTTAG
     * @since 24/06/2016
     */
    public function generaAcuerdoPDF($idAcuerdo) {
        date_default_timezone_set('America/Bogota');
        $this->load->library("html2pdf");
        
        $arrParam["idAcuerdo"] = $idAcuerdo;
        $data['macro'] = $this->consultas_eval_model->get_asignacion_macro($arrParam); //listado macroporcesos para el acuerdo
        $data['acuerdo'] = $this->consultas_eval_model->get_acuerdo_byID($idAcuerdo);
        
        $evaluador = $data['acuerdo'][0]->EVALUADOR;

        $infoEvaluador = $this->consultas_generales->get_consulta_basica('GH_PARAM_DEPENDENCIA', 'CODIGO_DEPENDENCIA', 'CODIGO_DEPENDENCIA', $evaluador);
        $idUserEvaluador = $infoEvaluador[0]['FK_ID_USUARIO'];
        $data['usuarioEvaluador'] = $this->consultas_generales->get_user_by_id($idUserEvaluador);
        if ($evaluador == 1) {
            $data['usuarioEvaluador']['cargo'] = 'Director';
        } elseif ($evaluador == 2) {
            $data['usuarioEvaluador']['cargo'] = 'Subdirector';
        }

        $idUserJefe = $data['acuerdo'][0]->FK_ID_USUARIO;
        $data['usuarioJefe'] = $this->consultas_generales->get_user_by_id($idUserJefe);
        
        $this->html2pdf->folder('./assets/pdfs/');
        $this->html2pdf->filename("compromisos.pdf");
        $this->html2pdf->paper('A4', 'landscape');

        $html = $this->load->view("acuerdoPDF", $data, true);
        //echo $html; exit;
        $this->html2pdf->html($html);
        $this->html2pdf->create("download");

        //header('Content-type: application/vnd.ms-excel; charset=UTF-8');
        //header("Content-Disposition: attachment; filename=compromisos.xls");
        //$this->load->view('acuerdoXLS', $data);
    }

    /**
     * Método para descargar el PDF del FORMATO DEL ACUERDO
     * @author AOCUBILLOSA
     * @since 25/07/2016
     */
    public function generaPDF($idAcuerdo) {
        date_default_timezone_set('America/Bogota');
        $this->load->library("html2pdf");

        $arrParam["idAcuerdo"] = $idAcuerdo;

        $data['imagen'] = '/home1/home/dimpe/daneweb/ghumana/images/logo_dane2.png';
        $data['acuerdo'] = $this->consultas_eval_model->get_acuerdo_byID($idAcuerdo);

        $evaluador = $data['acuerdo'][0]->EVALUADOR;

        $infoEvaluador = $this->consultas_generales->get_consulta_basica('GH_PARAM_DEPENDENCIA', 'CODIGO_DEPENDENCIA', 'CODIGO_DEPENDENCIA', $evaluador);
        $idUserEvaluador = $infoEvaluador[0]['FK_ID_USUARIO'];
        $data['usuarioEvaluador'] = $this->consultas_generales->get_user_by_id($idUserEvaluador);
        if ($evaluador == 1) {
            $data['usuarioEvaluador']['cargo'] = 'Director';
        } elseif ($evaluador == 2) {
            $data['usuarioEvaluador']['cargo'] = 'Subdirector';
        }

        $idUserJefe = $data['acuerdo'][0]->FK_ID_USUARIO;
        $data['usuarioJefe'] = $this->consultas_generales->get_user_by_id($idUserJefe);

        $this->html2pdf->folder('./assets/pdfs/');
        $this->html2pdf->filename("acuerdo.pdf");
        $this->html2pdf->paper('A4', 'portrait');

        $html = $this->load->view("acuerdoFormatoPDF", $data, true);
        //echo $html; exit;
        $this->html2pdf->html($html);
        $this->html2pdf->create("download");
    }

    /**
     * Método para descargar el PDF de los COMPROMISOS ADICIONALES
     * @author AOCUBILLOSA
     * @since 4/08/2016
     */
    public function compromisoPDF($idAcuerdo) {
        date_default_timezone_set('America/Bogota');
        $this->load->library("html2pdf");

        $arrParam["idAcuerdo"] = $idAcuerdo;

        $data['imagen'] = '/home1/home/dimpe/daneweb/ghumana/images/logo_dane2.png';
        $data['detalle'] = $this->consultas_eval_model->get_calificacion_compromiso($idAcuerdo); //detalle de la calificacion si existe
//////////////inicio BORRAR				
        $data['acuerdo'] = $this->consultas_eval_model->get_acuerdo_byID($idAcuerdo);

        $evaluador = $data['acuerdo'][0]->EVALUADOR;

        $infoEvaluador = $this->consultas_generales->get_consulta_basica('GH_PARAM_DEPENDENCIA', 'CODIGO_DEPENDENCIA', 'CODIGO_DEPENDENCIA', $evaluador);
        $idUserEvaluador = $infoEvaluador[0]['FK_ID_USUARIO'];
        $data['usuarioEvaluador'] = $this->consultas_generales->get_user_by_id($idUserEvaluador);
        if ($evaluador == 1) {
            $data['usuarioEvaluador']['cargo'] = 'Director';
        } elseif ($evaluador == 2) {
            $data['usuarioEvaluador']['cargo'] = 'Subdirector';
        }

        $idUserJefe = $data['acuerdo'][0]->FK_ID_USUARIO;
        $data['usuarioJefe'] = $this->consultas_generales->get_user_by_id($idUserJefe);
//////////////FIN BORRAR 

        $this->html2pdf->folder('./assets/pdfs/');
        $this->html2pdf->filename("adicionales.pdf");
        $this->html2pdf->paper('A4', 'portrait');

        $html = $this->load->view("acuerdoCompromisosPDF", $data, true);
        //echo $html; exit;
        $this->html2pdf->html($html);
        $this->html2pdf->create("download", "UTF-8");
    }

    /**
     * Envia correos al director para aprobar el seguimiento
     * @author BMOTTAG
     * @since  21/07/2016
     */
    public function mailDirector($arrDatos) {
        $this->load->library("email");

        $data['acuerdo'] = $this->consultas_eval_model->get_acuerdo_byID($arrDatos["idAcuerdo"]);
        $evaluador = $data['acuerdo'][0]->EVALUADOR;

        $infoEvaluador = $this->consultas_generales->get_consulta_basica('GH_PARAM_DEPENDENCIA', 'CODIGO_DEPENDENCIA', 'CODIGO_DEPENDENCIA', $evaluador);

        $idUser = $infoEvaluador[0]['FK_ID_USUARIO'];
        $data['usuario'] = $this->consultas_generales->get_user_by_id($idUser);
        $email = $data['usuario']['mail_usuario'];
        $data['msj'] = "Ingresar al Módulo de Evaluación de Gerentes Públicos y realizar la verificación del seguimiento de <strong>" . $arrDatos['periodo'] . "</strong>";
        $data['msj'].= " para la Dependencia/Territorial <strong>" . $data['acuerdo'][0]->DESCRIPCION . "</strong>.";

        $this->email->from("aplicaciones@dane.gov.co", "Módulo de Evaluación Gerentes Públicos - DANE");
        $this->email->to('aocubillosa@dane.gov.co'); //to($email);
        $this->email->subject("Seguimiento completo");
        $html = $this->load->view("email", $data, true);

        $this->email->message($html);
        $this->email->send();

        return true;
    }

    /**
     * Envia correos al gerente publico para revisar el seguimiento que le asignaron
     * @author BMOTTAG
     * @since  21/07/2016
     */
    public function mailGerente($arrDatos) {
        $this->load->library("email");

        $data['acuerdo'] = $this->consultas_eval_model->get_acuerdo_byID($arrDatos["idAcuerdo"]);

        $idUser = $data['acuerdo'][0]->FK_ID_USUARIO;
        $data['usuario'] = $this->consultas_generales->get_user_by_id($idUser);
        $email = $data['usuario']['mail_usuario'];
        $data['msj'] = "Se realizó el seguimiento de <strong>" . $arrDatos['periodo'] . "</strong>";
        $data['msj'].= " para la Dependencia/Territorial <strong>" . $data['acuerdo'][0]->DESCRIPCION . "</strong>.";
        $data['msj'].= "<p>Revisarla en el siguiente enlace:</p>";
        $data['msj'].= "<br><a href='" . base_url('gh_evaluacion/generaPDF/' . $arrDatos['idAcuerdo']) . "'>Acuerdo - " . $data['acuerdo'][0]->DESCRIPCION . "</a>";


        $this->email->from("aplicaciones@dane.gov.co", "Módulo de Evaluación Gerentes Públicos - DANE");
        $this->email->to('aocubillosa@dane.gov.co'); //to($email);
        $this->email->subject("Seguimiento completo");
        $html = $this->load->view("email", $data, true);

        $this->email->message($html);
        $this->email->send();

        return true;
    }

}