<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Periodo extends CI_Model {

	    function __construct(){        
	        parent::__construct();	        
	        $this->load->library("danecrypt");	        
	    }
	    
	    /**
	     * Obtiene el ultimo ano y secuencial del periodo mas reciente a partir del tipo de periodo
	     * @author Daniel M. Diaz
	     * @since  Noviembre 15 / 2013 
	     */
	    public function obtenerPeriodoReciente($tipo_periodo){
	    	$periodo = array();
	    	$sql = "SELECT cod_periodo, periodo_ano, periodo_sec, nom_periodo, estado_periodo
					FROM fivi_admin_periodos
					WHERE cod_periodo = (SELECT MAX(cod_periodo)
                     					 FROM fivi_admin_periodos
                                         WHERE cod_tipoper = $tipo_periodo
                                         AND estado_periodo = 'A')";
	    	$query = $this->db->query($sql);
	    	if ($query->num_rows() > 0){
	    		foreach ($query->result() as $row){
	    			$periodo["cod_periodo"] = $row->cod_periodo;
	    			$periodo["ano_periodo"] = $row->periodo_ano;
	    			$periodo["sec_periodo"] = $row->periodo_sec;
	    			$periodo["nom_periodo"] = $row->nom_periodo;
	    		}
	    	}
	    	$this->db->close();
	    	return $periodo;
	    }
	    
	    
	    
	    
		
	    
	}//EOC   