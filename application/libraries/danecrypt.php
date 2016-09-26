<?php

/***
 * Daniel Mauricio Díaz Forero
 * Junio 05 2012
 * Libreria codeigniter para Encriptar / Desencriptar contraseñas
 */

class DaneCrypt {
    
	var $skey = "Ln\9P#oR3I?ZP0w\UK-X"; // you can change it

    public function safe_b64encode($string) {
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }

    public function safe_b64decode($string) {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

    public function encode($value){ 
        if(!$value){return false;}
        $text = $value;
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->skey, $text, MCRYPT_MODE_ECB, $iv);
        return trim($this->safe_b64encode($crypttext)); 
    }

    public function decode($value){
        if(!$value){return false;}
        $crypttext = $this->safe_b64decode($value); 
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->skey, $crypttext, MCRYPT_MODE_ECB, $iv);
        return trim($decrypttext);
    }
    
    //Daniel M. Diaz - Junio 07 de 2012
    //Funcion para generar una contraseña aleatoriamente del numero de caracteres indicado.
    //Se entrega la contraseña codificada con encode.
    public function generarPassword(){
    	$largo = 10; //Cantidad de caracteres con los que se va a generar la contraseña
    	$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		$passwd = "";
		for($i=0;$i<$largo;$i++) {
			$passwd .= substr($str,rand(0,62),1);
		}
		$result = $this->encode($passwd);
		return $result;
    }
	
}//EOC