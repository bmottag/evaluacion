<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Controlador Administrador de Usuarios
 * @author AOCUBILLOSA
 * @since  04/08/2016
 */
class Admin_usuarios extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array("consultas_user_model", "consultas_generales"));
    }

    /**
     * Consultar Usuarios
     * @since 04/08/2016
     * @author AOCUBILLOSA
     */
    public function index() 
	{
		$arrParam['politica'] = 1;
		$data['conPolitica'] = $this->consultas_user_model->contar_usuario_politica($arrParam);//cantidad de usuarios que aceptaron la politica
		
		$arrParam['politica'] = 2;
		$data['sinPolitica'] = $this->consultas_user_model->contar_usuario_politica($arrParam);//cantidad de usuarios que no aceptaron la politica
		
		$data['dependencias'] = $this->consultas_generales->get_solo_dependencias();//lista de dependencias

        $data["view"] = "lista_usuario";
        $this->load->view("layout", $data);
    }
	
    /**
     * Cargo modal- para mostrar datos de los usuariosde que aceptaron la politica para una dependencia especifica
     * @since 19/08/2016
     */
    public function cargarModal() {
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
		$idDependencia = $_POST["idDependenica"];
		$data["dependencia"] = $this->consultas_generales->get_consulta_basica('GH_PARAM_DEPENDENCIA','DESCRIPCION','CODIGO_DEPENDENCIA',$idDependencia);//consultar datos de la dependencia
        $data["usuarios"] = $this->consultas_user_model->get_usuarios_by_dependencia();//consultar lista de usuarios para la dependencia
		//echo $this->db->last_query(); exit;  
        $this->load->view("modal_usuarios_politica", $data);
    }
	


}