<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Controlador para el modulo de Ingreso (Login)
 * @author Daniel Mauricio Díaz Forero
 * @since  Mayo 27 / 2015
 */
class Login extends MX_Controller {

    const PERNO = 1;
    const SICO = 2;
    const ADMIN = 3;

    public function __construct() {
        parent::__construct();
        $this->config->load("sitio");
        $this->load->library("danecrypt");
    }

    /**
     * Ingreso de Usuarios. Muestra el formulario para el ingreso de usuarios al sistema
     * @author Daniel M. Díaz
     * @since  Junio 09 / 2015
     */
    public function index() {
        $this->session->sess_destroy();
        $data["view"] = "login";
        $this->load->view("layout", $data);
    }

    /**
     * Valida el acceso de los usuarios. Valida si se trata de usuarios de sistema o de usuarios SICO o PERNO
     * @author Daniel M. Díaz
     * @since  Julio 03 / 2015
     */
    public function actualizar() {
        $this->load->model(array("usuario", "consultas_generales"));

        $login = $this->input->post("inputLogin");
        $passwd = $this->input->post("inputPassword");
        /**
         * Se agrega la autenticacion por el ldap. Verifica que el usuario y la contrasena esten en el 
         * directorio activo, si los encuentra sigue con el proceso en el sistema.
         * @author Benjamin Motta
         * @since 04-09-2015
         */
        $ldapuser = $login;
        $ldappass = $passwd;

        //$ds = ldap_connect("192.168.1.101", "389") or die("No es posible conectar con: 192.168.1.101");  // Servidor LDAP!
        $ds = ldap_connect("kintaro.dane.gov.co", "389") or die("No es posible conectar con el directorio activo.");  // Servidor LDAP!
        if (!$ds) {
            echo "<br /><h4>Servidor LDAP no disponible</h4>";
            @ldap_close($ds);
        } else {
            $ldapdominio = "dane";
            $ldapusercn = $ldapdominio . "\\" . $ldapuser;
            $binddn = "ou=dane, dc=dane, dc=gov, dc=co";
            $r = @ldap_bind($ds, $ldapusercn, $ldappass);
            if (!$r) {
                @ldap_close($ds);
                $data["view"] = "error";
                $data["mensaje"] = "Error de autenticación. Revisar usuario y contraseña de red.";
                $this->load->view("layout", $data);
            } else {
                //////////////////////////////////////////
                //CODIGO AL PASAR LAS CREDENCIALES DE LDAP
                //////////////////////////////////////////

                $user = $this->usuario->validarUsuarioBDMIntegra($login); //traer datos del usuario de la tabla gh_admin_usuarios

                if (($user["valid"] == true) && ($user["rol_usuario"] == 1)) { //Deja pasar a usuarios con el rol de administrador
                    $sessionData = array(
                        "auth" => "OK",
                        "id" => $user["id"],
                        "num_ident" => $user["num_ident"],
                        "usuario" => $login,
                        "nom_usuario" => $user["nom_usuario"],
                        "ape_usuario" => $user["ape_usuario"],
                        "tel_usuario" => $user["tel_usuario"],
                        "ext_usuario" => $user["ext_usuario"],
                        "mail_usuario" => $user["mail_usuario"],
                        "dep_usuario" => $user["dep_usuario"],
                        "terr_usuario" => $user["terr_usuario"],
                        "tipov_usuario" => $user["tipov_usuario"],
                        "rol_usuario" => $user["rol_usuario"]
                    );
                    $this->session->set_userdata($sessionData);
                    $this->usuario->redireccionarUsuario();
                } elseif (($user["valid"] == true) && ($user["rol_usuario"] == 0)) { //Son usuarios normales
                    $perno = $this->usuario->validarUsuarioPERNO($user["num_ident"], $user["mail_usuario"]); //verficiar por cedula o correo si es usuario PERNO
                    $sico = $this->usuario->validarUsuarioSICO($user["num_ident"], $user["mail_usuario"]); //verficiar por cedula o correo si es usuario SICO

                    if ($perno["valid"] || $sico["valid"]) {
                        if ($perno["valid"]) {// Usuario PERNO, se carga C.C., Nombre, Apellido, Tipo Vinculacion
                            $user["num_ident"] = $perno["num_ident"];
                            $user["nom_usuario"] = $perno["nom_usuario"];
                            $user["ape_usuario"] = $perno["ape_usuario"];
                            $user["tipov_usuario"] = Login::PERNO;
                            //$user["dep_usuario"] = $perno["cod_dep_usuario"];
                            //$user["terr_usuario"] = $perno["cod_terr_usuario"];
                        } elseif ($sico["valid"]) { // Usuario SICO, se carga C.C., Nombre, Apellido, Tipo Vinculacion
                            $user["num_ident"] = $sico["num_ident"];
                            $user["nom_usuario"] = $sico["nom_usuario"];
                            $user["ape_usuario"] = $sico["ape_usuario"];
                            $user["tipov_usuario"] = Login::SICO;
                        }

                        //verficiar si tiene dependencia y extencion 
                        if (is_null($user["ext_usuario"]) || $user["ext_usuario"] == '' || $user["ext_usuario"] == 0 || is_null($user["dep_usuario"]) || $user["dep_usuario"] == '' || $user["dep_usuario"] == 0) {
                            //Debe llenar el formulario de actualización de datos.
                            $data["user"] = $user;
                            $data["view"] = "actualizar";
                            $data["despacho"] = $this->consultas_generales->get_despacho();
                            $this->load->view("layout", $data);
                        } elseif ($this->usuario->actualizarUsuario($user["id"], $user["num_ident"], $user["nom_usuario"], $user["ape_usuario"], NULL, NULL, NULL, NULL, NULL, $user["tipov_usuario"])) { //Actualizo los datos    				
                            $user = $this->usuario->obtenerUsuarioID($user["id"]);
                            $sessionData = array(
                                "auth" => "OK",
                                "id" => $user["id_usuario"],
                                "num_ident" => $user["num_ident"],
                                "usuario" => $login,
                                "nom_usuario" => $user["nom_usuario"],
                                "ape_usuario" => $user["ape_usuario"],
                                "tel_usuario" => $user["tel_usuario"],
                                "ext_usuario" => $user["ext_usuario"],
                                "mail_usuario" => $user["mail_usuario"],
                                "dep_usuario" => $user["dep_usuario"],
                                "terr_usuario" => $user["terr_usuario"],
                                "tipov_usuario" => $user["tipov_usuario"],
                                "rol_usuario" => $user["rol_usuario"]
                            );
                            $this->session->set_userdata($sessionData);
                            $this->usuario->redireccionarUsuario();
                        }
                    } else { //No es usuario PERNO ni SICO
                        $data["view"] = "error";
                        $data["mensaje"] = "Su usuario no se encuentra activo. Por favor consultar con Gesti&oacuten; Humana.";
                        $this->load->view("layout", $data);
                    }
                } else if (($user["valid"] == true) && ($user["rol"] == 9)) { //Usuarios válidos por TRES (3) Días	    		
                    echo "Este es un usuario válido por 3 días";
                } else if ($user["valid"] == false) {
                    $data["view"] = "error";
                    $data["mensaje"] = "Usuario no existe, ingresar por el siguiente enlace 
													<a href=" . site_url() . "login/usuario>'Crear Usuario'</a>.";
                    $this->load->view("layout", $data);
                } else {
                    $this->session->sess_destroy();
                    redirect("/login", "location", 301);
                }
            }
            //////////////////////////////////////////
            //FIN CODIGO AL PASAR LAS CREDENCIALES DE LDAP
            //////////////////////////////////////////
        }
    }

    //EOF

    /**
     * Actualizar datos del usuario
     * @since 07/04/2016
     */
    public function updateUser() {
        $this->load->model("consultas_generales");
        $data["despacho"] = $this->consultas_generales->get_despacho();
        //cargo datos del usuario
        $idUser = $this->session->userdata("id");
        $data["user"] = $this->consultas_generales->get_user_by_id($idUser);

        $data["view"] = "actualizar";
        $this->load->view("layout", $data);
    }

    /**
     * Actualiza los datos de un usuario en la B.D. Mintegra cuando se solicita la actualizacion de datos
     * @author Daniel M. Díaz
     * @since  19/06/2015
     */
    public function actualizarDatos() {
        $this->load->model("usuario");
        $id = $this->input->post("hddIDUsuario");
        $nombres = $this->input->post("hddNombres");
        $apellidos = $this->input->post("hddApellidos");
        $telefono = $this->input->post("txtTelefono");
        $extension = $this->input->post("txtExtension");
        $tipovincula = $this->input->post("cmbTipoVinculacion");
		
		$despacho = $this->input->post("cmbDespacho");
		$dependencia = $this->input->post("dependencia");
		$grupo = $this->input->post("grupo");
		//dato para la dependencia
		if ($despacho != '' && $despacho != "-") {
			$datoDependencia = $despacho;
		}
		if ($dependencia != '' && $dependencia != "-") {
			$datoDependencia = $dependencia;
		}
		if ($grupo != '' && $grupo != "-") {
			$datoDependencia = $grupo;
		}		

        if ($this->usuario->actualizarUsuario($id, NULL, $nombres, $apellidos, $telefono, $extension, NULL, $datoDependencia, NULL, $tipovincula)) {
            $sessionData = array(
                "auth" => "OK",
                "id" => $id,
                "num_ident" => $numident,
                "nom_usuario" => $nombres,
                "ape_usuario" => $apellidos,
                "tel_usuario" => $telefono,
                "ext_usuario" => $extension,
                "mail_usuario" => $email,
                "dep_usuario" => $dependencia,
                "tipov_usuario" => $tipovincula);
            $this->session->set_userdata($sessionData);
            $this->usuario->redireccionarUsuario();
        } else {
            echo "ERROR: No se han podido actualizar los datos del usuario";
            die();
        }
    }

    /**
     * Muestra el formulario para la creación de nuevos usuarios sobre el aplicativo
     * Verifica si se trata de un usuario SICO ó PERNO válido, en caso contrario no permite crear el usuario
     * @author Daniel M. Díaz
     * @since  22/06/2015
     */
    public function usuario() {
        $this->load->model("consultas_generales");
        $data["controller"] = "login";
        //$data["menu"] = "/template/headernolog";
        $data["view"] = "nuevousuario";

        $data["despacho"] = $this->consultas_generales->get_despacho();
        $this->load->view("layout", $data);
    }

    /**
     * Crea los usuarios en la B.D. luego de verificar que se trata de usuarios PERNO ó SICO válidos
     * @author Daniel M. Díaz
     * @since  22/06/2015
     */
    public function crearUsuario() {
        $this->load->model("usuario");
        $data = array();
        $numident = $this->input->post("txtIdentificacion");
        //$nombres = $this->input->post("txtNombres");
        //$apellidos = $this->input->post("txtApellidos");
        $telefono = $this->input->post("txtTelefono");
        $extension = $this->input->post("txtExtension");
        $email = $this->input->post("txtEmail");
		
		$despacho = $this->input->post("cmbDespacho");
		$dependencia = $this->input->post("dependencia");
		$grupo = $this->input->post("grupo");
		//dato para la dependencia
		if ($despacho != '' && $despacho != "-") {
			$datoDependencia = $despacho;
		}
		if ($dependencia != '' && $dependencia != "-") {
			$datoDependencia = $dependencia;
		}
		if ($grupo != '' && $grupo != "-") {
			$datoDependencia = $grupo;
		}		
		
        $territorial = $this->input->post("cmbTerritorial");
        //$tipovincula = $this->input->post("cmbTipoVinculacion");
        $rol = 0; //Crea usuarios normales. Solo un usuario administrador puede crear usuarios administradores.

        $perno = $this->usuario->validarUsuarioPERNO($numident, $email); //Validar que el usuario se encuentre en PERNO
        $sico = $this->usuario->validarUsuarioSICO($numident, $email); //Validar que el usuario se encuentre en SICO

        $login = $this->usuario->obtenerNombreUsuario($email);
        $data["controller"] = "login";
        //$data["menu"] = "/template/headernolog";
        //verificar que tenga el formato del dane
        $findme = '@dane.gov.co';
        if (substr_count($email, '@') > 0) {
            $email = strtolower($email);
            $pos = strpos($email, $findme);
            if (!$pos) {
                $data["view"] = "error";
                $data["mensaje"] = "Correo sin formato v&aacute;lido para el DANE.";
            }
        } else {
            $email .= '@dane.gov.co';
        }
        
        if (empty($data["mensaje"])) {
            $result = $this->usuario->existeLogin($login); //Validar el login de usuario no esté repetido en la B.D.
            if (!$result)
                $result = $this->usuario->existeCC($numident);

            if ($result == false) {
                if ($perno["valid"]) {
                    $nombres = $perno["nom_usuario"];
                    $apellidos = $perno["ape_usuario"];
                    $territorial = $perno["cod_terr_usuario"];
                    $tipovincula = Login::PERNO;

                    $result = $this->usuario->agregarUsuario($numident, $nombres, $apellidos, $telefono, $extension, $email, $datoDependencia, $territorial, $tipovincula, $rol);
                    if ($result) {
                        //Asignar permisos por defecto
                        $user = $this->usuario->obtenerUsuarioNumID($numident);
                        $permisosXDefecto = $this->usuario->obtenerPermisosDefecto($tipovincula);
                        $permisos = $this->usuario->asignarPermisos($user["id_usuario"], $permisosXDefecto);
                        $data["view"] = "success";
                        $data["mensaje"] = "El usuario ha sido creado exitosamente";
                        $data["usuario"] = $this->usuario->buscarUsuarioEmail($email);
                    } else {
                        $data["view"] = "error";
                        $data["mensaje"] = "No se ha podido crear el usuario en el sistema - Revisar Perno.";
                    }
                } else if ($sico["valid"]) {
                    $nombres = $sico["nom_usuario"];
                    $apellidos = $sico["ape_usuario"];
                    $tipovincula = Login::SICO;

                    $result = $this->usuario->agregarUsuario($numident, $nombres, $apellidos, $telefono, $extension, $email, $datoDependencia, $territorial, $tipovincula, $rol);
                    if ($result == true) {
                        //Asignar permisos por defecto
                        $user = $this->usuario->obtenerUsuarioNumID($numident);
                        $permisosXDefecto = $this->usuario->obtenerPermisosDefecto($tipovincula);
                        $permisos = $this->usuario->asignarPermisos($user["id_usuario"], $permisosXDefecto);

                        $data["view"] = "success";
                        $data["mensaje"] = "El usuario ha sido creado exitosamente";
                        $data["usuario"] = $this->usuario->buscarUsuarioEmail($email);
                    } else {
                        $data["view"] = "error";
                        $data["mensaje"] = "No se ha podido crear el usuario en el sistema - Revisar Sico.";
                    }
                } else {
                    $data["view"] = "error";
                    $data["mensaje"] = "No se ha podido crear el usuario. El usuario no existe en los sistemas SICO ni PERNO. Por favor comun&iacute;quese con el &aacute;rea de Gesti&oacute;n Humana.";
                }
            } else {
                $data["view"] = "error";
                $data["mensaje"] = "El usuario ya existe o ya ha sido creado.";
                echo "ERROR: El usuario ya existe o ya ha sido creado";
            }
        }
        $this->load->view("layout", $data);
    }

    /**
     * Recordatorio de Contraseñas por vía email
     * @author Daniel M. Díaz 
     * @since  22/06/2015
     */
    public function recordatorio() {
        $data["controller"] = "login";
        //$data["menu"] = "/template/headernolog";
        $data["view"] = "olvido";
        $this->load->view("layout", $data);
    }

    /**
     * Envia correos de recordatorio de login y contraseña
     * @author Daniel M. Díaz
     * @since  22/06/2015
     */
    public function mailRecordar() {
        $this->load->library("email");
        $this->load->model("usuario");
        $email = $this->input->post("txtEmail");
        $user = $this->usuario->buscarUsuarioEmail($email);
        if ($user["found"] == true) {
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
            $this->email->initialize($config);
            $this->email->from("aplicaciones@dane.gov.co", "Sistema Integrado de Gestión Humana");
            $this->email->to($email);
            $this->email->subject("Recordatorio de Usuario y Contraseña de acceso al Sistema");
            $html = $this->load->view("email", $user, true);
            $this->email->message($html);
            $this->email->send();
            $data["view"] = "confirmenvio";
            $data["email"] = $email;
            //var_dump($this->email->print_debugger());
        } else {
            echo "ERROR: NO se ha podido enviar el mensaje para recordar su usuario y contraseña.";
        }

        $this->load->view("layout", $data);
    }

    /**
     * Funcion para realizar búsqueda de usuarios al momento de crear nuevos usuarios
     * @author Daniel M. Díaz
     * @since  22/06/2015
     */
    public function buscarUsuario() {
        $this->load->model("usuario");
        $usuario["result"] = false;
        $busq = $this->input->post("valor");
        $usuarioID = $this->usuario->obtenerUsuarioNumID($busq);
        $usuarioEmail = $this->usuario->obtenerUsuarioEMAIL($busq);
        if ($usuarioID) {
            $usuarioID["result"] = true;
            echo json_encode($usuarioID);
        } elseif ($usuarioEmail) {
            $usuarioEmail["result"] = true;
            echo json_encode($usuarioEmail);
        } else {
            $usuario["result"] = false;
            echo json_encode($usuario);
        }
    }

    /**
     * TEST PARA VALIDAR CONTRASEÑAS !!! ELIMINAR ESTE METODO !!!
     * @author Daniel M. Díaz
     * @since  19/06/2015
     */
    public function test() {
        $password = "w1fxMYD6E0h2bKmAQfD0yCkAL1YIcYojyfAyKaKxb1g";
        $decode = $this->danecrypt->decode($password);
        var_dump($decode);
    }
}
//EOC