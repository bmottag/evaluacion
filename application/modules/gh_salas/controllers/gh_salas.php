<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	 * Controlador para solcitar salas
	 * @since 11/10/2013
	 * @review 7/10/2015
	 * @author BMOTTAG
	 */
	
	class GH_Salas extends MX_Controller {
	
		public function __construct(){
	        parent::__construct();
			$this->load->model('salones_model');
			$this->load->model('consultas_salas_model');
			$this->load->model('consultas_generales');
			$this->load->library("pagination");
	    }
		
		/**
		* Muestra lista de las salas
		* @since 11/10/2013
		* @review 7/10/2015
		* @author BMOTTAG
		*/	
		public function index()
		{
				$this->form_validation->set_rules('fecha', '"Fecha de solicitud"', 'required');
				if ($this->form_validation->run() === FALSE)
				{
					$data['salas'] = $this->consultas_salas_model->get_salas();
					$data['view'] = 'listaSalas';
				} 
				else
				{
					$salaId = $this->input->post('salaId');
					$fecha = $this->input->post('fecha');
					
					$data['solicitudes'] = $this->consultas_salas_model->get_solicitudes($salaId,$fecha);
					$data['solicitud'] = $this->consultas_salas_model->get_solbyID();

					$data["fullName"] = $this->session->userdata("nom_usuario") . ' ' . $this->session->userdata("ape_usuario");
					$data['view'] = 'form_solicitud';
				}			
				$this->load->view("layout",$data);
		}
		
		/**
		 * Guarda datos del formulario
		 * Envio de correo al usuaro y al admInistrador
		 * @since 19/10/2015
		 */
		public function guardaDatosFormulario()
		{
			header("Content-Type: text/plain; charset=utf-8");//Para evitar problemas de acentos
			if($this->salones_model->add_sala() )
			{   
				$this->load->library("email");//FALTA ENVIAR CORREO AL USUARIO Y AL ADMIN
    			for ($i=1; $i<=2; $i++){
    				if ($i==1)
    				{//Envio de correo al usuario
						$idUser = $this->session->userdata("id");
						$data['usuario'] = $this->consultas_generales->get_user_by_id($idUser);
						$email = $data['usuario']['mail_usuario'];							
						$data['msj'] = '<p>Reciba un cordial saludo del área de Administrativa.</p>
										<p>Queremos informarle que su solicitud está siendo verificada en el sistema con el fin de ser atendida.</p>
										<p>En el transcurso de la semana estaremos atendiendo su solicitud.</p>';
    				}
    				else
    				{//Envio de correo al administrador
						$email = 'serviciosgenerales@dane.gov.co';
						$data['msj'] = 'Queremos informarle que en el sistema se encuentra pendiente una solicitud para su respectiva atención.';
    				}
    				$this->email->from("serviciosgenerales@dane.gov.co", "Sistema Integrado de Gestion Humana");
					$this->email->to('aocubillosa@dane.gov.co');//to($email);
    				$this->email->subject("Solicitudes de Salas - DANE");						
    				$html = $this->load->view("email",$data,true);
    				$this->email->message($html);
    				$this->email->send();
    			}				
				echo "-ok-";
			}else echo "error";
		}		
			
	    /**
	     * Lista de solicitudes para ver el estado
	     * @author BMOTTAG
	     * @since 19/10/2015
	     */
	    public function ver_solicitudes()
		{
				$data['titulo'] = 'LISTA SOLICITUDES DE SALAS';
				$idUser = $this->session->userdata("id");
				$numRegistros = $this->consultas_salas_model->conteoRegistrosUsuario($idUser);
				if($numRegistros){
						//Configuracion del paginador
						$limit = 10;
						$config = array();
						$config["base_url"] = site_url("gh_salas/ver_solicitudes/");
						$config["total_rows"] = $numRegistros;
						$config["per_page"] = $limit;   //Cantidad de registros por pagina que debe mostrar el paginador
						$config["uri_segment"] = 3;
						$config["num_links"] = 10;  //Cantidad de links para cambiar de página que va a mostrar el paginador.
					
						$config["use_page_numbers"] = TRUE;
						$this->pagination->initialize($config);
						//Trabajo de paginacion
						$pagina = ($this->uri->segment(3))?$this->uri->segment(3):1; //Si esta definido un valor por get, utilice el valor, de lo contrario utilice cero (para el primer valor a mostrar).
						//echo $pagina; die();
						$desde = $pagina!=1?(($pagina - 1) * $limit)+1:0;
						$hasta = $pagina!=1?$desde + $limit-1:$desde + $limit;
						$data["solicitudes"] = $this->consultas_salas_model->get_solicitudes_usuario($desde,$hasta);
						$data["links"] = $this->pagination->create_links();					
						$data["view"] = "listaSolicitudes";
				}else{
					$data['text'] = "No tiene ninguna solicitud registrada.";
					$data['clase'] = "alert-danger";
					$data["view"] = "respuesta";	
				}
				$this->load->view("layout",$data);
	    }

		/**
		 * Cancelar solicitud
		 * @review 20/10/2015
		 */	
		public function cancelar_solicitud()
		{
				
				$data['titulo'] = 'CANCELAR SOLICITUD';
				$data['boton'] = 'gh_salas/ver_solicitudes';//ruta para el boton regresar
				if($this->salones_model->update_estado_solicitud()){
					$data['text'] = 'Se actualizó el estado de la solicitud.';
					$data['clase'] = 'alert-success';
				} else {
					$data['text'] = 'Problema guardando en la base de datos';
					$data['clase'] = 'alert-danger';
				}
				$data["view"] = "respuesta";			
				$this->load->view("layout",$data);
		}		
	
	
	}