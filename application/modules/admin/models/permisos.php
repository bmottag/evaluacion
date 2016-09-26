<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Clase para manejar CRUD de permisos de usuario
* @author hhchavezv
* @since  2015jul14
*/
		 
	class Permisos extends CI_Model {

		function __construct(){        
	    	parent::__construct();	
			$this->load->library("validarsesion");	    	
		}
		
		/**
		 * Consulta los permisos de un usuario
		 * @author hhchavezv
	     * @since  2015jul14
		 */
		public function permisosUsuario($id_usuario){
			
			$res=array();
			$sql = "SELECT FK_ID_MODULO 
					FROM GH_ADMIN_PERMISOS 
					WHERE FK_ID_USUARIO = '$id_usuario'";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0){				
				foreach($query->result() as $row){
					$res[$row->FK_ID_MODULO]=$row->FK_ID_MODULO;
					
				}
			}
			$this->db->close();
			return $res;
		}
		
		
		/**
		 * 
		 * Consulta el listado completo de permisos del sistema
		 * @author hhchavezv
	     * @since  2015jul14
		 */
		public function listadoModulos(){
			
			$modulos=array();
			$sql = "SELECT ID_MODULO, NOMBRE_MODULO 
					FROM GH_ADMIN_MODULOS
					ORDER BY NOMBRE_MODULO";			
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0){
				$i = 1;
				foreach($query->result() as $row){
					$modulos[$i]["id"] = $row->ID_MODULO;
					$modulos[$i]["nombre"] = $row->NOMBRE_MODULO;
					$i++;					
				}
			}
			$this->db->close();
			return $modulos;
		}
		
		/**
    	 * Actualiza / Inserta permisos de usuario en base de datos
    	 * @author hhchavezv		
    	 * @since  2015jul15
    	 */ 
    	public function guardaPermisos($numform, $datos, $fk_usu_digita){    
		
			$this->load->model("fecha_hora");
    		$fecha_digitacion=$this->fecha_hora->obtenerFechaActual('h');
    		
    		
	    	foreach($datos as $nombre_campo => $valor){
	  			$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
	   			eval($asignacion);
			}
    					
			
			$data = array();	
		}
	}//EOC
	    
	    