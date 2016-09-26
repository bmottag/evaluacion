<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/***
 * CONFIGURACION DEL FRASEO DEL SITIO
 */


//Configura el texto para el title del sitio
$config['title']	= "MINTEGRA";

//Configura el nombre del sitio
$config['header']	= "Modelo Integrado de la Secretar&iacute;a General";

//Texto para el footer del sitio
$config['footer']   = "<p>DANE: Carrera 59 No. 26-70 Interior I - CAN. Conmutador (571) 5978300 - Fax (571) 5978399</p>
		               <p>L&iacute;nea gratuita de atenci&oacute;n 01-8000-912002. &oacute; (571) 5978300 Exts. 2532 - 2605</p>";

//Configura el modulo que va a contener los formularios de cada uno de los modulos
$config["forms"] = "formulario";

//Configura el nombre y la cantidad de modulos que va a tener el sitio
//$config["mods"] = obtenerModulos($config["forms"]);

//Configura el objetivo general de la encuesta
$config["objetivo"] = "<p>Se&ntilde;or Empresario:</p>
					   <p>El Departamento Administrativo Nacional de Estad&iacute;stica DANE, en el marco de su plan de modernizaci&oacute;n de los instrumentos de recolecci&oacute;n de las encuestas econ&oacute;micas y con el prop&oacute;sito de agilizar y facilitar el reporte correcto y oportuno de los datos estad&iacute;sticos requeridos por la ENCUESTA ANUAL DE SERVICIOS, pone a su disposici&oacute;n el presente formulario electr&oacute;nico, con el cual podr&aacute; diligenciar y verificar en linea la consistencia de su informaci&oacute;n.</p>
					   <p>Un funcionario de nuestra entidad, estar&aacute; en todo momento atento para prestarle la asesor&iacute;a y orientaci&oacute;n necesaria.</p>";

//Configura los nombres que van a tener cada uno de los formularios
$config["nombres"] = array("fivi" => "FIVI",
		                   "sfv"  => "SFV",
		                   "leasing" => "Leasing",
		                   "certnomov" => "No Movimiento",
		                   "envio" => "Env&iacute;o",
		                   "pazysalvo" => "Paz y Salvo");
/*
|-----------------------------------------------------------------------------
| Funcion para obtener los modulos que componen el formulario de una encuesta
|-----------------------------------------------------------------------------
| @author Daniel M. D�az
| @since  Agosto 14 / 2013
| @param  $form Ruta del directorio del modulo que contiene los controladores para cada uno de los formularios 
|
| Desde esta funci�n se obtienen todos los controladores que se encuentran dentro del modulo de formularios que 
| se recibe por par�metro.
|
*/
function obtenerModulos($form){
	$modules = array();
	$module_path = APPPATH."modules/$form/controllers";
	$directorio = opendir($module_path); 
	$idx = 0;
	while ($archivo = readdir($directorio)) {
    	if (!is_dir($archivo)){
        	$string = explode(".",$archivo);
        	$mod["file"] = $string[0];  //Obtengo el nombre del archivo sin la extensi�n .php
        	//$mod["name"] = $config["nombres"][$string[0]];
        	array_push($modules,$mod);
        	$idx++;
    	}
	}
	return $modules;
}