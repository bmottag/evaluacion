<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Usuario extends CI_Model {

	    function __construct(){        
	        parent::__construct();
	        $this->load->library("danecrypt");	        
	    }
	    
	    /**
	     * Valida los datos del formulario de ingreso (login y password) contra la base de datos del aplicativo
	     * @author Daniel M. Díaz
	     * @since  19/06/2015
	     */
	    public function validarUsuarioBDMintegra($login){
	    	$user = array();
	    	$user["valid"] = false;	    	
	    	$login = str_replace(array("<",">","[","]","*","^","-","'","="),"",$login);   
	    	//$passwd = str_replace(array("<",">","[","]","*","^","-","'","="),"",$passwd); 
	    	$sql = "SELECT * FROM gh_admin_usuarios WHERE log_usuario = '$login'";
	    	$query = $this->db->query($sql);
	    	if ($query->num_rows() > 0){	    		
	    		//$encrypt = $this->danecrypt->encode($passwd);
	    		foreach($query->result() as $row){
	    			//if (strcmp($row->PAS_USUARIO, $encrypt)===0){
	    				$user["valid"] = true;
	    				$user["id"] = $row->ID_USUARIO;
	    				$user["num_ident"] = $row->NUM_IDENT;
	    				$user["nom_usuario"] = $row->NOM_USUARIO;
	    				$user["ape_usuario"] = $row->APE_USUARIO;
	    				$user["tel_usuario"] = $row->TEL_USUARIO;
	    				$user["ext_usuario"] = $row->EXT_USUARIO;
	    				$user["mail_usuario"] = $row->MAIL_USUARIO;
	    				$user["dep_usuario"] = $row->DEP_USUARIO;
	    				$user["terr_usuario"] = $row->TERR_USUARIO;
	    				$user["tipov_usuario"] = $row->TIPOV_USUARIO;	
	    				$user["rol_usuario"] = $row->ROL_USUARIO;
	    			//}	    			
	    		}
	    	}
	    	$this->db->close();	    	
	    	return $user;
	    }
	    
	    /**
	     * Obtiene los datos de un usuario para prediligenciar el formulario de actualización de datos
	     * @author Daniel M. Díaz
	     * @since  19/06/2015
	     */
	    public function obtenerUsuarioID($id){
	    	$user = false;
	    	$sql = "SELECT id_usuario, num_ident, nom_usuario, ape_usuario, tel_usuario, ext_usuario, 
	    	               mail_usuario, dep_usuario, terr_usuario, tipov_usuario, rol_usuario 
					FROM gh_admin_usuarios 
					WHERE id_usuario = $id";	    	
	    	$query = $this->db->query($sql);
	    	if ($query->num_rows() > 0){
	    		foreach($query->result() as $row){
	    			$user["id_usuario"] = $row->ID_USUARIO;
	    			$user["num_ident"] = $row->NUM_IDENT;
	    			$user["nom_usuario"] = $row->NOM_USUARIO;
	    			$user["ape_usuario"] = $row->APE_USUARIO;
	    			$user["tel_usuario"] = $row->TEL_USUARIO;
	    			$user["ext_usuario"] = $row->EXT_USUARIO;
	    			$user["mail_usuario"] = $row->MAIL_USUARIO;
	    			$user["dep_usuario"] = $row->DEP_USUARIO;
	    			$user["terr_usuario"] = $row->TERR_USUARIO;
	    			$user["tipov_usuario"] = $row->TIPOV_USUARIO;
	    			$user["rol_usuario"] = $row->ROL_USUARIO;
	    		}
	    	}
	    	$this->db->close();
	    	return $user;
	    }
	    
	    /**
	     * Obtiene los datos de un usuario para prediligenciar el formulario de actualización de datos
	     * @author Daniel M. Díaz
	     * @since  19/06/2015
	     */
	    public function obtenerUsuarioNumID($numid){
	    	$user = false;
	    	$sql = "SELECT id_usuario, num_ident, nom_usuario, ape_usuario, tel_usuario, ext_usuario,
	    	               mail_usuario, dep_usuario, terr_usuario, tipov_usuario, rol_usuario
	    	        FROM gh_admin_usuarios
	    	        WHERE num_ident = '$numid'";
	    	$query = $this->db->query($sql);
	    	if ($query->num_rows() > 0){
	    		foreach($query->result() as $row){
	    			$user["id_usuario"] = $row->ID_USUARIO;
	    			$user["num_ident"] = $row->NUM_IDENT;
	    			$user["nom_usuario"] = $row->NOM_USUARIO;
	    			$user["ape_usuario"] = $row->APE_USUARIO;
	    			$user["tel_usuario"] = $row->TEL_USUARIO;
	    			$user["ext_usuario"] = $row->EXT_USUARIO;
	    			$user["mail_usuario"] = $row->MAIL_USUARIO;
	    			$user["dep_usuario"] = $row->DEP_USUARIO;
	    			$user["terr_usuario"] = $row->TERR_USUARIO;
	    			$user["tipov_usuario"] = $row->TIPOV_USUARIO;
	    			$user["rol_usuario"] = $row->ROL_USUARIO;
	    		}
	    	}
	    	$this->db->close();
	    	return $user;
	    }
	    
	    /**
	     * Obtiene los datos de un usuario para prediligenciar el formulario de actualización de datos
	     * @author Daniel M. Díaz
	     * @since  19/06/2015
	     */
	    public function obtenerUsuarioEMAIL($email){
	    	$user = false;
	    	$sql = "SELECT id_usuario, num_ident, nom_usuario, ape_usuario, tel_usuario, ext_usuario,
	    	               mail_usuario, dep_usuario, terr_usuario, tipov_usuario, rol_usuario
	    	        FROM gh_admin_usuarios
	    	        WHERE LOWER(mail_usuario) = '$email'";
	    	$query = $this->db->query($sql);
	    	if ($query->num_rows() > 0){
	    		foreach($query->result() as $row){
	    			$user["id_usuario"] = $row->ID_USUARIO;
	    			$user["num_ident"] = $row->NUM_IDENT;
	    			$user["nom_usuario"] = $row->NOM_USUARIO;
	    			$user["ape_usuario"] = $row->APE_USUARIO;
	    			$user["tel_usuario"] = $row->TEL_USUARIO;
	    			$user["ext_usuario"] = $row->EXT_USUARIO;
	    			$user["mail_usuario"] = $row->MAIL_USUARIO;
	    			$user["dep_usuario"] = $row->DEP_USUARIO;
	    			$user["terr_usuario"] = $row->TERR_USUARIO;
	    			$user["tipov_usuario"] = $row->TIPOV_USUARIO;
	    			$user["rol_usuario"] = $row->ROL_USUARIO;
	    		}
	    	}
	    	$this->db->close();
	    	return $user;
	    }
	    
	    
	    /**
	     * Inserta - Agrega los datos de un usuario en la B.D. del aplicativo
	     * @author Daniel M. Díaz
	     * @since  22/06/2015
	     */
	    public function agregarUsuario($num_ident, $nombres, $apellidos, $telefono, $extension, $email, $dependencia, $territorial, $tipovincula, $rol){
	    	$result = false;
	    	$login = $this->obtenerNombreUsuario($email);
	    	$password = '';//se usa autenticacion por LDAP
			
	    	$sql = "INSERT INTO GH_ADMIN_USUARIOS (ID_USUARIO, NUM_IDENT, NOM_USUARIO, APE_USUARIO, TEL_USUARIO, EXT_USUARIO, MAIL_USUARIO, DEP_USUARIO, TERR_USUARIO, TIPOV_USUARIO, LOG_USUARIO, PAS_USUARIO, ROL_USUARIO) 
                    VALUES (SEQ_ADMIN_USUARIOS.Nextval, '$num_ident', '".strtoupper($nombres)."', '".strtoupper($apellidos)."', '$telefono', '$extension', '".strtolower($email)."', '$dependencia', '$territorial', $tipovincula, '$login', '$password', $rol)";
	    	$query = $this->db->query($sql);
	    	if ($query){
	    		$result = true;
	    	}
	    	$this->db->close();	    	
	    	return $result;
	    }
	    
	    
	    
	    /**
	     * Actualiza los datos de un usuario en la B.D. del aplicativo
	     * @author Daniel M. Díaz
	     * @since  19/06/2015
	     */
	    public function actualizarUsuario($id, $numident, $nombres, $apellidos, $telefono, $extension, $email, $dependencia, $territorial, $tipovincula){
	    	$result = false;
	    	$data = array();
	    	if ($numident!=NULL){ $data["NUM_IDENT"] = $numident; }
	    	if ($nombres!=NULL){ $data["NOM_USUARIO"] = strtoupper($nombres); }
	    	if ($apellidos!=NULL){ $data["APE_USUARIO"] = strtoupper($apellidos); }
	    	if ($telefono!=NULL){ $data["TEL_USUARIO"] = $telefono; }
	    	if ($extension!=NULL){ $data["EXT_USUARIO"] = $extension; }
	    	if ($email!=NULL){ $data["MAIL_USUARIO"] = strtolower($email); }
	    	if ($dependencia!=NULL){ $data["DEP_USUARIO"] = $dependencia; }
	    	if ($territorial!=NULL){ $data["TERR_USUARIO"] = $territorial; }
	    	if ($tipovincula!=NULL){ $data["TIPOV_USUARIO"] = $tipovincula; }
			$data["ESTADO"] = 1;
	    	$this->db->where("ID_USUARIO", $id);
	    	$this->db->update("GH_ADMIN_USUARIOS", $data);
	    	if ($this->db->affected_rows() > 0){
	    		$result = true;
	    	}
	    	$this->db->close();	    	
	    	return $result;	    		    	
	    }
	    
	    /**
	     * Redirecciona el usuario al módulo correspondiente dependiendo de los datos almacenados en la session
	     * @author Daniel M. Díaz
	     * @since  19/06/2015
	     */
	    public function redireccionarUsuario(){
	    	$tipov = $this->session->userdata("rol_usuario");
	    	switch($tipov){
	    		case 0: //Usuarios normales de los sistemas SICO y PERNO	    				
	    				redirect("/usuarios",location,301);
						//redirect("/gh_directorio/directorio",location,301);
	    				break;
	    		
	    		case 1: //Redireccionar a Administradores del Sistema
	    				redirect("/admin","location",301);
	    				break;
	    				
	    		case 9: //Redireccionar a Usuarios con acceso limitado a tres días
	    				redirect("/gh_temporal","location",301);
	    				break;

	    		default: //No sé como llegaron hasta acá, pero los devuelvo al Login.
	    				$this->session->sess_destroy();
	    				redirect("/login","location",301);
	    				break;
	    	}
	    }
	    
	    /**
	     * Valido los datos del usuario contra el sistema PERNO.
	     * Si el usuario se encuentra en el sistema, debo actualizar los datos de la tabla de usuarios
	     * @author Daniel M. Díaz
	     * @since  19/06/2015
	     */ 
	    public function validarUsuarioPERNO($numid, $mail){
	    	$perno = array();
	    	$perno["valid"] = false;
	    	$sql = "SELECT numero_identificacion, nombres, primer_apellido, segundo_apellido, correo, 
	    	               dependencia, territorial, cod_dependencia, cod_territorial
					FROM rh.v_infofuncionarios 
					WHERE (numero_identificacion = '$numid' OR LOWER(correo) = '$mail')
	    	        AND UPPER(estado) = 'ACTIVO'";	    	    	
	    	$query = $this->db->query($sql);
	    	if ($query->num_rows() > 0){
	    		foreach($query->result() as $row){	    			
	    			$perno["valid"] = true;
	    			$perno["num_ident"] = $row->NUMERO_IDENTIFICACION;
	    			$perno["nom_usuario"] = $row->NOMBRES;
	    			$perno["ape_usuario"] = $row->PRIMER_APELLIDO." ".$row->SEGUNDO_APELLIDO;
	    			$perno["mail_usuario"] = $row->CORREO;
	    			$perno["dep_usuario"] = $row->DEPENDENCIA;
	    			$perno["terr_usuario"] = $row->TERRITORIAL;	
	    			$perno["cod_dep_usuario"] = $row->COD_DEPENDENCIA;
	    			$perno["cod_terr_usuario"] = $row->COD_TERRITORIAL;
	    		}
	    	}
	    	$this->db->close();
	    	return $perno;
	    }
	    
	    /**
	     * Valido los datos del usuario contra el sistema SICO.
	     * Si el usuario se encuentra en el sistema, debo actualizar los datos de la tabla de usuarios
	     * @author Daniel M. Díaz
	     * @since  19/06/2015
	     */
	    public function validarUsuarioSICO($numid, $mail){
	    	$sico = array();
	    	$sico["valid"] = false;
	    	$sql = "SELECT doc_nro, TRIM(razon_social) AS razon_social, email, dependencia, territorial
                    FROM co.co_directorio_mv 
	    			WHERE (doc_nro = '$numid' OR LOWER(email) = '$mail')
	    	        AND fecha_final - CURRENT_DATE > 0";	    	  	
	    	$query = $this->db->query($sql);
	    	if ($query->num_rows() > 0){
	    		foreach($query->result() as $row){
	    			$user = $this->obtenerNombresApellidos($row->RAZON_SOCIAL);
	    			$sico["valid"] = true;
	    			$sico["num_ident"] = $row->DOC_NRO;
	    			$sico["nom_usuario"] = $user["nombres"];
	    			$sico["ape_usuario"] = $user["apellidos"];
	    			$sico["mail_usuario"] = $row->EMAIL;
	    			$sico["dep_usuario"] = $row->DEPENDENCIA;
	    			$sico["terr_usuario"] = $row->TERRITORIAL;
	    		}
	    	}
	    	$this->db->close();
	    	return $sico;
	    }
	    
	    
	    /**
	     * Funcion para obtener los nombres o los apellidos de un usuario (que vienen en una unica cadena)
	     * @author Daniel M. Díaz
	     * @since  19/06/2015
	     */
	    private function obtenerNombresApellidos($string){
	    	$data = array();
	    	$array = explode(" ",$string);
	    	switch(count($array)){
	    		case 2: //Un nombre y un apellido
                                        $data["nombres"] = $array[0];
	    				$data["apellidos"] = $array[1];
	    				break;
	    		case 3: //Se asume que siempre viene con dos apellidos
	    				$data["nombres"] = $array[0];
	    				$data["apellidos"] = $array[1] . " " . $array[2];
	    				break;
	    		case 4: //Se asume que viene con dos nombres y dos apellidos
	    				$data["nombres"] = $array[0] . " " . $array[1];
	    				$data["apellidos"] = $array[2] . " " . $array[3];
	    				break;
                        case 5: //Se asume que viene con tres nombres y dos apellidos
                                        $data["nombres"] = $array[0] . " " . $array[1] . " " . $array[2];
	    				$data["apellidos"] = $array[3] . " " . $array[4];
	    				break;
                        /*case 6: //Se asume que viene con cuatro nombres y dos apellidos
                                        $data["nombres"] = $array[0] . " " . $array[1] . " " . $array[2] . " " . $array[3];
	    				$data["apellidos"] = $array[4] . " " . $array[5];
	    				break;*/
	    	}
	    	return $data;
	    }
	    
	    /**
	     * Obtiene el nombre del usuario a partir del email
	     * @author Daniel M. Díaz
	     * @since  22/06/2015
	     */
	    public function obtenerNombreUsuario($email){
	    	$data = array();
	    	$data = explode("@",$email);
	    	return $data[0];
	    }
	    
	    /**
	     * Valida que el login de usuario no exista, o no se haya creado en la tabla de usuarios
	     * @author Daniel M. Díaz
	     * @since  22/06/2015 
	     */
	    public function existeLogin($login){
	    	$result = false;
	    	$sql = "SELECT * FROM gh_admin_usuarios WHERE log_usuario = '$login'";
	    	$query = $this->db->query($sql);
	    	if ($query->num_rows() > 0){
	    		$result = true;
	    	}
	    	$this->db->close();
	    	return $result;
	    }
		
	    /**
	     * Valida que la CC de usuario no exista, o no se haya creado en la tabla de usuarios
	     * @since  9/11/2015 
	     */
	    public function existeCC($cc){
	    	$result = false;
	    	$sql = "SELECT * FROM gh_admin_usuarios WHERE num_ident = '$cc'";
	    	$query = $this->db->query($sql);
	    	if ($query->num_rows() > 0){
	    		$result = true;
	    	}
	    	$this->db->close();
	    	return $result;
	    }		
	    
	    /**
	     * Realiza la Búsqueda de un usuario y contraseña a partir del email
	     * @author Daniel M. Díaz
	     * @since  22/06/2015
	     */
	    public function buscarUsuarioEmail($email){
	    	$user["found"] = false;
	    	$sql = "SELECT nom_usuario, ape_usuario, log_usuario, pas_usuario, mail_usuario
	    			FROM gh_admin_usuarios
	    			WHERE LOWER(mail_usuario) = '$email'";	    	
	    	$query = $this->db->query($sql);
	    	if ($query->num_rows() > 0){
	    		foreach($query->result() as $row){
		    		$user["found"] = true;
		    		$user["nombres"] = $row->NOM_USUARIO;
		    		$user["apellidos"] = $row->APE_USUARIO;
		    		$user["log_usuario"] = $row->LOG_USUARIO;
		    		$user["pas_usuario"] = $this->danecrypt->decode($row->PAS_USUARIO);
		    		$user["mail_usuario"] = $row->MAIL_USUARIO;
	    		}	
	    	}
	    	$this->db->close();
	    	return $user;
	    }
		

		
		
		
		
		
		
		
	/**
	 * Consulta por defecto
	 * @author BMOTTAG
	 * @since 16/9/2015
	 */	
	public function obtenerPermisosDefecto($tipoVinculacion)
	{
	    	$result = false;
			$tipoVinculacion = $tipoVinculacion==1?2:1;

	    	$sql = "SELECT ID_PERMISO FROM gh_admin_permisos 
					WHERE POR_DEFECTO = 1
					AND TIPO_USUARIO <> '$tipoVinculacion'";

			$query = $this->db->query($sql);		
			if($query->num_rows() >= 1){
				return $query->result_array();
			}else return false;	
	}		

	/**
	 * Asignar permisos por defecto al usuario
	 */
	public function asignarPermisos($idUser,$permisosXDefecto)
	{
		foreach ($permisosXDefecto as $lista):
				$data = array(
					'FK_ID_USUARIO' => $idUser,
					'FK_ID_PERMISO' => $lista["ID_PERMISO"]
				);
				$query = $this->db->insert('GH_ADMIN_RELACION_PERMISOS', $data);				
		endforeach;	

		if($query){
			return true;
		}else return false;
	}		
		
		
		
		
		
		
		
		
		
		
		
		
	    
	}//EOC	   
	
	