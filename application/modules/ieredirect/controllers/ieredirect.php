<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controlador para el módulo de IERedirect
 * Se redirecciona a los usuarios que utilizan Internet Explorer a otra página para que utilicen otro tipo de navegador.
 * @since  22/09/2015	   
 * @author dmdiazf
 */
class ieredirect extends MX_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data["view"] = "ieredirect";
        $this->load->view("layout", $data);
    }
}
//EOC