<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	 * Controlador para los administradores de las salas
	 * @since 05/11/2013
	 * @review 22/10/2015
	 * @author BMOTTAG
	 */
	
	class Admin_salas extends MX_Controller {

	
		public function __construct(){
	        parent::__construct();
			$this->load->model('salones_model');
			$this->load->model('consultas_salas_model');
			$this->load->model('consultas_generales');
			$this->load->library("pagination");
	    }

		/**
		 * Lista de nuevas solicitudes
		 * @since 05/11/2013
		 * @review 22/10/2015
		 * @author BMOTTAG
		 */	
		public function index($idSolicitud)
		{
			$data['titulo'] = 'ADMINISTRACI&Oacute;N';
			$data['idSolicitud'] = $idSolicitud;
			$estado = 1;//PENDIENTE
			$data['solicitudes'] = $this->consultas_salas_model->get_new_solicitudes($idSolicitud, $estado);
			
			if($data['solicitudes']){
				if( $idSolicitud != 'x' )
				{
					//Consulto horario reservado para revisar si hay espacios disponibles para la solicitud
					$salaId = $data['solicitudes'][0]['FK_ID_SALA'];
					$fecha = $data['solicitudes'][0]['FECHA_APARTADO'];				
					$estado = 2;//APARTADO
					$data['solApartadas'] = $this->consultas_salas_model->get_solicitudes($salaId,$fecha,$estado);

					$data["view"] = "form_aprobar";
				}
				else
				{
					$data["view"] = "listaSolicitudesPendientes";
				}
			}else{
				$data['text'] = "En el momento no hay solicitudes nuevas.";
				$data['clase'] = 'alert-danger';
				$data["view"] = "respuesta";
			}
							
			$this->load->view("layout",$data);
		}

		/**
		 * Actualizar el estado de la solicitud
		 * @review 20/10/2015
		 */	
		public function update_estado_solicitud()
		{
				
				$data['titulo'] = 'ACTUALIZAR ESTADO DE LA SOLICITUD';
				$data['boton'] = 'gh_salas/admin_salas/index/x';//ruta para el boton regresar
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
	
		/**
		 * Buscar solicitudes anteriores
		 * @since 12/11/2013
		 * @review 24/10/2015
		 */	
		public function buscar()
		{
				$data['salas'] = $this->consultas_salas_model->get_salas();
				$data['titulo'] = 'RESERVAS REALIZADAS';
				
				$data['text'] = "No hay solicitud registradas con esa busqueda.";
				$data['clase'] = "alert-danger";
				$data['boton'] = 'gh_salas/admin_salas/buscar';//ruta para el boton regresar
				$data["view"] = "form_busqueda";

				if ( $this->input->post('fechaSol') && $this->input->post('salaId') )
				{
					$salaId = $this->input->post('salaId');
					$fecha = $this->input->post('fechaSol');
					$data['solicitudes'] = $this->consultas_salas_model->get_solicitudes($salaId,$fecha);
					
					
					if($data['solicitudes']){
						$data["view"] = "listaSolicitudes";
					}else{
						$data["view"] = "respuesta";	
					}	
				}
				elseif ( $this->input->post('solicitudId') )
				{
					$data['solicitudes'] = $this->consultas_salas_model->get_solbyID();
					if($data['solicitudes']){
						$data["view"] = "listaSolicitudes";
					}else{
						$data["view"] = "respuesta";	
					}						
				}	
				$this->load->view("layout",$data);
		}

		/**
		 * Actualiza el estado de las salas
		 * @since 13/11/2013
		 * @review 24/10/2015
		 */	
		public function bloquear_salas(){
				$data['titulo'] = 'CAMBIAR EL ESTADO DE LA SALA';
				
				if ( $this->input->post() )
				{
					if($this->salones_model->estado_sala()){
						$data['text'] = 'Se actualizó el estado de la sala.';
						$data['clase'] = "alert-success";
					} 
					else
					{
						$data['text'] = "Problema guardando en la base de datos";
						$data['clase'] = "alert-danger";
					}
					$data['boton'] = 'gh_salas/admin_salas/bloquear_salas';//ruta para el boton regresar
					$data["view"] = "respuesta";
				}else $data["view"] = "salas";
				$data['salas'] = $this->consultas_salas_model->get_salas('x');
				$this->load->view("layout",$data);
		}

		/**
		 * Generar reporte de solicitudes para un perido de tiempo
		 * @since 8/1/2014
		 * @review 26/10/2015
		 * @author BMOTTAG
		 */	
		public function historico()
		{
				$data["view"] = "form_filtro";
				$this->load->view("layout",$data);
		}

		/**
		 * Descargar reporte
		 * @review 26/10/2015
		 */		
		public function generar_xls() 
		{
				$data['solicitudes'] = $this->consultas_salas_model->get_solicitudes_historico();

				if($data['solicitudes']){
						// redireccionamos la salida al navegador del cliente (Excel2007)
						header('Content-type: application/vnd.ms-excel; charset=UTF-8');
						header("Content-Disposition: attachment; filename=reporte.xls");
						$this->load->view('listaDescarga', $data);
				}else{
						$data['titulo'] = 'GENERAR REPORTE PARA UN PERIODO DE TIEMPO';
						$data['text'] = 'No se encontraron solicitudes de permiso con dicho filtro.';
						$data['clase'] = 'alert-danger';	
						$data["view"] = "respuesta";
						$this->load->view("layout",$data);					
				}				
		}	
		
	
	
}
?>