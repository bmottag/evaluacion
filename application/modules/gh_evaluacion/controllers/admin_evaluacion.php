<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Controlador para actulizar datos parametricos del modulo de evaluacion
 * @since 12/05/2016
 * @author BMOTTAG
 */
class Admin_evaluacion extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("evaluacion_model");
        $this->load->model("consultas_eval_model");
        $this->load->model("consultas_generales");
    }

    /**
     * Adicionar/Editar OFICINA
     * @param int $id: id oficina
     * @since 16/05/2016
     * @author BMOTTAG
     */
    public function oficina($id = 'x') {
        $data['msj'] = '';
        $data['informacion'] = FALSE;

        $data["despacho"] = $this->consultas_generales->get_despacho();
        $data["dependencias"] = $this->consultas_generales->get_dependencias();

        if ($id != 'x') {
            $data['informacion'] = $this->consultas_generales->get_consulta_basica("EVAL_PARAM_OFICINA", "ID_OFICINA", "ID_OFICINA", $id);
        }

        $data["view"] = "form_param_oficina";
        $this->load->view("layout", $data);
    }

    /**
     * Guarda datos del formulario
     * @since 30/04/2016
     */
    public function guardaOficina() {
        header('Content-Type: application/json');
        $data = array();
        //VERIFICAR SI YA EXISTE ESTA DEPENDENCIA CON EL EVALUADOR MUESTRO MENSAJE QUE YA SE CREO
        $result = $this->consultas_eval_model->existeDependencia();
        if ($result) {
            $data["result"] = "error";
            $data["mensaje"] = "ERROR. La dependencia ya tiene asignado un evaluador.";
        } else {
            //VERIFICAR SI LA DEPENDENCIA TIENE JEFE ASIGNADO
            $result = $this->consultas_eval_model->existeJefe();
            if (!$result) {
                $data["result"] = "error";
                $data["mensaje"] = "ERROR. La dependencia no tiene Jefe asignado.";
            } else {
                if ($this->evaluacion_model->add_oficina()) {
                    $data["result"] = true;
                    $data["mensaje"] = "Solicitud guardada correctamente.";
                } else {
                    $data["result"] = "error";
                    $data["mensaje"] = "Error al guardar. Intente nuevamente o actualice la p\u00e1gina.";
                }
            }
        }
        echo json_encode($data);
    }

    /**
     * Lista Oficina
     * @author BMOTTAG
     * @since  09/06/2016
     */
    public function listaOficina() {
        $arrParam = array();
        if ($data['informacion'] = $this->consultas_eval_model->get_oficinas($arrParam)) {
            $this->load->view("lista_param_oficina", $data);
        }
    }

    /**
     * Adicionar/Editar MACROPROCESOS
     * @param int $id: id del macroproceso
     * @since 16/05/2016
     * @author BMOTTAG
     */
    public function macroproceso($id = 'x') {
        $data['msj'] = '';
        $data['informacion'] = FALSE;

        $data['usuariosPlanta'] = $this->consultas_eval_model->get_jefes();
        $data['area'] = $this->consultas_generales->get_consulta_basica("EVAL_PARAM_AREA", "AREA");

        if ($id != 'x') {
            $data['informacion'] = $this->consultas_generales->get_consulta_basica("EVAL_PARAM_MACROPROCESO", "MACROPROCESO", "ID_MACROPROCESO", $id);
            //pr($data); exit;
        }

        $data["view"] = "form_param_macroproceso";
        //pr($data); exit;
        $this->load->view("layout", $data);
    }

    /**
     * Guarda datos del formulario
     * @since 30/04/2016
     */
    public function guardaMacroproceso() {
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
        if ($this->evaluacion_model->add_macroproceso()) {
            echo "-ok-";
        } else {
            echo "error";
        }
    }

    /**
     * Lista Macroproceso
     * @author BMOTTAG
     * @since  09/06/2016
     */
    public function listaMacroproceso() {
        if ($data['informacion'] = $this->consultas_eval_model->get_macroproceso()) {
            $this->load->view("lista_param_macroproceso", $data);
        }
    }

    /**
     * Adicionar/Editar PILAR ESTRATEGICO
     * @param int $id: id del pilar
     * @since 16/05/2016
     * @author BMOTTAG
     */
    public function pilar($id = 'x') {
        $data['msj'] = '';
        $data['informacion'] = FALSE;

        if ($id != 'x') {
            $data['informacion'] = $this->consultas_generales->get_consulta_basica("EVAL_PARAM_PILAR", "PILAR", "ID_PILAR", $id);
        }

        $data["view"] = "form_param_pilar";
        $this->load->view("layout", $data);
    }

    /**
     * Guarda datos del formulario
     * @since 30/04/2016
     */
    public function guardaPilar() {
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
        if ($this->evaluacion_model->add_pilar()) {
            echo "-ok-";
        } else {
            echo "error";
        }
    }

    /**
     * Lista Macroproceso
     * @author BMOTTAG
     * @since  09/06/2016
     */
    public function listaPilar() {
        if ($data['informacion'] = $this->consultas_generales->get_consulta_basica("EVAL_PARAM_PILAR", "PILAR")) {
            $this->load->view("lista_param_pilar", $data);
        }
    }

    /**
     * Plantilla para generar el acuerdo
     * @since 07/07/2016
     * @author BMOTTAG
     */
    public function plantilla($id = 'x') {
        $data['peso_total'] = $this->consultas_eval_model->get_suma_peso();
        $data['acuerdoTerritorial'] = $this->consultas_eval_model->existeAcuerdo("terr"); //verificar si ya existen acuerdos para la TERRIRIAL para la vigencia actual
        $data['acuerdoDireccion'] = $this->consultas_eval_model->existeAcuerdo("dir"); //verificar si ya existen acuerdos para la DIRECCION para la vigencia actual
        $data['infoArea'] = $this->consultas_generales->get_consulta_basica("EVAL_PARAM_AREA", "ID_AREA"); //informacion area para los pesos de la TERRITORIAL

        $data["view"] = "form_param_plantilla";
        $this->load->view("layout", $data);
    }

    /**
     * Cargo modal- formulario de captura de macroproceso y tabla con datos
     * @since 08/07/2016
     */
    public function cargarModal() {
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

        $data["tipoGerente"] = $this->input->post("tipoGerente");
        $data["plantilla"] = $this->consultas_eval_model->get_plantilla($data["tipoGerente"]);
        $data['peso_total'] = $this->consultas_eval_model->get_suma_peso($data["tipoGerente"]);
        $data['macropoceso'] = $this->consultas_eval_model->get_macroproceso(); //para lista desplegable en el formulario

        $this->load->view("modal_macro_plantilla", $data);
    }

    /**
     * Guarda datos del formulario
     * @since 8/08/2016
     */
    public function guardaPlantilla() {
        header('Content-Type: application/json');
        $data = array();
        $bandera = true;

        //Verificar peso total no se pase
        //200 para DIRECCIONES TERRITORIALES(1) = 100 PARA AREA DE APOYO Y 100 PARA MISIONAL
        //100 PARA NIVEL CENTRAL(2)
        $tipoGerente = $this->input->post('hddIdParam');
        $pesoTotal = $this->consultas_eval_model->get_suma_peso($tipoGerente);

        $peso = $this->input->post('peso');
        if ($tipoGerente == 1) {
            $pesoMax = 200; //peso maximo que se puede programar ----HACER TABLA PARAMETRICA PARA ESTE DATO
        } elseif ($tipoGerente == 2) {
            $pesoMax = 100; //peso maximo que se puede programar ----HACER TABLA PARAMETRICA PARA ESTE DATO
        }
        $pesoProgramado = $pesoTotal[0]["PESO"] + $peso; //suma de peso guardado mas el nuevo peso

        if ($pesoProgramado > $pesoMax) {
            $data["result"] = "error";
            $data["mensaje"] = "No se puede asignar ese peso, sobrepasa el permitido.";
            $bandera = false;
        }

        if ($bandera) {
            //Verificar que no se adicine el mismo macroproceso
            $result = $this->consultas_eval_model->existeMacroPlantilla();

            if ($result) {
                $data["result"] = "error";
                $data["mensaje"] = "Ya se asigno este Macroproceso para esta plantilla.";
            } else {
                if ($this->evaluacion_model->add_macro_plantilla()) {
                    $data["result"] = true;
                    $data["mensaje"] = "Solicitud guardada correctamente.";
                } else {
                    $data["result"] = "error";
                    $data["mensaje"] = "Error al guardar. Intente nuevamente o actualice la p\u00e1gina.";
                }
            }
        }
        echo json_encode($data);
    }

    /**
     * Eliminar MACRO de la PLANTILLA
     */
    public function eliminarMacroPlantilla($idPlantilla) {
        $arrParam = array(
            "tabla" => "EVAL_PARAM_PLANTILLA",
            "llavePrimaria" => "ID_PLANTILLA",
            "id" => $idPlantilla
        );

        if ($this->evaluacion_model->eliminarRegistro($arrParam)) {
            $this->session->set_flashdata('retornoExito', 'Se elimino el Macroproceso');
        } else {
            $this->session->set_flashdata('retornoError', 'Error al registrar');
        }
        redirect(base_url('gh_evaluacion/admin_evaluacion/plantilla'), 'refresh');
    }

    /**
     * Usar plantilla para crear Acuerdo y asignarle los macroprocesos sugeridos
     */
    public function aplicarPlantilla($idTipoGerente) {
        //consultar las dependencias que estan creadas con su evaluador, filtradas por tipo de gerente publico
        $arrParam = array(
            "estado" => 1,
            "tipoGerente" => $idTipoGerente
        );
        $data['oficinas'] = $this->consultas_eval_model->get_oficinas($arrParam); //oficinas para el tipo de gerente publico
        $data['macroSugerido'] = $this->consultas_eval_model->get_plantilla($idTipoGerente); //macroproceso sugerido
        $data['idTipoGerente'] = $idTipoGerente;

        if ($this->evaluacion_model->add_datos_plantilla($data)) {
            $this->session->set_flashdata('retornoExito', 'Se crearon los acuerdos con los Macroprocesos sugeridos');
        } else {
            $this->session->set_flashdata('retornoError', 'Error al registrar');
        }
        redirect(base_url('gh_evaluacion/admin_evaluacion/plantilla'), 'refresh');
    }
	
	/**
	 * Buscar acuerdos
	 * @since 28/8/2016
	 */	
	public function verAcuerdo()
	{
			$data["view"] = "form_busqueda";

			if ( $this->input->post() )
			{
				$idUser = $this->session->userdata("id");
				//verificar si es el director o subdirector, 1:Director; 2:Subdirector"
				$data['codDependencia'] = $this->consultas_eval_model->get_cargo_user($idUser);

				$arrParam = array(
					"estado" => 1,
					"tipoEvaluador" => $data['codDependencia']
				);
				$data['oficinas'] = $this->consultas_eval_model->get_oficinas($arrParam); //listado oficinas

				$data["view"] = "lista_acuerdo";

			}	
			$this->load->view("layout",$data);
	}

}