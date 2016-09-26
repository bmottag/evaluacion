<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

	/**	  
	 * Libreria general de funciones del aplicativo.
	 * Esta libreria contiene varias funciones útiles en el desarrollo del aplicativo
	 * @author DMDiazF
	 * @since  Abril 10 de 2012	 
	 **/

	class General {
		
		// dmdiazf - Abril 10 2012
	 	// Funcion para dar formato a las fechas de MySQL en el formato d/m/Y
	 	// El parametro formato indica con que formato viene la fecha. Si el formato es '-' la fecha 
	 	// se convierte de MySQL a formato DANE, si el formato es '/' la fecha se convierte de formato DANE
	 	// a formato MySQL.	 		
		function formatoFecha($fecha,$formato){
			$fecha = substr($fecha,0,10);
			switch($formato){
				case '-':  //Guardar en la Base de Datos
					       $arrayFecha = explode("-",$fecha);
					       $string = $arrayFecha[2]."/".$arrayFecha[1]."/".$arrayFecha[0];
					       break;
					      
				case '/':  //Recoger de la base de datos
						   $arrayFecha = explode('/',$fecha);
						   $string = $arrayFecha[2].'-'.$arrayFecha[1].'-'.$arrayFecha[0];
						   break;
						  
				case '\\': //Recoger de la base de datos
						   $arrayFecha = explode('\\',$fecha);
						   $string = $arrayFecha[2].'-'.$arrayFecha[1].'-'.$arrayFecha[0];
						   break;		  
			}
			return $string;			
    	}
    	
    	// dmdiazf - Abril 11 2012
    	// Funcion para obtener la imagen de "chequeado" cuando la información de un capitulo
    	// ya se ha actualizado en la base de datos.
    	function obtenerImagen($valor){
    		$imagen = "";
    		switch($valor){
    			case 0: //No se ha actualizado el capitulo
    					$imagen = base_url("images/noimg.png");
    					break;
    					
    			case 1: //No se ha actualizado el capitulo
    					$imagen = base_url("images/noimg.png");
    					break;	

    			case 2: //El capitulo ya esta actualizado
    					$imagen = base_url("images/tick.png");
    					break;

    			default: //Si no viene nada definido
    				     $imagen = base_url("images/noimg.png");
    				     break;		
    		}
    		return $imagen;
    	}
    	
    	// dmdiazf - Abril 19 2012
    	// Funcion para bloquear los campos de los capitulos de un formulario, luego de que el formulario
    	// se ha enviado a DANE central y se encuentra en la novedad 5 y el estado 3. Se recibe un parametro
    	// que indica el estado de bloqueo del formulario. 
    	function bloqueoCampo($bloqueo){
    		if ($bloqueo){
    			$string = 'disabled = "disabled"';
    			echo $string;
    		}
    	}
    	
    	
    	
    	
    	
    	
	
	}//EOC