<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Certificados extends CI_Model {

		function __construct(){        
	    	parent::__construct();	
	    	$this->load->library("danecrypt");
		}
		
		/**
		 * Realiza el conteo del total de certificados que hay por mostrar en el paginador de registros.
		 * @author Daniel M. Díaz
		 * @since  Julio 08 / 2015
		 */
		public function conteoCertificaciones(){
			$pendientes = 0;
			$usuario=$this->session->userdata("id");
			if ($usuario==4798)
			{
				$condicion="AND tipo_certificado in ('12', '13')";
			}
			else if ($usuario==5856)
			{
				$condicion="AND tipo_certificado not in ('12', '13')";
			}
			else
			{
				$condicion="";
			}
			echo $sql = "SELECT COUNT(*) AS pendientes FROM gh_form_certificados WHERE estado = 1 ".$condicion;
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0){				
				foreach($query->result() as $row){
					$pendientes = $row->PENDIENTES;					
				}
			}
			$this->db->close();
			return $pendientes;
		}
		
		
		/**
		 * Obtiene el listado de las certificaciones que han sido generadas a través del sistema.
		 * Certificaciones generadas desde el modulo gh_certificados de Gestion Humana
		 * @author Daniel M. Díaz
		 * @since  Julio 08 / 2015
		 */
		public function obtenerCertificadosPendientes($desde, $hasta){
			$certificados = array();
			$usuario=$this->session->userdata("id");
			if ($usuario==4798 )
			{
				$condicion="AND C.tipo_certificado in ('12', '13')";
			}
			else if ($usuario==5856)
			{
				$condicion="AND C.tipo_certificado not in ('12', '13')";
			}
			else
			{
				$condicion="";
			}
			$sql = "SELECT *
					FROM (SELECT ROWNUM r, C.id_certificado, U.num_ident, U.nom_usuario, U.ape_usuario, C.tipo_certificado, P.nom_certificado, C.estado, E.descripcion, C.fecha_radicado, C.fecha_generado 
		                  FROM gh_form_certificados C, gh_param_certificados P, gh_param_estado_certificados E, gh_admin_usuarios U 
                          WHERE C.tipo_certificado = P.id_certificado 
  	                      AND C.estado = E.id_estado 
                          AND C.id_usuario = U.id_usuario
  	                      AND C.estado = 1 
  	                      ".$condicion." 
  	                      ORDER BY C.fecha_radicado, C.id_certificado, U.num_ident) A
                    WHERE r > $desde AND r <= $hasta
                    ORDER BY A.fecha_radicado, A.id_certificado, A.num_ident";			
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0){
				$i = 0;
				foreach($query->result() as $row){
					$certificados[$i]["id_certificado"] = $row->ID_CERTIFICADO;
					$certificados[$i]["num_ident"] = $row->NUM_IDENT;
					$certificados[$i]["nom_usuario"] = $row->NOM_USUARIO;
					$certificados[$i]["ape_usuario"] = $row->APE_USUARIO;
					$certificados[$i]["tipo_certificado"] = $row->TIPO_CERTIFICADO;
					$certificados[$i]["nom_certificado"] = $row->NOM_CERTIFICADO;					
					$certificados[$i]["estado"] = $row->ESTADO;
					$certificados[$i]["descripcion"] = $row->DESCRIPCION;
					$certificados[$i]["fecha_radicado"] = $row->FECHA_RADICADO;
					$certificados[$i]["fecha_generado"] = $row->FECHA_GENERADO;
					$i++;					
				}
			}
			$this->db->close();
			return $certificados;
		}
		
		/**
		 * Realiza la búsqueda de las certificaciones realizadas a un usuario a partir del num. identificacion del usuario
		 * @author Daniel M. Díaz
		 * @since  09 Julio / 2015
		 */
		public function busquedaCertificaciones($id_usuario){
			$certificaciones = array();
			$sql = "SELECT C.id_certificado, C.id_usuario, U.num_ident, U.nom_usuario, U.ape_usuario, C.tipo_certificado, P.nom_certificado, C.estado, E.descripcion, C.fecha_radicado, C.fecha_generado
					FROM gh_form_certificados C, gh_admin_usuarios U, gh_param_certificados P, gh_param_estado_certificados E
					WHERE C.id_usuario = U.id_usuario 
					AND C.tipo_certificado = P.id_certificado
					AND C.estado = E.id_estado
					AND C.id_usuario = $id_usuario
			        ORDER BY C.fecha_radicado, C.id_certificado, U.num_ident";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0){
				$i = 0;
				foreach($query->result() as $row){
					$certificaciones[$i]["id_certificado"] = $row->ID_CERTIFICADO;
					$certificaciones[$i]["id_usuario"] = $row->ID_USUARIO;
					$certificaciones[$i]["num_ident"] = $row->NUM_IDENT;
					$certificaciones[$i]["nom_usuario"] = $row->NOM_USUARIO;
					$certificaciones[$i]["ape_usuario"] = $row->APE_USUARIO;
					$certificaciones[$i]["tipo_certificado"] = $row->TIPO_CERTIFICADO;
					$certificaciones[$i]["nom_certificado"] = $row->NOM_CERTIFICADO;
					$certificaciones[$i]["estado"] = $row->ESTADO;
					$certificaciones[$i]["descripcion"] = $row->DESCRIPCION;
					$certificaciones[$i]["fecha_radicado"] = $row->FECHA_RADICADO;
					$certificaciones[$i]["fecha_generado"] = $row->FECHA_GENERADO;
					$i++;
				}
			}
			$this->db->close();
			return $certificaciones;
		}
		
		/**
		 * Obtiene el email al que debe enviarse la notificacion de la generacion del certificado
		 * @author Daniel M. Díaz
		 * @since  09 Julio / 2015
		 */
		public function obtenerEmailCertificado($id_certificado){
			$email = NULL;
			$sql = "SELECT U.mail_usuario
					FROM gh_form_certificados C, gh_admin_usuarios U
					WHERE C.id_usuario = U.id_usuario
					AND C.id_certificado = $id_certificado";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0){
				foreach($query->result() as $row){
					$email = $row->MAIL_USUARIO;
				}
			}
			$this->db->close();
			return $email;
		}
		
		/**
		 * Obtiene los datos del usuario que ha solicitado la generación de un certificado
		 * @author Daniel M. Díaz
		 * @since  09 Julio / 2015 
		 */
		public function obtenerDatosUsuario($id_certificado){
			$datos = array();
			$sql = "SELECT U.nom_usuario, U.ape_usuario, U.tel_usuario, U.ext_usuario, P.nom_certificado
					FROM gh_form_certificados C, gh_admin_usuarios U, gh_param_certificados P
					WHERE C.id_usuario = U.id_usuario
					AND C.tipo_certificado =  P.id_certificado
					AND C.id_certificado = $id_certificado";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0){
				foreach($query->result() as $row){
					$datos["id_certificado"] = $id_certificado;
					$datos["nom_usuario"] = $row->NOM_USUARIO;
					$datos["ape_usuario"] = $row->APE_USUARIO;
					$datos["tel_usuario"] = $row->TEL_USUARIO;
					$datos["ext_usuario"] = $row->EXT_USUARIO;
					$datos["nom_certificado"] = $row->NOM_CERTIFICADO;
				}
			}
			$this->db->close();
			return $datos;
		}
		
		/**
		 * Actualiza la generación del certificado con la fecha de entrega y el cambio de estado de la notificacion
		 * @author Daniel M. Díaz
		 * @since  10 Julio / 2015
		 */
		public function actualizarNotificacionCertificado($id_certificado){
			$sql = "UPDATE gh_form_certificados 
                    SET estado = 2,
                        fecha_generado = CURRENT_DATE
                    WHERE id_certificado = $id_certificado";
			$query = $this->db->query($sql);
			return ($this->db->affected_rows() > 0)?true:false;			
		}
		
		
	}//EOC
	    
	    