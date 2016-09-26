<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class usuario_model extends CI_Model {

    /**
     * Datos usuario
     * @param $idUsuario int: id del usuario
     * @since 05/05/2016
     */
    public function get_user_by_id($idUsuario) {
        $this->db->where('ID_USUARIO', $idUsuario);
        $query = $this->db->get('GH_ADMIN_USUARIOS');

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    /**
     * Informacion especifica
     * @param $idUsuario int: id del usuario
     * @since 05/05/2016
     */
    public function get_info_especifica_by_id($idUsuario) {
        /*$this->db->where('FK_ID_USUARIO', $idUsuario);
        $this->db->join('GH_PARAM_DIVIPOLA P', 'P.COD_MUNICIPIO = U.MPIO_NACIMIENTO', 'INNER');
        $query = $this->db->get('USER_INFO_ESPECIFICA U');*/

        $sql = "SELECT FK_ID_USUARIO,MPIO_NACIMIENTO,TO_CHAR(FECHA_NACIMIENTO, 'DD/MM/YYYY') FECHA_NACIMIENTO,FK_ESTADO_CIVIL,
                VIVIENDA_HABITA,FK_TIPO_SANGRE,FONDO_PENSIONES,EPS,ARP,CAJA_COMPENSACION,ADMIN_ARP,ADMIN_AFP,ALERGIA,
                ENFERMEDAD,DISCAPACIDAD,LIBRETA_MILITAR,CLASE_LIBRETA,DISTRITO_MILITAR,LUGAR_EXPEDICION,LICENCIA_CONDUCCION, P.*
                FROM USER_INFO_ESPECIFICA U 
                INNER JOIN GH_PARAM_DIVIPOLA P ON (P.COD_MUNICIPIO = U.MPIO_NACIMIENTO)
                WHERE FK_ID_USUARIO = '$idUsuario'";
        
        $query = $this->db->query($sql);
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    /**
     * Obtiene datos de contacto
     * @param $idUser: ID del usuario
     * @author BMOTTAG
     * @since  30/04/2016
     */
    public function get_contacto() {
        $idUser = $this->session->userdata("id");

        $this->db->select();
        $this->db->from('USER_CONTACTO');
        $this->db->where('FK_ID_USUARIO', $idUser);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    /**
     * Actualizar datos usuario
     * @since 30/05/2016
     */
    public function update_user() {
        $idUser = $this->session->userdata("id");

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
		
        $politica = $this->input->post("politica"); // 1: acepta politica de privacidad; 2: no acepta
        $data = array(
            'DEP_USUARIO' => $datoDependencia,
            'TEL_USUARIO' => $this->input->post('txtTelefono'),
            'EXT_USUARIO' => $this->input->post('txtExtension'),
            
        );
        if(!empty($politica)) {
            if($politica == 'on') {
                $data['POLITICA'] = 1;
                $data['FECHA_ACEPTA'] = date('d/m/Y');
            } else if($politica == 'off') {
                unset($data['POLITICA']);
            }
        } else {
            $data['POLITICA'] = 2;
        }
        
        $this->db->where('ID_USUARIO', $idUser);
        $query = $this->db->update('GH_ADMIN_USUARIOS', $data);
        
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Actualiar imagen 
     * @since 27/05/2016
     */
    public function update_image($img) {
        $idUser = $this->session->userdata("id");

        $data = array('IMAGEN' => $img);
        $this->db->where('ID_USUARIO', $idUser);
        $query = $this->db->update('GH_ADMIN_USUARIOS', $data);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Adicionar/Editar Contacto
     * @since 30/04/2016
     */
    public function add_contacto() {
        $idUser = $this->session->userdata("id");
        $idContacto = $this->input->post('hddIDContacto');
        $nombre = mayuscula_inicial($this->input->post('txtNombres'));
        $parentesco = $this->input->post('txtParentesco');
        $celular = $this->input->post('txtCelular');

        //revisar si es para adicionar o editar
        if ($idContacto == '') {
            $sql = "INSERT INTO USER_CONTACTO 
                    (ID_CONTACTO, FK_ID_USUARIO, NOMBRE_CONTACTO, PARENTESCO, CELULAR_CONTACTO) 
                    VALUES (SEQ_FORM_CONTACTO.Nextval, $idUser, '$nombre', '$parentesco', '$celular')";
        } else {
            $sql = "UPDATE USER_CONTACTO
                    SET NOMBRE_CONTACTO= '$nombre', PARENTESCO='$parentesco', CELULAR_CONTACTO='$celular'
                    WHERE ID_CONTACTO=$idContacto";
        }

        $query = $this->db->query($sql);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Obtiene datos de dependientes
     * @param $idDependiente: ID del dependiente
     * @author BMOTTAG
     * @since  02/05/2016
     */
    public function get_dependientes($idDependiente = 'x') {
        $idUser = $this->session->userdata("id");

        //$this->db->select();
        //$this->db->from('USER_DEPENDIENTE');
        //$this->db->where('FK_ID_USUARIO', $idUser);
        $sql = "SELECT ID_DEPENDIENTE,FK_ID_USUARIO,PARENTESCO,NOM_DEPENDIENTE,APE_DEPENDIENTE,SEXO,TIPO_DOCUMENTO,NUM_IDENT_DEP,
                LUGAR_EXPEDICION,TO_CHAR(FECHA_NACIMIENTO, 'DD/MM/YYYY') FECHA_NACIMIENTO,SUBSIDIO,RAZON_SUBSIDIO
                FROM USER_DEPENDIENTE WHERE FK_ID_USUARIO = '$idUser'";
        if ($idDependiente != 'x') {
            //$this->db->where('ID_DEPENDIENTE', $idDependiente);
            $sql.= " AND ID_DEPENDIENTE = '$idDependiente'";
        }

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /**
     * Obtiene datos de informacion academica
     * @param $idAcademica: ID infor academica
     * @author BMOTTAG
     * @since  23/05/2016
     */
    public function get_info_academica($idAcademica = 'x') {
        $idUser = $this->session->userdata("id");

        $this->db->select();
        $this->db->from('USER_INFO_ACADEMICA A');
        $this->db->where('FK_ID_USUARIO', $idUser);
        if ($idAcademica != 'x') {
            $this->db->where('ID_ACADEMICA', $idAcademica);
        }
        $this->db->join('GH_PARAM_NIVEL_ESTUDIO E', 'E.ID_ESTUDIO = A.FK_ID_ESTUDIO', 'INNER');
        $this->db->join('GH_PARAM_AREA_CONOCIMIENTO C', 'C.ID_AREA = A.FK_ID_AREA', 'LEFT');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /**
     * Obtiene actividad del usuario
     * @param $idActividad: ID actividad
     * @author BMOTTAG
     * @since  26/05/2016
     */
    public function get_info_actividad($idActividad = 'x') {
        $idUser = $this->session->userdata("id");

        $this->db->select();
        $this->db->from('USER_ACTIVIDADES A');
        $this->db->where('FK_ID_USUARIO', $idUser);
        if ($idActividad != 'x') {
            $this->db->where('ID_ACTIVIDAD', $idActividad);
        }
        $this->db->join('GH_PARAM_LUDICA L', 'L.ID_LUDICA = A.FK_ID_LUDICA', 'INNER');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /**
     * Obtiene actividad del usuario
     * @param $idIdioma: ID idioma
     * @author BMOTTAG
     * @since  08/06/2016
     */
    public function get_info_idioma($idIdioma = 'x') {
        $idUser = $this->session->userdata("id");

        $this->db->select();
        $this->db->from('USER_IDIOMA I');
        $this->db->where('FK_ID_USUARIO', $idUser);
        if ($idIdioma != 'x') {
            $this->db->where('ID_USER_IDIOMA', $idIdioma);
        }
        $this->db->join('GH_PARAM_IDIOMAS P', 'P.ID_IDIOMA = I.FK_ID_IDIOMA', 'INNER');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /**
     * Obtiene mascotas del usuario
     * @param $idMascota: ID mascota
     * @author BMOTTAG
     * @since  31/05/2016
     */
    public function get_info_mascota($idMascota = 'x') {
        $idUser = $this->session->userdata("id");

        $this->db->select();
        $this->db->from('USER_MASCOTAS M');
        $this->db->where('FK_ID_USUARIO', $idUser);
        if ($idMascota != 'x') {
            $this->db->where('ID_MASCOTA', $idMascota);
        }

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /**
     * Adicionar/Editar Dependiente
     * @since 02/05/2016
     */
    public function add_dependiente() {
        $idUser = $this->session->userdata("id");
        $idDependiente = $this->input->post('hddIDDependiente');
        $parentesco = $this->input->post('parentesco');
        $nombre = mayuscula_inicial($this->input->post('txtNombres'));
        $apellido = mayuscula_inicial($this->input->post('txtApellidos'));
        $sexo = $this->input->post('sexo');
        $tipoDocumento = $this->input->post('tipoDocumento');
        $txtIdentificacion = $this->input->post('txtIdentificacion');
        $txtLugar = mayuscula_inicial($this->input->post('txtLugar'));
        $fechaNacimiento = $this->input->post('fechaNacimiento');
        $subsidio = $this->input->post('subsidio');
        $razonSocial = $this->input->post('razonSocial');

        //revisar si es para adicionar o editar
        if ($idDependiente == '') {
            $sql = "INSERT INTO USER_DEPENDIENTE
                    (ID_DEPENDIENTE, FK_ID_USUARIO, PARENTESCO, NOM_DEPENDIENTE, APE_DEPENDIENTE, SEXO, TIPO_DOCUMENTO, NUM_IDENT_DEP, LUGAR_EXPEDICION, FECHA_NACIMIENTO, SUBSIDIO, RAZON_SUBSIDIO) 
                    VALUES (SEQ_FORM_DEPENDIENTE.Nextval, $idUser, '$parentesco', '$nombre', '$apellido', '$sexo', '$tipoDocumento', '$txtIdentificacion', '$txtLugar', '$fechaNacimiento', '$subsidio', '$razonSocial')";
        } else {
            $sql = "UPDATE USER_DEPENDIENTE
                    SET PARENTESCO='$parentesco',NOM_DEPENDIENTE= '$nombre', APE_DEPENDIENTE='$apellido', SEXO='$sexo', TIPO_DOCUMENTO= '$tipoDocumento', NUM_IDENT_DEP='$txtIdentificacion', LUGAR_EXPEDICION='$txtLugar', FECHA_NACIMIENTO= '$fechaNacimiento', SUBSIDIO='$subsidio', RAZON_SUBSIDIO='$razonSocial'
                    WHERE ID_DEPENDIENTE=$idDependiente";
        }

        $query = $this->db->query($sql);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Adicionar/Editar Informacion academica
     * @since 23/05/2016
     */
    public function add_academica() {
        $idUser = $this->session->userdata("id");
        $idAcademica = $this->input->post('hddIDAcademica');
        $nivelEstudio = $this->input->post('nivelEstudio');
        $tituloEstudio = $this->input->post('tituloEstudio');
        $annoEstudio = $this->input->post('annoEstudio');
        $areaConocimmiento = $this->input->post('areaConocimmiento');
        $graduado = $this->input->post('graduado');

        //revisar si es para adicionar o editar
        if ($idAcademica == '') {
            $sql = "INSERT INTO USER_INFO_ACADEMICA
                    (ID_ACADEMICA, FK_ID_USUARIO, FK_ID_ESTUDIO, TITULO, ANNO, FK_ID_AREA, GRADUADO) 
                    VALUES (SEQ_FORM_ACADEMICA.Nextval, $idUser, $nivelEstudio, '$tituloEstudio', '$annoEstudio', '$areaConocimmiento', '$graduado')";
        } else {
            $sql = "UPDATE USER_INFO_ACADEMICA
                    SET FK_ID_ESTUDIO=$nivelEstudio, TITULO= '$tituloEstudio', ANNO='$annoEstudio', FK_ID_AREA= '$areaConocimmiento', GRADUADO='$graduado'
                    WHERE ID_ACADEMICA=$idAcademica";
        }

        $query = $this->db->query($sql);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Adicionar/Editar Actividades
     * @since 26/05/2016
     */
    public function add_mascota() {
        $idUser = $this->session->userdata("id");
        $idMascota = $this->input->post('hddIDMascota');
        $mascota = $this->input->post('mascota');
        $cual = $this->input->post('cual');
        $cuantos = $this->input->post('cuantos');
        if(!empty($cual)) {
            $cual = mayuscula_inicial($cual);
        }
        if(empty($cuantos)) {
            $cuantos = 'NULL';
        }

        //revisar si es para adicionar o editar
        if ($idMascota == '') {
            $sql = "INSERT INTO USER_MASCOTAS
                    (ID_MASCOTA, FK_ID_USUARIO, MASCOTA, CUAL, CUANTOS) 
                    VALUES (SEQ_FORM_MASCOTAS.Nextval, $idUser, $mascota, '$cual', $cuantos)";
        } else {
            $sql = "UPDATE USER_MASCOTAS
                    SET MASCOTA=$mascota, CUAL='$cual', CUANTOS=$cuantos
                    WHERE ID_MASCOTA=$idMascota";
        }

        $query = $this->db->query($sql);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Adicionar/Editar Actividades
     * @since 26/05/2016
     */
    public function add_actividad() {
        $idUser = $this->session->userdata("id");
        $idActividad = $this->input->post('hddIDActividad');
        $ludica = $this->input->post('ludica');
        $cual = mayuscula_inicial($this->input->post('cual'));
        $horas = $this->input->post('horas');

        //revisar si es para adicionar o editar
        if ($idActividad == '') {
            $sql = "INSERT INTO USER_ACTIVIDADES
                    (ID_ACTIVIDAD, FK_ID_USUARIO, FK_ID_LUDICA, HORAS, CUAL) 
                    VALUES (SEQ_FORM_ACTIVIDADES.Nextval, $idUser, $ludica, $horas, '$cual')";
        } else {
            $sql = "UPDATE USER_ACTIVIDADES
                    SET FK_ID_LUDICA=$ludica, HORAS=$horas, CUAL='$cual'
                    WHERE ID_ACTIVIDAD=$idActividad";
        }

        $query = $this->db->query($sql);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Adicionar/Editar Idiomas
     * @since 08/06/2016
     */
    public function add_idioma() {
        $idUser = $this->session->userdata("id");
        $idIdioma = $this->input->post('hddIDIdioma');
        $idioma = $this->input->post('idiomas');
        $habla = $this->input->post('habla');
        $lee = $this->input->post('lee');
        $escribe = $this->input->post('escribe');
        $cual = mayuscula_inicial($this->input->post('cual'));

        //revisar si es para adicionar o editar
        if ($idIdioma == '') {
            $sql = "INSERT INTO USER_IDIOMA
                    (ID_USER_IDIOMA, FK_ID_USUARIO, FK_ID_IDIOMA, HABLA, LEE, ESCRIBE, CUAL) 
                    VALUES (SEQ_FORM_IDIOMA.Nextval, $idUser, $idioma, $habla, $lee, $escribe, '$cual')";
        } else {
            $sql = "UPDATE USER_IDIOMA
                    SET FK_ID_IDIOMA=$idioma, HABLA=$habla, LEE=$lee, ESCRIBE=$escribe, CUAL='$cual'
                    WHERE ID_USER_IDIOMA=$idIdioma";
        }

        $query = $this->db->query($sql);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Adicionar/Editar Informacion especifica
     * @since 23/05/2016
     */
    public function add_especifica() {
        $idUser = $this->session->userdata("id");
        $hddIDUsuario = $this->input->post('hddIDUsuario');
        $municipio = $this->input->post('municipio');
        $fechaNacimiento = $this->input->post('fechaNacimiento');
        $libretaMilitar = $this->input->post('libretaMilitar');
        $claseLibreta = $this->input->post('claseLibreta');
        $distritoMilitar = $this->input->post('distritoMilitar');
        $lugarExpedicion = mayuscula_inicial($this->input->post('lugarExpedicion'));
        $estadoCivil = $this->input->post('estadoCivil');
        $vivienda = $this->input->post('vivienda');
        $tipoSangre = $this->input->post('tipoSangre');
        $alergia = mayuscula_inicial($this->input->post('alergia'));
        $enfermedad = mayuscula_inicial($this->input->post('enfermedad'));
        $discapacidad = mayuscula_inicial($this->input->post('discapacidad'));
        $licencia = $this->input->post('licencia');

		//actualizo datos de tabla GH_ADMIN_USUARIOS
        $data = array(
            'FK_COD_MUNICIPIO' => $this->input->post('ciudadResidencia'),
            'DIRECCION' => mayuscula_inicial($this->input->post('txtDireccion')),
            'BARRIO' => mayuscula_inicial($this->input->post('txtBarrio')),
            'MAIL_PERSONAL' => strtolower($this->input->post('txtCorreoPersonal')),
            'CELULAR' => $this->input->post('txtCelular'),
            'SEXO' => $this->input->post('sexo')
        );
        $this->db->where('ID_USUARIO', $idUser);
        $query = $this->db->update('GH_ADMIN_USUARIOS', $data);		
		
        //revisar si es para adicionar o editar
        if ($hddIDUsuario == '') {
            $sql = "INSERT INTO USER_INFO_ESPECIFICA
                    (FK_ID_USUARIO, MPIO_NACIMIENTO, FECHA_NACIMIENTO, LIBRETA_MILITAR, CLASE_LIBRETA, DISTRITO_MILITAR, LUGAR_EXPEDICION,
                    FK_ESTADO_CIVIL, VIVIENDA_HABITA, FK_TIPO_SANGRE, 
                    ALERGIA, ENFERMEDAD, DISCAPACIDAD, LICENCIA_CONDUCCION) 
                    VALUES ($idUser, $municipio, '$fechaNacimiento', '$libretaMilitar', '$claseLibreta', '$distritoMilitar', '$lugarExpedicion',
                    '$estadoCivil','$vivienda','$tipoSangre', 
                    '$alergia', '$enfermedad', '$discapacidad', '$licencia' )";
        } else {
            $sql = "UPDATE USER_INFO_ESPECIFICA
                    SET MPIO_NACIMIENTO=$municipio,FECHA_NACIMIENTO= '$fechaNacimiento',
                    LIBRETA_MILITAR='$libretaMilitar', CLASE_LIBRETA='$claseLibreta', DISTRITO_MILITAR='$distritoMilitar', LUGAR_EXPEDICION='$lugarExpedicion',
                    FK_ESTADO_CIVIL='$estadoCivil', VIVIENDA_HABITA='$vivienda', FK_TIPO_SANGRE='$tipoSangre', 
                    ALERGIA='$alergia', ENFERMEDAD='$enfermedad', DISCAPACIDAD='$discapacidad', LICENCIA_CONDUCCION='$licencia'
                    WHERE FK_ID_USUARIO=$idUser";
        }

        $query = $this->db->query($sql);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Eliminar dependiente
     * @since 02/05/2016
     */
    public function eliminarDependiente($id) {
        $query = $this->db->delete('USER_DEPENDIENTE', array('ID_DEPENDIENTE' => $id));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Eliminar academica
     * @since 24/05/2016
     */
    public function eliminarAcademica($id) {
        $query = $this->db->delete('USER_INFO_ACADEMICA', array('ID_ACADEMICA' => $id));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Eliminar actividad
     * @since 24/05/2016
     */
    public function eliminarActividad($id) {
        $query = $this->db->delete('USER_ACTIVIDADES', array('ID_ACTIVIDAD' => $id));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Eliminar idioma
     * @since 09/06/2016
     */
    public function eliminarIdioma($id) {
        $query = $this->db->delete('USER_IDIOMA', array('ID_USER_IDIOMA' => $id));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Eliminar mascota
     * @since 31/05/2016
     */
    public function eliminarMascota($id) {
        $query = $this->db->delete('USER_MASCOTAS', array('ID_MASCOTA' => $id));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Lista de tipo de ludica
     * @since 26/05/2016
     */
    public function get_tipo_ludica() {
        $deps = array();
        $sql = "SELECT DISTINCT TIPO_LUDICA
                FROM GH_PARAM_LUDICA
                WHERE ID_LUDICA != 99
                ORDER BY TIPO_LUDICA";
        $query = $this->db->query($sql);
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /**
     * Lista ludica
     * @since 26/05/2016
     */
    public function get_ludica() {
        $deps = array();
        $sql = "SELECT *
                FROM GH_PARAM_LUDICA
                WHERE ID_LUDICA != 99
                ORDER BY TIPO_LUDICA";
        $query = $this->db->query($sql);
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /**
     * Lista de ludicas por tipo de ludica
     * @since 26/05/2016
     */
    public function get_listaLudica_by_id($filtro) {
        $deps = array();
        $sql = "SELECT ID_LUDICA, LUDICA
                FROM GH_PARAM_LUDICA
                WHERE TIPO_LUDICA = '$filtro'
                ORDER BY LUDICA";
        $query = $this->db->query($sql);
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }
	
    /**
     * Lista nivel de estudio
     * @since 15/07/2016
     */
    public function get_lista_nivel_estudio($arrDatos) 
	{
		$this->db->select();
		if (array_key_exists("filtro", $arrDatos)) {
			$this->db->where('ID_ESTUDIO <> ', $arrDatos["filtro"] );
		}
		$this->db->order_by('ID_ESTUDIO', "ASC");
		$query = $this->db->get('GH_PARAM_NIVEL_ESTUDIO');
		
		if($query->num_rows() > 0){
				return $query->result_array();
		}else{ return false; }		
    }
}
?>