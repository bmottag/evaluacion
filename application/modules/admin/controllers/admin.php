<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	 * Controlador para el modulo de Administración
	 * @author Daniel Mauricio Díaz Forero
	 * @since  Mayo 27 / 2015
	 */

	class Admin extends MX_Controller {
		
		public function __construct(){
	        parent::__construct();
	        $this->config->load("sitio");
	        $this->load->library("danecrypt");
	        $this->load->library("validarsesion");
	        $this->load->library("pagination");
	    }
	    
	    /**
	     * Landing Page Administración
	     * @author Daniel M. Díaz
	     * @since  Junio 09 / 2015
	     */
	    public function index(){
	    	$data["view"] = "admin";	    	
	    	$this->load->view("layout",$data);
	    }
	    
	    /**
	     * Muestra el listado de las certificaciones que han sido generadas por el sistema
	     * @author Daniel M. Díaz
	     * @since  Julio 08 / 2015
	     */
	    public function certificaciones(){
	    	$this->load->model("certificados");	    		    	
	    	//Configuracion del paginador
	    	$config = array();
			$config["base_url"] = site_url("admin/certificaciones");
			$config["total_rows"] = $this->certificados->conteoCertificaciones();
			$config["per_page"] = 20;   //Cantidad de registros por pagina que debe mostrar el paginador
			$config["num_links"] = 5;  //Cantidad de links para cambiar de página que va a mostrar el paginador.
			$config["first_link"] = "Primero";
			$config["last_link"] = "&Uacute;ltimo";
			$config["use_page_numbers"] = TRUE;
			$this->pagination->initialize($config);
			//Trabajo de paginacion
			$pagina = ($this->uri->segment(3))?$this->uri->segment(3):1; //Si esta definido un valor por get, utilice el valor, de lo contrario utilice cero (para el primer valor a mostrar).
			$desde = ($pagina - 1) * $config["per_page"];
			$hasta = $desde + $config["per_page"];
			$data["certificaciones"] = $this->certificados->obtenerCertificadosPendientes($desde, $hasta);
			$data["links"] = $this->pagination->create_links();
			$data["view"] = "certificaciones";
			$this->load->view("layout",$data);	
	    }
	    
	    /**
	     * Ejecuta AJAX para la búsqueda de certificados a partir del numero de identificacion del usuario
	     * @author Daniel M. Díaz
	     * @since  Julio 09 / 2017
	     */
	    public function ajaxBusquedaCertificados(){
	    	header("Content-Type: text/plain; charset=utf-8");//Para evitar problemas de acentos
	    	$this->load->model(array("certificados","usuarios"));
	    	$num_identificacion = $this->input->post("numid");
	    	$userid = $this->usuarios->obtenerIDUsuario($num_identificacion);	    	
	    	if ($userid!=NULL)
	    		$data["certificaciones"] = $this->certificados->busquedaCertificaciones($userid);
	    	else
	    		$data["certificaciones"] = NULL;	    		
	    	$this->load->view("certificajx",$data);
	    }
	    
	    /**
	     * Ejecuta AJAX para el envío de emails de notiificación a los usuarios que solicitan certificaciones
	     * @author Daniel M. Díaz
	     * @since  Julio 09 / 2017
	     */
	    public function ajaxEnviarNotificaciones(){
	    	$this->load->library("email");
	    	$this->load->model("certificados");
	    	$config = array(
	    			'protocol' => 'smtp',
	    			'smtp_host' => '192.168.1.98',
	    			'smtp_port' => 25,
	    			'smtp_crypto' => 'tls',
	    			'smtp_user' => 'aplicaciones@dane.gov.co',
	    			'smtp_pass' => 'Ou67UtapW3v',
	    			'mailtype' => 'html',
	    			'charset' => 'utf-8',
	    			'newline' => "\r\n"
	    	);
	    	$string = $this->input->post("string");
	    	$arrayCert = explode(",",$string);
	    	$this->email->initialize($config);
	    	for ($i=0; $i<count($arrayCert); $i++){	    		
	    		$data = $this->certificados->obtenerDatosUsuario($arrayCert[$i]);
	    		$this->email->from("aplicaciones@dane.gov.co", "Sistema Integrado de Gestión Humana");
	    		$this->email->to($this->certificados->obtenerEmailCertificado($arrayCert[$i]));
	    		$this->email->subject("Certificación Generada por el Sistema de Gestión Humana");
	    		$html = $this->load->view("notificacionenvio",$data,true);
	    		$this->email->message($html);
	    		$bool = $this->email->send();
	    		if ($bool){
	    			$this->certificados->actualizarNotificacionCertificado($arrayCert[$i]);
	    		}	    		
	    	}
	    	var_dump($this->email->print_debugger());	    		    	 
	    }
	    
	    
	    /**
	     * Sale del módulo de administración y regresa al login del aplicativo
	     * @author Daniel M. Díaz
	     * @since  Junio 09 / 2015
	     */
	    public function salir(){
	    	$this->session->unset_userdata("auth");
	    	$this->session->sess_destroy();
	    	redirect("/","location",301);
	    }
	    
		
		/**
	     * Ingresa a la interfaz para editar permisos de un usuario
	     * @author hhchavezv
	     * @since  2015jul14
	     */
	    public function permisos($id_usuario){
			$this->load->model(array("permisos","usuarios"));
			
			$data["nombre_usuario"]=$this->usuarios->obtenerNombreUsuario($id_usuario);
			$data["permisos"]=$this->permisos->permisosUsuario($id_usuario);
			$data["modulos"]=$this->permisos->listadoModulos();			
			$data["controller"]="admin";
			$data["view"] = "permisos";
			$this->load->view("layout",$data);	
			
		}
		
		/**
	     * Guarda permisos de un usuario
	     * @author hhchavezv
	     * @since  2015jul14
	     */
	    public function permisosGuardar(){
			//$this->load->model(array("permisos","usuarios"));
			/*
			$data["controller"]="admin";
			$data["view"] = "permisos";
			$this->load->view("layout",$data);	
			*/
			//echo "-ok-";
			
		}
		
	    public function test(){
	    	$this->load->view("notificacionenvio");
	    }
	    
	}//EOC	    