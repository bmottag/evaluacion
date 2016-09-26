<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * MENU
 * @since 28/07/2015
 */
class Menu extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("menu_model");
        $this->load->model("consultas_generales");
        $this->load->model("consultas_model");
    }

    /**
     * MENU
     * @author BMOTTAG
     * @since 28/07/2015
     */
    public function index() {
        $menu = '';
        if (isset($this->session->userdata['auth'])) {
            $data["rightMenu"] = '<li><a href="' . site_url("/menu/menu/salir") . '">Salir</a></li>';
            $tema = $this->menu_model->get_tema();

            if (isset($this->session->userdata['rol_usuario']) && $this->session->userdata['rol_usuario'] == 1) {
                $nextElement = count($tema);
                $tema[$nextElement]["ID_TEMA"] = 1;
                $tema[$nextElement]["NOMBRE_TEMA"] = "ADMON";
            }
            foreach ($tema as $item):
                $menu .= '<li class="dropdown">';
                $menu .= '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">' . $item['NOMBRE_TEMA'] . ' <span class="caret"></span></a>';
                $menu .= '<ul class="dropdown-menu" role="menu">';
                //modulos para el tema
                $modulos = $this->menu_model->get_modulos($item['ID_TEMA']);
                foreach ($modulos as $list):
                    $menu .= '<li class="dropdown-header">' . $list['NOMBRE_MODULO'] . '</li>';
                    //menu para el modulo
                    $valores = $this->menu_model->get_menu($list['ID_MODULOS'], $list['FK_ID_TEMA']);
                    foreach ($valores as $value):
                        $menu .= '<li><a href="' . site_url($value['ENLACE']) . '"><span class="' . $value['IMG'] . '" aria-hidden="true"></span> ' . $value['NOMBRE_MENU'] . '</a></li>';
                        //$menu .= '<li><a href="' . site_url("menu/ruta/" . $value['ID_MENU']) . '"><span class="' . $value['IMG'] . '" aria-hidden="true"></span>&nbsp; ' . $value['NOMBRE_MENU'] . '</a></li>';
                    endforeach;
                    $menu .= '<li class="divider"></li>';
                endforeach;
                $menu .= '</ul></li>';
            endforeach;
        }
        else {
            $menu .= '<li><a href="' . base_url('gh_directorio') . '">DIRECTORIO INSTITUCIONAL</a></li>';
            $data["rightMenu"] = '<li><a href="' . base_url() . '">Ingresar</a></li>';
        }

        $data["mainMenu"] = $menu;
        $this->load->view("menu", $data);
    }

    /**
     * Adicionar/Editar ITEMS DEL MENU
     * @param varchar $Objeto: item del menu a modificar
     * @param int $idObjeto: id del item
     * @since 03/08/2015
     * @author BMOTTAG
     */
    public function editObjeto($Objeto, $idObjeto) {
        if (isset($this->session->userdata['auth'])) {
            $data['msj'] = '';
            $data['clase'] = "alert-danger";
            if ($idObjeto == 'x') {
                $data['nuevo'] = true;
            } else
                $data['nuevo'] = false;

            if ($this->input->post()) { //ADICION O EDICION SEGUN EL CASO
                if ($this->menu_model->$Objeto($idObjeto)) {
                    if ($idObjeto == 'x')
                        $data['msj'] = "Se adicionar&oacute;n los datos.";
                    else
                        $data['msj'] = "Se actualizar&oacute;n los datos.";
                    $data['clase'] = "alert-success";
                }else {
                    $data['msj'] = "Problema guardando en la base de datos, solicitar soporte.";
                    $data['clase'] = "alert-danger";
                }
            }
            switch ($Objeto) {
                case "modulos":
                    $tablaPadre = "GH_ADMIN_TEMA";
                    $ordernarPadre = "NOMBRE_TEMA";
                    $data['HIJO'] = $this->consultas_model->get_modulo($idObjeto);
                    $vista = "form_modulo";
                    break;
                case "permisos":
                    $tablaPadre = "GH_ADMIN_MODULOS";
                    $ordernarPadre = "NOMBRE_MODULO";
                    $data['HIJO'] = $this->consultas_model->get_permiso($idObjeto);
                    $vista = "form_permiso";
                    break;
                case "menu":
                    $tablaPadre = "GH_ADMIN_PERMISOS";
                    $ordernarPadre = "NOMBRE_PERMISO";
                    $data['HIJO'] = $this->consultas_model->get_menu($idObjeto);
                    $data['LISTA'] = $this->consultas_generales->get_consulta_basica("GH_ADMIN_MODULOS", "NOMBRE_MODULO");
                    $vista = "form_menu";
                    break;
            }
            $data['PADRE'] = $this->consultas_generales->get_consulta_basica($tablaPadre, $ordernarPadre);
            $data["view"] = $vista;
            $this->load->view("layout", $data);
        } else
            redirect('admin/salir');
    }

    /**
     * Formulario para actualizar permisos del usuario
     */
    public function update($userID) {
        if (isset($this->session->userdata['auth'])) {
            //$data['perfiles'] = $this->consultas_generales->get_consulta_basica('GH_ADMIN_PERMISOS', 'PERFIL', 'ESTADO', 1); 
            $data['perfiles'] = $this->consultas_model->get_permiso('x', 1);
            $data['usuario'] = '';
            $data['regreso'] = 'update'; //valor para regresar a este mismo controlador
            if ($userID != 'x') {

                $data['usuario'] = $this->consultas_generales->get_user_by_id($userID);

                if ($this->input->post()) {
                    //var_dump($this->input->post()); die();
                    if ($this->menu_model->update_permisos()) {
                        $data['text'] = "Se actualizó su información.";
                    } else
                        $data['text'] = "Problema guardando en la base de datos";
                }
            }
            $data["view"] = "form_relacion_permisos";
            $this->load->view("layout", $data);
        } else
            redirect('admin/salir');
    }

    /**
     * Busca el funcionario al cual se le va a generar la novedad .
     * @since 06/08/2015
     */
    public function buscafuncionario() {
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
        $this->load->model("consultas_model");
        $data = array();
        $cedula = $this->input->post("cedula");
        $regreso = $this->input->post("regreso"); //viene para indicar a donde debe volver
        $data = $this->consultas_model->existeusuarioGH($cedula);
        //pr($data); exit;
        if ($data == false) {
            echo "<label for='txtNombres'>El usuario no existe</label>";
        } else {
            echo '<div class="col-md-6">';
            echo "<label for='txtNombres'>Nombre del funcionario </label>";
            echo "<input type='text' id='txtNombres' name='txtNombres' value='" . $data['nombres'] . "' class='form-control' placeholder='Nombre' disabled='disabled' required autofocus />";
            echo '</div><div class="col-md-6">';
            $enlace = site_url() . 'menu/' . $regreso . '/' . $data['idUser'];
            echo "<br><a class='btn btn-success' href='" . $enlace . "' role='button'>Ver permisos del usuario</a>";
            echo '</div>';
        }
    }

    /**
     * Ver listados de usuarios administradores por modulo
     * @since 02/09/2015
     * @author BMOTTAG
     */
    public function listasAdministradores() {
        if (isset($this->session->userdata['auth'])) {
            $data['msj'] = '';
            $data['clase'] = "alert-danger";

            $arrParam = array();
			$data['tipoLista'] = $this->consultas_model->get_lista_permisos($arrParam);//consultar lista de permisos para el modulo			
			
            if($idPermiso = $this->input->post('tipoLista')) {
				
				$arrParam['idPermiso'] = $idPermiso;
				$data['infoPermiso'] = $this->consultas_model->get_lista_permisos($arrParam);//consultar informacion del permiso
				
                $data['lista'] = $this->consultas_model->get_lista_administradores();
                if (!$data['lista']) {
                    $data['msj'] = 'No hay usuarios en esta lista.';
                    $data['clase'] = "alert-danger";
                }
            }

            $data["view"] = 'listaAdmin';
            $this->load->view("layout", $data);
        } else
            redirect('admin/salir');
    }

    /**
     * Sale del módulo de administración y regresa al login del aplicativo
     * @since 03/08/2015
     */
    public function salir() {
        $this->session->unset_userdata("auth");
        $this->session->sess_destroy();
        redirect(base_url('login'));
    }

    /**
     * Formulario para actualizar permisos especificos del usuario 
     */
    public function updateByModulo($idModulo, $userID = 'x') {
        $data['perfiles'] = $this->consultas_model->get_permisos_by_modulo($idModulo);
        $data['usuario'] = '';
        $data['regreso'] = 'updateByModulo/' . $idModulo; //valor para regresar a este mismo controlador
        if ($userID != 'x') {
            $data['usuario'] = $this->consultas_generales->get_user_by_id($userID);
            
            if ($this->input->post()) {
                //var_dump($this->input->post()); die();
                if ($this->menu_model->update_permisos($idModulo)) {
                    $data['text'] = "Se actualizó su información.";
                } else
                    $data['text'] = "Problema guardando en la base de datos";
            }
        }
        $data["view"] = "form_relacion_permisos";
        $this->load->view("layout", $data);
    }

    /**
     * Buscar permisos por modulo
     * @author bmottag
     * @since  13/05/2016
     */
    public function listaPermiso() {
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

        $identificador = $this->input->post('identificador');

        if ($lista = $this->consultas_model->get_permisos_by_modulo($identificador)) {
            echo "<option value=''>Seleccione...</option>";
            foreach ($lista as $fila) {
                echo "<option value='" . $fila["ID_PERMISO"] . "' >" . $fila["PERFIL"] . ' - ' . $fila['NOMBRE_PERMISO'] . "</option>";
            }
        }
    }

    /**
     * Adicionar/Editar MACROPROCESOS
     * @param int $idObjeto: id del macroproceso
     * @since 16/05/2016
     * @author BMOTTAG
     */
    public function editJefes($idObjeto = '') {
        $data['msj'] = '';
        $data['clase'] = "alert-danger";


        if (empty($idObjeto)) {
            show_error('No se definio ID');
        } else {
            if ($idObjeto == 'x') {
                $data['nuevo'] = true;
            } else
                $data['nuevo'] = false;
        }





        if ($this->input->post()) { //ADICION O EDICION SEGUN EL CASO
            if ($this->evaluacion_model->oficina($idObjeto)) {
                if ($idObjeto == 'x')
                    $data['msj'] = "Se adicionar&oacute;n los datos.";
                else
                    $data['msj'] = "Se actualizar&oacute;n los datos.";
                $data['clase'] = "alert-success";
            }else {
                $data['msj'] = "Problema guardando en la base de datos, solicitar soporte.";
                $data['clase'] = "alert-danger";
            }
        }

        $data['macropoceso'] = $this->consultas_generales->get_consulta_basica("EVAL_PARAM_MACROPROCESO", "MACROPROCESO", "ID_MACROPROCESO", $idObjeto);
        $data['usuariosPlanta'] = $this->consultas_generales->get_consulta_basica("GH_ADMIN_USUARIOS", "NOM_USUARIO, APE_USUARIO", "TIPOV_USUARIO", 1);
        $data["view"] = "form_jefe";
        $this->load->view("layout", $data);
    }

    /**
     * Buscar Usuario
     * @since 16/05/2016
     * @author BMOTTAG
     */
    public function buscarUsuario($idCB = 'x') {
        $data["despacho"] = $this->consultas_generales->get_despacho();
        $data["dependencias"] = $this->consultas_generales->get_dependencias();
        $data["view"] = "lista_usuario";
        $this->load->view("layout", $data);
    }

    /**
     * Consultar para mostrar la informacion de los usuarios que tienen codigo de barras
     * @author oagarzond
     * @since  2016-05-13
     */
    public function buscarPersonas($param) {
        $this->load->model('consultas_model');

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

        $config["per_page"] = ($rows > 0) ? $rows : 100;
        $start = ($page > 0) ? (($config["per_page"] * $page) - $config["per_page"]) : 0;
        $sidx = "INTERNO_PERSONA";
        $sord = (strlen($sord)) ? "DESC" : "DESC";

        $i = 3;
        $arrParam = $datosPers = $responce = array();

        for ($i = 3; $i < 50; $i++) {
            $valor = $this->uri->segment($i);
            if ($i == 4 && !empty($valor) && ($valor != "-" && $valor != "0")) {
                $arrParam["tipoDepe"] = urldecode($valor);
            }
            if ($i == 5 && !empty($valor) && ($valor != "-" && $valor != "0")) {
                $arrParam["tipoGrupo"] = urldecode($valor);
                unset($arrParam["tipoDepe"]);
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
        //pr($arrParam); exit;
        $datosPers = $this->consultas_model->buscar_personas($arrParam);
        //pr($datosPers); exit;
        if (count($datosPers) > 0) {
            $total = count($datosPers);
            $limit = (($config["per_page"] * $page) > $total) ? $total : ($config["per_page"] * $page);
            $responce["page"] = $page;
            $responce["total"] = ceil($total / $config["per_page"]);
            $responce["records"] = $total;
            // Se revisa que se va a mostrar en la grilla - 2016-05-10
            $i = 0;
            for ($j = $start; $j < $limit; $j++) {

                $datosPers[$j]["jefe"] .= '<a href="' . base_url('menu/jefes/' . $datosPers[$j]["id"]) . '"><span class="glyphicon glyphicon-pushpin" aria-hidden="true"></span></a>';
                $datosPers[$j]["rol"] .= '<a href="' . base_url('menu/update/' . $datosPers[$j]["id"]) . '"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a>';

                $responce["rows"][$i]["id"] = $datosPers[$j]["id"];
                $responce["rows"][$i]["cell"] = array(
                    $datosPers[$j]["nume_docu"],
                    $datosPers[$j]["apellidos"],
                    $datosPers[$j]["nombres"],
                    $datosPers[$j]["email"],
                    $datosPers[$j]["usuario"],
                    $datosPers[$j]["jefe"],
                    $datosPers[$j]["rol"]
                );
                $i++;
            }
        }
        //pr($responce); exit;
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode($responce);
    }
    
    /**
     * Formualrio de asignacion de jefes
     * @author BMOTTAG
     * @since  20/06/2016
     */
    public function jefes($id) {
        $data['msj'] = '';
        $data['infoActividades'] = FALSE;
   
        $data["despacho"] = $this->consultas_generales->get_despacho();
        $data["dependencias"] = $this->consultas_generales->get_dependencias();
        $data["user"] = $this->consultas_generales->get_user_by_id($id);
        
/*
        if ($id != 'x') {
            $data['infoActividades'] = $this->usuario_model->get_info_actividad($id);
        }
*/
        $data["view"] = "form_jefe";
        $this->load->view("layout", $data);
    }
    
    /**
     * Guarda datos del formulario
     * @since 26/05/2016
     */
    public function guardaJefe() {
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
        if ($this->menu_model->add_jefe()) {
            echo "-ok-";
        } else {
            echo "error";
        }
    }
    
    /**
     * Lista de jefes registrados
     * @author bmottag
     * @since  23/05/2016
     */
    public function listaJefes(){
                if ($data['info'] = $this->consultas_generales->get_info_jefes()){
                        $this->load->view("listaJefes", $data);
                }
    }
	
    /**
     * Lista de administradores por modulo
     * @author AOCUBILLOSA
     * @since  3/09/2016
     */
    public function listasAdministradoresByModulo($idModulo) {
            $data['msj'] = '';
            $data['clase'] = "alert-danger";

            $arrParam['idModulo'] = $idModulo;
			$data['tipoLista'] = $this->consultas_model->get_lista_permisos($arrParam);//consultar lista de permisos para el modulo

            if($idPermiso = $this->input->post('tipoLista')) {
				
				$arrParam['idPermiso'] = $idPermiso;
				$data['infoPermiso'] = $this->consultas_model->get_lista_permisos($arrParam);//consultar informacion del permiso
				
				$data['lista'] = $this->consultas_model->get_lista_administradores();//lista de administradores con ese permiso
                if (!$data['lista']) {
                    $data['msj'] = 'No hay usuarios en esta lista.';
                    $data['clase'] = "alert-danger";
                }
            }

            $data["view"] = 'listaAdmin';
            $this->load->view("layout", $data);
    }
    
    
    
}
