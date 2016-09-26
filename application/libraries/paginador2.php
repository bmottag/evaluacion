<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/**********************************************************************************************
 * DMDIAZF - Mayo 09 de 2012
 * Paginador de resultados (Segunda Version).
 * Se paginan resultados a través de AJAX
 * Debe indicarse al paginador cual es el div que se va a recargar
 **********************************************************************************************/
	
class Paginador2 {
	
	var $nregs = 50;         //Numero de registros que van a ser mostrados por pagina
	var $totalRegistros = 0;   //Obtener el total de registros que deben ser paginados
	var $pagActual = 1;		   //Obtiene la pagina actual en la que se encuentra el navegador.
	var $funcion = "";         //Indica cual es la funcion AJAX que debe ejecutar el JavaScript	
	
	//Ajusta el numero total de registros que deben paginarse
	function setTotal($totalRegistros){
		$this->totalRegistros = $totalRegistros;
	}
	
	//Ajusta el numero de pagina en el que se encuentra el navegador
	function setPagina($pagina){
		$this->pagActual = $pagina;
	}
	
	//Ajusta el nombre de la funcion AJAX que debera ejecutarse
	function setFuncion($funcion){
		$this->funcion = $funcion;
	}
	
	//Obtiene la pagina actual en la que está el validador
	function getPagina(){
		return $this->pagActual;
	}
	
	//Obtiene el numero de registros por pagina
	function getRegsPagina(){
		return $this->nregs;
	}
	
	//Obtiene el total de registros a paginar
	function getLimite(){
		$limite = ($this->pagActual - 1) * $this->nregs;
		return $limite;
	}
	
	//Obtiene la pagina anterior 
	function getAnterior(){
		$anterior = 1;
		if ($this->pagActual > 1)
			$anterior = $this->pagActual - 1;
		return $anterior;
	}
	
	//Obtiene la pagina siguiente
	function getSiguiente(){
		$siguiente = $this->pagActual + 1;
		return $siguiente;
	}
	
	//Calcula el numero total de paginas que debe tener el paginador
	function getTotalPaginas(){
		$totalPaginas = ceil($this->totalRegistros / $this->nregs);
		if ($totalPaginas==0){
			return 1;
		}
		else{
			return $totalPaginas;
		}
	}
	
	//Obtiene el nombre de la funcion AJAX que debe ser ejecutada
	function getFuncion(){
		return $this->funcion;
	}
	
	//Ejecuta todas las funciones y retorna una cadena HTML con los links para hacer la paginacion
	function paginar($div, $pagina, $total){		
		$this->setPagina($pagina);
		$this->setTotal($total);
		$totalPaginas = $this->getTotalPaginas();
		$string = '';
		if ($this->pagActual > 1){
			
			/***** ESTE PARCHE SE HACE PARA QUE ESCOJA LA FUNCION DEL PAGINADOR NRO. 2 SI ESTA PAGINANDO LOS CRITICOS *****/
			if (($div=='divAsignados')||($div=='pendientes')||($div=='divResultados')){
				$string .= '<a href="javascript:paginar2(\''.$div.'\','.$this->getAnterior().',\''.$this->getFuncion().'\');">Anterior</a>';
			}
			else{
				$string .= '<a href="javascript:paginar(\''.$div.'\','.$this->getAnterior().',\''.$this->getFuncion().'\');">Anterior</a>';
			}
			/**************************************************************************************************************/			
		}
		$string .= '&nbsp;P&aacute;gina '.$this->pagActual.' de '.$totalPaginas.'&nbsp;';
		
		
		if ($this->getSiguiente() <= $totalPaginas){
			
			/***** ESTE PARCHE SE HACE PARA QUE ESCOJA LA FUNCION DEL PAGINADOR NRO. 2 SI ESTA PAGINANDO LOS CRITICOS *****/
			if (($div=='divAsignados')||($div=='pendientes')||($div=='divResultados')){
				//$string .= '<a id="test" href="javascript:paginar2(\''.$div.'\','.$this->getSiguiente().',\''.$this->getFuncion().'\');">Siguiente</a>';	
				$string .= '<a href="#" onclick="javascript:paginar2(\''.$div.'\','.$this->getSiguiente().',\''.$this->getFuncion().'\');">Siguiente</a>';
			}
			else{
				//$string .= '<a id="test" href="javascript:paginar(\''.$div.'\','.$this->getSiguiente().',\''.$this->getFuncion().'\');">Siguiente</a>';
				$string .= '<a href="#" onclick="javascript:paginar2(\''.$div.'\','.$this->getSiguiente().',\''.$this->getFuncion().'\');">Siguiente</a>';
			}
			/**************************************************************************************************************/
		}
		return $string;
	}
	
	
	
}