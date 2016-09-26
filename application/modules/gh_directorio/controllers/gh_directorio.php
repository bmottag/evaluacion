<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controlador para Directorio
 * @author BMOTTAG
 * @since  30/07/2015
 */
class GH_Directorio extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array("consultas_model", "consultas_generales"));
        $this->load->library("pagination");
    }

    public function index() {
        /* $this->session->sess_destroy();
          $this->directorio(); */
        $data["despacho"] = $this->consultas_generales->get_despacho();
        $data["dependencias"] = $this->consultas_generales->get_dependencias();
        $data["view"] = "form_buscar";
        $this->load->view("layout", $data);
    }

    /**
     * Directorio
     * @since 30/07/2015
     * @author BMOTTAG
     */
    public function directorio() {
        $data["msj"] = '';
        $data["despacho"] = $this->consultas_generales->get_despacho();
        $data["dependencias"] = $this->consultas_generales->get_dependencias();
        $data["view"] = "directorio";

        $numUsuarios = $this->consultas_model->conteoUsuarios();
        if ($numUsuarios == 0) {
            $data["msj"] = "No hay usuarios con la busqueda seleccionada.";
        } else {
            //Configuracion del paginador
            $limit = 10;
            $config = array();
            $config["base_url"] = site_url("gh_directorio/directorio");
            $config["total_rows"] = $numUsuarios;
            $config["per_page"] = $limit;   //Cantidad de registros por pagina que debe mostrar el paginador
            $config["num_links"] = 10;  //Cantidad de links para cambiar de página que va a mostrar el paginador.
            // First Links
            $config['first_link'] = 'Primero';
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            // Last Links
            $config['last_link'] = '&Uacute;ltimo';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
            // Next Link
            $config['next_link'] = '»';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';
            // Previous Link
            $config['prev_link'] = '«';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';
            // Current Link
            $config['cur_tag_open'] = '<li class="active"><a href="#">';
            $config['cur_tag_close'] = '</a></li>';
            // Digit Link
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';

            $config["use_page_numbers"] = TRUE;
            $this->pagination->initialize($config);
            //Trabajo de paginacion
            $pagina = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1; //Si esta definido un valor por get, utilice el valor, de lo contrario utilice cero (para el primer valor a mostrar).
            $desde = $pagina != 1 ? (($pagina - 1) * $limit) + 1 : 0;
            $hasta = $pagina != 1 ? $desde + $limit - 1 : $desde + $limit;
            $data["directorio"] = $this->consultas_model->get_usuarios($desde, $hasta);

            //echo $this->db->last_query(); exit;
            $data["links"] = $this->pagination->create_links();
        }
        $this->load->view("layout", $data);
    }

    /**
     * Autocompletar nombre
     * @since 31/03/2016
     */
    function get_autocomplete() {
        header("Content-Type: text/plain; charset=utf-8");
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->consultas_model->autocomplete_nombre($q);
        }
    }

    /**
     * Autocompletar apellido
     * @since 31/03/2016
     */
    function get_autoApellido() {
        header("Content-Type: text/plain; charset=utf-8");
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->consultas_model->autocomplete_apellido($q);
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
        $lista = $this->consultas_generales->get_dependencia_by_id($identificador);
        echo "<option value='-'>Seleccione...</option>";
        if ($lista) {
            foreach ($lista as $fila) {
                echo "<option value='" . $fila["id_dependencia"] . "' >" . $fila["nom_dependencia"] . "</option>";
            }
        }
    }

    /**
     * Buscar grupo por dependencia
     * @author bmottag
     * @since  21/04/2016
     */
    public function listaGrupo() {
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

        $identificador = $this->input->post('identificador');
        echo "<option value=''>Seleccione...</option>";
        $lista = $this->consultas_generales->get_dependencia_by_id($identificador);
        if ($lista) {
            foreach ($lista as $fila) {
                echo "<option value='" . $fila["id_dependencia"] . "' >" . $fila["nom_dependencia"] . "</option>";
            }
        }
    }
}
//EOC