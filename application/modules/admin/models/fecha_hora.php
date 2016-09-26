<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Clase para obtener fecha y hora con difrentes formatos
* @author hhchavezv
* @since  2015jul14
*/
class Fecha_hora extends CI_Model 
{

    	public function __construct(){        
        	parent::__construct();        	
    	}

    	
    /*Obtener del sistema la Fecha y hora actual, acorde a Colombia	
	* @author hhchavezv
	* @since  2015jul14
	*/
    function obtenerFechaActual($formato){
    	date_default_timezone_set('America/Bogota');
    	if($formato=='f'){
    	
    	$fecha=date('Y-m-d'); //2012-05-31
    	}
    	if($formato=='h'){
    	$fecha=date('Y-m-d H:i:s'); //2012-05-31 12:08:01	
    	}
    	
    	return $fecha;
    }  
	
	/* Fecha para mostrar en vista de acuerdo a formato elegido
	* @author hhchavezv
	* @since  2015jul14
	*/
     function fechaActualMostrar($formato){
    	
    	date_default_timezone_set('America/Bogota');
    	if($formato=='f'){
    	 	$fecha=date('d/m/Y');//15/07/2015
    	}
     	if($formato=='h'){
    	$fecha=date('d/m/Y H:i:s'); //15/07/2015 12:08:01	
    	}	 
    	return $fecha;
    } 
   
	/* Convierte una fecha con formato mysql a formato d/m/Y
	* @author hhchavezv
	* @since  2015jul14
	*/
    function convierteFechaMysql($formato,$fechaConvertir){
    	
    	
    	if($formato=='f'){ //viene solo fecha
    	 	$arrayfecha = explode("-",$fechaConvertir);
			$string = $arrayfecha[2]."/".$arrayfecha[1]."/".$arrayfecha[0];							  
    	}else if($formato=='h'){ // viene con hora 2012-05-31 12:08:01
	    	$arrayfecha = explode("-",$fechaConvertir);
	    	$dia=explode(" ",$arrayfecha[2]);
	    	
			$string = $dia[0]."/".$arrayfecha[1]."/".$arrayfecha[0];			
    	}
    	 
    	return $string;
    }    

   
	/* Convierte una fecha a formato mysql Y-m-d
	* @author hhchavezv
	* @since  2015jul14
	*/
    function convierteFechaGuardar($formato,$fechaConvertir){
    
    	if($formato=='f'){ //viene solo fecha
    	 	$arrayfecha = explode("/",$fechaConvertir);
			$string = $arrayfecha[2]."-".$arrayfecha[1]."-".$arrayfecha[0];							  
    	}else if($formato=='h'){ // viene con hora 2012-05-31 12:08:01
	    	$arrayfecha = explode("/",$fechaConvertir);
	    	$dia=explode(" ",$arrayfecha[2]);
	    	
			$string = $dia[0]."-".$arrayfecha[1]."-".$arrayfecha[0];			
    	}
    	 
    	return $string;
    }   
    
}//EOC