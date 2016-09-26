<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Usuarios extends CI_Model {

		function __construct(){        
	    	parent::__construct();	    	
		}
		
		/**
		 * Realiza la búsqueda de un usuario por el número de identificacion, y retorna el id del usuario.
		 * @author Daniel M. Díaz
		 * @since  Julio 09 / 2015
		 */
		public function obtenerIDUsuario($num_identificacion){
			$userid = NULL;
			$sql = "SELECT id_usuario
					FROM gh_admin_usuarios
					WHERE num_ident = '$num_identificacion'";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0){				
				foreach($query->result() as $row){
					$userid = $row->ID_USUARIO;					
				}
			}
			$this->db->close();
			return $userid;
		}
		
		/**
		 * Realiza la búsqueda de un usuario por el id, y retorna el nombre
		 * @author hhchavezv
		 * @since  2015jul14
		 */
		public function obtenerNombreUsuario($id_usuario){
			$nom = NULL;
			$sql = "SELECT UPPER( CONCAT( CONCAT(  NOM_USUARIO, ' '), ape_usuario ) ) as NOMBRE
					FROM GH_ADMIN_USUARIOS 
					WHERE id_usuario='$id_usuario'";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0){				
				foreach($query->result() as $row){
					$nom = $row->NOMBRE;					
				}
			}
			$this->db->close();
			return $nom;
		}
		
	}//EOC	