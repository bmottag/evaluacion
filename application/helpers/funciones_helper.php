<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author oagarzond
 * @param	String	$ruta	Ruta relativa
 * @return	Ruta absoluta deseada
 */
if (!function_exists("base_dir")) {

    function base_dir($ruta = '') {
        return FCPATH . $ruta;
    }

}

/**
 * @author oagarzond
 * @param	String	$ruta	Ruta relativa
 * @return	Ruta absoluta deseada
 */
if (!function_exists("base_app")) {

    function base_app($ruta = '') {
        return APPPATH . $ruta;
    }

}

/**
 * @author oagarzond
 * @param	String	$ruta_imagen	Ruta relativa con el nombre de la imagen y su extension
 * @return	Ruta absoluta de la imagen deseada
 */
if (!function_exists("base_dir_images")) {

    function base_dir_images($ruta_imagen = '') {
        $CI = & get_instance();
        $dir_images = FCPATH . 'images/';
        if (strlen($ruta_imagen) > 0) {
            $dir_images .= $ruta_imagen;
        }
        return $dir_images;
    }

}

/**
 * @author oagarzond
 * @param	String	$ruta_imagen	Ruta relativa con el nombre de la imagen y su extension
 * @return	URL absoluta de la imagen deseada
 */
if (!function_exists("base_url_images")) {

    function base_url_images($ruta_imagen = '') {
        $CI = & get_instance();
        $url_images = $CI->config->base_url() . 'images/';
        if (strlen($ruta_imagen) > 0) {
            $url_images .= $ruta_imagen;
        }
        return $url_images;
    }

}

/**
 * @author oagarzond
 * @param	String	$ruta_archivo	Ruta relativa con el nombre del archivo y su extension
 * @return	Ruta absoluta del archivo deseado
 */
if (!function_exists("base_dir_files")) {

    function base_dir_files($ruta_archivo = '') {
        $CI = & get_instance();
        $dir_files = FCPATH . 'files/';
        if (strlen($ruta_archivo) > 0) {
            $dir_files .= $ruta_archivo;
        }
        return $dir_files;
    }

}

/**
 * @author oagarzond
 * @param	String	$ruta_archivo	Ruta relativa con el nombre del archivo y su extension
 * @return	URL absoluta del archivo deseado
 */
if (!function_exists("base_url_files")) {

    function base_url_files($ruta_archivo = '') {
        $CI = & get_instance();
        $url_files = $CI->config->base_url() . 'files/';
        if (strlen($ruta_archivo) > 0) {
            $url_files .= $ruta_archivo;
        }
        return $url_files;
    }

}

/**
 * @author oagarzond
 * @param	String	$ruta_archivo	Ruta relativa con el nombre del archivo y su extension
 * @return	Ruta absoluta del archivo deseado
 */
if (!function_exists("base_dir_tmp")) {

    function base_dir_tmp($ruta_archivo = '') {
        $CI = & get_instance();
        $dir_tmp = FCPATH . 'tmp/';
        if (strlen($ruta_archivo) > 0) {
            $dir_tmp .= $ruta_archivo;
        }
        return $dir_tmp;
    }

}

/**
 * @author oagarzond
 * @param	String	$ruta_archivo	Ruta relativa con el nombre del archivo y su extension
 * @return	URL absoluta del archivo deseado
 */
if (!function_exists("base_url_tmp")) {

    function base_url_tmp($ruta_archivo = '') {
        $CI = & get_instance();
        $url_tmp = $CI->config->base_url() . 'tmp/';
        if (strlen($ruta_archivo) > 0) {
            $url_tmp .= $ruta_archivo;
        }
        return $url_tmp;
    }

}

if (!function_exists("validarSesion")) {

    function validarSesion() {
        $CI = & get_instance();
        $CI->load->helper("url");
        $CI->load->library("session");
        if (!$CI->session->userdata("auth")) {
            redirect('/login', 'refresh');
        }
    }

}

/**
 * Cargar controlador de otro modulo con PHP normal
 * e instanciar objeto de dicho controlador
 * @author oagarzond
 * @since 2016-03-11
 */
if (!function_exists('load_controller')) {

    function load_controller($module, $controller) {
        if (!file_exists(APPPATH . 'modules/' . $module . '/controllers/' . ucfirst(strtolower($model)) . '.php')) {
            exit('Unable to locate the controller you have specified: ' . $model);
        }

        require_once(APPPATH . 'modules/' . $module . '/controllers/' . ucfirst(strtolower($controller)) . '.php');
        if (class_exists($model, FALSE)) {
            $controller = new $controller();
            //$controller->$method();
            return $controller;
        } else {
            exit('Unable to open the controller you have specified: ' . $model);
        }
    }

}

/**
 * Cargar modelo de otro modulo con PHP normal
 * e instanciar objeto de dicho modelo
 * @author oagarzond
 * @since 2016-03-11
 */
if (!function_exists('load_model')) {

    function load_model($module, $model) {
        if (!file_exists(APPPATH . 'modules/' . $module . '/models/' . ucfirst(strtolower($model)) . '.php')) {
            exit('Unable to locate the model you have specified: ' . $model);
        }

        if (!@include(APPPATH . 'modules/' . $module . '/models/' . ucfirst(strtolower($model)) . '.php')) {
            exit("Failed to require " . APPPATH . 'modules/' . $module . '/models/' . ucfirst(strtolower($model)) . '.php');
        }

        if (class_exists($model, FALSE)) {
            $model = new $model();
            return $model;
        } else {
            exit('Unable to open the model you have specified: ' . $model);
        }
    }

}

/**
 * Imprimir arreglos de una forma mas legible
 * @author oagarzond
 * @param mixed $objVar Arreglo o cadena para mostrar por pantalla con formato
 */
if (!function_exists("pr")) {

    function pr($objVar) {
        echo "<div align='left'>";
        if (is_array($objVar) or is_object($objVar)) {
            echo "<pre>";
            print_r($objVar);
            echo "</pre>";
        } else {
            echo str_replace("\n", "<br>", $objVar);
        }
        echo "</div><hr>";
    }

}


/**
 * Convierte a mayuscula la primera letra de cada palabra de la frase
 * @author Orlando Alberto Garzon Diaz <c.ogarzon@sic.gov.co>
 * @param   String  $texto  Texto a convertir
 * @return  String  $texto
 */
if (!function_exists("mayuscula_inicial")) {

    function mayuscula_inicial($texto) {
        if (strlen($texto)) {
            $texto = strtolower($texto);
            if (substr_count($texto, "@") == 0) {
                if (substr_count($texto, ".")) {
                    $arrTexto = explode(".", $texto);
                    $texto = "";
                    foreach ($arrTexto as $indTexto => $valTexto) {
                        if (strlen($valTexto) > 0) {
                            $texto .= ucwords($valTexto) . ".";
                        }
                    }
                } else {
                    $texto = ucwords($texto);
                }
            }
        }
        return $texto;
    }

}

/**
 * Funci�n para validar si una fecha es valida.
 *
 * Esta funci�n se utiliza para validar si la fecha pasada por parametro es valida o no Ej. 2011-02-29 no es una fecha valida.
 * @author javier-sanchez
 * @param string $cadena Arreglo o cadena para mostrar por pantalla con formato.
 * @param array $arrCaracteres Arreglo o cadena para mostrar por pantalla con formato.
 * @return string Retorna la cadena formateada o escapada.
 */
if (!function_exists("es_fecha_valida")) {

    function es_fecha_valida($fecha) {
        if (strstr($fecha, "-")) {
            $data = explode("-", $fecha);
            if (strlen($data[0]) != 4)
                return false;
            return(@checkdate(intval($data[1]), intval($data[2]), intval($data[0])));
        }
        elseif (strstr($fecha, "/")) {
            $data = explode("/", $fecha);
            if (strlen($data[2]) != 4)
                return false;
            return(@checkdate(intval($data[1]), intval($data[0]), intval($data[2])));
        }
    }

}


/**
 * Esta funcion se utiliza para darle formato a la fecha pasada por parametro, 
 * es decir si se pasa el formato YYYY-MM-DD se retorna la fecha en formato DD/MM/YYYY y viceversa.
 * @author oagarzond
 * @param	date	$fecha	Fecha
 * @return	string	Retorna la fecha formateada o vacio si la fecha no es valida
 */
if (!function_exists("formatear_fecha")) {

    function formatear_fecha($fecha) {
        if (es_fecha_valida($fecha)) {
            if (strstr($fecha, "-")) {
                $data = explode("-", $fecha);
                return $data[2] . "/" . $data[1] . "/" . $data[0];
            } elseif (strstr($fecha, "/")) {
                $data = explode("/", $fecha);
                return $data[2] . "-" . $data[1] . "-" . $data[0];
            }
        } else
            return "";
    }

}

/**
 * Retorna el texto de una fecha a partir de una fecha valida
 * @author  oagarzond
 * @param   $fecha  String  Fecha al cual se va sumar los dias, debe estar en formato YYYY-MM-DD
 * @param   $dias   Integer Numero de dias que se van a sumar
 * @return  Fecha de venc. final o vacio si no se pudo sumar
 */
if (!function_exists("obtener_texto_fecha")) {

    function obtener_texto_fecha($fecha) {
        if (es_fecha_valida($fecha)) {
            $fechatexto = "";
            $unixMark = strtotime($fecha);
            $mes = intval(date("m", $unixMark));
            $textosMes = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
            foreach ($textosMes as $key => $value) {
                if ($key == $mes)
                    $mes = $textosMes[$key];
            }
            $fechatexto = date("d", $unixMark) . " de " . $mes . " de " . date("Y", $unixMark);
            return $fechatexto;
        }
    }

}

/**
 * Funcion para agregar los ceros en el dia y/o mes de la fecha
 * @author oagarzond
 * @param	$fecha	Texto de la fecha en formato YYYY-MM-DD o DD/MM/YYYY
 * @return	Fecha completa de logitud 10 
 */
if (!function_exists("completar_fecha")) {

    function completar_fecha($fecha) {
        if (strstr($fecha, "-")) {
            $data = explode("-", $fecha);
            if(strlen($data[0]) == 2)
                $data[0] = '20' . $data[0];
            return str_pad($data[0], 4, "0", STR_PAD_LEFT) . "-" . str_pad($data[1], 2, "0", STR_PAD_LEFT) . "-" . str_pad($data[2], 2, "0", STR_PAD_LEFT);
        } elseif (strstr($fecha, "/")) {
            $data = explode("/", $fecha);
            if(strlen($data[2]) == 2)
                $data[2] = '20' . $data[2];
            return str_pad($data[0], 2, "0", STR_PAD_LEFT) . "/" . str_pad($data[1], 2, "0", STR_PAD_LEFT) . "/" . str_pad($data[2], 4, "0", STR_PAD_LEFT);
        }
    }

}


/**
 * Retorna el texto de una fecha a partir de una fecha valida
 * @author  oagarzond
 * @param   $fecha  String  Fecha al cual se va sumar los dias, debe estar en formato YYYY-MM-DD
 * @param   $dias   Integer Numero de dias que se van a sumar
 * @return  Fecha de venc. final o vacio si no se pudo sumar
 */
if (!function_exists("obtener_texto_fecha")) {

    function obtener_texto_fecha($fecha) {
        if (esFechaValida($fecha)) {
            $fechatexto = "";
            $unixMark = strtotime($fecha);
            $mes = intval(date("m", $unixMark));
            $textosMes = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
            foreach ($textosMes as $key => $value) {
                if ($key == $mes)
                    $mes = $textosMes[$key];
            }
            $fechatexto = date("d", $unixMark) . " de " . $mes . " de " . date("Y", $unixMark);
            return $fechatexto;
        }
    }

}

/**
 * Retorna el texto del mes
 * @author oagarzond
 * @param	$mes	Numero del mes que se quiere mostrar
 * @return	Nombre del mes
 */
if (!function_exists("obtener_texto_mes")) {

    function obtener_texto_mes($mes = 0) {
        $textosMes = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        foreach ($textosMes as $key => $value) {
            if ($key == $mes)
                $mes = $textosMes[$key];
        }
        return $mes;
    }

}

/**
 * Obtiene el tipo y la descripcion del tipo de documento
 * @author oagarzond
 * @param	Int		codi_tipo_docu	Codigo del tipo de documento
 * @return	Array	tipo_docu		Tipo y descripcion del documento
 */
if (!function_exists("descripcion_tipo_docu")) {

    function descripcion_tipo_docu($codi_tipo_docu = 0) {
        $tipo_docu = array();
        if (!empty($codi_tipo_docu)) {
            switch ($codi_tipo_docu) {
                case "1":
                    $tipo_docu["tipo"] = "RC";
                    $tipo_docu["desc"] = "Registro Civil";
                    break;
                case "2":
                    $tipo_docu["tipo"] = "TI";
                    $tipo_docu["desc"] = "Tarjeta de Identidad";
                    break;
                case "3":
                    $tipo_docu["tipo"] = "CC";
                    $tipo_docu["desc"] = "C&eacute;dula de Ciudadan&aicute;a";
                    break;
                case "4":
                    $tipo_docu["tipo"] = "CE";
                    $tipo_docu["desc"] = "C&eacute;dula de Extranjer&iacute;a";
                    break;
                case "5":
                    $tipo_docu["tipo"] = "NT";
                    $tipo_docu["desc"] = "NT";
                    break;
            }
        }
        return $tipo_docu;
    }

}

if (!function_exists("descripcion_genero")) {

    function descripcion_genero($codi_genero = 0) {
        $desc_genero = "";
        if (!empty($codi_genero)) {
            switch ($codi_genero) {
                case "1": $desc_genero = "Hombre";
                    break;
                case "2": $desc_genero = "Mujer";
                    break;
            }
        }
        return $desc_genero;
    }

}

/**
 * Retorna el texto de la ultima semana de la fecha parametrizada
 * @author oagarzond
 * @param	$fecha		Fecha en la que se va a calcular el dia y la semana en que estaba
 * @return	$txt_fecha	Texto de la semana que precede inmediatamente a la fecha
 */
if (!function_exists("calcular_ult_sem")) {

    function calcular_ult_sem($fecha) {
        $txt_fecha = '';
        $num_dia = date("w", strtotime($fecha));
        switch ($num_dia) {
            case "0": // domingo
                $fecha_ini = date("Y-m-d", strtotime("-6 day", strtotime($fecha)));
                $fecha_fin = $fecha;
                break;
            case "1": // lunes
                $fecha_ini = date("Y-m-d", strtotime("-7 day", strtotime($fecha)));
                $fecha_fin = date("Y-m-d", strtotime("-1 day", strtotime($fecha)));
                break;
            case "2": // martes
                $fecha_ini = date("Y-m-d", strtotime("-8 day", strtotime($fecha)));
                $fecha_fin = date("Y-m-d", strtotime("-2 day", strtotime($fecha)));
                break;
            case "3": // miercoles
                $fecha_ini = date("Y-m-d", strtotime("-9 day", strtotime($fecha)));
                $fecha_fin = date("Y-m-d", strtotime("-3 day", strtotime($fecha)));
                break;
            case "4": // jueves
                $fecha_ini = date("Y-m-d", strtotime("-10 day", strtotime($fecha)));
                $fecha_fin = date("Y-m-d", strtotime("-4 day", strtotime($fecha)));
                break;
            case "5": // viernes
                $fecha_ini = date("Y-m-d", strtotime("-11 day", strtotime($fecha)));
                $fecha_fin = date("Y-m-d", strtotime("-5 day", strtotime($fecha)));
                break;
            case "6": // sabado
                $fecha_ini = date("Y-m-d", strtotime("-12 day", strtotime($fecha)));
                $fecha_fin = date("Y-m-d", strtotime("-6 day", strtotime($fecha)));
                break;
        }
        $txt_fecha = obtener_texto_fecha($fecha_ini) . " al " . obtener_texto_fecha($fecha_fin);
        return $txt_fecha;
    }

}

/**
 * Retorna el texto de los textos separados por comas, excepto el ultimo texto que se separa con una y
 * @author oagarzond
 * @param	$arr_val	Valores que se van a contatenar
 * @return	$str_val	Texto con los valores concatenados
 */
if (!function_exists("mostrar_texto_comas")) {

    function mostrar_texto_comas($arr_val) {
        $str_val = '';
        $total = count($arr_val);
        if ($total == 1)
            $str_val = $arr_val[0];
        else if ($total > 1) {
            foreach ($arr_val as $k => $v) {
                if ($k == 0) {
                    $str_val = $arr_val[$k];
                } else if ($k <= ($total - 2)) {
                    $str_val .= ", " . $arr_val[$k];
                } else if ($k == ($total - 1)) {
                    $str_val .= " y " . $arr_val[$k];
                }
            }
        }
        return $str_val;
    }

}

/**
 * Valida si la fecha es dia es habil
 * @author oagarzond
 * @param	String	fecha       Fecha que se va a validar
 * @param	Array	$festivos   Fechas festivos, debe estar en formato YYYY-MM-DD
 * @return	Bool    Es o no habil
 */
if (!function_exists("es_dia_habil")) {

    function es_dia_habil($fecha, $festivos = array()) {
        $es_habil = true;
        $num_dia = date("w", strtotime($fecha));
        // 0 - domingo, 6 - sabado
        if($num_dia == 0 || $num_dia == 6) {
            $es_habil = false;
        } else {
            if(in_array($fecha, $festivos)) {
                $es_habil = false;
            }
        }
        return $es_habil;
    }
}

/**
 * Retorna los dias habiles entre un rango de fechas
 * @author oagarzond
 * @param	String	fecha_ini		Fecha inicial, debe estar en formato YYYY-MM-DD
 * @param	String	fecha_fin		Fecha final, debe estar en formato YYYY-MM-DD
 * @return	Array	dias_habiles	Dias habiles entre el rango de fechas
 */
if (!function_exists("calcular_dias_habiles")) {

    function calcular_dias_habiles($fecha_ini, $fecha_fin, $dias_festivos = array()) {
        $dias_habiles = array();
        $num_dia = date("w", strtotime($fecha_ini));
        if ($num_dia != 0 && $num_dia != 6) {
            $dias_habiles[] = $fecha_ini;
        }
        if ($fecha_ini != $fecha_fin) {
            $fecha = $fecha_ini;
            while ($fecha != $fecha_fin) {
                $fecha = date("Y-m-d", strtotime("+1 day", strtotime($fecha)));
                $num_dia = date("w", strtotime($fecha));
                if (!in_array($fecha, $dias_festivos)) {
                    if ($num_dia != 0 && $num_dia != 6) {
                        $dias_habiles[] = $fecha;
                    }
                }
            }
        }
        return $dias_habiles;
    }

}

/**
 * Retorna el segundo y cuarto viernes de cada mes de ano
 * @author oagarzond
 * @param	Array	$anios	Anio(s) en que se va a buscar los viernes Perfetti
 * @return	Array	$dias	Viernes segundo y cuarto de cada mes del anio
 */
if (!function_exists("calcular_viernes_perfetti")) {

    function calcular_viernes_perfetti($anios) {
        $dias = array();
        foreach ($anios AS $iabio => $vanio) {
            for ($i = 1; $i <= 12; $i++) {
                $fecha = completar_fecha($vanio . "-" . $i . "-" . "1");
                $num_dia = date("w", strtotime($fecha));
                switch ($num_dia) {
                    case "0": // domingo
                        $dias[] = date("Y-m-d", strtotime("+12 day", strtotime($fecha)));
                        break;
                    case "1": // lunes
                        $dias[] = date("Y-m-d", strtotime("+11 day", strtotime($fecha)));
                        break;
                    case "2": // martes
                        $dias[] = date("Y-m-d", strtotime("+10 day", strtotime($fecha)));
                        break;
                    case "3": // miercoles
                        $dias[] = date("Y-m-d", strtotime("+9 day", strtotime($fecha)));
                        break;
                    case "4": // jueves
                        $dias[] = date("Y-m-d", strtotime("+8 day", strtotime($fecha)));
                        break;
                    case "5": // viernes
                        $dias[] = date("Y-m-d", strtotime("+7 day", strtotime($fecha)));
                        break;
                    case "6": // sabado
                        $dias[] = date("Y-m-d", strtotime("+13 day", strtotime($fecha)));
                        break;
                }
                $mes_temp = intval(date("m", strtotime("+14 day", strtotime($dias[count($dias) - 1]))));
                $dias[] = date("Y-m-d", strtotime("+14 day", strtotime($dias[count($dias) - 1])));
                if ($mes_temp > $i) {
                    unset($dias[count($dias) - 1]);
                }
            }
        }
        //pr($dias); exit;
        return $dias;
    }
    
    /**
     * Retorna el contenido del archivo que se ve desde la URL
     * @author oagarzond
     * @param	String  $url    URL del archivo
     * @return	String  $data   Contenido del archivo
     */
    if (!function_exists("curl_get_contents")) {

        function curl_get_contents($url) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }

    }
}
// EOC