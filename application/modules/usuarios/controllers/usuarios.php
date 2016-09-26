<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Controlador datos del Usuario
 * @author BMOTTAG
 * @since  29/04/2016
 */
class Usuarios extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->config->load("sitio");
        $this->load->library(array("danecrypt", "validarsesion"));
        $this->load->model(array("usuario_model", "consultas_generales"));
    }

    /**
     * Bienvenida
     * @author BMOTTAG
     * @since  29/04/2016
     */
    public function index() {
        $data["view"] = "usuarios";
        $this->load->view("layout", $data);
    }

    /**
     * Formularios datos usuario, mediante tabs
     * Informacion general; Informacion especifica; Imagen
     * @author BMOTTAG
     * @since  29/04/2016
     */
    public function datos($tab = '', $id = 'x', $error = '') {

        if (empty($tab)) {
            show_error('ERROR!!! - No se definio tab');
        }

        $data['msj'] = '';
        $idUser = $this->session->userdata("id");
        $data['user'] = $this->usuario_model->get_user_by_id($idUser);
        $data['infoEspecifica'] = $this->usuario_model->get_info_especifica_by_id($idUser);
        $data['error'] = $error; //se usa para mostrar los errores al cargar la imagen                
        //CARGAR LISTAS PARAMETRICAS
        $data['estadoCivil'] = $this->consultas_generales->get_consulta_basica('GH_PARAM_ESTADO_CIVIL', 'ID_ESTADO_CIVIL');
        $data['tipoSangre'] = $this->consultas_generales->get_consulta_basica('GH_PARAM_TIPO_SANGRE', 'ID_TIPO_SANGRE');
        $data["despacho"] = $this->consultas_generales->get_despacho();
        $data["dependencias"] = $this->consultas_generales->get_dependencias();
        $data["municipio"] = $this->consultas_generales->get_consulta_basica('GH_PARAM_DIVIPOLA', 'NOM_MUNICIPIO');
        $data["departamento"] = $this->consultas_generales->get_departamentos();

        //Definir que tab se debe mostrar
        $data['tab1'] = $data['tab2'] = $data['tab3'] = '';
        switch ($tab) {
            case 1:
                $data['tab1'] = "active";
                break;
            case 2:
                $data['tab2'] = "active";
                break;
            case 3:
                $data['tab3'] = "active";
                break;
            default:
                $data['tab1'] = "active";
        }
		
		$infoProgreso = $this->progresoFormulario();//calcular progreso diligenciamiento de los formularios
		$data['progreso'] = $infoProgreso['progreso'];//porcentaje para la barra de progreso
		$data['colorProgreso'] = $infoProgreso['colorProgreso'];//porcentaje para la barra de progreso

        $data["view"] = "form_usuario";
        $this->load->view("layout", $data);
    }

    /**
     * Guarda datos del formulario
     * @since 30/04/2016
     */
    public function guardaDatos() {
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

        if ($this->usuario_model->update_user()) {
            echo "-ok-";
        } else {
            echo "error";
        }
    }

    //FUNCIÓN PARA SUBIR LA IMAGEN 
    function do_upload() {
        $config['upload_path'] = './files/funcionarios/';
        $config['overwrite'] = true;
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '2000';
        $config['max_width'] = '1024';
        $config['max_height'] = '1008';
        $idUser = $this->session->userdata("id");
        $config['file_name'] = $idUser;

        $this->load->library('upload', $config);
        //SI LA IMAGEN FALLA AL SUBIR MOSTRAMOS EL ERROR EN LA VISTA 
        if (!$this->upload->do_upload()) {
            $error = $this->upload->display_errors();
            $this->datos(3, 'x', $error);
        } else {
            //EN OTRO CASO SUBIMOS LA IMAGEN, CREAMOS LA MINIATURA Y 
            //ENVÍAMOS LOS DATOS AL MODELO PARA HACER LA INSERCIÓN
            $file_info = $this->upload->data();
            //USAMOS LA FUNCIÓN create_thumbnail Y LE PASAMOS EL NOMBRE DE LA IMAGEN,
            //ASÍ YA TENEMOS LA IMAGEN REDIMENSIONADA
            $this->_create_thumbnail($file_info['file_name']);
            $data = array('upload_data' => $this->upload->data());

            $imagen = $file_info['file_name'];
            $subir = $this->usuario_model->update_image($imagen);

            $data['imagen'] = $imagen;

            redirect('usuarios/datos/1');
        }
    }

    //FUNCIÓN PARA CREAR LA MINIATURA A LA MEDIDA QUE LE DIGAMOS
    function _create_thumbnail($filename) {
        $config['image_library'] = 'gd2';
        //CARPETA EN LA QUE ESTÁ LA IMAGEN A REDIMENSIONAR
        $config['source_image'] = 'files/funcionarios/' . $filename;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        //CARPETA EN LA QUE GUARDAMOS LA MINIATURA
        $config['new_image'] = 'files/funcionarios/thumbs/';
        $config['width'] = 150;
        $config['height'] = 150;
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
    }

    /**
     * Formulario de contacto
     * @author BMOTTAG
     * @since  29/04/2016
     */
    public function contacto() {
        $data['msj'] = '';
        
        $idUser = $this->session->userdata("id");
        $data['user'] = $this->usuario_model->get_user_by_id($idUser);//cargar datos del usuario
        
        $data['contacto'] = $this->usuario_model->get_contacto();
		
		$infoProgreso = $this->progresoFormulario();//calcular progreso diligenciamiento de los formularios
		$data['progreso'] = $infoProgreso['progreso'];//porcentaje para la barra de progreso
		$data['colorProgreso'] = $infoProgreso['colorProgreso'];//porcentaje para la barra de progreso
		
        $data["view"] = "form_contacto";
        $this->load->view("layout", $data);
    }

    /**
     * Guarda datos del formulario
     * @since 30/04/2016
     */
    public function guardaContacto() {
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
        if ($this->usuario_model->add_contacto()) {
            echo "-ok-";
        } else {
            echo "error";
        }
    }

    /**
     * Formualrio de dependientes
     * @author BMOTTAG
     * @since  29/04/2016
     */
    public function dependientes($id = 'x') {
        $data['msj'] = '';
        $data['infoDependiente'] = FALSE;
        $data['btnGuardarDep'] = 'SI';
        
        $idUser = $this->session->userdata("id");
        $data['user'] = $this->usuario_model->get_user_by_id($idUser);//cargar datos del usuario
        
        $data['dependientes'] = $this->usuario_model->get_dependientes();
        
        if (!empty($data['dependientes'])) {//si hay datos registrados no debe traer el valor ninguno
            foreach ($data['dependientes'] as $valor) {
                if($valor['PARENTESCO'] == 99) {
                    $data['btnGuardarDep'] = 'NO';
                }
            }
        }
        
        if ($id != 'x') {
            $data['infoDependiente'] = $this->usuario_model->get_dependientes($id);
        }
		
		$infoProgreso = $this->progresoFormulario();//calcular progreso diligenciamiento de los formularios
		$data['progreso'] = $infoProgreso['progreso'];//porcentaje para la barra de progreso
		$data['colorProgreso'] = $infoProgreso['colorProgreso'];//porcentaje para la barra de progreso
        
        $data["view"] = "form_dependientes";
        $this->load->view("layout", $data);
    }

    /**
     * Guarda datos del formulario
     * @since 30/04/2016
     */
    public function guardaDependiente() {
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
        if ($this->usuario_model->add_dependiente()) {
            echo "-ok-";
        } else {
            echo "error";
        }
    }

    /**
     * Formualrio de Actividades
     * @author BMOTTAG
     * @since  26/05/2016
     */
    public function actividades($id = 'x') {
        $data['msj'] = '';
        $data['infoActividades'] = FALSE;
        
        $idUser = $this->session->userdata("id");
        $data['user'] = $this->usuario_model->get_user_by_id($idUser);//cargar datos del usuario
        
        $data["tipoLudica"] = $this->usuario_model->get_tipo_ludica();
        $data["ludica"] = $this->usuario_model->get_ludica();

        if ($id != 'x') {
            $data['infoActividades'] = $this->usuario_model->get_info_actividad($id);
        }
		
		$infoProgreso = $this->progresoFormulario();//calcular progreso diligenciamiento de los formularios
		$data['progreso'] = $infoProgreso['progreso'];//porcentaje para la barra de progreso
		$data['colorProgreso'] = $infoProgreso['colorProgreso'];//porcentaje para la barra de progreso

        $data["view"] = "form_actividades";
        $this->load->view("layout", $data);
    }

    /**
     * Guarda datos del formulario
     * @since 26/05/2016
     */
    public function guardaActividad() {
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
        if ($this->usuario_model->add_actividad()) {
            echo "-ok-";
        } else {
            echo "error";
        }
    }

    /**
     * Formualrio de Mascotas
     * @author BMOTTAG
     * @since  26/05/2016
     */
    public function mascotas($id = 'x') {
        $data['msj'] = '';
        $data['infoMascota'] = FALSE;
        $data['btnGuardarMasc'] = 'SI';
	
        $idUser = $this->session->userdata("id");
        $data['user'] = $this->usuario_model->get_user_by_id($idUser);//cargar datos del usuario
        
	$data['mascota'] = $this->usuario_model->get_info_mascota();
        
        if (!empty($data['mascota'])) {//si hay datos registrados no debe traer el valor ninguno
            foreach ($data['mascota'] as $valor) {
                if($valor['MASCOTA'] == 99) {
                    $data['btnGuardarMasc'] = 'NO';
                }
            }
        }
		
        if ($id != 'x') {
            $data['infoMascota'] = $this->usuario_model->get_info_mascota($id);
        }
		
		$infoProgreso = $this->progresoFormulario();//calcular progreso diligenciamiento de los formularios
		$data['progreso'] = $infoProgreso['progreso'];//porcentaje para la barra de progreso
		$data['colorProgreso'] = $infoProgreso['colorProgreso'];//porcentaje para la barra de progreso
        
        $data["view"] = "form_mascotas";
        $this->load->view("layout", $data);
    }

    /**
     * Guarda datos del formulario
     * @since 31/05/2016
     */
    public function guardaMascota() {
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
        if ($this->usuario_model->add_mascota()) {
            echo "-ok-";
        } else {
            echo "error";
        }
    }

    /**
     * Formualrio de Idiomas
     * @author BMOTTAG
     * @since  08/06/2016
     */
    public function idiomas($id = 'x') {
        $data['msj'] = '';
        $data['infoIdioma'] = FALSE;
        
        $idUser = $this->session->userdata("id");
        $data['user'] = $this->usuario_model->get_user_by_id($idUser);//cargar datos del usuario
        
        $data["idiomas"] = $this->consultas_generales->get_consulta_basica('GH_PARAM_IDIOMAS', 'IDIOMA');

        if ($id != 'x') {
            $data['infoIdioma'] = $this->usuario_model->get_info_idioma($id);
        }

		$infoProgreso = $this->progresoFormulario();//calcular progreso diligenciamiento de los formularios
		$data['progreso'] = $infoProgreso['progreso'];//porcentaje para la barra de progreso
		$data['colorProgreso'] = $infoProgreso['colorProgreso'];//porcentaje para la barra de progreso
		
        $data["view"] = "form_idiomas";
        $this->load->view("layout", $data);
    }

    /**
     * Guarda datos del formulario
     * @since 26/05/2016
     */
    public function guardaIdioma() {
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
        if ($this->usuario_model->add_idioma()) {
            echo "-ok-";
        } else {
            echo "error";
        }
    }

    /**
     * Formualrio de academica
     * @author BMOTTAG
     * @since  26/05/2016
     */
    public function academica($id = 'x') {
        $data['msj'] = '';
        $data['infoAcademica'] = FALSE;
        $data['btnGuardarAcad'] = 'SI';

        $idUser = $this->session->userdata("id");
        $data['user'] = $this->usuario_model->get_user_by_id($idUser); //cargar datos del usuario

        $data['academica'] = $this->usuario_model->get_info_academica();

        if (!empty($data['academica'])) {//si hay datos registrados no debe traer el valor ninguno
            $arrParam['filtro'] = 99;

            // Se bloquea el campo del año de graduación
            foreach ($data['academica'] as $llave => $valor) {
                $data['academica'][$llave]['anoGrad'] = 'SI';
                if($valor['GRADUADO'] == '2') {
                    $data['academica'][$llave]['anoGrad'] = 'NO';
                }
                if($valor['FK_ID_ESTUDIO'] == 99) {
                    $data['btnGuardarAcad'] = 'NO';
                }
            }
        } else {
            $arrParam = array();
        }
        $data["nivelEstudio"] = $this->usuario_model->get_lista_nivel_estudio($arrParam);
        $data["areaConocimmiento"] = $this->consultas_generales->get_consulta_basica('GH_PARAM_AREA_CONOCIMIENTO', 'AREA_CONOCIMIENTO');

        if ($id != 'x') {
            $data['infoAcademica'] = $this->usuario_model->get_info_academica($id);
        }
		
		$infoProgreso = $this->progresoFormulario();//calcular progreso diligenciamiento de los formularios
		$data['progreso'] = $infoProgreso['progreso'];//porcentaje para la barra de progreso
		$data['colorProgreso'] = $infoProgreso['colorProgreso'];//porcentaje para la barra de progreso

        $data["view"] = "form_academica";
        $this->load->view("layout", $data);
    }

    /**
     * Guarda datos del formulario
     * @since 30/04/2016
     */
    public function guardaAcademica() {
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
        if ($this->usuario_model->add_academica()) {
            echo "-ok-";
        } else {
            echo "error";
        }
    }

    /**
     * Guarda datos informacion especifica
     * @since 30/04/2016
     */
    public function guardaEspecifica() {
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
        if ($this->usuario_model->add_especifica()) {
            echo "-ok-";
        } else {
            echo "error";
        }
    }

    /**
     * Eliminar Dependiente
     */
    public function eliminarDependiente($idDependiente) {
        if ($this->usuario_model->eliminarDependiente($idDependiente)) {
            redirect('usuarios/dependientes');
        } else {
            $data['msj'] = "Problema guardando en la base de datos, solicitar soporte.";
            $data['clase'] = "alert-danger";
            $data["view"] = "form_dependientes";
            $this->load->view("layout", $data);
        }
    }

    /**
     * Eliminar info academica
     */
    public function eliminarAcademica($idAcademica) {
        if ($this->usuario_model->eliminarAcademica($idAcademica)) {
            redirect('usuarios/academica/');
        } else {
            $data['msj'] = "Problema guardando en la base de datos, solicitar soporte.";
            $data['clase'] = "alert-danger";
            $data["view"] = "form_academica";
            $this->load->view("layout", $data);
        }
    }

    /**
     * Eliminar idioma
     */
    public function eliminarIdioma($idIdioma) {
        if ($this->usuario_model->eliminarIdioma($idIdioma)) {
            redirect('usuarios/idiomas/');
        } else {
            $data['msj'] = "Problema guardando en la base de datos, solicitar soporte.";
            $data['clase'] = "alert-danger";
            $data["view"] = "form_idiomas";
            $this->load->view("layout", $data);
        }
    }

    /**
     * Eliminar actividad
     */
    public function eliminarActividad($idActividad) {
        if ($this->usuario_model->eliminarActividad($idActividad)) {
            redirect('usuarios/actividades/');
        } else {
            $data['msj'] = "Problema guardando en la base de datos, solicitar soporte.";
            $data['clase'] = "alert-danger";
            $data["view"] = "form_dependientes";
            $this->load->view("layout", $data);
        }
    }

    /**
     * Eliminar mascota
     */
    public function eliminarMascota($idMascota) {
        if ($this->usuario_model->eliminarMascota($idMascota)) {
            redirect('usuarios/mascotas/');
        } else {
            $data['msj'] = "Problema guardando en la base de datos, solicitar soporte.";
            $data['clase'] = "alert-danger";
            $data["view"] = "form_dependientes";
            $this->load->view("layout", $data);
        }
    }

    /**
     * Buscar dependencias por despacho
     * @author bmottag
     * @since  18/04/2016
     */
    public function listaDesplegable() {
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

        $identificador = $this->input->post('identificador');

        if ($lista = $this->consultas_generales->get_listaMuni_by_id($identificador)) {
            echo "<option value='-'>Seleccione...</option>";
            foreach ($lista as $fila) {
                echo "<option value='" . $fila["COD_MUNICIPIO"] . "' >" . $fila["NOM_MUNICIPIO"] . "</option>";
            }
        }
    }

    /**
     * Buscar ludicas por tipo ludico
     * @author bmottag
     * @since  26/05/2016
     */
    public function listaLudica() {
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

        $identificador = $this->input->post('identificador');

        if ($lista = $this->usuario_model->get_listaLudica_by_id($identificador)) {
            echo "<option value='-'>Seleccione...</option>";
            foreach ($lista as $fila) {
                echo "<option value='" . $fila["ID_LUDICA"] . "' >" . $fila["LUDICA"] . "</option>";
            }
            echo "<option value='99' >Otra</option>";
        }
    }

    /**
     * Lista Dependientes filtrado por usuario autenticado
     * @author bmottag
     * @since  26/05/2016
     */
    public function listaDependiente() {
        if ($data['dependientes'] = $this->usuario_model->get_dependientes()) {
            $this->load->view("lista_dependiente", $data);
        }
    }

    /**
     * Lista Actividades filtrado por usuario autenticado
     * @author bmottag
     * @since  26/05/2016
     */
    public function listaActividad() {
        if ($data['actividad'] = $this->usuario_model->get_info_actividad()) {
            $this->load->view("lista_actividad", $data);
        }
    }

    /**
     * Lista Academica filtrado por usuario autenticado
     * @author bmottag
     * @since  23/05/2016
     */
    public function listaAcademica() {
        if ($data['academica'] = $this->usuario_model->get_info_academica()) {
            $this->load->view("lista_academica", $data);
        }
    }

    /**
     * Lista Actividades filtrado por usuario autenticado
     * @author bmottag
     * @since  26/05/2016
     */
    public function listaMascota() {
        if ($data['mascota'] = $this->usuario_model->get_info_mascota()) {
            $this->load->view("lista_mascota", $data);
        }
    }

    /**
     * Lista Idioma filtrado por usuario autenticado
     * @author bmottag
     * @since  08/06/2016
     */
    public function listaIdioma() {
        if ($data['idioma'] = $this->usuario_model->get_info_idioma()) {
            $this->load->view("lista_idioma", $data);
        }
    }
	
    /**
     * Consulta porcentaje de formularios llenos
     * @author OACUBILLOSA
     * @since  26/09/2016
     */
    public function progresoFormulario() {

		$progreso = 6;//porcentaje para la barra de progreso; usuario registrado con su correo y numero de cedula

		$idUser = $this->session->userdata("id");
		$user = $this->usuario_model->get_user_by_id($idUser);
		if ($user["IMAGEN"] != '') {
			$progreso = $progreso + 2.3;//porcentaje para la barra de progreso; usuario con foto
		}
		
		$infoEspecifica = $this->usuario_model->get_info_especifica_by_id($idUser);
        if (!empty($infoEspecifica)) {
			$progreso = $progreso + 6;//porcentaje para la barra de progreso; usuario con informacion especifica
		}		
		
		$academica = $this->usuario_model->get_info_academica();
        if (!empty($academica)) {
			$progreso = $progreso + 14.3;//porcentaje para la barra de progreso; usuario con informacion academica
		}
		
		$idioma = $this->usuario_model->get_info_idioma();
        if (!empty($idioma)) {
			$progreso = $progreso + 14.3;//porcentaje para la barra de progreso; usuario con idiomas
		}
		
		$dependientes = $this->usuario_model->get_dependientes();
        if (!empty($dependientes)) {
			$progreso = $progreso + 14.3;//porcentaje para la barra de progreso; usuario con dependientes
		}
		
		$actividad = $this->usuario_model->get_info_actividad();
        if (!empty($actividad)) {
			$progreso = $progreso + 14.3;//porcentaje para la barra de progreso; usuario con actividades
		}
		
		$mascota = $this->usuario_model->get_info_mascota();
        if (!empty($mascota)) {
			$progreso = $progreso + 14.3;//porcentaje para la barra de progreso; usuario con mascotas
		}
		
		$contacto = $this->usuario_model->get_contacto();
        if (!empty($contacto)) {
			$progreso = $progreso + 14.3;//porcentaje para la barra de progreso; usuario con contacto de emergancia
		}		
		
		$colorProgreso = "progress-bar-danger";//color de la barra
		if($progreso > 45 && $progreso < 71 ){
			$colorProgreso = "progress-bar-warning";//color de la barra
		}elseif($progreso > 70){
			$colorProgreso = "progress-bar-success";//color de la barra
		}

		$arreglo = array(
			"progreso" => $progreso,
			"colorProgreso" => $colorProgreso
		);

        return $arreglo;
    }

    /**
     * Salir del módulo de usuarios y regresar a la pantalla de login
     * @author Daniel M. Díaz
     * @since  Julio 07 / 2015
     */
    public function salir() {
        $this->session->sess_destroy();
        redirect("/login/", "refresh");
    }

}
//EOC