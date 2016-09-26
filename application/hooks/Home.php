<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home {

    private $ci;
    private $db;

    public function __construct() {
        $this->ci = & get_instance();
        !$this->ci->load->library('session') ? $this->ci->load->library('session') : false;
        !$this->ci->load->helper('url') ? $this->ci->load->helper('url') : false;
        $this->db = $this->ci->load->database("default", true);
    }

    public function check_login() {
        $error = FALSE;
        $arrModules = array("login", "gh_directorio", "ieredirect");
        if (!in_array($this->ci->uri->segment(1), $arrModules)) {
            if ($this->ci->uri->segment(1) == "menu") {
                if(($this->ci->uri->segment(2) . '/' . $this->ci->uri->segment(3)) != 'menu/salir') {
                    if (isset($this->ci->session) && $this->ci->session->userdata('id') == FALSE) {
                        $error = TRUE;
                    }
                }
            } else if ($this->ci->uri->segment(1) == "gh_asistencia") {
                $arrControllers = array($this->ci->uri->segment(1), "index", "insertarAsisDiario", "registro", "userAuth", "validaSesion");
                if ($this->ci->uri->segment(2) != FALSE && !in_array($this->ci->uri->segment(2), $arrControllers)) {
                    if (isset($this->ci->session) && $this->ci->session->userdata('id') == FALSE) {
                        $error = TRUE;
                    }
                }
            } else {
                if ($this->ci->session->userdata('id') == FALSE) {
                    $error = TRUE;
                }
            }
            
            if ($error == FALSE) {
                // oagarzond - 2016-05-25 - Se consulta si la ruta actual tiene permiso o no en el sistema
                $this->ci->load->model('menu/menu_model', 'mm');
                $ruta_validar = '';
                for ($i = 1; $i <= 5; $i++) {
                    if ($this->ci->uri->segment($i)) {
                        $ruta_validar .= ($i == 1) ? $this->ci->uri->segment($i) : '/' . $this->ci->uri->segment($i);
                    }
                }
                
                $arrParam = array('enlace' => $ruta_validar);
                $ruta_valida = $this->ci->mm->consultar_enlaces($arrParam);
                //pr($ruta_valida); exit;
                if(count($ruta_valida) > 0) {
                    // oagarzond - 2016-05-25 - Se consulta si el usuario actual tiene permiso para ver la ruta actual
                    $arrParam = array(
                        'idPers' => $this->ci->session->userdata('id'),
                        'enlace' => $ruta_validar
                    );
                    $permiso = $this->ci->mm->consultar_permisos_enlace($arrParam);
                    //pr($permiso); exit;
                    if (count($permiso) > 0) {
                        $sessionData = array('idModulo' => $permiso[0]['FK_ID_MODULOS']);
                        $this->ci->session->set_userdata($sessionData);
                    } else {
                        $error = TRUE;
                    }
                }
            }
        }
        
        if ($error) {
            if (isset($this->ci->session) && $this->ci->session->userdata('id') == FALSE) {
                $this->ci->session->unset_userdata("auth");
                $this->ci->session->sess_destroy();
            }
            redirect(site_url("/menu/menu/salir"));
        }
    }
}
//EOC